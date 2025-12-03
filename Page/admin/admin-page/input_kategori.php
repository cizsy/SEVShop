
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
    <link rel="stylesheet" href="../../../css/form.css">
</head>
<body>
    <div>
        <form action="" method="post" class="card-form-c">
            <p class="card-title-c">Jenis Kategori</p>
            <label class="form-label-c">
                Jenis kategori:
            </label><br>
            <input type="text" name="jenis_kategori" class="input-box-form" required><br><br>
            <button type="submit" class="button-form-c">Simpan</button>
        </form>
    </div>
</body>
</html>

 <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Form Input Kategori</h5>
              <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                    <label class="form-label">Nama Artis:</label><br>
                    <input type="text" name="nama_artis" required class="input-box"><br><br>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>