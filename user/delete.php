<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/users.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$user = new Users($db);
 
// get product id

if (isset($_POST['user_id'])&&
    !empty($_POST['user_id'])
) {
    $user->user_id = $_POST['user_id'];
    // delete the user
    if ($user->delete()) {
 
    // set response code - 200 ok
        http_response_code(200);
 
        // tell the user
        echo json_encode(array("message" => "user was deleted.","delete"=>true));
    }
    // if unable to delete the user
    else {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to delete user.","delete"=>true));
    }
} elseif (!isset($_POST['user_id'])) {
    echo json_encode(array( "message" => "user_id is required"));
} elseif (empty($_POST['user_id'])) {
    echo json_encode(array("message" => "user_id is empty","delete"=>true));
} else {
 
    // set response code - 400 bad request
   // http_response_code(400);
 
    // tell the user
   // echo json_encode(array("error" => true  ,"message" => "Unable to delete user."));
}
