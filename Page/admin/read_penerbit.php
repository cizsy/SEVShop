<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM penerbit WHERE id_penerbit = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: read_penerbit.php");
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Penerbit</h5>
            <a href="input_penerbit.php" class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID Penerbit</th>
                        <th>Nama Penerbit</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_penerbit']; ?></td>

                                <td><?= htmlspecialchars($row['nama_penerbit'], ENT_QUOTES); ?></td>

                                <td>
                                    <a href="input_penerbit.php?id=<?= $row['id_penerbit']; ?>"
                                       class="btn btn-sm btn-warning mb-1">
                                        Edit
                                    </a>

                                    <a href="read_penerbit.php?hapus=<?= $row['id_penerbit']; ?>"
                                       onclick="return confirm('Hapus penerbit ini?')"
                                       class="btn btn-sm btn-danger mb-1">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Data masih kosong</td>
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