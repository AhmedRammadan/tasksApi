<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
// instantiate users object
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$task = new Task($db);

// set user_id property of record to read
if (isset($_POST['created_by'])&&
    !empty($_POST['created_by'])) {
    $task->created_by = $_POST['created_by'];
 

    // read the details of product to be edited
   
 
    $stmt = $task->readByDeveloper();
    $num = $stmt->rowCount();
 
    // users array
    $tasks_arr=array();
    $tasks_arr["tasks"]=array();

    // check if more than 0 record found
    if ($num>0) {
 
 
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
        echo json_encode($tasks_arr);
    }
} elseif (!isset($_POST['created_by'])) {
    echo json_encode(array("error" => true  ,"message" => "created_by is required"));
} elseif (empty($_POST['created_by'])) {
    echo json_encode(array("error" => true  ,"message" => "created_by is empty"));
} else {
    echo json_encode(array("message" => "user id"));
}
