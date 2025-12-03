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
<body>
   <?php
    $sql = "SELECT * FROM artis";
    $result = $conn->query($sql);
    ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Artis</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_artis']; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_artis'], ENT_QUOTES); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" style="text-align: center;">Data masih kosong</td>
            </tr>
        <?php endif; ?>
    </table> 
</body>
</html>


