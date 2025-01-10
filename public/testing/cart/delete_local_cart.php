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

    if (!empty($data->local_id) && !empty($data->action_type)) {
	$localCartId = htmlspecialchars(strip_tags($data->local_id));
	$actionType = htmlspecialchars(strip_tags($data->action_type));

    // price of single product include with making charge and gst
    $productPrice = htmlspecialchars(strip_tags($data->product_price));

	$quantity = htmlspecialchars(strip_tags($data->quantity));

    // set the price of product
    $price = $productPrice * $quantity;

    
	if ($actionType == 'remove') {

        //delete the cart item where cart id match
        $sql = "DELETE FROM offline_cart WHERE id = :local_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':local_id', $localCartId, PDO::PARAM_INT);

		if ($stmt->execute()) {
		    // display message
			echo json_encode(['status' => true, 'message' => 'Cart deleted successfully']);
		    } else {
		    echo json_encode(['status' => false, 'message' => 'Failed to delete cart']);
		}

    
	} else if($actionType == 'increaseDecreaseQuantity') {

		    // Update Session id
		$sql = "UPDATE offline_cart SET quantity = :quantity, price = :price WHERE id = :local_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':local_id', $localCartId, PDO::PARAM_INT);
		$stmt->bindParam(':quantity', $quantity);
		$stmt->bindParam(':price', $price);

		if ($stmt->execute()) {
		    // display message
			echo json_encode(['status' => true, 'message' => 'Cart quantity updated successfully']);
		    } else {
		    echo json_encode(['status' => false, 'message' => 'Failed to quantity updated cart']);
		}

	} 

        
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
