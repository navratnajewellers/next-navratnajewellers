<?php

	$conn = mysqli_connect("127.0.0.1", "root", "", "shopping");

	if(!$conn){
		$response = array("success" => false, "message" => "Connection Failed");
		echo json_encode($response);
		return;
	}

?>