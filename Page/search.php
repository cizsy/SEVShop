<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/artis.php';
require_once __DIR__ . '/../Model/kategori.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$q = trim($_GET['q'] ?? '');
$selectedArtist = $_GET['artist'] ?? '';
$selectedCategory = $_GET['category'] ?? '';
$minPrice = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? (int)$_GET['max_price'] : 0;
$sortBy = $_GET['sort'] ?? 'newest';

// Fetch all artists for filter
$artistListRes = $conn->query("SELECT * FROM artis ORDER BY nama_artis ASC");
$artistList = [];
if ($artistListRes) {
    while ($a = $artistListRes->fetch_assoc()) {
        $artistList[] = $a;
    }
}

// Fetch all categories for filter
$catListRes = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$categoryList = [];
if ($catListRes) {
    while ($c = $catListRes->fetch_assoc()) {
        $categoryList[] = $c;
    }
}

// Build dynamic search query
$whereClauses = ["1=1"];
$params = [];
$types = "";

if (!empty($q)) {
    $whereClauses[] = "(p.nama_produk LIKE ? OR a.nama_artis LIKE ? OR k.nama_kategori LIKE ? OR pb.nama_penerbit LIKE ?)";
    $likeQ = "%" . $q . "%";
    $params[] = $likeQ;
    $params[] = $likeQ;
    $params[] = $likeQ;
    $params[] = $likeQ;
    $types .= "ssss";
}

if (!empty($selectedArtist)) {
    $whereClauses[] = "p.id_artis = ?";
    $params[] = (int)$selectedArtist;
    $types .= "i";
}

if (!empty($selectedCategory)) {
    $whereClauses[] = "(p.id_kategori = ? OR k.nama_kategori = ?)";
    $params[] = (int)$selectedCategory;
    $params[] = $selectedCategory;
    $types .= "is";
}

if ($minPrice > 0) {
    $whereClauses[] = "p.harga >= ?";
    $params[] = $minPrice;
    $types .= "i";
}

if ($maxPrice > 0) {
    $whereClauses[] = "p.harga <= ?";
    $params[] = $maxPrice;
    $types .= "i";
}

// Sorting logic
$orderClause = "ORDER BY p.id_produk DESC";
if ($sortBy === 'price_asc') {
    $orderClause = "ORDER BY p.harga ASC";
} elseif ($sortBy === 'price_desc') {
    $orderClause = "ORDER BY p.harga DESC";
} elseif ($sortBy === 'name_asc') {
    $orderClause = "ORDER BY p.nama_produk ASC";
} elseif ($sortBy === 'oldest') {
    $orderClause = "ORDER BY p.id_produk ASC";
}

$sql = "
    SELECT p.*, a.nama_artis, a.logo_artis, k.nama_kategori, pb.nama_penerbit
    FROM produk p
    LEFT JOIN artis a ON p.id_artis = a.id_artis
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    LEFT JOIN penerbit pb ON p.id_penerbit = pb.id_penerbit
    WHERE " . implode(" AND ", $whereClauses) . "
    " . $orderClause . "
