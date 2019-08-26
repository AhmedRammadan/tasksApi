<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
// instantiate users object
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$task = new Task($db);

if (isset($_POST['task_id'])&&
    !empty($_POST['task_id'])&&
    isset($_POST['status_id'])&&
    !empty($_POST['status_id'])
) {
    $task->task_id = $_POST['task_id'];
    $task->status_id = $_POST['status_id'];
  
    if ($task->update()) {

        // set response code - 201 update
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("error" => false  ,"message" => "task was update."));
    }
 
    // if unable to create the users, tell the user
    else {
 
        // set response code - 503 service unavailable
      //  http_response_code(503);
 
        // tell the user
      //  echo json_encode(array("error" => true  ,"message" => "Unable to update task."));
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
