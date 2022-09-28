<?php
class Database {
    public $conn = null;

    public function createConnection() {
        include_once("config.php");
        try {    
            $this->conn = new PDO("mysql:host=$servername;dbname=SQL_injection", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
            return $this->conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>