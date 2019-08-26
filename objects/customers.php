<?php
class Customers
{
    private $conn;
    private $table_name = "customers";

    
    public $customer_id;
    public $customer_name;
    public $phone;
    public $email;
    public $address;

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
  customer_name=:customer_name, phone=:phone, address=:address, email=:email";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->customer_name=htmlspecialchars(strip_tags($this->customer_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));

        // bind values
        $stmt->bindParam(":customer_name", $this->customer_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);

        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            if (strpos($stmt->errorInfo()[2], 'customer_name') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'Customer Name taken'));
            }
        }
    
        return false;
    }
    public function readOne()
    {

    // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE
        customer_id = ?
        LIMIT
        0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->customer_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->customer_id = $row['customer_id'];
        $this->customer_name = $row['customer_name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
    }
    // update the product
    public function update()
    {

    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        customer_name = :customer_name,
        email = :email,
        phone = :phone,
        address = :addressy
        WHERE
        customer_id = :customer_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->customer_name=htmlspecialchars(strip_tags($this->customer_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));

        // bind new values
        $stmt->bindParam(':customer_name', $this->customer_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':customer_id', $this->customer_id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            if (strpos($stmt->errorInfo()[2], 'customer_name') !== false) {
                echo json_encode(array("error" => true  ,"message" => 'customer name taken'));
            }
        }

        return false;
    }
    // delete the product
    public function delete()
    {

    // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE customer_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->customer_id);

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
