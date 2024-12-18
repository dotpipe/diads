<?php
header('Content-Type: application/json');

$db = new mysqli("localhost", "root", "", "ADAPT");

$query = "SELECT i.item_name, i.price, i.quantity, s.name as store_name
           FROM inventory i
           JOIN stores s ON i.store_id = s.id
           ORDER BY i.item_name, i.price";

$result = $db->query($query);
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $items]);
?>
