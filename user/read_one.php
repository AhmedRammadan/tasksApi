<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/users.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$user = new Users($db);
// set user_id property of record to read
if (isset($_POST['user_id'])&&
    !empty($_POST['user_id'])) {
    $user->user_id = $_POST['user_id'];
 
    // read the details of product to be edited
    $user->readOne();
 
    if ($user->name!=null) {
        // create array
      
        $product_arr = array(
        "user_id" =>  $user->user_id,
        "name" => $user->name,
        "user_name" => $user->user_name,
        "email" => $user->email,
        "phone" => $user->phone,
        "address" => $user->address,
        "user_category" => $user->user_category

    );
 
        // set response code - 200 OK
        http_response_code(200);
 
        // make it json format
        echo json_encode($product_arr);
    } else {
        // set response code - 404 Not found
        http_response_code(404);
 
        // tell the user product does not exist
        echo json_encode(array("message" => "user does not exist."));
    }
} elseif (!isset($_POST['user_id'])) {
    echo json_encode(array("error" => true  ,"message" => "user_id is required"));
} elseif (empty($_POST['user_id'])) {
    echo json_encode(array("error" => true  ,"message" => "user_id is empty"));
} else {
    echo json_encode(array("message" => "user id"));
}
