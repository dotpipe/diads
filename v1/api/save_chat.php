<?php
// File: v1/api/save_chat.php

require_once '../config/database.php';
require_once '../auth/APIKeyManager.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$apiKeyManager = new \MyApp\Auth\APIKeyManager($db);

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];
$encryptedMessage = $data['message'];

if (!$apiKeyManager->isTokenValid($token)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    exit;
}

$userId = $apiKeyManager->getUserIdFromToken($token);

$stmt = $db->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $userId, $encryptedMessage);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
}
