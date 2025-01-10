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

    if (!empty($data->userId)) {
        $userId = htmlspecialchars(strip_tags($data->userId));
	$address1 = htmlspecialchars(strip_tags($data->address1));
        $address2 = htmlspecialchars(strip_tags($data->address2));
	$country = htmlspecialchars(strip_tags($data->country));
	$city = htmlspecialchars(strip_tags($data->city));
	$state = htmlspecialchars(strip_tags($data->state));
        $postalCode = htmlspecialchars(strip_tags($data->pincode));
	$landmark = htmlspecialchars(strip_tags($data->landmark));
	$phoneNumber = htmlspecialchars(strip_tags($data->mobile));


// Check if the user exists in the database
$searchQuery = "SELECT * FROM addresses WHERE user_id = :userId";
$searchStmt = $pdo->prepare($searchQuery);
$searchStmt->bindParam(':userId', $userId);
$searchStmt->execute();
$user = $searchStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {

    // Update Address into the database
	$sql = "UPDATE addresses SET address_line_1 = :address_one, address_line_2 = :address_two, country = :country, city = :city, state = :state, postal_code = :pincode, landmark = :landmark, phone_number = :mobile_number WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':address_one', $address1);
        $stmt->bindParam(':address_two', $address2);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':pincode', $postalCode);
        $stmt->bindParam(':landmark', $landmark);
	$stmt->bindParam(':mobile_number', $phoneNumber);


} else {
    // Insert into the database
	$sql = "INSERT INTO `addresses` (`user_id`, `address_line_1`, `address_line_2`, `country`, `city`, `state`, `postal_code`, `landmark`, `phone_number`) VALUES (:user_id, :address_one, :address_two, :country, :city, :state, :pincode, :landmark, :mobile_number)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':address_one', $address1);
        $stmt->bindParam(':address_two', $address2);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':pincode', $postalCode);
        $stmt->bindParam(':landmark', $landmark);
	$stmt->bindParam(':mobile_number', $phoneNumber);

}


        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Address updated registered successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update address."]);
        }
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>