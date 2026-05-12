<?php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $conn;
    private $table_name = "produk";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT p.*, a.nama_artis, k.nama_kategori, pb.nama_penerbit
                  FROM " . $this->table_name . " p
                  LEFT JOIN artis a ON p.id_artis = a.id_artis
                  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                  LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit";

        return $this->conn->query($query);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
            (nama_produk, id_artis, harga, stok, detail, gambar_produk, thn_terbit, id_kategori, id_penerbit, id_komentar, id_jenis, notice, terms_recomen, size, contents) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "siiissiiiiissss",
            $data['name'],
            $data['artis_id'],
            $data['price'],
            $data['stock'],
            $data['detail'],
            $data['gambar_produk'],
            $data['thn_terbit'],
            $data['category_id'],
            $data['penerbit_id'],
            $data['komentar_id'],
            $data['jenis_id'],
            $data['notice'],
            $data['terms'],
            $data['size'],
            $data['contents']
        );

        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_produk = ?, 
                      id_artis = ?, 
                      harga = ?, 
                      stok = ?, 
                      detail = ?, 
                      gambar_produk = ?, 
                      thn_terbit = ?, 
                      id_kategori = ?, 
                      id_penerbit = ?, 
                      id_komentar = ?, 
                      id_jenis = ?, 
                      notice = ?, 
                      terms_recomen = ?, 
                      size = ?, 
                      contents = ?
                  WHERE id_produk = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "siiissiiiiissssi",
            $data['name'],
            $data['artis_id'],
            $data['price'],
            $data['stock'],
            $data['detail'],
            $data['gambar_produk'],
            $data['thn_terbit'],
            $data['category_id'],
            $data['penerbit_id'],
            $data['komentar_id'],
            $data['jenis_id'],
            $data['notice'],
            $data['terms'],
            $data['size'],
            $data['contents'],
            $id
        );

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_produk = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function getProductsByCategory($categoryName) {
        $query = "SELECT p.*, a.nama_artis, k.nama_kategori, pb.nama_penerbit
                  FROM " . $this->table_name . " p
                  LEFT JOIN artis a ON p.id_artis = a.id_artis
                  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                  LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit
                  LEFT JOIN jenis j ON p.id_jenis = j.id_jenis
                  WHERE k.nama_kategori = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $categoryName);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getById($id) {
        $query = "SELECT p.*, a.nama_artis, k.nama_kategori, pb.nama_penerbit
                  FROM " . $this->table_name . " p
                  LEFT JOIN artis a ON p.id_artis = a.id_artis
                  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                  LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit
                  WHERE p.id_produk = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: [];
    }
}
?>