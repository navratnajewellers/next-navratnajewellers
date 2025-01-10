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

    if (!empty($data->websiteStatus) || $data->websiteStatus == 0 ) {
        $websiteStatus = htmlspecialchars(strip_tags($data->websiteStatus));

// Update website status into the database
	$sql = "UPDATE website_update SET update_status = :site_status WHERE id = 1";
        $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':site_status', $websiteStatus);
        


        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Website status updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update website status."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>