<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM artis WHERE id_artis = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$data = $conn->query("SELECT * FROM artis ORDER BY id_artis ASC");

$title = "Data Artis";
ob_start();
?>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Artis berhasil ditambahkan!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        Artis berhasil diperbarui!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Artis berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($editData) { ?>
<div class="card mb-4 border border-warning">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-3">Edit Artis</h5>

        <form action="/controller/artis_ud.php" method="post">
            <input type="hidden" name="id_artis" value="<?= $editData['id_artis'] ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Artis</label>
                <input type="text" name="nama_artis" class="form-control" value="<?= htmlspecialchars($editData['nama_artis'], ENT_QUOTES) ?>" required>
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Update Artis</button>
            <a href="view_artis.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php } ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Artis</h5>
            <a href="input_artis.php" class="btn btn-primary">+ Tambah Artis</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nama Artis</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data && $data->num_rows > 0) { ?>
                        <?php while ($d = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $d['id_artis'] ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($d['nama_artis'], ENT_QUOTES) ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="view_artis.php?edit=<?= $d['id_artis'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="/controller/artis_controller.php?id=<?= $d['id_artis'] ?>" onclick="return confirm('Hapus artis ini?')" class="btn btn-sm btn-danger">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">Belum ada data artis</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>
