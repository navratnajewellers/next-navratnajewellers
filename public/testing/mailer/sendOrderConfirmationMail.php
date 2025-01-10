<?php

   header("Access-Control-Allow-Origin: *");
   header("Content-Type: application/json");
   header("Access-Control-Allow-Methods: POST");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

   require 'vendor/autoload.php';
   //Import PHPMailer classes into the global namespace
   //These must be at the top of your script, not inside a function
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\SMTP;
   use PHPMailer\PHPMailer\Exception;

   require '../api/nav_db_connection.php';


   



// get the user data with address and order details
try {

    // Get JSON data from request body
    $data = json_decode(file_get_contents('php://input'), true);

// check the protection getting from react frontend matched or not, before proceed further otherwise exit
if(empty($data['protectionId']) || ($data['protectionId'] != 'Nav##$56') ){
    echo 'Direct access not allowed';
    exit();
}

    $userId = $data['user_id'];
    $orderId = $data['orderId'];

    // for testing mail send message
    // $userId = 4;
    // $orderId = 'order_PabajVE97rdsEO';


    if (!empty($userId) && !empty($orderId)  ) {


// Move Cart Items to Order Items
// Fetch user with address

$userAddressQuery = "SELECT * FROM users INNER JOIN addresses ON users.id = addresses.user_id WHERE addresses.user_id = ?";
$userAddressStmt = $pdo->prepare($userAddressQuery);
$userAddressStmt->execute([$userId]);
$userAddress = $userAddressStmt->fetch(PDO::FETCH_ASSOC);

$orderQuery = "SELECT * FROM orders WHERE order_id = :orderId";
$orderStmt = $pdo->prepare($orderQuery);
$orderStmt->bindParam(':orderId', $orderId);
$orderStmt->execute();
$orderItem = $orderStmt->fetch(PDO::FETCH_ASSOC);

//echo json_encode(["message" => "Order has been placed successfuly", "userAddress" => $userAddress, "orderItem" => $orderItem ]);

// email format start here



$username = strtoupper($userAddress['username']);
$todayDate=getdate(date("U"));
$orderDate = substr($orderItem['order_date'], 0, 10);
$orderPaymentMethod;

if($orderItem['payment_method'] == 'online'){
	$orderPaymentMethod = 'Paid Online';
} else {
	$orderPaymentMethod = 'Cash On Delivery';
}

$mailSendSubject = "Order ID [{$orderItem['order_id']}] Confirmation";

$sendMessageBody = "<!doctype html>
<html>
  <head>
    <title>Booking corfirmation</title>
    <style>
      body {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande',
          'Lucida Sans', Arial, sans-serif;
      }
      .main-color {
        color: palevioletred;
      }

      .color-blue {
        color: blue;
      }

      .margin-t10 {
        margin-top: 10px;
      }

      .margin-b10 {
        margin-bottom: 10px;
      }

      .margin-t20 {
        margin-top: 20px;
      }

      .margin-b20 {
        margin-bottom: 20px;
      }

      .margin-t30 {
        margin-top: 30px;
      }

      .margin-b30 {
        margin-bottom: 30px;
      }

      .margin-t50 {
        margin-top: 50px;
      }

      .margin-b50 {
        margin-bottom: 50px;
      }

      .imageWrapper {
        width: 200px;
        height: 150px;
        background-image: url(https://navratnajewellers.in/nav-jew-logo.jpg);
        background-size: contain;
        background-repeat: no-repeat;
        margin: auto;
      }

      .logo-container {
        width: 100%;
      }

      .flex-col {
        flex-direction: column;
      }

      .padding-lr5 {
        padding: 0 5%;
      }

      .padding-r10 {
        padding-right: 10px;
      }

      .textCenter {
        text-align: center;
      }

      .textRight {
        text-align: end;
      }

      .table {
        border: solid 1px palevioletred;
        width: 100%;
        text-align: center;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0px 5px palevioletred;
      }

      td {
        padding-top: 10px;
        padding-left: 10px;
        padding-right: 10px;
      }
    </style>
  </head>
  <body>
    <div class='padding-lr5'>
      <div class='logo-container'>
        <div class='imageWrapper'></div>
      </div>
      <div>
        <h1 class='textCenter main-color margin-t5 margin-b50'>
          Thank you for your order
        </h1>
      </div>
      <div>
        <p>Hello, <strong>{$username} </strong></p>
      </div>
      <div>
        <p>
          Just let you know - we have recieved your order id: <strong>{$orderItem['order_id']}</strong>, and it is being
          processed.
        </p>
      </div>
      <div class='margin-t30'>
        <div>
          <h2>Order ID: <span class='main-color'>{$orderItem['order_id']}</span>, Date:  <span class='color-blue'>{$todayDate['weekday']}, {$todayDate['month']} {$todayDate['mday']}, {$todayDate['year']}</span> </h2>
        </div>
        <div>
          <table class='table margin-t30'>
            <thead>
              <tr>
                <th>Order Date</th>
                <th>Order ID</th>
                <th>Payment</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{$orderDate}</td>
                <td>{$orderItem['order_id']}</td>
                <td>{$orderPaymentMethod}</td>
                <td>&#8377; {$orderItem['total_amount']}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <address class='margin-t50 margin-b30'>
        <h3>Shipping address</h3>
        <p class='margin-t20'>
          <strong>Address: </strong> {$userAddress['address_line_1']} {$userAddress['address_line_2']} {$userAddress['country']}  {$userAddress['postal_code']}   
        </p>
        <p><strong>City:</strong> {$userAddress['city']}</p>
        <p><strong>State:</strong> {$userAddress['state']}</p>
        <p><strong>Country:</strong> {$userAddress['country']}</p>
        <p><strong>Landmark:</strong> {$userAddress['landmark']}</p>
        <p><strong>Mobile Number:</strong> {$userAddress['phone_number']}</p>
      </address>
      <div class='margin-t50'>
        <p class='textRight padding-r10'>Thank you for shopping with us</p>
        <h3 class='textRight padding-lr5'>Navratna Jewellers</h3>
      </div>
    </div>
  </body>
</html>
";

    // for testing the email message
    // $sendEmail = 'navratnajewellers0@gmail.com';


   // for sending mail to user
   //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 0;
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostname.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'navratnajewellers@navratnajewellers.in';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('navratnajewellers@navratnajewellers.in', 'Navratna Jewellers');
    // $mail->addAddress($sendEmail, $userAddress['username']);
    $mail->addAddress($userAddress['email'], $userAddress['username']);     //Add a recipient
    $mail->addReplyTo('navratnajewellers@navratnajewellers.in', 'Navratna Jewellers');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mailSendSubject;
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->Body = $sendMessageBody;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->AltBody = 'Your Order has been Confirmed by Navratna Jewellers';

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Message has been sent"]);
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Message could not be sent.", "error" =>  $mail->ErrorInfo ]);
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



// email format end here


    } else {
        echo json_encode(["message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}


?>