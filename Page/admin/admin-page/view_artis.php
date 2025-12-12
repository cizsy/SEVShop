<?php 
require_once __DIR__ . '/../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$editData = null;

if (!$conn) {
    die('Koneksi gagal');
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id_artis = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM artis WHERE id_artis = '$id_artis'");
    header("Location: view_artis.php");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $id_artis = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM artis WHERE id_artis = '$id_artis'");
    $editData = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Artis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <?php if ($editData) { ?>
        <div class="card shadow mb-4" style="border-radius:12px;">
            <div class="card-body">
                <h4 class="mb-3">Edit Artis</h4>
                <form method="post">
                    <input type="hidden" name="id_artis" value="<?= $editData['id_artis'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Artis</label>
                        <input type="text" name="nama_artis" value="<?= $editData['nama_artis'] ?>" 
                               class="form-control"
                               style="border-radius:6px; border:1px solid #D1D5DB; padding:8px 12px;" required>
                    </div>

                    <button type="submit" name="update" class="btn text-white" 
                        style="background-color:#1E4ED8; border-radius:8px; padding:8px 16px;">
                        Update
                    </button>
                    <a href="view_artis.php" class="btn text-white"
                       style="background-color:#6B7280; border-radius:8px; padding:8px 16px;">
                       Batal
                    </a>
                </form>
            </div>
        </div>
    <?php } ?>

    <div class="d-flex justify-content-end mb-3">
        <a href="input_artis.php" class="btn text-white"
           style="background-color:#1E4ED8; border-radius:8px; padding:8px 18px;">
           + Tambah Artis
        </a>
    </div>

    <div class="card shadow" style="border-radius:12px;">
        <div class="card-body">
            <h4 class="mb-3">Data Artis</h4>

            <table class="table table-bordered table-striped align-middle" style="border-radius:10px; overflow:hidden;">
                <thead style="background-color:#1E4ED8; color:white;">
                    <tr>
                        <th>ID</th>
                        <th>Nama Artis</th>
                        <th style="width:200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $data = mysqli_query($conn, "SELECT * FROM artis ORDER BY id_artis ASC");
                while ($d = mysqli_fetch_assoc($data)) {
                ?>
                    <tr>
                        <td><?= $d['id_artis'] ?></td>
                        <td><?= $d['nama_artis'] ?></td>
                        <td>
                            <a href="view_artis.php?edit=<?= $d['id_artis'] ?>" 
                               class="btn btn-sm text-white" 
                               style="background-color:#1E4ED8; border-radius:6px; padding:5px 12px;">
                                Edit
                            </a>

                            <a href="view_artis.php?hapus=<?= $d['id_artis'] ?>" 
                               class="btn btn-sm text-white" 
                               style="background-color:#DC2626; border-radius:6px; padding:5px 12px;"
                               onclick="return confirm('Yakin mau hapus')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>