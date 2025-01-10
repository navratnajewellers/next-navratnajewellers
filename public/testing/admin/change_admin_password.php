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


$inputAdminId = $data['adminId'];
$inputPassword = $data['password'];

try{

$hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

// Update Session id
$sql = "UPDATE nav_admin SET ad_password = :password WHERE ad_id = :admin_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':admin_id', $inputAdminId);
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
