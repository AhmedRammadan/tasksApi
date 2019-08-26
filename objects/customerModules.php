<?php
class CustomerModules
{
    private $conn;
    private $table_name = "customer_modules";

    public $customer_id;
    public $module_id;
    public $module_Version;

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
  customer_id = :customer_id,
   module_id = :module_id,
    module_Version = :module_Version";

        $stmt = $this->conn->prepare($query);

        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->module_id=htmlspecialchars(strip_tags($this->module_id));
        $this->module_Version=htmlspecialchars(strip_tags($this->module_Version));

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":module_id", $this->module_id);
        $stmt->bindParam(":module_Version", $this->module_Version);

        if ($stmt->execute()) {
            return true;
        } else {
        }
    
        return false;
    }
  
  
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE customer_id = ?";

        $stmt = $this->conn->prepare($query);

        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));

        $stmt->bindParam(1, $this->customer_id);

        if ($stmt->execute()) {
            return true;
        } else {
            echo json_encode(array("message" => $stmt->errorInfo()[2],'delete'=>false));
        }

        return false;
    }
}
