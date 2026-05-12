<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

/* ================= UPDATE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = $_POST['id_artis'] ?? null;
    $nama = trim($_POST['nama_artis'] ?? '');

    if ($id && $nama !== '') {
        $stmt = $conn->prepare("UPDATE artis SET nama_artis = ? WHERE id_artis = ?");
        $stmt->bind_param("si", $nama, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /codekat/Page/admin/admin-page/view_artis.php");
    exit;
}

/* ================= DELETE ================= */
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM artis WHERE id_artis = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: /codekat/Page/admin/admin-page/view_artis.php");
    exit;
}

/* ================= DEFAULT ================= */
header("Location: /codekat/Page/admin/admin-page/view_artis.php");
exit;