<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$id_artis = $_GET['id'] ?? null;

if (!$id_artis) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Artis tidak ditemukan.</div></div>";
    exit;
}

$stmtArtis = $conn->prepare("SELECT * FROM artis WHERE id_artis = ? LIMIT 1");
$stmtArtis->bind_param("i", $id_artis);
$stmtArtis->execute();
$artis = $stmtArtis->get_result()->fetch_assoc();

if (!$artis) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Artis tidak ditemukan.</div></div>";
    exit;
}

$stmtProduk = $conn->prepare("
    SELECT 
        p.*,
        a.nama_artis,
        k.nama_kategori,
        pb.nama_penerbit
    FROM produk p
    LEFT JOIN artis a ON p.id_artis = a.id_artis
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit
    WHERE p.id_artis = ?
    ORDER BY p.id_produk DESC
");

$stmtProduk->bind_param("i", $id_artis);
$stmtProduk->execute();
$produk = $stmtProduk->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/../Component/head.php'; ?>

<style>
    body {
        background: #f8fbff;
    }

    .artist-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 32px 24px 60px;
        min-height: 70vh;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 18px;
        color: #3f5f7f;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .back-link:hover {
        color: #ec707e;
    }

    .artist-header {
        background: #ffffff;
        border: 1px solid #edf1f5;
        border-radius: 20px;
        padding: 28px 24px;
        margin-bottom: 32px;
        box-shadow: 0 6px 18px rgba(80, 112, 150, 0.08);
        border-left: 6px solid #ffaeac;
    }

    .artist-label {
        display: inline-block;
        color: #ec707e;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .artist-title {
        font-size: 30px;
        font-weight: 800;
        color: #26384f;
        margin-bottom: 6px;
    }

    .artist-subtitle {
        color: #6d7f91;
        margin-bottom: 0;
        font-size: 14px;
    }

    .product-section-title {
        font-size: 20px;
        font-weight: 800;
        color: #26384f;
        margin-bottom: 20px;
    }

    .artist-product-card {
        border: 1px solid #edf1f5;
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 5px 14px rgba(80, 112, 150, 0.08);
        transition: 0.2s ease;
        height: 100%;
    }

    .artist-product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(80, 112, 150, 0.13);
    }

    .artist-product-image-wrap {
        background: #f2f7fc;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .artist-product-image {
        max-width: 100%;
        max-height: 190px;
        object-fit: contain;
    }

    .artist-product-body {
        padding: 16px;
    }

    .artist-product-name {
        font-size: 14px;
        font-weight: 700;
        color: #26384f;
        min-height: 42px;
        margin-bottom: 6px;
        line-height: 1.45;
    }

    .artist-product-category {
        font-size: 13px;
        color: #7c8fa5;
        margin-bottom: 12px;
    }

    .artist-price-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #edf1f5;
        padding-top: 12px;
    }

    .artist-currency {
        font-size: 12px;
        font-weight: 700;
        color: #ec707e;
    }

    .artist-price {
        font-size: 14px;
        font-weight: 800;
        color: #26384f;
    }

    .empty-product {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px;
        text-align: center;
        color: #52677f;
        border: 1px solid #edf1f5;
        box-shadow: 0 5px 14px rgba(80, 112, 150, 0.08);
    }

    @media (max-width: 768px) {
        .artist-page {
            padding: 24px 16px 50px;
        }

        .artist-title {
            font-size: 26px;
        }

        .artist-header {
            padding: 24px 20px;
        }
    }
</style>

<body>
    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="artist-page">

        <a href="/index.php?Page=home" class="back-link">
            ← Kembali
        </a>

        <section class="artist-header">
            <div class="artist-label">
                ARTIST PRODUCTS
            </div>

            <h1 class="artist-title">
                <?= htmlspecialchars($artis['nama_artis'], ENT_QUOTES); ?>
            </h1>

            <p class="artist-subtitle">
                Kumpulan produk yang tersedia dari artis ini.
            </p>
        </section>

        <section>
            <h2 class="product-section-title">
                Produk Tersedia
            </h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">

                <?php if ($produk && $produk->num_rows > 0): ?>
                    <?php while ($row = $produk->fetch_assoc()): ?>

                        <div class="col">
                            <a href="/index.php?Page=detailProduk&id=<?= $row['id_produk']; ?>"
                               class="text-decoration-none">

                                <div class="artist-product-card">

                                    <div class="artist-product-image-wrap">
                                        <?php if (!empty($row['gambar_produk'])): ?>
                                            <img src="/produk-cover/<?= htmlspecialchars($row['gambar_produk'], ENT_QUOTES); ?>"
                                                 class="artist-product-image"
                                                 alt="<?= htmlspecialchars($row['nama_produk'], ENT_QUOTES); ?>">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="artist-product-body">

                                        <div class="artist-product-name">
                                            <?= htmlspecialchars($row['nama_produk'], ENT_QUOTES); ?>
                                        </div>

                                        <div class="artist-product-category">
                                            <?= htmlspecialchars($row['nama_kategori'] ?? 'Produk', ENT_QUOTES); ?>
                                        </div>

                                        <div class="artist-price-box">
                                            <span class="artist-currency">
                                                IDR
                                            </span>

                                            <span class="artist-price">
                                                Rp. <?= number_format($row['harga'], 0, ',', '.'); ?>
                                            </span>
                                        </div>

                                    </div>
                                </div>

                            </a>
                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12">
                        <div class="empty-product">
                            Belum ada produk untuk artis ini.
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </section>

    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>
</body>
</html>