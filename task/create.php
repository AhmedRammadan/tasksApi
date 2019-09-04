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
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$task = new Task($db);

if (isset($_POST['task_title'])&&
    !empty($_POST['task_title'])&&
    isset($_POST['task_desc'])&&
    !empty($_POST['task_desc'])&&
   isset($_POST['customer_id'])&&
    !empty($_POST['customer_id'])&&
   isset($_POST['module_id'])&&
    !empty($_POST['module_id'])&&
   isset($_POST['img_url'])&&
    !empty($_POST['img_url'])&&
    isset($_POST['to_user_id'])&&
    !empty($_POST['to_user_id'])&&
    isset($_POST['created_by'])&&
    !empty($_POST['created_by'])&&
    isset($_POST['status_id'])&&
    !empty($_POST['status_id'])
) {
    $task->task_title = $_POST['task_title'];
    $task->task_desc = $_POST['task_desc'];
    $task->customer_id = $_POST['customer_id'];
    $task->module_id = $_POST['module_id'];
    $task->img_url = $_POST['img_url'];
    $task->to_user_id =$_POST['to_user_id'];
    $task->created_by =$_POST['created_by'];
    $task->created_date =date('Y-m-d H:i:s');
    $task->closed_date ='0000-00-00 00:00:00';
    $task->duration_task ='1';
    $task->status_id = $_POST['status_id'];
  
    if ($task->create()) {
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("error" => false  ,"message" => "task was created."));
    }
 
    // if unable to create the users, tell the user
    else {
 
        // // set response code - 503 service unavailable
        // http_response_code(503);
 
        // // tell the user
        // echo json_encode(array("error" => true  ,"message" => "Unable to create users."));
    }
} elseif (!isset($_POST['task_title'])) {
    echo json_encode(array("error" => true  ,"message" => "task_title is required"));
} elseif (empty($_POST['task_title'])) {
    echo json_encode(array("error" => true  ,"message" => "task_title is empty"));
} else {
 
    // set response code - 400 bad request
   /// http_response_code(400);
 
    // tell the user
    //echo json_encode(array("error" => true  ,"message" => "Unable to create product. Data is incomplete."));
}
