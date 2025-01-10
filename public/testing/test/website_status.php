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

try {


     // fetch website update status from the database
	$sql = "SELECT * FROM website_update";
        $stmt = $pdo->prepare($sql);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(["status" => "success","message" => "Website status retrive successfuly.", "update_status" => $user['update_status'] ]);
        } else {
            echo json_encode(["message" => "Failed to retrive website status."]);
        }

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
