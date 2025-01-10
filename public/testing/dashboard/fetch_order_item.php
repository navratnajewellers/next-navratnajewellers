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

$inputOrderId = $data['orderId'];


// Check if the username exists in the database
$sql = "SELECT * FROM order_items WHERE order_id_oi = :order_id ";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':order_id', $inputOrderId);
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['status' => 'success', 'message' => 'Order Item found successfullly', 'record' => $user ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order Item not found']);
}
?>
