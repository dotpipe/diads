<?php
require_once '../auth/APIKeyManager.php';
require_once '../config/database.php';

function validateToken() {
    $headers = getallheaders();
    $token = isset($headers['Authorization']) ? 
        str_replace('Bearer ', '', $headers['Authorization']) : null;

    if (!$token) {
        http_response_code(401);
        echo json_encode(['error' => 'No token provided']);
        exit;
    }

    try {
        $db = Database::getInstance();
        $apiKeyManager = new \MyApp\Auth\APIKeyManager($db);

        if (!$apiKeyManager->isTokenValid($token)) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token']);
            exit;
        }

        return $token;
    } catch (Exception $e) {
        error_log("Token validation error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
        exit;
    }
}