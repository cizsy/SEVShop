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
            (nama_produk, id_artis, harga, stok, detail, gambar_produk, thn_terbit, id_kategori, id_penerbit, id_komentar, id_jenis, notice, terms_recomen, size, contents) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        // s = string, i = integer. Sesuai gambar: nama(s), id_artis(i), harga(i), stok(i), detail(s), id_kat(i), gambar(s), thn(i)
        $stmt->bind_param("siiiissiiiissss", 
            $data['name'],          // s
            $data['artis_id'],      // i
            $data['price'],         // i
            $data['stock'],         // i
            $data['detail'],        // s
            $data['gambar_produk'], // s
            $data['thn_terbit'],    // i
            $data['category_id'],   // i
            $data['penerbit_id'],   // i
            $data['komentar_id'],   // i
            $data['jenis_id'],      // i
            $data['notice'],        // s
            $data['terms'],         // s
            $data['size'],          // s
            $data['contents']       // s
    );
    return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
              SET nama_produk=?, id_artis=?, harga=?, stok=?, detail=?, 
                  gambar_produk=?, thn_terbit=?, id_kategori=?, id_penerbit=?, 
                  id_komentar=?, id_jenis=?, notice=?, terms_recomen=?, 
                  size=?, contents=? 
              WHERE id_produk=?";

        $stmt = $this->conn->prepare($query);
        
        // Ditambah satu "i" di akhir untuk ID_produk
        $stmt->bind_param("siiiissiiiiisssi", 
        $data['name'],          // s
        $data['artis_id'],      // i
        $data['price'],         // i
        $data['stock'],         // i
        $data['detail'],        // s
        $data['gambar_produk'], // s
        $data['thn_terbit'],    // i
        $data['category_id'],   // i
        $data['penerbit_id'],   // i
        $data['komentar_id'],   // i
        $data['jenis_id'],      // i
        $data['notice'],        // s
        $data['terms'],         // s
        $data['size'],          // s
        $data['contents'],      // s
        $id                     // i (untuk WHERE)
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

    public function getById($id) {
    $query = "SELECT p.*, a.nama_artis, k.nama_kategori 
              FROM " . $this->table_name . " p
              LEFT JOIN artis a ON p.id_artis = a.id_artis
              LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
              WHERE p.id_produk = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_assoc() ?: [];
    }
}