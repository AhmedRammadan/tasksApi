<?php
class TaskProcess
{
    private $conn;
    private $table_name = "task_process";

                                
    public $process_id;
    public $task_id;
    public $assigned_to;
    public $assigned_date;
    public $assigned_by;
    public $process_desc;
    public $img_url;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function read()
    {
        $query = "SELECT * FROM
        " . $this->table_name ;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    public function create()
    {
        $query = "INSERT INTO
  " . $this->table_name . "
SET
   task_id=:task_id, assigned_to=:assigned_to, assigned_date=:assigned_date, assigned_by=:assigned_by, process_desc=:process_desc, img_url=:img_url, status=:status";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        //  $this->process_id=htmlspecialchars(strip_tags($this->process_id));
        $this->task_id=htmlspecialchars(strip_tags($this->task_id));
        $this->assigned_to=htmlspecialchars(strip_tags($this->assigned_to));
        $this->assigned_date=htmlspecialchars(strip_tags($this->assigned_date));
        $this->assigned_by=htmlspecialchars(strip_tags($this->assigned_by));
        $this->process_desc=htmlspecialchars(strip_tags($this->process_desc));
        $this->img_url=htmlspecialchars(strip_tags($this->img_url));
        $this->status=htmlspecialchars(strip_tags($this->status));

        // bind values
        //$stmt->bindParam(":process_id", $this->process_id);
        $stmt->bindParam(":task_id", $this->task_id);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":assigned_date", $this->assigned_date);
        $stmt->bindParam(":assigned_by", $this->assigned_by);
        $stmt->bindParam(":process_desc", $this->process_desc);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":status", $this->status);

        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            if (strpos($stmt->errorInfo()[2], 'name') !== false &&
                strpos($stmt->errorInfo()[2], 'user_name') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'Name and User Name taken '));
            } elseif (strpos($stmt->errorInfo()[2], 'user_name') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'User Name taken'));
            } elseif (strpos($stmt->errorInfo()[2], 'name') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'Name taken'));
            } elseif (strpos($stmt->errorInfo()[2], 'customer_id') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'customer_id taken'));
            } elseif (strpos($stmt->errorInfo()[2], 'module_id') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'module_id taken'));
            }
            echo json_encode(array("error" => true  ,"message" => $stmt->errorInfo()[2]));
        }
    
        return false;
    }
}
