<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "user";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function register($nama_user, $email_user, $password, $no_hp) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table_name . " 
                  (nama_user, email_user, password, no_hp) 
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssss", $nama_user, $email_user, $password_hash, $no_hp);

        return $stmt->execute();
    }

    public function login($email_user, $password) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE email_user = ? 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email_user);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function emailExists($email_user) {
        $query = "SELECT id_user FROM " . $this->table_name . " 
                  WHERE email_user = ? 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email_user);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getById($id_user) {
        $query = "SELECT id_user, nama_user, email_user, no_hp 
                  FROM " . $this->table_name . " 
                  WHERE id_user = ? 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}
?>