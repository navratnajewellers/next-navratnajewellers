<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'vendor/autoload.php';

use Razorpay\Api\Api;

require '../api/nav_db_connection.php';

require './nav_razor_api_key.php';

try {

    // Razorpay API credentials
    // $api_key = 'YOUR_RAZORPAY_KEY_ID';
    // $api_secret = 'YOUR_RAZORPAY_SECRET';

    $api = new Api($api_key, $api_secret);

    // Create Razorpay order
    $input = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($input['protectionId']) || ($input['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

    // Amount in paise
    $amount = $input['amount']; 
    $userId = $input['user_id'];
    $inputPaymentMethod = $input['paymentMethod'];

    $orderData = [
        'receipt' => uniqid(),
        'amount' => $amount,
        'currency' => 'INR',
    ];

    $razorpayOrder = $api->order->create($orderData);

    // Save order details to the database
    $stmt = $pdo->prepare("INSERT INTO orders (order_id, user_id, total_amount, status, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$razorpayOrder['id'], $userId, $amount/100, 'created', $inputPaymentMethod]);

    echo json_encode(['order_id' => $razorpayOrder['id'], 'amount' => $amount]);
    //echo json_encode(['user_id' => $userId, 'amount' => $amount]);
} catch (Exception $e) {
    //http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>