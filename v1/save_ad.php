<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_data = $_POST['ad_data'];
    $store_id = $_SESSION['store_id'];
    $address = $_SESSION['store_address'];
    $hours_accumulated = 0; // Initial hours accumulated
    $active = 1; // Active status
    $created_on = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO ads (store_id, address, hours_accumulated, active, created_on, ad_data) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisss", $store_id, $address, $hours_accumulated, $active, $created_on, $ad_data);

    if ($stmt->execute()) {
        echo "New ad created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>