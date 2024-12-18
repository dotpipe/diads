<?php
require_once '../includes/encryption_functions.php';

// Fetch encrypted messages from the database
$encrypted_messages = []; // Replace with actual database query

$decrypted_messages = array_map(function($msg) {
    $msg['content'] = decrypt($msg['content']);
    return $msg;
}, $encrypted_messages);

echo json_encode($decrypted_messages);
