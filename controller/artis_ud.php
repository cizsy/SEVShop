<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

/* ================= UPDATE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id_artis'] ?? 0);
    $nama = trim($_POST['nama_artis'] ?? '');

    if ($id && $nama !== '') {
        $stmt = $conn->prepare("UPDATE artis SET nama_artis = ? WHERE id_artis = ?");
        $stmt->bind_param("si", $nama, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /Page/admin/view_artis.php?status=updated");
    exit;
}

/* ================= DELETE ================= */
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $conn->prepare("DELETE FROM artis WHERE id_artis = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: /Page/admin/view_artis.php?status=deleted");
    exit;
}

/* ================= DEFAULT ================= */
header("Location: /Page/admin/view_artis.php");
exit;