<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: read_kategori.php?status=deleted");
        exit;
    }
}

$sql = "SELECT * FROM kategori ORDER BY id_kategori ASC";
$result = $conn->query($sql);

$title = "Data Kategori";
ob_start();
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Kategori berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Kategori berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Kategori</h5>
            <a href="input_kategori.php" class="btn btn-primary">+ Tambah Kategori</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nama Kategori</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_kategori']; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama_kategori'], ENT_QUOTES); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="input_kategori.php?id=<?= $row['id_kategori']; ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="read_kategori.php?hapus=<?= $row['id_kategori']; ?>"
                                           onclick="return confirm('Hapus kategori ini?')"
                                           class="btn btn-sm btn-danger">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">Belum ada data kategori</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>