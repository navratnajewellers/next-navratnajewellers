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

    if (!empty($data->user_id) && !empty($data->product_id) && !empty($data->quantity) && !empty($data->price)) {
	$user_id = htmlspecialchars(strip_tags($data->user_id));
	$productId = htmlspecialchars(strip_tags($data->product_id));
        $quantity = htmlspecialchars(strip_tags($data->quantity));
	$price = htmlspecialchars(strip_tags($data->price));


	//check product already add to cart with user and product ID
	$sql = "SELECT * FROM offline_cart WHERE local_user_id = :user_id AND product_id = :product_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->bindParam(':product_id', $productId);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user) {
	    // update the price and quantity
		$updatedPrice = $price / $quantity;
		$quantity = $quantity + $user['quantity'];
		$price = $updatedPrice * $quantity;

		// Update Session id
		$sql = "UPDATE offline_cart SET quantity = :quantity, price = :price WHERE local_user_id = :user_id AND product_id = :product_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
		$stmt->bindParam(':quantity', $quantity);
		$stmt->bindParam(':price', $price);

		if ($stmt->execute()) {
		    // display message
			echo json_encode(['status' => true, 'message' => 'Cart updated successfully.']);
		    } else {
		    echo json_encode(['status' => false, 'message' => 'Failed to update cart']);
		}

    
	} else {

		    // Insert into the database
	        $sql = "INSERT INTO offline_cart ( local_user_id, product_id, quantity, price) VALUES ( :user_id, :product_id, :quantity, :price)";
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':user_id', $user_id);
	        $stmt->bindParam(':product_id', $productId);
		$stmt->bindParam(':quantity', $quantity);
		$stmt->bindParam(':price', $price);

	        if ($stmt->execute()) {
	            echo json_encode(["message" => "Cart updated successfully."]);
	        } else {
	            echo json_encode(["message" => "Failed to update cart."]);
	        }

	}

        
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
