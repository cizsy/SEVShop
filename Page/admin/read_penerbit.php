<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM penerbit WHERE id_penerbit = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: read_penerbit.php?status=deleted");
        exit;
    }
}

$sql = "SELECT * FROM penerbit ORDER BY id_penerbit ASC";
$result = $conn->query($sql);

$title = "Data Penerbit";
ob_start();
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Penerbit berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Penerbit berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Penerbit</h5>
            <a href="input_penerbit.php" class="btn btn-primary">+ Tambah Penerbit</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nama Penerbit</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_penerbit']; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama_penerbit'], ENT_QUOTES); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="input_penerbit.php?id=<?= $row['id_penerbit']; ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="read_penerbit.php?hapus=<?= $row['id_penerbit']; ?>"
                                           onclick="return confirm('Hapus penerbit ini?')"
                                           class="btn btn-sm btn-danger">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">Belum ada data penerbit</td>
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