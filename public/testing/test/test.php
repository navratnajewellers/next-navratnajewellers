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

// getting the price of the gold
$priceQuery = "SELECT * FROM gold_price";
$priceStmt = $pdo->prepare($priceQuery);
$priceStmt->execute();
$priceItems = $priceStmt->fetch();

$makingCharge = $priceItems['price_1_gram_24K'] * $priceItems['making_charge_gold'];
$gst = ($priceItems['price_1_gram_24K'] + $makingCharge) * $priceItems['gst_gold'];
$goldPrice = round($priceItems['price_1_gram_24K'] + $makingCharge + $gst);

echo json_encode(["message" => "Price updated", "data" => $priceItems, "22K gold price" => $priceItems['price_1_gram_24K'], "makingCharge" =>  $makingCharge, "gst" => $gst, "goldPrice" => $goldPrice, "gold-rate-contain" => $priceItems ]);

 } catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
