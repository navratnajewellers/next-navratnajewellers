<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../api/nav_db_connection.php';

try {

// Get data from React frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

$inputuserId = $data['userId'];

// Check if the username exists in the database
$sql = "SELECT * FROM addresses INNER JOIN users ON addresses.user_id = users.id WHERE user_id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userId', $inputuserId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {

    echo json_encode(['status' => 'found', 'message' => 'Address is filled already', 'mobile' => $user['phone_number'], 'address1' => $user['address_line_1'], 'address2' => $user['address_line_2'], 'country' => $user['country'], 'city' => $user['city'], 'state' => $user['state'], 'pincode' => $user['postal_code'], 'email' => $user['email'] ]);

} else {
    echo json_encode(['status' => 'notFound', 'message' => 'Address not found']);
}

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
