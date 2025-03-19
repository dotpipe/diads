<?php
require_once '../config/database.php';

$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->query("SELECT * FROM shopping_list");
    echo json_encode($stmt->fetchAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("INSERT INTO shopping_list (item, quantity) VALUES (?, ?)");
    $stmt->execute([$data['item'], $data['quantity']]);
    echo json_encode(['status' => 'success']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("DELETE FROM shopping_list WHERE id = ?");
    $stmt->execute([$data['id']]);
    echo json_encode(['status' => 'success']);
}
?>
