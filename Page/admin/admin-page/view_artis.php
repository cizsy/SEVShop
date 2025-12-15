<?php
require_once '../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

/* ambil data edit kalau ada */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM artis WHERE id_artis='$id'");
    $editData = mysqli_fetch_assoc($result);
}

/* ambil semua data */
$data = mysqli_query($conn, "SELECT * FROM artis ORDER BY id_artis ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Artis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<?php if ($editData) { ?>
<div class="card shadow mb-4">
    <div class="card-body">
        <h4>Edit Artis</h4>
        <form action="/codekat/controller/artis_action.php" method="post">
            <input type="hidden" name="id_artis" value="<?= $editData['id_artis'] ?>">
            <input type="text" name="nama_artis" class="form-control mb-3"
                   value="<?= $editData['nama_artis'] ?>" required>
            <button class="btn btn-primary">Update</button>
            <a href="view_artis.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php } ?>

<div class="card shadow">
<div class="card-body">
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Artis</h4>
        <a href="input_artis.php" class="btn btn-primary">+ Tambah</a>
    </div>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Aksi</th>
</tr>
<?php while ($d = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $d['id_artis'] ?></td>
    <td><?= $d['nama_artis'] ?></td>
    <td>
        <a href="view_artis.php?edit=<?= $d['id_artis'] ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="/codekat/controller/artis_action.php?id=<?= $d['id_artis'] ?>"
        onclick="return confirm('Hapus artis ini?')"
        class="btn btn-sm btn-danger">
        Hapus
        </a>
    </td>
</tr>
<?php } ?>
</table>

</div>
</div>

</div>
</body>
</html>
