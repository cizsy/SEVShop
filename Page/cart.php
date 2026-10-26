<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/CartController.php';
$cartCtrl = new CartController();

// Handle direct POST actions if JavaScript is disabled
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_produk = (int)($_POST['id_produk'] ?? 0);

    if ($action === 'update') {
        $qty = (int)($_POST['qty'] ?? 1);
        $cartCtrl->updateQuantity($id_produk, $qty);
    } elseif ($action === 'remove') {
        $cartCtrl->removeFromCart($id_produk);
    } elseif ($action === 'clear') {
        $cartCtrl->clearCart();
    } elseif ($action === 'coupon') {
        $code = $_POST['coupon_code'] ?? '';
        $cartCtrl->applyCoupon($code);
    } elseif ($action === 'remove_coupon') {
        $cartCtrl->removeCoupon();
    }
    header("Location: /index.php?Page=cart");
    exit;
}

$cartItems = $cartCtrl->getCartItems();
$cartCount = $cartCtrl->getCartCount();
$subtotal = $cartCtrl->getSubtotal();
$discount = $cartCtrl->getDiscount();
$coupon = $_SESSION['coupon'] ?? null;
$grandTotal = $cartCtrl->getGrandTotal();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - SEVShop</title>
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/cart.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f7ff 0%, #fff0f3 100%);
            min-height: 100vh;
            color: #2b3a4a;
        }
        .cart-wrapper {
            max-width: 1200px;
            margin: 35px auto 60px;
            padding: 0 15px;
        }
        .cart-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .cart-page-title {
            font-size: 28px;
            font-weight: 800;
            color: #2b3a4a;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-item-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 5px 20px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            transition: all 0.2s ease;
        }
        .cart-item-card:hover {
            box-shadow: 0 8px 25px rgba(236, 112, 126, 0.12);
        }
        .product-img-box {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            background: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .product-img-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .artist-pill {
            background: #ffe6e8;
            color: #ec707e;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 5px;
        }
        .item-name {
            font-size: 16px;
            font-weight: 700;
            color: #2b3a4a;
            margin-bottom: 6px;
            line-height: 1.35;
        }
        .item-price {
            font-size: 15px;
            font-weight: 800;
            color: #ec707e;
        }
        .qty-control {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid #edf2f7;
            border-radius: 10px;
            background: #f8fafc;
            overflow: hidden;
        }
        .qty-btn {
            background: transparent;
            border: none;
            width: 32px;
            height: 32px;
            font-size: 15px;
            font-weight: bold;
            color: #4a5568;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qty-btn:hover {
            background: #e2e8f0;
            color: #ec707e;
        }
        .qty-input {
            width: 45px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #2d3748;
            outline: none;
        }
        .btn-delete-item {
            color: #a0aec0;
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .btn-delete-item:hover {
            color: #e53e3e;
        }
        .summary-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 8px 25px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            position: sticky;
            top: 90px;
        }
        .summary-header {
            font-size: 19px;
            font-weight: 800;
            color: #2b3a4a;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid #edf2f7;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14.5px;
            color: #718096;
        }
        .summary-row.total-row {
            font-size: 18px;
            font-weight: 800;
            color: #2b3a4a;
            border-top: 2px dashed #edf2f7;
            padding-top: 15px;
            margin-top: 15px;
        }
        .checkout-main-btn {
            background: linear-gradient(135deg, #ff8fa3 0%, #ec707e 100%);
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.3px;
            box-shadow: 0 6px 18px rgba(236, 112, 126, 0.35);
            transition: all 0.25s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .checkout-main-btn:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 9px 24px rgba(236, 112, 126, 0.45);
        }
        .empty-cart-container {
            background: #ffffff;
            border-radius: 24px;
            padding: 60px 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(80, 112, 150, 0.08);
        }
        .coupon-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 18px;
        }
        .voucher-badge {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="cart-wrapper">
        <div class="cart-page-header">
            <div>
                <h1 class="cart-page-title">
                    <i class="bi bi-bag-heart text-danger"></i> Keranjang Belanja
                </h1>
                <p class="text-muted mb-0">Periksa kembali barang belanjaan official K-Pop merch Anda.</p>
            </div>
            <?php if (!empty($cartItems)): ?>
                <form action="/index.php?Page=cart" method="post" onsubmit="return confirm('Kosongkan semua barang di keranjang?');">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (empty($cartItems)): ?>
            <div class="empty-cart-container">
                <div style="font-size: 70px; margin-bottom: 15px;">🛍️</div>
                <h3 class="fw-bold mb-2">Keranjang Belanja Kamu Masih Kosong</h3>
                <p class="text-muted mb-4">Temukan album, lightstick, dan merchandise idol favoritmu sekarang!</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/index.php?Page=search" class="btn btn-danger rounded-pill px-4 py-2 fw-bold" style="background: #ec707e; border:none;">
                        <i class="bi bi-compass me-1"></i> Jelajahi Katalog Produk
                    </a>
                    <a href="/index.php?Page=wishlist" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                        <i class="bi bi-heart me-1"></i> Buka Wishlist
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <!-- Cart Items List -->
                <div class="col-lg-8">
                    <?php foreach ($cartItems as $productId => $item): 
                        $itemTotal = (int)$item['harga'] * (int)$item['qty'];
                    ?>
                        <div class="cart-item-card" id="item-card-<?= $productId; ?>">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="product-img-box">
                                    <?php if (!empty($item['gambar_produk'])): ?>
                                        <img src="/produk-cover/<?= htmlspecialchars($item['gambar_produk'], ENT_QUOTES); ?>" 
                                             alt="<?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?>">
                                    <?php else: ?>
                                        <span class="text-muted small">No Image</span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="artist-pill"><?= htmlspecialchars($item['nama_artis'], ENT_QUOTES); ?></span>
                                            <a href="/index.php?Page=detailProduk&id=<?= $productId; ?>" class="text-decoration-none text-dark">
                                                <h2 class="item-name mb-1"><?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?></h2>
                                            </a>
                                            <div class="item-price mb-2">
                                                Rp <?= number_format($item['harga'], 0, ',', '.'); ?>
                                            </div>
                                        </div>
                                        <button class="btn-delete-item" title="Hapus Barang" onclick="removeItemAjax(<?= $productId; ?>)">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2">
                                        <div class="qty-control">
                                            <button class="qty-btn" onclick="updateQtyAjax(<?= $productId; ?>, <?= $item['qty'] - 1; ?>)">-</button>
                                            <input type="text" class="qty-input" id="qty-input-<?= $productId; ?>" value="<?= $item['qty']; ?>" readonly>
                                            <button class="qty-btn" onclick="updateQtyAjax(<?= $productId; ?>, <?= $item['qty'] + 1; ?>)">+</button>
                                        </div>

                                        <div class="text-end">
                                            <span class="text-muted small">Subtotal: </span>
                                            <span class="fw-bold text-dark fs-6" id="item-subtotal-<?= $productId; ?>">
                                                Rp <?= number_format($itemTotal, 0, ',', '.'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Guarantee Badges -->
                    <div class="bg-white p-3 rounded-3 shadow-sm border mt-3 d-flex align-items-center justify-content-around text-muted small flex-wrap gap-2">
                        <span><i class="bi bi-shield-check text-success fs-5 me-1"></i> 100% Official Licensed Merch</span>
                        <span><i class="bi bi-box-seam text-primary fs-5 me-1"></i> Extra Bubble Wrap Packing</span>
                        <span><i class="bi bi-truck text-warning fs-5 me-1"></i> Fast Dispatch</span>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="summary-box">
                        <h2 class="summary-header">Ringkasan Belanja</h2>

                        <!-- Voucher Code Box -->
                        <div class="coupon-box">
                            <?php if ($coupon): ?>
                                <div class="voucher-badge">
                                    <div>
                                        <i class="bi bi-ticket-perforated-fill me-1"></i>
                                        <strong><?= htmlspecialchars($coupon['code'], ENT_QUOTES); ?></strong> (<?= htmlspecialchars($coupon['label'], ENT_QUOTES); ?>)
                                    </div>
                                    <form action="/index.php?Page=cart" method="post" style="margin:0;">
                                        <input type="hidden" name="action" value="remove_coupon">
                                        <button type="submit" class="btn btn-sm text-danger p-0" title="Hapus Kupon"><i class="bi bi-x-circle-fill"></i></button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <form action="/index.php?Page=cart" method="post" class="d-flex gap-2">
                                    <input type="hidden" name="action" value="coupon">
                                    <input type="text" name="coupon_code" class="form-control form-control-sm text-uppercase" placeholder="Kode Promo (cth: SEVKPOP10)" required>
                                    <button type="submit" class="btn btn-sm btn-dark px-3 fw-bold">Gunakan</button>
                                </form>
                                <div class="text-muted" style="font-size: 11px; margin-top: 6px;">
                                    💡 Coba kode promo: <strong>SEVKPOP10</strong> (Diskon 10%) atau <strong>SEVWELCOME</strong>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="summary-row">
                            <span>Total Barang</span>
                            <span id="summaryCartCount"><?= $cartCount; ?> item</span>
                        </div>

                        <div class="summary-row">
                            <span>Subtotal Harga</span>
                            <span id="summarySubtotal">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                        </div>

                        <?php if ($discount > 0): ?>
                            <div class="summary-row text-success fw-bold">
                                <span>Potongan Diskon</span>
                                <span id="summaryDiscount">- Rp <?= number_format($discount, 0, ',', '.'); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span class="text-muted">Dihitung di Checkout</span>
                        </div>

                        <div class="summary-row total-row">
                            <span>Total Belanja</span>
                            <span class="text-danger" id="summaryGrandTotal">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></span>
                        </div>

                        <a href="/index.php?Page=checkout" class="checkout-main-btn mt-4">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right ms-1"></i>
                        </a>

                        <a href="/index.php?Page=search" class="btn btn-link text-center w-100 text-decoration-none mt-2 text-muted small">
                            ← Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <script>
        function updateQtyAjax(productId, qty) {
            if (qty <= 0) {
                if (!confirm('Hapus produk ini dari keranjang?')) return;
            }

            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id_produk', productId);
            formData.append('qty', qty);

            fetch('/index.php?Page=api_cart', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (qty <= 0) {
                        location.reload();
                    } else {
                        document.getElementById('qty-input-' + productId).value = data.qty;
                        document.getElementById('item-subtotal-' + productId).textContent = 'Rp ' + data.itemSubtotal.toLocaleString('id-ID');
                        document.getElementById('summarySubtotal').textContent = 'Rp ' + data.cartSubtotal.toLocaleString('id-ID');
                        document.getElementById('summaryGrandTotal').textContent = 'Rp ' + data.grandTotal.toLocaleString('id-ID');
                        document.getElementById('summaryCartCount').textContent = data.cartCount + ' item';
                        
                        const badge = document.getElementById('navCartBadge');
                        if (badge) {
                            badge.textContent = data.cartCount;
                            badge.style.display = data.cartCount > 0 ? 'flex' : 'none';
                        }
                    }
                }
            })
            .catch(() => {
                location.reload();
            });
        }

        function removeItemAjax(productId) {
            if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
            
            const formData = new FormData();
            formData.append('action', 'remove');
            formData.append('id_produk', productId);

            fetch('/index.php?Page=api_cart', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(() => {
                location.reload();
            });
        }
    </script>
</body>
</html>