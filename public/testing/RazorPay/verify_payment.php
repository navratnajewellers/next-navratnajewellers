<?php

require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Razorpay\Api\Api;

require '../api/nav_db_connection.php';

require './nav_razor_api_key.php';

try {

    // Razorpay API credentials
    // $api_key = 'YOUR_RAZORPAY_KEY_ID';
    // $api_secret = 'YOUR_RAZORPAY_SECRET';

    $api = new Api($api_key, $api_secret);

    $input = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($input['protectionId']) || ($input['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

    $attributes = [
        'razorpay_order_id' => $input['razorpay_order_id'],
        'razorpay_payment_id' => $input['razorpay_payment_id'],
        'razorpay_signature' => $input['razorpay_signature'],
    ];

    try {
        $api->utility->verifyPaymentSignature($attributes);

        $stmt1 = $pdo->prepare("INSERT INTO payment_details (pd_order_id, pd_payment_id, pd_verify_signature) VALUES (?, ?, ?)");
        $stmt1->execute([$input['razorpay_order_id'], $input['razorpay_payment_id'], $input['razorpay_signature']]);

        // Update payment status in the database
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->execute(['paid', $input['razorpay_order_id']]);

        echo json_encode(['status' => 'success', 'orderId' => $input['razorpay_order_id'] ]);
    } catch (\Exception $e) {
        echo json_encode(['status' => 'failure', 'error' => $e->getMessage()]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
