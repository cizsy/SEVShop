<?php include '../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// ambil data foreign key
$artis = $conn->query("SELECT id_artis, nama_artis FROM artis");
$kategori = $conn->query("SELECT id_kategori, jenis_kategori FROM kategori");
$penerbit = $conn->query("SELECT id_penerbit, nama_penerbit FROM penerbit");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_produk = $_POST['nama_produk'];
    $id_artis = $_POST['id_artis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $detail = $_POST['detail'];
    $thn_terbit = $_POST['thn_terbit'];
    $id_kategori = $_POST['id_kategori'];
    $id_penerbit = $_POST['id_penerbit'];

    // upload gambar
    $gambar = $_FILES['gambar_produk']['name'];
    $tmp = $_FILES['gambar_produk']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $gambar);

    // prepared statement
    $stmt = $conn->prepare("
        INSERT INTO produk 
        (nama_produk, id_artis, harga, stok, detail, gambar_produk, thn_terbit, id_kategori, id_penerbit)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssdiisssi",
        $nama_produk,
        $id_artis,
        $harga,
        $stok,
        $detail,
        $gambar,
        $thn_terbit,
        $id_kategori,
        $id_penerbit
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
</head>
<body>
    <div class="">
        <form action="" method="post" enctype="multipart/form-data">

            <label>Nama Produk:</label><br>
            <input type="text" name="nama_produk" required><br><br>

            <label>Artis:</label><br>
            <select name="id_artis" required>
                <option value="">-- Pilih Artis --</option>
                <?php while ($row = $artis->fetch_assoc()) { ?>
                    <option value="<?= $row['id_artis'] ?>">
                        <?= $row['nama_artis'] ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>

            <label>Harga:</label><br>
            <input type="number" name="harga" required><br><br>

            <label>Stok:</label><br>
            <input type="number" name="stok" required><br><br>

            <label>Detail Produk:</label><br>
            <textarea name="detail" required></textarea><br><br>

            <label>Gambar Produk:</label><br>
            <input type="file" name="gambar_produk" required><br><br>

            <label>Tahun Terbit:</label><br>
            <input type="number" name="thn_terbit" required><br><br>

            <label>Kategori:</label><br>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($row = $kategori->fetch_assoc()) { ?>
                    <option value="<?= $row['id_kategori'] ?>">
                        <?= $row['jenis_kategori'] ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>

            <label>Penerbit:</label><br>
            <select name="id_penerbit" required>
                <option value="">-- Pilih Penerbit --</option>
                <?php while ($row = $penerbit->fetch_assoc()) { ?>
                    <option value="<?= $row['id_penerbit'] ?>">
                        <?= $row['nama_penerbit'] ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>