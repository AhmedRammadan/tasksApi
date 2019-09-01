<?php
class Task
{
    private $conn;
    private $table_name = "tasks";


    public $task_id;
    public $task_title;
    public $task_desc;
    public $customer_id;
    public $module_id;
    public $img_url;
    public $created_by;
    public $created_date;
    public $closed_date;
    public $status_id;

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
  task_title=:task_title, task_desc=:task_desc, customer_id=:customer_id, module_id=:module_id, img_url=:img_url, created_by=:created_by, created_date=:created_date,closed_date=:closed_date, status_id=:status_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->task_title=htmlspecialchars(strip_tags($this->task_title));
        $this->task_desc=htmlspecialchars(strip_tags($this->task_desc));
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->module_id=htmlspecialchars(strip_tags($this->module_id));
        $this->img_url=htmlspecialchars(strip_tags($this->img_url));
        $this->created_by=htmlspecialchars(strip_tags($this->created_by));
        $this->created_date=htmlspecialchars(strip_tags($this->created_date));
        $this->closed_date=htmlspecialchars(strip_tags($this->closed_date));
        $this->status_id=htmlspecialchars(strip_tags($this->status_id));

        // bind values
        $stmt->bindParam(":task_title", $this->task_title);
        $stmt->bindParam(":task_desc", $this->task_desc);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":module_id", $this->module_id);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":created_by", $this->created_by);
        $stmt->bindParam(":created_date", $this->created_date);
        $stmt->bindParam(":closed_date", $this->closed_date);
        $stmt->bindParam(":status_id", $this->status_id);

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
    
    public function readByStatus()
    {

    // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE
        status_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->status_id);

        $stmt->execute();
        return $stmt;
    }

    public function readByDeveloper()
    {

    // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE
        created_by = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->created_by);

        $stmt->execute();
        return $stmt;
    }
    public function readByCustomer()
    {

    // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE
        customer_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->customer_id);

        $stmt->execute();
        return $stmt;
    }
    // update the product
    public function update()
    {
                    
    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        status_id = :status_id
        WHERE
        task_id = :task_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->status_id=htmlspecialchars(strip_tags($this->status_id));
        $this->task_id=htmlspecialchars(strip_tags($this->task_id));

        // bind new values
        $stmt->bindParam(':status_id', $this->status_id);
        $stmt->bindParam(':task_id', $this->task_id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            if (strpos($stmt->errorInfo()[2], 'status_id') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'status_id taken'));
            }
        }

        return false;
    }
    // delete the product
    public function delete()
    {

    // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->user_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo json_encode(array("message" => $stmt->errorInfo()[2],'delete'=>false));
        }

        return false;
    }

    // used for paging products
    public function count()
    {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
