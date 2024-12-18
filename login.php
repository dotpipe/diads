<?php
require_once 'config/database.php';
require_once 'auth/APIKeyManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$_POST['email'], hash('sha256', $_POST['password'])]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate new token
            $token = bin2hex(random_bytes(32));
            $stmt = $db->prepare("
                INSERT INTO active_tokens (token, user_id, expires_at) 
                VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))
            ");
            $stmt->execute([$token, $user['id']]);
            
            echo json_encode(['status' => 'success', 'token' => $token]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        }
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Server error']);
    }
}
?>