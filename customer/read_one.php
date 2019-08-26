<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customers.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$customers = new Customers($db);

// set user_id property of record to read
if (isset($_POST['customer_id'])&&
    !empty($_POST['customer_id'])) {
    $customers->customer_id = $_POST['customer_id'];
 
    // read the details of product to be edited
    $customers->readOne();
 
    if ($customers->customer_id!=null) {
        // create array

        $product_arr = array(
        "customer_id" =>  $customers->customer_id,
        "customer_name" => $customers->customer_name,
        "email" => $customers->email,
        "phone" => $customers->phone,
        "address" => $customers->address

    );
 
        // set response code - 200 OK
        http_response_code(200);
 
        // make it json format
        echo json_encode($product_arr);
    } else {
        // set response code - 404 Not found
        http_response_code(404);
 
        // tell the customer product does not exist
        echo json_encode(array("message" => "customer does not exist."));
    }
} elseif (!isset($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is required"));
} elseif (empty($_POST['customer_id'])) {
    echo json_encode(array("error" => true  ,"message" => "customer_id is empty"));
} else {
    echo json_encode(array("message" => "customer id"));
}
