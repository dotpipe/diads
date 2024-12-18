#!/bin/bash

# Create directory for file uploads
mkdir -p v1/uploads

# Create file upload handler
cat > v1/api/file_upload.php << EOL
<?php
require_once '../auth/APIKeyManager.php';
require_once '../config/database.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$apiKeyManager = new \MyApp\Auth\APIKeyManager($db);

$token = $_POST['token'];
if (!$apiKeyManager->isTokenValid($token)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    exit;
}

$uploadDir = "../uploads/$token/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$file = $_FILES['file'];
$timestamp = time();
$userId = getUserIdFromToken($token); // Implement this function
$uniqueHash = md5(uniqid(rand(), true));
$fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFileName = "{$timestamp}_{$userId}_{$uniqueHash}.{$fileExtension}";

if (move_uploaded_file($file['tmp_name'], $uploadDir . $newFileName)) {
    $filePath = $uploadDir . $newFileName;
    saveFileInfoToDatabase($userId, $token, $filePath); // Implement this function
    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
}

function getUserIdFromToken($token) {
    global $db;
    $stmt = $db->prepare("SELECT user_id FROM active_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['user_id'];
}

function saveFileInfoToDatabase($userId, $token, $filePath) {
    global $db;
    $stmt = $db->prepare("INSERT INTO user_files (user_id, token, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $token, $filePath);
    $stmt->execute();
}
EOL

# Create function to rename token directory
cat > v1/auth/renameTokenDirectory.php << EOL
<?php
function renameTokenDirectory($oldToken, $newToken) {
    $oldDir = "../uploads/$oldToken";
    $newDir = "../uploads/$newToken";
    if (file_exists($oldDir)) {
        rename($oldDir, $newDir);
        updateFilePathsInDatabase($oldToken, $newToken);
    }
}

function updateFilePathsInDatabase($oldToken, $newToken) {
    global $db;
    $stmt = $db->prepare("UPDATE user_files SET token = ?, file_path = REPLACE(file_path, ?, ?) WHERE token = ?");
    $stmt->bind_param("ssss", $newToken, $oldToken, $newToken, $oldToken);
    $stmt->execute();
}
EOL

# Create database table for user files
cat > v1/db/user_files_schema.sql << EOL
CREATE TABLE user_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(32) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
EOL

echo "File upload system with token-named directories created successfully!"
