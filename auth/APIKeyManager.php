<?php
namespace MyApp\Auth;

class APIKeyManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isTokenValid($token) {
        try {
            // Check expired tokens
            $stmt = $this->db->prepare("SELECT id FROM expired_tokens WHERE token = ?");
            $stmt->execute([$token]);
            if ($stmt->fetch()) {
                return false;
            }

            // Check active tokens
            $stmt = $this->db->prepare("
                SELECT id FROM active_tokens 
                WHERE token = ? 
                AND expires_at > NOW() 
                AND status = 'ACTIVE'
            ");
            $stmt->execute([$token]);
            return $stmt->fetch() ? true : false;
        } catch (PDOException $e) {
            error_log("Token validation error: " . $e->getMessage());
            return false;
        }
    }

    public function invalidateToken($token, $reason = 'USED') {
        try {
            $this->db->beginTransaction();

            // Move to expired tokens
            $stmt = $this->db->prepare("
                INSERT INTO expired_tokens (token, reason, user_id, ip_address)
                SELECT token, ?, user_id, ? FROM active_tokens WHERE token = ?
            ");
            $stmt->execute([$reason, $_SERVER['REMOTE_ADDR'], $token]);

            // Remove from active tokens
            $stmt = $this->db->prepare("DELETE FROM active_tokens WHERE token = ?");
            $stmt->execute([$token]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Token invalidation error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserIdFromToken($token) {
        try {
            $stmt = $this->db->prepare("SELECT user_id FROM active_tokens WHERE token = ?");
            $stmt->execute([$token]);
            $result = $stmt->fetch();
            return $result ? $result['user_id'] : null;
        } catch (PDOException $e) {
            error_log("Error getting user ID: " . $e->getMessage());
            return null;
        }
    }
}