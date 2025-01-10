<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Access-Control-Max-Age: 86400');

// Exit early so the page isn't fully loaded for options requests
if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
    exit();
}

// header close

require '../api/nav_db_connection.php';

// Get data from React frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

try {


     // get the build version from the database
	$sql = "SELECT * FROM nav_version";
        $stmt = $pdo->prepare($sql);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(["status" => "success","message" => "Version Data retrive successfuly.", "version" => $user['version'] ]);
        } else {
            echo json_encode(["message" => "Failed to retrive version data."]);
        }

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