";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$searchResults = $stmt->get_result();
$totalResults = $searchResults->num_rows;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog & Pencarian Produk - SEVShop</title>
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f7ff 0%, #fff0f3 100%);
            min-height: 100vh;
            color: #2b3a4a;
        }
        .catalog-container {
            max-width: 1240px;
            margin: 30px auto 70px;
            padding: 0 15px;
        }
        .filter-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            position: sticky;
            top: 90px;
        }
        .filter-section-title {
            font-size: 14px;
            font-weight: 800;
            color: #2b3a4a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .product-card-custom {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            box-shadow: 0 5px 15px rgba(80, 112, 150, 0.06);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }
        .product-card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(236, 112, 126, 0.18);
            border-color: #ffaeac;
        }
        .product-thumb-container {
            height: 210px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            position: relative;
            overflow: hidden;
        }
        .product-thumb-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .product-card-custom:hover .product-thumb-container img {
            transform: scale(1.05);
        }
        .artist-badge-pill {
            background: #ffe6e8;
            color: #ec707e;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .product-title-text {
            font-size: 14.5px;
            font-weight: 700;
            color: #2b3a4a;
            line-height: 1.35;
            min-height: 38px;
            margin-bottom: 8px;
        }
        .product-price-tag {
            font-size: 15px;
            font-weight: 800;
            color: #ec707e;
        }
        .btn-quick-cart {
            background: #ffe6e8;
            color: #ec707e;
            border: none;
            border-radius: 10px;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 12.5px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
        }
        .btn-quick-cart:hover {
            background: #ec707e;
            color: #ffffff;
        }
        .wishlist-heart-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.85);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ec707e;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            z-index: 10;
        }
        .wishlist-heart-btn:hover {
            transform: scale(1.15);
            background: #ffffff;
        }
        .filter-chip {
            padding: 6px 14px;
            border-radius: 50px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            color: #4a5568;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin: 3px;
            transition: all 0.2s;
        }
        .filter-chip:hover, .filter-chip.active {
            background: #ec707e;
            color: #ffffff;
            border-color: #ec707e;
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="catalog-container">
        
        <!-- Header Banner -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">
                    <i class="bi bi-grid-fill text-danger me-2"></i> Katalog & Pencarian Merchandise
                </h1>
                <p class="text-muted small mb-0">
                    <?php if (!empty($q)): ?>
                        Hasil pencarian untuk: <strong class="text-danger">"<?= htmlspecialchars($q, ENT_QUOTES); ?>"</strong> (<?= $totalResults; ?> produk ditemukan)
                    <?php else: ?>
                        Menampilkan <?= $totalResults; ?> produk official K-Pop merch original
                    <?php endif; ?>
                </p>
            </div>

            <!-- Sorting Dropdown -->
            <div class="d-flex align-items-center gap-2">
                <label class="small text-muted fw-bold text-nowrap">Urutkan:</label>
                <select class="form-select form-select-sm rounded-pill px-3" style="width: auto;" onchange="applySort(this.value)">
                    <option value="newest" <?= $sortBy === 'newest' ? 'selected' : ''; ?>>Terbaru</option>
                    <option value="price_asc" <?= $sortBy === 'price_asc' ? 'selected' : ''; ?>>Harga: Terendah ke Tertinggi</option>
                    <option value="price_desc" <?= $sortBy === 'price_desc' ? 'selected' : ''; ?>>Harga: Tertinggi ke Terendah</option>
                    <option value="name_asc" <?= $sortBy === 'name_asc' ? 'selected' : ''; ?>>Nama: A - Z</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left: Filter Sidebar -->
            <div class="col-lg-3">
                <div class="filter-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-sliders me-1"></i> Filter Produk</h2>
                        <a href="/index.php?Page=search" class="text-danger small text-decoration-none">Reset</a>
                    </div>

                    <form action="/index.php" method="get" id="filterForm">
                        <input type="hidden" name="Page" value="search">
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($sortBy, ENT_QUOTES); ?>">

                        <!-- Keyword Input -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kata Kunci</label>
                            <input type="text" name="q" class="form-control form-control-sm rounded-pill" 
                                   value="<?= htmlspecialchars($q, ENT_QUOTES); ?>" placeholder="Nama produk / artis...">
                        </div>

                        <!-- Artist Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Artis / Group</label>
                            <select name="artist" class="form-select form-select-sm rounded-pill">
                                <option value="">Semua Artis</option>
                                <?php foreach ($artistList as $art): ?>
                                    <option value="<?= $art['id_artis']; ?>" <?= (string)$selectedArtist === (string)$art['id_artis'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($art['nama_artis'], ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category" class="form-select form-select-sm rounded-pill">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categoryList as $cat): ?>
                                    <option value="<?= $cat['nama_kategori']; ?>" <?= $selectedCategory === $cat['nama_kategori'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($cat['nama_kategori'], ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Rentang Harga (Rp)</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm" 
                                       value="<?= $minPrice > 0 ? $minPrice : ''; ?>" placeholder="Min">
                                <input type="number" name="max_price" class="form-control form-control-sm" 
                                       value="<?= $maxPrice > 0 ? $maxPrice : ''; ?>" placeholder="Max">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 rounded-pill btn-sm fw-bold" style="background:#ec707e; border:none;">
                            Terapkan Filter
                        </button>
                    </form>

                    <!-- Popular Tags / Categories -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="small fw-bold text-muted mb-2">Kategori Populer:</div>
                        <div class="d-flex flex-wrap">
                            <a href="/index.php?Page=search&category=BestSeller" class="filter-chip <?= $selectedCategory === 'BestSeller' ? 'active' : ''; ?>">🔥 Best Seller</a>
                            <a href="/index.php?Page=search&category=NewArrival" class="filter-chip <?= $selectedCategory === 'NewArrival' ? 'active' : ''; ?>">✨ New Arrival</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Product Grid -->
            <div class="col-lg-9">
                <?php if ($totalResults > 0): ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        <?php while ($prod = $searchResults->fetch_assoc()): ?>
                            <div class="col">
                                <div class="product-card-custom">
                                    <button class="wishlist-heart-btn" title="Simpan ke Wishlist" onclick="toggleWishlist(<?= htmlspecialchars(json_encode($prod), ENT_QUOTES); ?>, this)">
                                        <i class="bi bi-heart"></i>
                                    </button>

                                    <a href="/index.php?Page=detailProduk&id=<?= $prod['id_produk']; ?>" class="text-decoration-none">
                                        <div class="product-thumb-container">
                                            <?php if (!empty($prod['gambar_produk'])): ?>
                                                <img src="/produk-cover/<?= htmlspecialchars($prod['gambar_produk'], ENT_QUOTES); ?>" 
                                                     alt="<?= htmlspecialchars($prod['nama_produk'], ENT_QUOTES); ?>">
                                            <?php else: ?>
                                                <span class="text-muted small">No Image</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>

                                    <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                        <div>
                                            <span class="artist-badge-pill"><?= htmlspecialchars($prod['nama_artis'] ?? '-', ENT_QUOTES); ?></span>
                                            <a href="/index.php?Page=detailProduk&id=<?= $prod['id_produk']; ?>" class="text-decoration-none">
                                                <h3 class="product-title-text"><?= htmlspecialchars($prod['nama_produk'], ENT_QUOTES); ?></h3>
                                            </a>
                                            <div class="product-price-tag mb-3">
                                                Rp <?= number_format($prod['harga'], 0, ',', '.'); ?>
                                            </div>
                                        </div>

                                        <button class="btn-quick-cart" onclick="quickAddToCart(<?= $prod['id_produk']; ?>)">
                                            <i class="bi bi-bag-plus-fill"></i> + Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
                        <div style="font-size: 60px; margin-bottom: 12px;">🔍💔</div>
                        <h3 class="fw-bold mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-muted mb-4">Kami tidak dapat menemukan produk yang sesuai dengan kriteria filter atau pencarian Anda.</p>
                        <a href="/index.php?Page=search" class="btn btn-danger rounded-pill px-4 py-2" style="background:#ec707e; border:none;">
                            Reset Filter & Tampilkan Semua
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="actionToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Aksi berhasil!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        function applySort(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            window.location.href = url.toString();
        }

        function showToast(msg) {
            document.getElementById('toastMessage').innerHTML = msg;
            const toastEl = document.getElementById('actionToast');
            const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
            toast.show();
        }

        function quickAddToCart(productId) {
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('id_produk', productId);
            formData.append('qty', 1);

            fetch('/index.php?Page=api_cart', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('<i class="bi bi-check-circle-fill text-success me-2"></i>' + data.message);
                    const badge = document.getElementById('navCartBadge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        badge.style.display = 'flex';
                    }
                }
            });
        }

        function toggleWishlist(prod, btn) {
            let saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            const id = prod.id_produk;
            const icon = btn.querySelector('i');

            if (saved[id]) {
                delete saved[id];
                icon.className = 'bi bi-heart';
                showToast('<i class="bi bi-trash3 text-warning me-2"></i>Dihapus dari Wishlist');
            } else {
                saved[id] = {
                    id: prod.id_produk,
                    name: prod.nama_produk,
                    group: prod.nama_artis || 'K-Pop',
                    price: parseInt(prod.harga),
                    image: prod.gambar_produk
                };
                icon.className = 'bi bi-heart-fill text-danger';
                showToast('<i class="bi bi-heart-fill text-danger me-2"></i>Disimpan ke Wishlist!');
            }
            localStorage.setItem('sev_wishlist', JSON.stringify(saved));
            window.dispatchEvent(new CustomEvent('wishlistUpdated'));
        }
    </script>
</body>
</html>
