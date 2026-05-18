<?php
require_once '../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$q = $_GET['q'] ?? '';
$keyword = '%' . $q . '%';

$stmt = $conn->prepare("SELECT * FROM artis WHERE nama_artis LIKE ? ORDER BY nama_artis ASC");
$stmt->bind_param("s", $keyword);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Artis - SEVShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">
        Hasil pencarian artis: 
        <span class="text-primary"><?= htmlspecialchars($q, ENT_QUOTES); ?></span>
    </h3>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($row['nama_artis'], ENT_QUOTES); ?>
                            </h5>

                            <a href="/index.php?Page=artistProduk&id=<?= $row['id_artis']; ?>" class="btn btn-primary btn-sm">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Artis tidak ditemukan.
        </div>
    <?php endif; ?>

    <a href="/Page/home.php" class="btn btn-secondary mt-3">
        Kembali
    </a>
</div>

</body>
</html>