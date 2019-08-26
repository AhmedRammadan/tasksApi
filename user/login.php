<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate users object
include_once '../objects/users.php';

$database = new Database();
$db = $database->getConnection();

$user = new Users($db);
$password = '';

if (
   isset($_POST['user_name'])&&
    !empty($_POST['user_name'])&&
    isset($_POST['password'])&&
    !empty($_POST['password'])
) {
    $user->user_name = $_POST['user_name'];
    $this->password =$_POST['password'];
    if ($user->userNameExists()) {
        if ($user->password_verify($this->password)) {
            http_response_code(201);
            echo json_encode(array("error" => false  ,"message" => "Successful login."));
        } else {
            echo json_encode(array("error" => true  ,"message" => "Login failed."));
        }
        // // set response code - 201 created
        // http_response_code(201);
 
        // // tell the user
        // echo json_encode(array("error" => false  ,"message" => "Successful login."));
    }
 
    // if unable to create the users, tell the user
    else {
 
        // set response code - 503 service unavailable
      //  http_response_code(503);
 
        // tell the user
      //  echo json_encode(array("error" => true  ,"message" => "Unable to create users."));
    }
} elseif (!isset($_POST['name'])) {
    echo json_encode(array("error" => true  ,"message" => "Name is required"));
} elseif (empty($_POST['name'])) {
    echo json_encode(array("error" => true  ,"message" => "Name is empty"));
} else {
 
    // set response code - 400 bad request
   /// http_response_code(400);
 
    // tell the user
    //echo json_encode(array("error" => true  ,"message" => "Unable to create product. Data is incomplete."));
}
