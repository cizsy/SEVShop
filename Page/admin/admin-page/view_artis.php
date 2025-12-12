<?php 
require_once __DIR__ . '/../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$editData = null;

if (!$conn) {
    die('Koneksi gagal');
}

if (isset($_GET['hapus'])) {
    $id_artis = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM artis WHERE id_artis = '$id_artis'");
    header("Location: view_artis.php");
    exit;
}

if (isset($_GET['edit'])) {
    $id_artis = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM artis WHERE id_artis = '$id_artis'");
    $editData = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>CRUD Artis</title>
</head>
<body>

<?php if ($editData) { ?>
  <h3>Edit Data</h3>
  <form method="post">
    <input type="hidden" name="id_artis" value="<?= $editData['id_artis'] ?>">
    <input type="text" name="nama_artis" value="<?= $editData['nama_artis'] ?>" required>
    <button type="submit" name="update">Update</button>
    <a href="view_artis.php">Batal</a>
  </form>
<?php } ?>

<hr>

<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Aksi</th>
  </tr>

  <?php
  $data = mysqli_query($conn, "SELECT * FROM artis");
  while ($d = mysqli_fetch_assoc($data)) {
  ?>
    <tr>
      <td><?= $d['id_artis'] ?></td>
      <td><?= $d['nama_artis'] ?></td>
      <td>
        <a href="view_artis.php?edit=<?= $d['id_artis'] ?>">Edit</a> | 
        <a href="view_artis.php?hapus=<?= $d['id_artis'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
      </td>
    </tr>
  <?php } ?>

</table>

</body>
</html>
