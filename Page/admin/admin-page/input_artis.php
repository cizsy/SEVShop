<?php
require_once '../config/Database.php';

$db = new Database();
$conn = $db->getConnection();

// jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = $_POST['nama_artis'];

    // query simpan ke database
    $sql = "INSERT INTO artis (nama_artis) VALUES ('$nama')";
    $conn->query($sql);

    // balik lagi ke index atau halaman daftar
    header("Location: index.php");
    exit;
}
?>

<div>
    <form action="" method="post">
        <label>Nama Artis:</label><br>
        <input type="text" name="nama_artis" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</div>
