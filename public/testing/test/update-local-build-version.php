<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Database connection
$dsn = 'mysql:host=127.0.0.1;dbname=navratna';
$username = 'root'; // Change to your database username
$password = '';     // Change to your database password
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}


try {

	// get the version from database
	$versionQuery = "SELECT * FROM nav_version";
	$versionStmt = $pdo->prepare($versionQuery);
	$versionStmt->execute();
	$user = $versionStmt->fetch(PDO::FETCH_ASSOC);


		$updatedVersion = $user['version'] + 0.01;

		$sql = "UPDATE nav_version SET version = :version WHERE id = :version_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':version', $updatedVersion);
		$stmt->bindParam(':version_id', $user['id']);

		if ($stmt->execute()) {
		    // display message
			echo json_encode(['status' => true, 'message' => 'Local version updated successfully.', 'updatedVersion' => $updatedVersion ]);
		    } else {
		    echo json_encode(['status' => false, 'message' => 'Failed to update local version']);
		}


    
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
