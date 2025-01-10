<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../api/nav_db_connection.php';

try {

    // Get JSON data from request body
    $data = json_decode(file_get_contents("php://input"));

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data->protectionId) || ($data->protectionId != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

    if (!empty($data->orderId)) {
	$orderId = htmlspecialchars(strip_tags($data->orderId));

	//delete the cart item where cart id match
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);

    	if ($stmt->execute()) {
		// display message
		echo json_encode(['status' => "success", 'message' => 'order deleted successfully']);
	} else {
		echo json_encode(['status' => "error", 'message' => 'Failed to delete order']);
	}

        
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
