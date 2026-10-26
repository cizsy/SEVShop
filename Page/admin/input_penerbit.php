<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../Model/penerbit.php';

$penerbitModel = new Penerbit();
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$editData = $id ? $penerbitModel->getById($id) : null;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penerbit = trim($_POST['nama_penerbit'] ?? '');

    if ($id && $editData) {
        $res = $penerbitModel->update($id, $nama_penerbit);
    } else {
        $res = $penerbitModel->create($nama_penerbit);
    }

    if ($res) {
        header("Location: read_penerbit.php?status=success");
        exit;
    } else {
        $error = "Gagal menyimpan data penerbit.";
    }
}

$title = $id ? "Edit Penerbit" : "Form Input Penerbit";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_penerbit.php" class="btn btn-primary">
        <i class="ti ti-list me-1"></i> Lihat Data Penerbit
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4"><?= $id ? 'Edit Penerbit' : 'Form Input Penerbit' ?></h5>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mb-3"><?= htmlspecialchars($error, ENT_QUOTES); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Penerbit / Label <span class="text-danger">*</span></label>
                <input type="text" name="nama_penerbit" value="<?= htmlspecialchars($editData['nama_penerbit'] ?? '', ENT_QUOTES) ?>" required class="form-control" placeholder="Cth: HYBE / SM Entertainment / JYP">
            </div>

            <button type="submit" class="btn btn-primary fw-bold">
                <i class="ti ti-device-floppy me-1"></i> <?= $id ? 'Update Penerbit' : 'Simpan Penerbit' ?>
            </button>
            <?php if ($id): ?>
                <a href="read_penerbit.php" class="btn btn-secondary">Batal</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>