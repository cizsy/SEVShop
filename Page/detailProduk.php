<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$id_produk = $_GET['id'] ?? null;

if (!$id_produk) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Produk tidak ditemukan.</div></div>";
    exit;
}

$stmt = $conn->prepare("
    SELECT 
        p.*,
        a.nama_artis,
        k.nama_kategori,
        pb.nama_penerbit
    FROM produk p
    LEFT JOIN artis a ON p.id_artis = a.id_artis
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit
    WHERE p.id_produk = ?
    LIMIT 1
");

$stmt->bind_param("i", $id_produk);
$stmt->execute();
$produk = $stmt->get_result()->fetch_assoc();

if (!$produk) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Produk tidak ditemukan.</div></div>";
    exit;
}

$harga = (int) $produk['harga'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?> - SEVShop</title>
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/shopAll.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <div class="view-produk container mb-5 mt-4">
        <div class="row">
            <div class="col-md-12 d-flex flex-wrap shadow bg-white p-4 rounded-4 border">

                <div class="produk-img col-md-5 m-3 text-center">
                    <?php if (!empty($produk['gambar_produk'])): ?>
                        <img src="/produk-cover/<?= htmlspecialchars($produk['gambar_produk'], ENT_QUOTES); ?>"
                             alt="<?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?>"
                             class="img-fluid rounded-3 shadow-sm" style="max-height: 420px; object-fit: contain;">
                    <?php else: ?>
                        <div class="bg-light rounded-3 shadow-sm d-flex align-items-center justify-content-center"
                             style="height: 350px;">
                            Tidak ada gambar
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-info col-md-6 m-3">
                    <div class="d-flex align-items-start mb-3">
                        <div class="grow flex-grow-1">
                            <div class="nama-artis text-danger fw-bold fs-6">
                                <?= htmlspecialchars($produk['nama_artis'] ?? '-', ENT_QUOTES); ?>
                            </div>

                            <h1 class="nama-produk h3 fw-bold text-dark mb-2">
                                <?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?>
                            </h1>
                        </div>

                        <button class="wishlist-btn btn btn-outline-danger rounded-circle p-2" id="wishlistBtn" title="Wishlist" onclick="toggleDetailWishlist()">
                            <i class="bi bi-heart fs-5" id="wishlistHeartIcon"></i>
                        </button>
                    </div>

                    <div class="tag-idr text-muted small fw-bold">HARGA RESMI</div>

                    <div class="harga-produk fs-3 fw-bold text-danger mb-3">
                        Rp. <?= number_format($harga, 0, ',', '.'); ?>
                    </div>

                    <div class="beli mb-3 p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="label-barang fw-bold small text-muted">Jumlah Pembelian</span>
                            <span class="small text-muted">Tersedia: <strong><?= htmlspecialchars($produk['stok'] ?? '99', ENT_QUOTES); ?></strong> pcs</span>
                        </div>

                        <div class="kontrol-barang d-flex align-items-center gap-2">
                            <button class="btn btn-outline-secondary btn-sm rounded-circle px-3 fw-bold" onclick="decreaseQuantity()">-</button>

                            <input type="number"
                                   class="form-control form-control-sm text-center fw-bold"
                                   id="stok"
                                   value="1"
                                   min="1"
                                   max="<?= htmlspecialchars($produk['stok'] ?? 99, ENT_QUOTES); ?>"
                                   style="max-width: 70px;"
                                   data-price="<?= $harga; ?>">

                            <button class="btn btn-outline-secondary btn-sm rounded-circle px-3 fw-bold" onclick="increaseQuantity()">+</button>

                            <span class="ms-auto fw-bold text-dark">
                                Subtotal: <span id="total-harga" class="text-danger">Rp. <?= number_format($harga, 0, ',', '.'); ?></span>
                            </span>
                        </div>
                    </div>

                    <div class="button-group d-flex gap-3 mb-3">
                        <button class="btn btn-outline-danger flex-grow-1 py-2 fw-bold rounded-pill" onclick="addToCartAjax(false)">
                            <i class="bi bi-bag-plus me-1"></i> Masukkan ke Keranjang
                        </button>

                        <button class="btn btn-danger flex-grow-1 py-2 fw-bold rounded-pill" style="background:#ec707e; border:none;" onclick="addToCartAjax(true)">
                            <i class="bi bi-lightning-fill me-1"></i> Pesan Sekarang
                        </button>
                    </div>

                    <div class="shipping-info small text-muted bg-white p-2 border rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-truck text-danger fs-5"></i>
                        <span>Pengiriman ke seluruh Indonesia dengan proteksi bubble wrap tebal & official seal guarantee.</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tabs-section container mb-5">
        <div class="bg-white rounded-4 p-4 shadow-sm border">

            <h2 class="h4 fw-bold mb-4 text-dark"><i class="bi bi-info-circle me-2 text-danger"></i>Informasi & Spesifikasi Produk</h2>

            <div class="alert alert-light border p-3 mb-4 rounded-3">
                <strong>Catatan Penting:</strong>
                <?php if (!empty($produk['notice'])): ?>
                    <p class="mb-0 mt-2">
                        <?= nl2br(htmlspecialchars($produk['notice'], ENT_QUOTES)); ?>
                    </p>
                <?php else: ?>
                    <ul class="mb-0 mt-2 small text-muted">
                        <li>Semua album dan merch 100% Original langsung terhitung pada Hanteo & Circle Chart.</li>
                        <li>Box luar (outbox) berfungsi sebagai proteksi pengiriman.</li>
                    </ul>
                <?php endif; ?>
            </div>

            <table class="table table-bordered table-striped mb-4">
                <tr>
                    <td style="width: 30%;"><strong>Nama Produk</strong></td>
                    <td><?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Artis</strong></td>
                    <td><?= htmlspecialchars($produk['nama_artis'] ?? '-', ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Kategori</strong></td>
                    <td><?= htmlspecialchars($produk['nama_kategori'] ?? '-', ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Penerbit / Label</strong></td>
                    <td><?= htmlspecialchars($produk['nama_penerbit'] ?? '-', ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Tahun Rilis</strong></td>
                    <td><?= htmlspecialchars($produk['thn_terbit'] ?? '-', ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Stok Tersedia</strong></td>
                    <td><?= htmlspecialchars($produk['stok'] ?? '0', ENT_QUOTES); ?> pcs</td>
                </tr>

                <tr>
                    <td><strong>Ukuran / Dimensi</strong></td>
                    <td><?= htmlspecialchars($produk['size'] ?? '-', ENT_QUOTES); ?></td>
                </tr>

                <tr>
                    <td><strong>Isi Paket (Contents)</strong></td>
                    <td>
                        <?php if (!empty($produk['contents'])): ?>
                            <?= nl2br(htmlspecialchars($produk['contents'], ENT_QUOTES)); ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <?php if (!empty($produk['detail'])): ?>
                <div class="text-center mt-4">
                    <h3 class="h5 fw-bold mb-3 text-muted">Detail Merchandise</h3>
                    <img src="/produk-detail/<?= htmlspecialchars($produk['detail'], ENT_QUOTES); ?>"
                         class="img-fluid rounded-3 shadow-sm"
                         alt="Detail Produk">
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="detailToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="detailToastBody">
                    Aksi berhasil!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <script>
        const productId = <?= (int)$produk['id_produk']; ?>;
        const productPrice = <?= $harga; ?>;
        const prodData = {
            id_produk: productId,
            nama_produk: <?= json_encode($produk['nama_produk']); ?>,
            nama_artis: <?= json_encode($produk['nama_artis'] ?? 'K-Pop'); ?>,
            harga: productPrice,
            gambar_produk: <?= json_encode($produk['gambar_produk'] ?? ''); ?>
        };

        function formatRupiah(number) {
            return "Rp. " + number.toLocaleString("id-ID");
        }

        function updateTotal() {
            const input = document.getElementById("stok");
            const totalHarga = document.getElementById("total-harga");
            let qty = parseInt(input.value) || 1;
            const max = parseInt(input.max) || 999;

            if (qty < 1) qty = 1;
            if (qty > max) qty = max;

            input.value = qty;
            totalHarga.textContent = formatRupiah(productPrice * qty);
        }

        function increaseQuantity() {
            const input = document.getElementById("stok");
            const max = parseInt(input.max) || 999;
            let qty = parseInt(input.value) || 1;

            if (qty < max) {
                input.value = qty + 1;
            }
            updateTotal();
        }

        function decreaseQuantity() {
            const input = document.getElementById("stok");
            let qty = parseInt(input.value) || 1;

            if (qty > 1) {
                input.value = qty - 1;
            }
            updateTotal();
        }

        function showDetailToast(msg) {
            document.getElementById('detailToastBody').innerHTML = msg;
            const toastEl = document.getElementById('detailToast');
            const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
            toast.show();
        }

        function addToCartAjax(directCheckout = false) {
            const qty = parseInt(document.getElementById('stok').value) || 1;
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('id_produk', productId);
            formData.append('qty', qty);

            fetch('/index.php?Page=api_cart', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (directCheckout) {
                        window.location.href = '/index.php?Page=checkout';
                    } else {
                        showDetailToast('<i class="bi bi-check-circle-fill text-success me-2"></i>' + data.message);
                        const badge = document.getElementById('navCartBadge');
                        if (badge) {
                            badge.textContent = data.cartCount;
                            badge.style.display = 'flex';
                        }
                    }
                }
            })
            .catch(() => {
                if (directCheckout) window.location.href = '/index.php?Page=checkout';
            });
        }

        function toggleDetailWishlist() {
            let saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            const icon = document.getElementById('wishlistHeartIcon');

            if (saved[productId]) {
                delete saved[productId];
                icon.className = 'bi bi-heart fs-5';
                showDetailToast('<i class="bi bi-trash3 text-warning me-2"></i>Dihapus dari Wishlist');
            } else {
                saved[productId] = {
                    id: productId,
                    name: prodData.nama_produk,
                    group: prodData.nama_artis,
                    price: productPrice,
                    image: prodData.gambar_produk
                };
                icon.className = 'bi bi-heart-fill text-danger fs-5';
                showDetailToast('<i class="bi bi-heart-fill text-danger me-2"></i>Disimpan ke Wishlist!');
            }
            localStorage.setItem('sev_wishlist', JSON.stringify(saved));
            window.dispatchEvent(new CustomEvent('wishlistUpdated'));
        }

        // Check if item is already in wishlist on page load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            if (saved[productId]) {
                const icon = document.getElementById('wishlistHeartIcon');
                if (icon) icon.className = 'bi bi-heart-fill text-danger fs-5';
            }
        });

        document.getElementById("stok").addEventListener("input", updateTotal);
    </script>
</body>
</html>