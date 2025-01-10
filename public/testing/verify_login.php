<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'api/nav_db_connection.php';

// Get data from React frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}


$inputUsername = $data['username'];
$inputPassword = $data['password'];

// Check if the username exists in the database
$sql = "SELECT password FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $inputUsername);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verify the password
    if (password_verify($inputPassword, $user['password'])) {
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username not found']);
}
?>
