<?php
session_start();

require_once __DIR__ . '/../Model/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'          => $_POST['nama_produk'] ?? '',
                'artis_id'      => $_POST['id_artis'] ?? 0,
                'price'         => $_POST['harga'] ?? 0,
                'stock'         => $_POST['stok'] ?? 0,
                'detail'        => $_POST['detail_produk'] ?? '',
                'gambar_produk' => $_POST['gambar_produk'] ?? '',
                'thn_terbit'    => $_POST['thn_terbit'] ?? 0,
                'category_id'   => $_POST['id_kategori'] ?? 0,
                'penerbit_id'   => $_POST['id_penerbit'] ?? 0,
                'komentar_id'   => $_POST['id_komentar'] ?? 0,
                'jenis_id'      => $_POST['id_jenis'] ?? 0,
                'notice'        => $_POST['notice'] ?? '',
                'terms'         => $_POST['terms'] ?? '',
                'size'          => $_POST['size'] ?? '',
                'contents'      => $_POST['contents'] ?? ''
            ];

            if ($action === 'create') {
                $this->productModel->create($data);
            }

            if ($action === 'update' && $id) {
                $this->productModel->update($id, $data);
            }

            header("Location: ../Page/admin/admin-page/read_produk.php");
            exit;
        }

        if ($action === 'delete' && $id) {
            $this->productModel->delete($id);

            header("Location: ../Page/admin/admin-page/read_produk.php");
            exit;
        }

        header("Location: ../Page/admin/admin-page/read_produk.php");
        exit;
    }
}

$controller = new ProductController();
$controller->handleRequest();