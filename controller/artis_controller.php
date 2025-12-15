<?php
require_once __DIR__ . '/../config/database.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = $_POST['nama_artis'];

    $stmt = $conn->prepare(
        "INSERT INTO artis (nama_artis) VALUES (?)"
    );
    $stmt->bind_param("s", $nama);
    $stmt->execute();

    // APAPUN HASILNYA, REDIRECT
    header("Location: ../Page/admin/admin-page/input_artis.php");
    exit;
}

// kalau controller diakses langsung lewat URL
header("Location: ../Page/admin/admin-page/input_artis.php");
exit;
