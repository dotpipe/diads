<?php
header("Content-Type: application/json");

$db = new mysqli("localhost", "root", "", "ADAPT");

$listData = json_decode(file_get_contents("php://input"), true);

$response = array();

foreach ($listData['items'] as $item) {
    $query = "SELECT s.id as store_id, s.name as store_name, i.quantity, i.price 
              FROM inventory i 
              JOIN stores s ON i.store_id = s.id 
              WHERE i.item_name = ? AND i.quantity >= ?
              ORDER BY i.price ASC";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $item['name'], $item['quantity']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stores = array();
    while ($row = $result->fetch_assoc()) {
        $stores[] = $row;
    }
    
    $response[$item['name']] = $stores;
}

echo json_encode([
    "status" => "success",
    "data" => $response
]);
