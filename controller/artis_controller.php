<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_artis'] ?? '';

    if (!empty($nama)) {
        $stmt = $conn->prepare("INSERT INTO artis (nama_artis) VALUES (?)");
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../Page/admin/admin-page/input_artis.php");
    exit;
}

header("Location: ../Page/admin/admin-page/input_artis.php");
exit;