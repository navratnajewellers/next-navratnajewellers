//header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Set the age to 1 day to improve speed/caching.
//header('Access-Control-Max-Age: 86400');

// Exit early so the page isn't fully loaded for options requests
//if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
//    exit();
//}

// additional information
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Origin: https://www.example.com');
//http://localhost:5173/
//https://navratnajewellers.in

//header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');