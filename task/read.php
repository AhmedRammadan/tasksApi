<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$task = new Task($db);
 
// read users will be here
// query users
$stmt = $task->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if ($num>0) {
 
    // users array
    $tasks_arr=array();
    $tasks_arr["tasks"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $tasks_item=array(
            
            "task_id" => $task_id,
            "task_title" => $task_title,
            "task_desc" => $task_desc,
            "customer_id" => $customer_id,
            "module_id" => $module_id,
            "img_url" => $img_url,
            "created_by" => $created_by,
            "created_date" => $created_date,
            "closed_date" => $closed_date,
            "status_id" => $status_id,
        );
 
        array_push($tasks_arr["tasks"], $tasks_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($tasks_arr);
} else {
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.")
    );
}
 
// no products found will be here
