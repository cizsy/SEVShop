<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$editData = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = trim($_POST['nama_kategori'] ?? '');

    if ($id && $editData) {
        $stmt = $conn->prepare("UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?");
        $stmt->bind_param("si", $nama_kategori, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param("s", $nama_kategori);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: read_kategori.php?status=success");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$title = $id ? "Edit Kategori" : "Form Input Kategori";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_kategori.php" class="btn btn-primary">
        <i class="ti ti-list me-1"></i> Lihat Data Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4"><?= $id ? 'Edit Kategori' : 'Form Input Kategori' ?></h5>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mb-3"><?= htmlspecialchars($error, ENT_QUOTES); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" value="<?= htmlspecialchars($editData['nama_kategori'] ?? '', ENT_QUOTES) ?>" required class="form-control" placeholder="Cth: Album / Lightstick / Photobook">
            </div>

            <button type="submit" class="btn btn-primary fw-bold">
                <i class="ti ti-device-floppy me-1"></i> <?= $id ? 'Update Kategori' : 'Simpan Kategori' ?>
            </button>
            <?php if ($id): ?>
                <a href="read_kategori.php" class="btn btn-secondary">Batal</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>
