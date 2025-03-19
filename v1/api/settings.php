<?php
require_once '../config/database.php';

$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->query("SELECT * FROM settings");
    echo json_encode($stmt->fetchAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("UPDATE settings SET value = ? WHERE name = ?");
    $stmt->execute([$data['value'], $data['name']]);
    echo json_encode(['status' => 'success']);
}
?>
