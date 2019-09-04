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
include_once '../objects/taskProcess.php';
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$taskProcess = new taskProcess($db);
$task = new Task($db);

if (isset($_POST['task_id'])&&
    !empty($_POST['task_id'])&&
    isset($_POST['assigned_to'])&&
    !empty($_POST['assigned_to'])&&
   isset($_POST['assigned_by'])&&
    !empty($_POST['assigned_by'])&&
   isset($_POST['process_desc'])&&
    !empty($_POST['process_desc'])&&
    isset($_POST['img_url'])&&
    !empty($_POST['img_url'])&&
    isset($_POST['status'])&&
    !empty($_POST['status'])
) {
    $taskProcess->task_id = $_POST['task_id'];
    $taskProcess->assigned_to = $_POST['assigned_to'];
    $taskProcess->assigned_date = date('Y-m-d H:i:s');
    $taskProcess->assigned_by = $_POST['assigned_by'];
    $taskProcess->process_desc = $_POST['process_desc'];
    $taskProcess->img_url =$_POST['img_url'];
    $taskProcess->status =$_POST['status'];
  
    if ($taskProcess->create()) {
        // set response code - 201 created
        $task->task_id = $taskProcess->task_id;
        $task->to_user_id = $taskProcess->assigned_to;
  
        if ($task->updateDeveloper()) {
            http_response_code(201);

            // tell the user
            echo json_encode(array("error" => false  ,"message" => "taskProcess was created."));
        }
    }
 
    // if unable to create the users, tell the user
    else {
 
        // // set response code - 503 service unavailable
        // http_response_code(503);
 
        // // tell the user
        // echo json_encode(array("error" => true  ,"message" => "Unable to create users."));
    }
} elseif (!isset($_POST['task_id'])) {
    echo json_encode(array("error" => true  ,"message" => "task_id is required"));
} elseif (empty($_POST['task_id'])) {
    echo json_encode(array("error" => true  ,"message" => "task_id is empty"));
} else {
 
    // set response code - 400 bad request
   /// http_response_code(400);
 
    // tell the user
    //echo json_encode(array("error" => true  ,"message" => "Unable to create product. Data is incomplete."));
}
