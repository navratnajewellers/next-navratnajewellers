<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../api/nav_db_connection.php';

// Get data from React frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}


$inputEmail = $data['email'];
$inputMobileNo = $data['phone_no'];

// Check if the username exists in the database
// $sql = "SELECT * FROM users WHERE email = :email";
$sql = "SELECT * FROM users INNER JOIN addresses ON users.id = addresses.user_id WHERE users.email = :email AND addresses.phone_number = :mobile_no";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $inputEmail);
$stmt->bindParam(':mobile_no', $inputMobileNo);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['status' => 'success', 'message' => 'Data matched' ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data did not matched']);
}
?>
