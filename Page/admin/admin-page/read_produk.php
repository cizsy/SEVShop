<?php include '../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);
    ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID Produk </th>
            <th>Nama Produk </th>
            <th>Nama Artis </th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Detail Produk</th>
            <th>Gambar Produk </th>
            <th>Tahun Terbit </th>
            <th>Kategori </th>
            <th>Penerbit </th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_produk']; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_produk'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['id_artis'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['harga'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['stok'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['detail'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['gambar_produk'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['thn_terbit'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['id_kategori'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['id_penerbit'], ENT_QUOTES); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align: center;">Data masih kosong</td>
            </tr>
        <?php endif; ?>
    </table>
?>