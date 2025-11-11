<?php
include '../../../config/database.php'; 


$db =new Database();
$conn =$db->getConnection();

// submit handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['jenis_kategori'];

    // prepared statement
    $stmt = $conn->prepare("INSERT INTO kategori (jenis_kategori) VALUES (?)");
    $stmt->bind_param("s", $kategori);
    
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="" method="post">
            <label>
                Jenis kategori:
            </label><br>
            <input type="text" name="jenis_kategori" required><br><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>