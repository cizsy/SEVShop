<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_artis'] ?? '');

    if (!empty($nama)) {
        $stmt = $conn->prepare("INSERT INTO artis (nama_artis) VALUES (?)");
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /Page/admin/view_artis.php?status=success");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM artis WHERE id_artis = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: /Page/admin/view_artis.php?status=deleted");
    exit;
}

header("Location: /Page/admin/view_artis.php");
exit;