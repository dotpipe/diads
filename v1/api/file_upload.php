<?php
require_once '../auth/APIKeyManager.php';
require_once '../config/database.php';

 = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 = new \MyApp\Auth\APIKeyManager();

 = ['token'];
if (!->isTokenValid()) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    exit;
}

 = "../uploads//";
if (!file_exists()) {
    mkdir(, 0755, true);
}

 = ['file'];
 = time();
 = getUserIdFromToken(); // Implement this function
 = md5(uniqid(rand(), true));
 = pathinfo(['name'], PATHINFO_EXTENSION);
 = "{}_{}_{}.{}";

if (move_uploaded_file(['tmp_name'],  . )) {
     =  . ;
    saveFileInfoToDatabase(, , ); // Implement this function
    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
}

function getUserIdFromToken() {
    global ;
     = ->prepare("SELECT user_id FROM active_tokens WHERE token = ?");
    ->bind_param("s", );
    ->execute();
     = ->get_result();
     = ->fetch_assoc();
    return ['user_id'];
}

function saveFileInfoToDatabase(, , ) {
    global ;
     = ->prepare("INSERT INTO user_files (user_id, token, file_path) VALUES (?, ?, ?)");
    ->bind_param("iss", , , );
    ->execute();
}
