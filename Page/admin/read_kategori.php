<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: read_kategori.php");
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Kategori</h5>
            <a href="input_kategori.php" class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID Kategori</th>
                        <th>Nama Kategori</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_kategori']; ?></td>

                                <td><?= htmlspecialchars($row['nama_kategori'], ENT_QUOTES); ?></td>

                                <td>
                                    <a href="input_kategori.php?id=<?= $row['id_kategori']; ?>"
                                       class="btn btn-sm btn-warning mb-1">
                                        Edit
                                    </a>

                                    <a href="read_kategori.php?hapus=<?= $row['id_kategori']; ?>"
                                       onclick="return confirm('Hapus kategori ini?')"
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