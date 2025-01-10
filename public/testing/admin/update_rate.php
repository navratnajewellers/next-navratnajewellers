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

    if (!empty($data->goldRate24k) && !empty($data->silverRate) && !empty($data->goldRate22k) && !empty($data->goldRate18k) ) {
        $goldRate24k = htmlspecialchars(strip_tags($data->goldRate24k));
	$silverRate = htmlspecialchars(strip_tags($data->silverRate));
        $goldRate22k = htmlspecialchars(strip_tags($data->goldRate22k));
        $goldRate18k = htmlspecialchars(strip_tags($data->goldRate18k));


// Update Address into the database
	$sql = "UPDATE gold_price SET price_1_gram_24K = :gold_rate_24k, price_1_gram_24K_s = :silver_price, price_1_gram_22K = :gold_rate_22k, price_1_gram_18K = :gold_rate_18k WHERE id = 1";
        $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':gold_rate_24k', $goldRate24k);
        $stmt->bindParam(':silver_price', $silverRate);
	$stmt->bindParam(':gold_rate_22k', $goldRate22k);
	$stmt->bindParam(':gold_rate_18k', $goldRate18k);
        


        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Rate updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update rate."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>