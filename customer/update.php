<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customers.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
$customers = new Customers($db);
    
if (isset($_POST['customer_id'])&&
    !empty($_POST['customer_id'])&&
    isset($_POST['customer_name'])&&
    !empty($_POST['customer_name'])&&
    isset($_POST['email'])&&
    !empty($_POST['email'])&&
    isset($_POST['phone'])&&
    !empty($_POST['phone'])&&
    isset($_POST['address'])&&
    !empty($_POST['address'])
) {
    $customers->customer_id = $_POST['customer_id'];
    $customers->customer_name = $_POST['customer_name'];
    $customers->email =$_POST['email'];
    $customers->phone = $_POST['phone'];
    $customers->address = $_POST['address'];
    if ($customers->update()) {
 
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
} elseif (!isset($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is required"));
} elseif (empty($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is empty"));
} else {
}
