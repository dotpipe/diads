<?php
require_once '../config/database.php';

$db = Database::getInstance();

$query = $_GET['q'] ?? '';
$stmt = $db->prepare("SELECT * FROM items WHERE name LIKE ?");
$stmt->execute(["%$query%"]);
echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
?>
