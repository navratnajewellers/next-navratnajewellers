<?php
	header('Access-Control-Allow-Origin: *');
	
	header('Content-type:application/json');

	include "api/connection.php";
	
	$sql = "SELECT * FROM customer";

	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$response = array("success" => true, "record" => $row, "message" => "Record of all the customers");

	echo json_encode($response);

	mysqli_close($conn);
	return;
?>