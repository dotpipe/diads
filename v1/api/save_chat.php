<?php
// File: v1/v1/api/save_chat.php

require_once '../config/database.php';
require_once '../auth/APIKeyManager.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$apiKeyManager = new \MyApp\Auth\APIKeyManager($db);

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];
$message = $data['message'];

if (!$apiKeyManager->isTokenValid($token)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    exit;
}

$userId = $apiKeyManager->getUserIdFromToken($token);
$targetUserId = $data['target_user_id'];
$timestamp = date('Y-m-d H:i:s');
$messageFilePath = "../messages/{$userId}_{$targetUserId}_" . time() . ".xml";

$xmlContent = "<?xml version='1.0' encoding='UTF-8'?>
<messages>
    <message>
        <user_id>{$userId}</user_id>
        <target_user_id>{$targetUserId}</target_user_id>
        <timestamp>{$timestamp}</timestamp>
        <content><![CDATA[{$message}]]></content>
    </message>
</messages>";

if (file_exists($messageFilePath)) {
    $existingXml = simplexml_load_file($messageFilePath);
    $newMessage = $existingXml->addChild('message');
    $newMessage->addChild('user_id', $userId);
    $newMessage->addChild('target_user_id', $targetUserId);
    $newMessage->addChild('timestamp', $timestamp);
    $newMessage->addChild('content', $message);
    $existingXml->asXML($messageFilePath);
} else {
    file_put_contents($messageFilePath, $xmlContent);
}

$stmt = $db->prepare("INSERT INTO chat_messages (user_id, target_user_id, message_file_path) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userId, $targetUserId, $messageFilePath);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
}
?>
