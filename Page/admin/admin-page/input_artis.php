<?php
include '../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_artis'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO artis (nama_artis) VALUES (?)");
    $stmt->bind_param("s", $nama);
    
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
    <title>Data Artis</title>
</head>
<body>
    <div>
        <form action="" method="post">
            <label>Nama Artis:</label><br>
            <input type="text" name="nama_artis" required><br><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>