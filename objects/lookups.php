<?php
class Lookups
{
    private $conn;
    private $table_name = "lookups";

    public $lookup_id;
    public $lookup_code;
    public $lookup_name;
    public $lookup_value;

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
}
