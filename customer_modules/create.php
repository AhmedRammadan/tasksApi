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
include_once '../objects/customerModules.php';


$database = new Database();
$db = $database->getConnection();

$customerModules = new CustomerModules($db);



if (isset($_POST['customer_id'])&&
    !empty($_POST['customer_id'])&&
   isset($_POST['module_id'])&&
    !empty($_POST['module_id'])&&
    isset($_POST['module_Version'])&&
    !empty($_POST['module_Version'])
) {
    $customerModules->customer_id = $_POST['customer_id'];
    $customerModules->module_id = $_POST['module_id'];
    $customerModules->module_Version =$_POST['module_Version'];
  
    if ($customerModules->create()) {

        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("error" => false  ,"message" => "users was created."));
    }
 
    // if unable to create the users, tell the user
    else {
 
        // set response code - 503 service unavailable
      //  http_response_code(503);
 
        // tell the user
      //  echo json_encode(array("error" => true  ,"message" => "Unable to create users."));
    }
} elseif (!isset($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is required"));
} elseif (empty($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is empty"));
} else {
 
    // set response code - 400 bad request
   /// http_response_code(400);
 
    // tell the user
    //echo json_encode(array("error" => true  ,"message" => "Unable to create product. Data is incomplete."));
}
