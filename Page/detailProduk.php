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

<?php include __DIR__ . '/../Component/header.php'; ?>
<?php include __DIR__ . '/../Component/navbar.php'; ?>

<script src="/script/detailproduk.js"></script>

<div class="view-produk container mb-5 mt-4">
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap shadow bg-white p-4 rounded">

            <div class="produk-img col-md-5 m-3">
                <?php if (!empty($produk['gambar_produk'])): ?>
                    <img src="/produk-cover/<?= htmlspecialchars($produk['gambar_produk'], ENT_QUOTES); ?>"
                         alt="<?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?>"
                         class="img-fluid rounded shadow">
                <?php else: ?>
                    <div class="bg-light rounded shadow d-flex align-items-center justify-content-center"
                         style="height: 350px;">
                        Tidak ada gambar
                    </div>
                <?php endif; ?>
            </div>

            <div class="product-info col-md-6 m-3">
                <div class="d-flex align-items-start mb-3">
                    <div class="grow">
                        <div class="nama-artis">
                            <?= htmlspecialchars($produk['nama_artis'] ?? '-', ENT_QUOTES); ?>
                        </div>

                        <div class="nama-produk">
                            <?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?>
                        </div>
                    </div>

                    <button class="wishlist-btn" id="wishlistBtn">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <div class="tag-idr">IDR</div>

                <div class="harga-produk">
                    Rp. <?= number_format($harga, 0, ',', '.'); ?>
                </div>

                <div class="beli">
                    <div class="label-barang">
                        Set
                    </div>

                    <div class="kontrol-barang">
                        <button class="btn-stok" onclick="decreaseQuantity()">-</button>

                        <input type="number"
                               class="input-stok"
                               id="stok"
                               value="1"
                               min="1"
                               max="<?= htmlspecialchars($produk['stok'], ENT_QUOTES); ?>"
                               data-price="<?= $harga; ?>">

                        <button class="btn-stok" onclick="increaseQuantity()">+</button>

                        <span style="margin-left: auto; font-weight: 600;">
                            Rp. <?= number_format($harga, 0, ',', '.'); ?>
                        </span>
                    </div>
                </div>

                <div class="total-harga">
                    <div class="selected-info">
                        <span id="selected-count">1</span> Barang dipilih<br>
                    </div>

                    <div id="total-harga" style="font-size: 20px; font-weight: 700;">
                        Rp. <?= number_format($harga, 0, ',', '.'); ?>
                    </div>
                </div>

                <div class="button-group">
                    <button class="btn-cart">
                        Masukkan ke Keranjang
                    </button>

                    <button class="btn-purchase">
                        Pesan
                    </button>
                </div>

                <div class="shipping-info">
                    <span>📍</span>
                    <span>Tambahkan alamat untuk memeriksa ongkir</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="tabs-section container mt-5">
    <div class="container mt-4">

        <h3 class="text-center mb-4">Informasi Produk</h3>

        <div class="alert alert-light border p-3 mb-4">
            <strong>Harap Diperhatikan:</strong>

            <?php if (!empty($produk['notice'])): ?>
                <p class="mb-0 mt-2">
                    <?= nl2br(htmlspecialchars($produk['notice'], ENT_QUOTES)); ?>
                </p>
            <?php else: ?>
                <ul class="mb-0">
                    <li>Box luar digunakan untuk melindungi produk utama.</li>
                    <li>Ukuran produk dapat berbeda karena perbedaan metode pengukuran.</li>
                    <li>Warna produk pada gambar dapat berbeda tergantung layar perangkat.</li>
                </ul>
            <?php endif; ?>
        </div>

        <table class="table table-bordered p-3 mb-4">
            <tr>
                <td><strong>Nama Produk</strong></td>
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
                <td><strong>Penerbit / Produsen</strong></td>
                <td><?= htmlspecialchars($produk['nama_penerbit'] ?? '-', ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td><strong>Tahun Terbit</strong></td>
                <td><?= htmlspecialchars($produk['thn_terbit'] ?? '-', ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td><strong>Stok</strong></td>
                <td><?= htmlspecialchars($produk['stok'] ?? '0', ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td><strong>Size</strong></td>
                <td><?= htmlspecialchars($produk['size'] ?? '-', ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td><strong>Contents</strong></td>
                <td>
                    <?php if (!empty($produk['contents'])): ?>
                        <?= nl2br(htmlspecialchars($produk['contents'], ENT_QUOTES)); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td><strong>Terms Recommend</strong></td>
                <td>
                    <?php if (!empty($produk['terms_recomen'])): ?>
                        <?= nl2br(htmlspecialchars($produk['terms_recomen'], ENT_QUOTES)); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="text-center mt-5 mb-4">
            <?php if (!empty($produk['detail'])): ?>
                <img src="/produk-detail/<?= htmlspecialchars($produk['detail'], ENT_QUOTES); ?>"
                     class="img-fluid mb-3 rounded"
                     alt="Detail Produk">
            <?php else: ?>
                <div class="alert alert-secondary">
                    Gambar detail produk belum tersedia.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    const price = <?= $harga; ?>;

    function formatRupiah(number) {
        return "Rp. " + number.toLocaleString("id-ID");
    }

    function updateTotal() {
        const input = document.getElementById("stok");
        const selectedCount = document.getElementById("selected-count");
        const totalHarga = document.getElementById("total-harga");

        let qty = parseInt(input.value) || 1;
        const max = parseInt(input.max) || 999;

        if (qty < 1) qty = 1;
        if (qty > max) qty = max;

        input.value = qty;
        selectedCount.textContent = qty;
        totalHarga.textContent = formatRupiah(price * qty);
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

    document.getElementById("stok").addEventListener("input", updateTotal);
</script>

<?php include __DIR__ . '/../Component/footer.php'; ?>