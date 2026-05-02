<?php
require_once __DIR__ . '/../config/database.php';

class Penerbit {
    private $conn;
    private $table_name = "penerbit";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    // CREATE: Menambah penerbit baru
    public function create($nama_penerbit) {
        $query = "INSERT INTO " . $this->table_name . " (nama_penerbit) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nama_penerbit);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ: Mengambil semua data
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_penerbit ASC";
        return $this->conn->query($query);
    }

    // READ SINGLE: Mengambil satu data berdasarkan ID (untuk form edit)
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_penerbit = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE: Mengubah data penerbit
    public function update($id, $nama_penerbit) {
        $query = "UPDATE " . $this->table_name . " SET nama_penerbit = ? WHERE id_penerbit = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nama_penerbit, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE: Menghapus data
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_penerbit = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>