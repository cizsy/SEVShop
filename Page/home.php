<?php
require_once __DIR__ . '/../Model/Product.php';
$productModel = new Product();
$data = $productModel -> readAll();
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../Component/head.php'; ?>
<body>
    <?php include __DIR__ . '/../Component/navbar.php'; ?>
    <?php include __DIR__ . '/../Component/heroo.php'; ?>

    <div class="container-produk-display justify-content-center mb-5">
        <div class="produk-display-home-header">BEST SELLER</div>
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <?php 
                $bestSellers = $productModel->getProductsByCategory('BestSeller'); 
                while($row = $bestSellers->fetch_assoc()): 
                ?>
                <div class="col">
                    <a href="index.php?Page=detailProduk&id=<?= $row['id_produk'] ?>" class="text-decoration-none">
                        <div class="card product-card h-100">
                            <div class="best-badge">BEST</div>
                            <div class="card-body">
                                <img src="<?= htmlspecialchars($row['gambar_produk']) ?>" class="product-image" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                                <h5 class="product-title"><?= htmlspecialchars($row['nama_produk']) ?></h5>
                                <p class="artist-name"><?= htmlspecialchars($row['nama_artis']) ?></p>
                                <div class="price-section">
                                    <span class="currency">IDR</span>
                                    <span class="price">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

        <div class="container-produk-display justify-content-center mb-5">
        <div class="produk-display-home-header">NEW ARRIVAL</div>
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <?php 
                $newArrivals = $productModel->getProductsByCategory('NewArrival'); 
                while($row = $newArrivals->fetch_assoc()): 
                ?>
                <div class="col">
                    <a href="index.php?Page=detailProduk&id=<?= $row['id_produk'] ?>" class="text-decoration-none">
                        <div class="card product-card h-100">
                            <div class="new-badge">NEW</div>
                            <div class="card-body">
                                <img src="<?= htmlspecialchars($row['gambar_produk']) ?>" class="product-image" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                                <h5 class="product-title"><?= htmlspecialchars($row['nama_produk']) ?></h5>
                                <p class="artist-name"><?= htmlspecialchars($row['nama_artis']) ?></p>
                                <div class="price-section">
                                    <span class="currency">IDR</span>
                                    <span class="price">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../Component/footer.php'; ?>
</body>
</html>