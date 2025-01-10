<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'api/nav_db_connection.php';

try {

    // Get JSON data from request body
    $data = json_decode(file_get_contents("php://input"));

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data->protectionId) || ($data->protectionId != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

    if (!empty($data->username) && !empty($data->password)) {
        $username = htmlspecialchars(strip_tags($data->username));
	$email = htmlspecialchars(strip_tags($data->email));
        $password = htmlspecialchars(strip_tags($data->password));

	$userId = uniqid();

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $sql = "INSERT INTO users (id, username, password, email) VALUES (:userId, :username, :password, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
	$stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo json_encode(["message" => "User registered successfully."]);
        } else {
            echo json_encode(["message" => "Failed to register user."]);
        }
    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
