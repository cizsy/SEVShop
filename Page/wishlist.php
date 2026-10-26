<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya - SEVShop</title>
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
        .wishlist-wrapper {
            max-width: 1200px;
            margin: 35px auto 70px;
            padding: 0 15px;
        }
        .wishlist-card {
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
        .wishlist-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(236, 112, 126, 0.18);
            border-color: #ffaeac;
        }
        .wishlist-img-wrap {
            height: 200px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .wishlist-img-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .btn-move-cart {
            background: #ec707e;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 700;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-move-cart:hover {
            background: #e05364;
            color: white;
        }
        .btn-remove-wishlist {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-remove-wishlist:hover {
            background: #fee2e2;
            color: #ef4444;
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="wishlist-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">
                    <i class="bi bi-heart-fill text-danger me-2"></i> Wishlist Favorit Saya
                </h1>
                <p class="text-muted small mb-0">Daftar merchandise impian yang tersimpan di akun Anda.</p>
            </div>
            <div id="wishlistActions" style="display: none;">
                <button class="btn btn-outline-danger btn-sm rounded-pill px-3 me-2" onclick="addAllToCart()">
                    <i class="bi bi-bag-plus me-1"></i> Pindahkan Semua ke Keranjang
                </button>
                <button class="btn btn-light border btn-sm rounded-pill px-3" onclick="clearWishlist()">
                    <i class="bi bi-trash me-1"></i> Bersihkan Wishlist
                </button>
            </div>
        </div>

        <div id="emptyWishlistView" class="bg-white rounded-4 p-5 text-center shadow-sm border" style="display: none;">
            <div style="font-size: 60px; margin-bottom: 12px;">💖✨</div>
            <h3 class="fw-bold mb-2">Wishlist Masih Kosong</h3>
            <p class="text-muted mb-4">Yuk simpan produk dan official merchandise incaranmu sekarang!</p>
            <a href="/index.php?Page=search" class="btn btn-danger rounded-pill px-4 py-2 fw-bold" style="background:#ec707e; border:none;">
                Jelajahi Merchandise
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="wishlistGrid">
            <!-- Dynamically populated via JS -->
        </div>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="wishlistToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="wishlistToastBody">
                    Aksi berhasil!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        function showWishlistToast(msg) {
            document.getElementById('wishlistToastBody').innerHTML = msg;
            const toastEl = document.getElementById('wishlistToast');
            const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
            toast.show();
        }

        function renderWishlist() {
            const grid = document.getElementById('wishlistGrid');
            const emptyView = document.getElementById('emptyWishlistView');
            const actions = document.getElementById('wishlistActions');
            const saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            const items = Object.values(saved);

            grid.innerHTML = '';

            if (items.length === 0) {
                emptyView.style.display = 'block';
                actions.style.display = 'none';
                return;
            }

            emptyView.style.display = 'none';
            actions.style.display = 'block';

            items.forEach(item => {
                const col = document.createElement('div');
                col.className = 'col';
                col.innerHTML = `
                    <div class="wishlist-card">
                        <a href="/index.php?Page=detailProduk&id=${item.id}" class="text-decoration-none">
                            <div class="wishlist-img-wrap">
                                ${item.image ? `<img src="/produk-cover/${item.image}" alt="${item.name}">` : '<i class="bi bi-gift fs-1 text-muted"></i>'}
                            </div>
                        </a>
                        <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <span class="badge bg-danger-subtle text-danger mb-2 font-weight-normal">${item.group || 'K-Pop'}</span>
                                <a href="/index.php?Page=detailProduk&id=${item.id}" class="text-decoration-none text-dark">
                                    <h3 class="h6 fw-bold mb-2 text-truncate" title="${item.name}">${item.name}</h3>
                                </a>
                                <div class="fw-bold text-danger fs-6 mb-3">
                                    Rp ${(item.price || 0).toLocaleString('id-ID')}
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <button class="btn-move-cart" onclick="moveToCart(${item.id})">
                                    <i class="bi bi-bag-plus-fill me-1"></i> Masukkan Keranjang
                                </button>
                                <button class="btn-remove-wishlist" onclick="removeFromWishlist(${item.id})">
                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                grid.appendChild(col);
            });
        }

        function moveToCart(productId) {
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
                    showWishlistToast('<i class="bi bi-check-circle-fill text-success me-2"></i>Produk dimasukkan ke keranjang!');
                    const badge = document.getElementById('navCartBadge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        badge.style.display = 'flex';
                    }
                }
            });
        }

        function removeFromWishlist(productId) {
            let saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            delete saved[productId];
            localStorage.setItem('sev_wishlist', JSON.stringify(saved));
            window.dispatchEvent(new CustomEvent('wishlistUpdated'));
            renderWishlist();
            showWishlistToast('<i class="bi bi-trash text-warning me-2"></i>Produk dihapus dari wishlist');
        }

        function clearWishlist() {
            if (!confirm('Hapus seluruh produk di wishlist?')) return;
            localStorage.removeItem('sev_wishlist');
            window.dispatchEvent(new CustomEvent('wishlistUpdated'));
            renderWishlist();
        }

        function addAllToCart() {
            const saved = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
            const items = Object.values(saved);
            if (items.length === 0) return;

            let promises = items.map(item => {
                const formData = new FormData();
                formData.append('action', 'add');
                formData.append('id_produk', item.id);
                formData.append('qty', 1);
                return fetch('/index.php?Page=api_cart', { method: 'POST', body: formData });
            });

            Promise.all(promises).then(() => {
                window.location.href = '/index.php?Page=cart';
            });
        }

        document.addEventListener('DOMContentLoaded', renderWishlist);
    </script>
</body>
</html>