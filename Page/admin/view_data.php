<?php
require_once 'database.php'; // manggil file koneksi

$db = new Database();
$conn = $db->getConnection();

// ambil jumlah produk
$q_produk = $conn->query("SELECT COUNT(*) AS total FROM produk");
$data_produk = $q_produk->fetch_assoc();

// ambil jumlah user
$q_user = $conn->query("SELECT COUNT(*) AS total FROM user");
$data_user = $q_user->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .card {
            width: 200px;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            display: inline-block;
            margin: 10px;
        }
    </style>
</head>
<body>
    <h2>Dashboard</h2>
    <div class="card">
        <h3>Produk</h3>
        <p><?= $data_produk['total'] ?></p>
    </div>
    <div class="card">
        <h3>User</h3>
        <p><?= $data_user['total'] ?></p>
    </div>
</body>
</html>
