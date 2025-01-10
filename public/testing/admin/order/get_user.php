<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require '../../api/nav_db_connection.php';

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

// get user details from the database
	$sql = "SELECT * FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.order_id = :order_id";
        $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':order_id', $orderId);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user) {

		// Get the address of user from the database
		$addressQuery = "SELECT * FROM `addresses` WHERE user_id = :userId";
		$addressStmt = $pdo->prepare($addressQuery);
		$addressStmt->bindParam(':userId', $user['id']);
		$addressStmt->execute();
		$userAddress = $addressStmt->fetch(PDO::FETCH_ASSOC);

 		echo json_encode(['status' => 'success', 'message' => 'user found', 'username' => $user['username'], 'email' => $user['email'], "userAddress" => $userAddress ]);
    
	} else {
    		echo json_encode(['status' => 'error', 'message' => 'Username not found']);
	}



    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>