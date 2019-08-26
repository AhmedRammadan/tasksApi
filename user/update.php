<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/users.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
$user = new Users($db);


if (isset($_POST['user_id'])&&
    !empty($_POST['user_id'])&&
    isset($_POST['name'])&&
    !empty($_POST['name'])&&
   isset($_POST['user_name'])&&
    !empty($_POST['user_name'])&&
    isset($_POST['password'])&&
    !empty($_POST['password'])&&
    isset($_POST['email'])&&
    !empty($_POST['email'])&&
    isset($_POST['phone'])&&
    !empty($_POST['phone'])&&
    isset($_POST['address'])&&
    !empty($_POST['address'])&&
    isset($_POST['user_category'])&&
    !empty($_POST['user_category'])
) {
    $user->user_id = $_POST['user_id'];
    $user->name = $_POST['name'];
    $user->user_name = $_POST['user_name'];
    $user->password =$_POST['password'];
    $user->email =$_POST['email'];
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    $user->user_category = $_POST['user_category'];
    if ($user->update()) {
 
    // set response code - 200 ok
        http_response_code(200);
 
        // tell the user
        echo json_encode(array("error" => false  ,"message" => "user was updated."));
    }
 
    // if unable to update the product, tell the user
    else {
 
    // set response code - 503 service unavailable
  //      http_response_code(503);
 
        // tell the user
      //  echo json_encode(array("message" => "Unable to update user."));
    }
} elseif (!isset($_POST['user_id'])) {
    echo json_encode(array("error" => true  ,"message" => "user_id is required"));
} elseif (empty($_POST['user_id'])) {
    echo json_encode(array("error" => true  ,"message" => "user_id is empty"));
} else {
}
