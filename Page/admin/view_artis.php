<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
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

<?php if ($editData) { ?>
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Artis</h5>

        <form action="../../Controller/Artis_controller.php" method="post">
            <input type="hidden" name="id_artis" value="<?= $editData['id_artis'] ?>">

            <label class="form-label">Nama Artis</label>
            <input type="text" name="nama_artis" class="form-control mb-3" value="<?= htmlspecialchars($editData['nama_artis'], ENT_QUOTES) ?>" required>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="view_artis.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php } ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Artis</h5>
            <a href="input_artis.php" class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data && $data->num_rows > 0) { ?>
                        <?php while ($d = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $d['id_artis'] ?></td>
                                <td><?= htmlspecialchars($d['nama_artis'], ENT_QUOTES) ?></td>
                                <td>
                                    <a href="view_artis.php?edit=<?= $d['id_artis'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="../../Controller/Artis_controller.php?id=<?= $d['id_artis'] ?>" onclick="return confirm('Hapus artis ini?')" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="text-center">Data masih kosong</td>
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
