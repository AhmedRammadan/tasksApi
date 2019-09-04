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
    isset($_POST['create_day'])&&
    !empty($_POST['create_day']&&
    isset($_POST['day'])&&
    !empty($_POST['day']))
) {
    $task->task_id = $_POST['task_id'];
    $task->duration_task = $_POST['create_day']>$_POST['day']?$_POST['create_day'] - $_POST['day'] :$_POST['day'] -$_POST['create_day'] ;
  
    if ($task->updateDurationTask()) {

        // set response code - 201 update
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("error" => false  ,"message" => "task was update.","duration_task" => $task->duration_task));
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
