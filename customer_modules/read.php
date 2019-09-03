<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/customerModules.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customerModules = new CustomerModules($db);
 
// read users will be here
// query users
$stmt = $customerModules->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if ($num>0) {
 
    // users array
    $customerModules_arr=array();
    $customerModules_arr["customerModules"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $customerModules_item=array(
            "customer_id" => $customer_id,
            "module_id" => $module_id,
            "module_Version" => $module_Version,
        );
 
        array_push($customerModules_arr["customerModules"], $customerModules_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($customerModules_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.","customerModules"=>[])
    );
}
