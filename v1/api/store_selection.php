<?php
require_once '../config/database.php';

$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->query("SELECT * FROM stores");
    echo json_encode($stmt->fetchAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("INSERT INTO store_revenue (store_id, revenue) VALUES (?, ?)");
    $stmt->execute([$data['store_id'], $data['revenue']]);
    echo json_encode(['status' => 'success']);
}
?>
