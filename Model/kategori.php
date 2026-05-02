<?php
require_once __DIR__ . '/../config/database.php';

class Kategori {
    private $conn;
    private $table_name = "kategori";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    // CREATE: Menambah kategori baru
    public function create($nama_kategori) {
        $query = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nama_kategori);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ: Mengambil semua data
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_kategori ASC";
        return $this->conn->query($query);
    }

    // READ SINGLE: Mengambil satu data berdasarkan ID (untuk form edit)
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_kategori = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE: Mengubah data kategori
    public function update($id, $nama_kategori) {
        $query = "UPDATE " . $this->table_name . " SET nama_kategori = ? WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nama_kategori, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE: Menghapus data
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>