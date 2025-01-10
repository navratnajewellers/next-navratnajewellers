<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../api/nav_db_connection.php';

try {

    // Get JSON data from request body
    $data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}


    if (!empty($data['order_id'])) {



// assigning values
    $orderId = $data['order_id'];
    $updatedStatus = $data['updated_status'];


// Move Cart Items to Order Items
// Fetch items from cart

$orderItemsQuery = "SELECT * FROM order_items WHERE order_id_oi = ?";
$orderItemsStmt = $pdo->prepare($orderItemsQuery);
$orderItemsStmt->execute([$orderId]);
$orderItems = $orderItemsStmt->fetchAll();

foreach ($orderItems as $item) {


		// Update Session id
		$updateOrderItemQuery = "UPDATE order_items SET delivery_status = :updated_status WHERE order_id_oi = :order_id";
		$updateOrderItemStmt = $pdo->prepare($updateOrderItemQuery);
		$updateOrderItemStmt->bindParam(':updated_status', $updatedStatus);
		$updateOrderItemStmt->bindParam(':order_id', $orderId);
		$updateOrderItemStmt->execute();



}



	echo json_encode(["status" => "success", "message" => "Order has cancel successfully"]);
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
