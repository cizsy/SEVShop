<?php
class Database {
    private $host = "localhost";
    private $db_name = "sevshop_db";
    private $username = "root"; 
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if ($this->conn->connect_error) {
                die("Koneksi gagal: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8");
            
        } catch (Exception $e) {
            echo "Error koneksi: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>  