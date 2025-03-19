<?php
require_once '../config/database.php';

function renameTokenDirectory($oldToken, $newToken) {
    $oldDir = "../uploads/$oldToken/";
    $newDir = "../uploads/$newToken/";

    if (file_exists($oldDir)) {
        rename($oldDir, $newDir);
        updateFilePathsInDatabase($oldToken, $newToken);
    }
}

function updateFilePathsInDatabase($oldToken, $newToken) {
    $db = Database::getInstance();
    $stmt = $db->prepare("UPDATE user_files SET token = ?, file_path = REPLACE(file_path, ?, ?) WHERE token = ?");
    $stmt->execute([$newToken, $oldToken, $newToken, $oldToken]);
}
?>
