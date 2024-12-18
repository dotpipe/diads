<?php
require_once '../api/token_middleware.php';
require_once '../config/database.php';

try {
    // Validate token first
    $token = validateToken();

    $data = json_decode(file_get_contents('php://input'), true);
    $encryptedMessage = $data['message'];

    $db = Database::getInstance();
    $apiKeyManager = new \MyApp\Auth\APIKeyManager($db);
    $userId = $apiKeyManager->getUserIdFromToken($token);

    $stmt = $db->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
    $success = $stmt->execute([$userId, $encryptedMessage]);

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        throw new Exception('Failed to save message');
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}