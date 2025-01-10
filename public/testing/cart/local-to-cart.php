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

    $movedQuantity = 0;


    if (!empty($data['user_id']) && !empty($data['hashedId'])) {


// getting the price of the gold
$priceQuery = "SELECT * FROM gold_price";
$priceStmt = $pdo->prepare($priceQuery);
$priceStmt->execute();
$priceItems = $priceStmt->fetch();



// assigning values
    $userId = $data['user_id'];
    $localUserId = $data['hashedId'];

	// set the gold and silver price from the database
        $goldPrice = $priceItems['price_1_gram_24K'];
	$silverPrice = $priceItems['price_1_gram_24K_s'];


// Move Cart Items to Order Items
// Fetch items from cart

$cartItemsQuery = "SELECT * FROM offline_cart WHERE local_user_id = ?";
$cartItemsStmt = $pdo->prepare($cartItemsQuery);
$cartItemsStmt->execute([$localUserId]);
$cartItems = $cartItemsStmt->fetchAll();

foreach ($cartItems as $item) {

// get the product details and calculating the product price
$productQuery = "SELECT * FROM product WHERE product_id = :productId";
$productStmt = $pdo->prepare($productQuery);
$productStmt->bindParam(':productId', $item['product_id']);
$productStmt->execute();
$productItem = $productStmt->fetch(PDO::FETCH_ASSOC);

$productPrice;


	//check product already add to cart with user and product ID
	$sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':user_id', $userId);
	$stmt->bindParam(':product_id', $item['product_id'] );
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);


// if already product is added in cart
	if ($user) {

		// update the price and quantity
		$quantity = $user['quantity'] + $item['quantity'];

// caluculating price of gold and silver with making charge and gst
if($productItem['metal_type'] == 'Gold'){

$productPrice = $goldPrice * $productItem['weight'] *  $quantity;
$makingCharge = $productPrice * 0.08;
$subTotal = $productPrice + $makingCharge;
$gst = $subTotal * 0.03;
$productPrice = round($subTotal + $gst);

} else {

$productPrice = $silverPrice * $productItem['weight'] *  $quantity;
$makingCharge = 20;
$subTotal = $productPrice + $makingCharge;
$gst = $subTotal * 0.03;
$productPrice = round($subTotal + $gst);

}

// calculation end


		// Update pervious product in cart
		$updateCartQuery = "UPDATE cart SET quantity = :quantity, price = :price WHERE user_id = :user_id AND product_id = :product_id";
		$updateCartStmt = $pdo->prepare($updateCartQuery);
		$updateCartStmt->bindParam(':user_id', $userId);
		$updateCartStmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
		$updateCartStmt->bindParam(':quantity', $quantity);
		$updateCartStmt->bindParam(':price', $productPrice);
		$updateCartStmt->execute();

    
	} else {

// caluculating price of gold and silver with making charge and gst
if($productItem['metal_type'] == 'Gold'){

$productPrice = $goldPrice * $productItem['weight'] *  $item['quantity'];
$makingCharge = $productPrice * 0.08;
$subTotal = $productPrice + $makingCharge;
$gst = $subTotal * 0.03;
$productPrice = round($subTotal + $gst);

} else {

$productPrice = $silverPrice * $productItem['weight'] *  $item['quantity'];
$makingCharge = 20;
$subTotal = $productPrice + $makingCharge;
$gst = $subTotal * 0.03;
$productPrice = round($subTotal + $gst);

}

// calculation end

		// update the quantity and price
		$quantity = $item['quantity'];
		//$price = $goldPrice * $quantity;

		    // Insert into the database
	        $insertCartQuery = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (:user_id, :product_id, :quantity, :price)";
	        $insertCartStmt = $pdo->prepare($insertCartQuery);
	        $insertCartStmt->bindParam(':user_id', $userId);
	        $insertCartStmt->bindParam(':product_id', $item['product_id']);
		$insertCartStmt->bindParam(':quantity', $quantity);
		$insertCartStmt->bindParam(':price', $productPrice);
		$insertCartStmt->execute();

	        
	}

	// updated the total moved Quantity
	$movedQuantity = $movedQuantity + $item['quantity'];


}

// Clear the Cart

$clearCartQuery = "DELETE FROM offline_cart WHERE local_user_id = ?";
$clearCartStmt = $pdo->prepare($clearCartQuery);
$clearCartStmt->execute([$localUserId]);


	echo json_encode(["status" => "success", "message" => "Items moved from local cart to user cart successfully", "movedQuantity" => $movedQuantity]);
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
