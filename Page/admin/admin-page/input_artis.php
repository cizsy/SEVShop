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
    <link rel="stylesheet" href="../../../css/form.css">
</head>
<body>
    <div class="form-body-wrapper-inner">
    <div class="card">
        <h4 class="card-title">Masukkan Nama Artis</h4>
        <form action="" method="post">
            <label class="form-label">Nama Artis:</label><br>
            <input type="text" name="nama_artis" required class="input-box"><br><br>
            <button type="submit" class="button">Simpan</button>
        </form>
    </div>
    </div>
</body>
</html>