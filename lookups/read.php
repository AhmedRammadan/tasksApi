<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/lookups.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$lookups = new Lookups($db);
 
// read users will be here
// query users
$stmt = $lookups->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if ($num>0) {
 
    // users array
    $users_arr=array();
    $users_arr["lookups"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $users_item=array(
            "lookup_id" => $lookup_id,
            "lookup_code" => $lookup_code,
            "lookup_name" => $lookup_name,
            "lookup_value" => $lookup_value,
        );
 
        array_push($users_arr["lookups"], $users_item);
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
        array("message" => "No lookups found.")
    );
}
 
// no products found will be here
