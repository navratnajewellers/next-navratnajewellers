<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../api/nav_db_connection.php';

try{

// Get data from React frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

// Check if the username exists in the database
$days = 30;
$sql = "DELETE FROM offline_cart WHERE created_at < NOW() - INTERVAL $days DAY";
$stmt = $pdo->prepare($sql);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Old local cart deleted']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unable to delete loacl cart data']);
}

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
