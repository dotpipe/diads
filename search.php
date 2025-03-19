<?php
require_once '../v1/api/token_middleware.php';
require_once '../config/database.php';

$token = validateToken();
$db = Database::getInstance();

try {
    $query = $_GET['q'] ?? '';
    $stmt = $db->prepare("SELECT * FROM items WHERE name LIKE ?");
    $stmt->execute(["%$query%"]);
    echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    error_log("Search error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Search failed']);
}