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
        $query = "SELECT p.*, a.nama_artis, k.nama_kategori 
                  FROM produk p 
                  LEFT JOIN artis a ON p.id_artis = a.id_artis 
                  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori";
        return $this->conn->query($query);
    }

    public function create($data) {
        // Query tanpa koma berlebih di akhir
        $query = "INSERT INTO " . $this->table_name . " 
                  (nama_produk, id_artis, harga, stok, detail, id_kategori, gambar_produk, thn_terbit) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // s = string, i = integer. Sesuai gambar: nama(s), id_artis(i), harga(i), stok(i), detail(s), id_kat(i), gambar(s), thn(i)
        $stmt->bind_param("siiisisi", 
            $data['name'], 
            $data['artis_id'], 
            $data['price'], 
            $data['stock'], 
            $data['detail'], 
            $data['category_id'],
            $data['gambar_produk'],
            $data['thn_terbit']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_produk=?, id_artis=?, harga=?, stok=?, detail=?, id_kategori=?, gambar_produk=?, thn_terbit=? 
                  WHERE id_produk=?";

        $stmt = $this->conn->prepare($query);
        
        // Ditambah satu "i" di akhir untuk ID_produk
        $stmt->bind_param("siiisisii", 
            $data['name'], 
            $data['artis_id'], 
            $data['price'], 
            $data['stock'], 
            $data['detail'], 
            $data['category_id'],
            $data['gambar_produk'],
            $data['thn_terbit'],
            $id
        );
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getProductsByCategory($categoryName) {
        $query = "SELECT p.*, a.nama_artis, k.nama_kategori
                  FROM produk p
                  LEFT JOIN artis a ON p.id_artis = a.id_artis
                  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                  LEFT JOIN jenis j ON p.id_jenis = j.id_jenis
                  WHERE k.nama_kategori = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>