<?php
class Users
{
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $name;
    public $user_name;
    public $password;
    public $email;
    public $phone;
    public $address;
    public $user_category;

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
  name=:name, user_name=:user_name, password=:password, email=:email, phone=:phone, address=:address, user_category=:user_category";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->user_category=htmlspecialchars(strip_tags($this->user_category));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":user_category", $this->user_category);

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
            }
        }
    
        return false;
    }
    public function readOne()
    {

    // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE
        user_id = ?
        LIMIT
        0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->user_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->user_id = $row['user_id'];
        $this->name = $row['name'];
        $this->user_name = $row['user_name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->user_category = $row['user_category'];
    }
    // update the product
    public function update()
    {

    // update query
        $query = "UPDATE
        " . $this->table_name . "
        SET
        name = :name,
        user_name = :user_name,
        email = :email,
        phone = :phone,
        address = :address,
        password = :password,
        user_category = :user_category
        WHERE
        user_id = :user_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->user_category=htmlspecialchars(strip_tags($this->user_category));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':user_category', $this->user_category);

        // execute the query
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
