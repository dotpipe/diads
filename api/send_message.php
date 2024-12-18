<?php
require_once '../includes/encryption_functions.php';

$message = $_POST['message'];
$recipient = $_POST['recipient'];

$encrypted_message = encrypt($message);

// Store $encrypted_message in the database
// Send to recipient

echo json_encode(['status' => 'success']);
