<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/customers.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customers = new Customers($db);

 
// read users will be here
// query users
$stmt = $customers->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if ($num>0) {
 
    // users array
    $users_arr=array();
    $users_arr["customers"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $users_item=array(
            "customer_id" => $customer_id,
            "customer_name" => $customer_name,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
        );
 
        array_push($users_arr["customers"], $users_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($users_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.")
    );
}
 
// no products found will be here