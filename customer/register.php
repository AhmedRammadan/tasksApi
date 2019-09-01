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
include_once '../objects/customers.php';

$database = new Database();
$db = $database->getConnection();

$customers = new Customers($db);


if (isset($_POST['customer_name'])&&
    !empty($_POST['customer_name'])&&
    isset($_POST['email'])&&
    !empty($_POST['email'])&&
    isset($_POST['phone'])&&
    !empty($_POST['phone'])&&
    isset($_POST['address'])&&
    !empty($_POST['address'])
) {
    $customers->customer_name = $_POST['customer_name'];
    $customers->email =$_POST['email'];
    $customers->phone = $_POST['phone'];
    $customers->address = $_POST['address'];
  
    if ($customers->create()) {
        $product_arr = array();
        $customers->readOneByCustomerName();
        if ($customers->customer_name!=null) {
            $product_arr = array(
                 "customer_id" =>  $customers->customer_id,
                 "customer_name" => $customers->customer_name,
                 "email" => $customers->email,
                 "phone" => $customers->phone,
                 "address" => $customers->address

             );
        }

        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("error" => false  ,"message" => "users was created.","customer_info" => $product_arr  ,));
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
