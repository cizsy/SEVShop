<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];

    $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
    $stmt->bind_param("s", $nama_kategori);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: read_kategori.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$title = "Form Input Kategori";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_kategori.php" class="btn btn-primary">
        Lihat Data
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Form Input Kategori</h5>

        <form action="" method="post">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" required class="form-control mb-3">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>
