<?php
class Database {
    private $host = "localhost";
    private $db_name = "sevshop_db";
    private $username = "root"; 
    private $password = "";
    private $conn;
    private static $instance = null;

    private function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>  