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


if (
   isset($_POST['user_name'])&&
    !empty($_POST['user_name'])&&
    isset($_POST['password'])&&
    !empty($_POST['password'])
) {
    $user->user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if ($user->userNameExists()) {
        if ($user->password_verify($password)) {
            http_response_code(201);
        
            echo json_encode(array("error" => false  ,"message" => "Successful login.",
            "user_info"=> ["user_id" => $user->user_id,
            "name" => $user->name,
            "email" => $user->email,
            "phone" => $user->phone,
            "address" => $user->address,
            "user_category" => $user->user_category,] ));
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
        http_response_code(503);

        echo json_encode(array("error" => true  ,"message" => "user name  failed."));

        // set response code - 503 service unavailable
      //  http_response_code(503);
 
        // tell the user
      //  echo json_encode(array("error" => true  ,"message" => "Unable to create users."));
    }
} elseif (!isset($_POST['user_name'])) {
    echo json_encode(array("error" => true  ,"message" => "user_name is required"));
} elseif (empty($_POST['user_name'])) {
    echo json_encode(array("error" => true  ,"message" => "user_name is empty"));
} elseif (!isset($_POST['password'])) {
    echo json_encode(array("error" => true  ,"message" => "password is required"));
} elseif (empty($_POST['password'])) {
    echo json_encode(array("error" => true  ,"message" => "password is empty"));
} else {
 
    // set response code - 400 bad request
   /// http_response_code(400);
 
    // tell the user
    //echo json_encode(array("error" => true  ,"message" => "Unable to create product. Data is incomplete."));
}
