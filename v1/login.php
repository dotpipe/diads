<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;

        if ($role == 'store_owner') {
            $storeData = getStoreData($id);
            $_SESSION['store_id'] = $storeData['id'];
            $_SESSION['store_address'] = $storeData['address'];
        }

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();

function getStoreData($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, address FROM stores WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($store_id, $store_address);
    $stmt->fetch();
    $stmt->close();
    return ['id' => $store_id, 'address' => $store_address];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>