<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/CartController.php';
require_once __DIR__ . '/../controller/OrderController.php';

$cartCtrl = new CartController();
$orderCtrl = new OrderController();

$cartItems = $cartCtrl->getCartItems();
if (empty($cartItems)) {
    header("Location: /index.php?Page=cart");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $orderCtrl->createOrder($_POST);
    if ($result['success']) {
        header("Location: /index.php?Page=orderSuccess&orderId=" . urlencode($result['orderId']));
        exit;
    } else {
        $error = $result['message'];
    }
}

$subtotal = $cartCtrl->getSubtotal();
$discount = $cartCtrl->getDiscount();
$coupon = $_SESSION['coupon'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Pembayaran - SEVShop</title>
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
        .checkout-container {
            max-width: 1200px;
            margin: 35px auto 60px;
            padding: 0 15px;
        }
        .checkout-title {
            font-size: 28px;
            font-weight: 800;
            color: #2b3a4a;
            margin-bottom: 25px;
        }
        .checkout-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 6px 20px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            margin-bottom: 24px;
        }
        .card-heading {
            font-size: 18px;
            font-weight: 800;
            color: #2b3a4a;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .step-number {
            width: 28px;
            height: 28px;
            background: #ec707e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #ec707e;
            box-shadow: 0 0 0 3px rgba(236, 112, 126, 0.15);
        }
        .radio-option-card {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .radio-option-card:hover {
            border-color: #ffaeac;
            background: #fffafa;
        }
        .radio-option-card.active {
            border-color: #ec707e;
            background: #fff5f6;
        }
        .order-summary-sidebar {
            background: #ffffff;
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 8px 25px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            position: sticky;
            top: 90px;
        }
        .btn-confirm-order {
            background: linear-gradient(135deg, #ff8fa3 0%, #ec707e 100%);
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 16px;
            box-shadow: 0 6px 20px rgba(236, 112, 126, 0.35);
            transition: all 0.25s ease;
        }
        .btn-confirm-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(236, 112, 126, 0.45);
            color: #ffffff;
        }
        .item-row {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }
        .item-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #f8fafc;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="checkout-container">
        <h1 class="checkout-title">
            <i class="bi bi-shield-check text-success me-2"></i> Checkout & Pembayaran
        </h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger rounded-3 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error, ENT_QUOTES); ?>
            </div>
        <?php endif; ?>

        <form action="/index.php?Page=checkout" method="post" id="checkoutForm">
            <div class="row g-4">
                
                <!-- Left: Form steps -->
                <div class="col-lg-8">
                    
                    <!-- Step 1: Shipping Address -->
                    <div class="checkout-card">
                        <div class="card-heading">
                            <span class="step-number">1</span>
                            <span>Informasi Penerima & Alamat Pengiriman</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap Penerima <span class="text-danger">*</span></label>
                                <input type="text" name="recipient_name" class="form-control" 
                                       value="<?= htmlspecialchars($_SESSION['nama_user'] ?? '', ENT_QUOTES); ?>" 
                                       placeholder="Cth: Zidan Fadhlillah" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nomor Handphone / WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="081234567890" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Konfirmasi</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($_SESSION['email_user'] ?? '', ENT_QUOTES); ?>" 
                                       placeholder="email@domain.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Provinsi <span class="text-danger">*</span></label>
                                <select name="province" class="form-select" required>
                                    <option value="DKI Jakarta" selected>DKI Jakarta</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="DI Yogyakarta">DI Yogyakarta</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Banten">Banten</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Sumatera Utara">Sumatera Utara</option>
                                    <option value="Lainnya">Provinsi Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label small fw-bold">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" placeholder="Cth: Jakarta Selatan / Bandung / Surabaya" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control" placeholder="12340">
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Alamat Lengkap (Nama Jalan, No. Rumah, RT/RW, Patokan) <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Jl. Melati No. 12, Blok A, RT 01/RW 02..." required></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Catatan Pengiriman (Opsional)</label>
                                <input type="text" name="notes" class="form-control" placeholder="Cth: Titip di pos satpam jika tidak ada orang di rumah">
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Courier Selection -->
                    <div class="checkout-card">
                        <div class="card-heading">
                            <span class="step-number">2</span>
                            <span>Pilih Jasa Ekspedisi / Kurir</span>
                        </div>

                        <div class="courier-options">
                            <label class="radio-option-card active" onclick="selectCourier('jne', 18000, this)">
                                <input type="radio" name="courier" value="jne" checked style="display:none;">
                                <i class="bi bi-box-seam fs-4 text-danger"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">JNE Reguler</div>
                                    <div class="text-muted small">Estimasi 2 - 3 Hari Kerja • Asuransi Pengiriman</div>
                                </div>
                                <div class="fw-bold text-dark">Rp 18.000</div>
                            </label>

                            <label class="radio-option-card" onclick="selectCourier('jnt', 22000, this)">
                                <input type="radio" name="courier" value="jnt" style="display:none;">
                                <i class="bi bi-truck fs-4 text-danger"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">J&T Express</div>
                                    <div class="text-muted small">Estimasi 1 - 2 Hari Kerja • Pick Up Cepat</div>
                                </div>
                                <div class="fw-bold text-dark">Rp 22.000</div>
                            </label>

                            <label class="radio-option-card" onclick="selectCourier('sicepat', 19000, this)">
                                <input type="radio" name="courier" value="sicepat" style="display:none;">
                                <i class="bi bi-lightning-charge-fill fs-4 text-warning"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">SiCepat BEST</div>
                                    <div class="text-muted small">Estimasi 1 - 2 Hari Kerja</div>
                                </div>
                                <div class="fw-bold text-dark">Rp 19.000</div>
                            </label>

                            <label class="radio-option-card" onclick="selectCourier('dhl', 45000, this)">
                                <input type="radio" name="courier" value="dhl" style="display:none;">
                                <i class="bi bi-airplane-fill fs-4 text-primary"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">DHL Express (Prioritas)</div>
                                    <div class="text-muted small">Next Day Delivery • Extra Fragile Protection</div>
                                </div>
                                <div class="fw-bold text-dark">Rp 45.000</div>
                            </label>
                        </div>
                    </div>

                    <!-- Step 3: Payment Method Selection -->
                    <div class="checkout-card">
                        <div class="card-heading">
                            <span class="step-number">3</span>
                            <span>Metode Pembayaran</span>
                        </div>

                        <div class="payment-options">
                            <label class="radio-option-card active" onclick="selectPayment('bca_va', this)">
                                <input type="radio" name="payment_method" value="bca_va" checked style="display:none;">
                                <i class="bi bi-bank2 fs-4 text-primary"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">BCA Virtual Account</div>
                                    <div class="text-muted small">Verifikasi Otomatis 24 Jam</div>
                                </div>
                                <span class="badge bg-light text-dark border">Instan</span>
                            </label>

                            <label class="radio-option-card" onclick="selectPayment('mandiri_va', this)">
                                <input type="radio" name="payment_method" value="mandiri_va" style="display:none;">
                                <i class="bi bi-bank2 fs-4 text-warning"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">Mandiri Virtual Account</div>
                                    <div class="text-muted small">Livin by Mandiri & ATM</div>
                                </div>
                            </label>

                            <label class="radio-option-card" onclick="selectPayment('bri_va', this)">
                                <input type="radio" name="payment_method" value="bri_va" style="display:none;">
                                <i class="bi bi-bank2 fs-4 text-info"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">BRI BRIVA</div>
                                    <div class="text-muted small">BRImo & ATM BRI</div>
                                </div>
                            </label>

                            <label class="radio-option-card" onclick="selectPayment('qris', this)">
                                <input type="radio" name="payment_method" value="qris" style="display:none;">
                                <i class="bi bi-qr-code-scan fs-4 text-danger"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">QRIS (GoPay, OVO, ShopeePay, DANA)</div>
                                    <div class="text-muted small">Scan langsung melalui semua aplikasi E-Wallet & M-Banking</div>
                                </div>
                                <span class="badge bg-danger">Populer</span>
                            </label>

                            <label class="radio-option-card" onclick="selectPayment('cod', this)">
                                <input type="radio" name="payment_method" value="cod" style="display:none;">
                                <i class="bi bi-cash-stack fs-4 text-success"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">Cash On Delivery (COD)</div>
                                    <div class="text-muted small">Bayar tunai kepada kurir saat barang sampai</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right: Order Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="order-summary-sidebar">
                        <h2 class="h5 fw-bold mb-3 pb-2 border-bottom">Ringkasan Pesanan</h2>

                        <!-- Items list -->
                        <div class="mb-3" style="max-height: 240px; overflow-y: auto;">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="item-row">
                                    <img src="/produk-cover/<?= htmlspecialchars($item['gambar_produk'], ENT_QUOTES); ?>" 
                                         alt="<?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?>" class="item-thumb">
                                    <div class="flex-grow-1 small">
                                        <div class="fw-bold text-truncate" style="max-width: 170px;">
                                            <?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?>
                                        </div>
                                        <div class="text-muted"><?= $item['qty']; ?> × Rp <?= number_format($item['harga'], 0, ',', '.'); ?></div>
                                    </div>
                                    <div class="fw-bold small text-end">
                                        Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Subtotal Barang</span>
                            <span class="text-dark fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                        </div>

                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-success small fw-bold">
                                <span>Diskon Voucher</span>
                                <span>- Rp <?= number_format($discount, 0, ',', '.'); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Biaya Pengiriman</span>
                            <span class="text-dark fw-bold" id="shippingFeeText">Rp 18.000</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span>Biaya Layanan / Asuransi</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-6">Total Pembayaran</span>
                            <span class="fw-bold fs-5 text-danger" id="grandTotalText">
                                Rp <?= number_format(max(0, $subtotal - $discount + 18000), 0, ',', '.'); ?>
                            </span>
                        </div>

                        <button type="submit" class="btn-confirm-order">
                            <i class="bi bi-lock-fill me-1"></i> Konfirmasi & Bayar
                        </button>

                        <div class="text-center text-muted small mt-3">
                            <i class="bi bi-shield-check text-success"></i> Transaksi Aman & Terenkripsi
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <script>
        let baseSubtotal = <?= $subtotal; ?>;
        let baseDiscount = <?= $discount; ?>;
        let currentShipping = 18000;

        function selectCourier(val, cost, element) {
            document.querySelectorAll('.courier-options .radio-option-card').forEach(c => c.classList.remove('active'));
            element.classList.add('active');
            element.querySelector('input[type="radio"]').checked = true;
            
            currentShipping = cost;
            document.getElementById('shippingFeeText').textContent = 'Rp ' + cost.toLocaleString('id-ID');
            
            const grandTotal = Math.max(0, baseSubtotal - baseDiscount + currentShipping);
            document.getElementById('grandTotalText').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function selectPayment(val, element) {
            document.querySelectorAll('.payment-options .radio-option-card').forEach(c => c.classList.remove('active'));
            element.classList.add('active');
            element.querySelector('input[type="radio"]').checked = true;
        }
    </script>
</body>
</html>
