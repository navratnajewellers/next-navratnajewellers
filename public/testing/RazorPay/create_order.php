<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay credentials
//$keyId = "rzp_test_1MFRdd0BJJ1Heu";
//$keySecret = "U7OVvF7GRNRhkUUE7PJn12GX";

// Initialize Razorpay API
$api = new Api($keyId, $keySecret);


// Capture details from the frontend
$data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}


$amount = $data['amount']; 
// Amount in paise (e.g., 50000 = ₹500)
//$amount = 50000;
$currency = "INR";

// Create order
 $order = $api->order->create([
    'amount' => $amount, 
    'currency' => $currency,
    'receipt' => 'order_rcptid_' . time(),
]);

// Send the order ID back to the frontend
 echo json_encode([
    'order_id' => $order['id']
]); 
?>