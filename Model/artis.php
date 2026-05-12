<?php
require_once __DIR__ . '/../config/database.php';

class Artis {
    private $conn;
    private $table_name = "artis";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_artis ASC";
        return $this->conn->query($query);
    }

    public function getRandomArtis($limit = 8) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY RAND() LIMIT ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_artis = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create($nama_artis) {
        $query = "INSERT INTO " . $this->table_name . " (nama_artis) VALUES (?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nama_artis);

        return $stmt->execute();
    }

    public function update($id, $nama_artis) {
        $query = "UPDATE " . $this->table_name . " SET nama_artis = ? WHERE id_artis = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nama_artis, $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_artis = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}