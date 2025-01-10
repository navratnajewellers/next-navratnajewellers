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
$inputPassword = $data['password'];

try{

$hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

// Update Session id
$sql = "UPDATE users SET password = :password WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':email', $inputEmail);
//$stmt->execute();
//$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->execute()) {
    // display message
	echo json_encode(['status' => true, 'message' => 'Password updated successfully']);
    } else {
    echo json_encode(['status' => false, 'message' => 'Failed to update']);
}


} catch (PDOException $e){
	echo json_encode(['status' => false, 'message' => 'Error: '. $e->getMessage()]);
}

?>
