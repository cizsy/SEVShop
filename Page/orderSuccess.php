<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/OrderController.php';
$orderCtrl = new OrderController();

$orderId = $_GET['orderId'] ?? ($_SESSION['last_order_id'] ?? null);
$order = null;

if ($orderId) {
    $order = $orderCtrl->getOrder($orderId);
}

if (!$order) {
    header("Location: /index.php?Page=home");
    exit;
}

$paymentDetails = $order['payment_details'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil #<?= htmlspecialchars($order['order_id'], ENT_QUOTES); ?> - SEVShop</title>
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
        .success-container {
            max-width: 900px;
            margin: 40px auto 70px;
            padding: 0 15px;
        }
        .success-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(80, 112, 150, 0.1);
            border: 1px solid #edf2f7;
        }
        .check-circle {
            width: 76px;
            height: 76px;
            background: #dcfce7;
            color: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 18px;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.2);
        }
        .payment-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 18px;
            padding: 24px;
            margin: 25px 0;
            text-align: center;
        }
        .va-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #1e293b;
            background: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
            border: 1px solid #e2e8f0;
            margin: 10px 0;
        }
        .btn-track {
            background: linear-gradient(135deg, #ff8fa3 0%, #ec707e 100%);
            color: #ffffff;
            border: none;
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 800;
            box-shadow: 0 6px 20px rgba(236, 112, 126, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }
        .btn-track:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 9px 25px rgba(236, 112, 126, 0.45);
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="success-container">
        <div class="success-card">
            <div class="text-center">
                <div class="check-circle">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">Terima Kasih! Pesanan Anda Berhasil Dibuat</h1>
                <p class="text-muted mb-2">No. Pesanan: <strong class="text-primary font-monospace"><?= htmlspecialchars($order['order_id'], ENT_QUOTES); ?></strong></p>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill font-weight-normal">
                    <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($order['payment_status'], ENT_QUOTES); ?>
                </span>
            </div>

            <!-- Payment instructions -->
            <div class="payment-box">
                <h2 class="h6 fw-bold text-uppercase text-muted mb-2">Instruksi Pembayaran</h2>
                <div class="h5 fw-bold text-dark mb-3"><?= htmlspecialchars($paymentDetails['label'], ENT_QUOTES); ?></div>

                <?php if (!empty($paymentDetails['qr_image'])): ?>
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars($paymentDetails['qr_image'], ENT_QUOTES); ?>" alt="QRIS Code" class="img-fluid rounded border shadow-sm" style="max-width: 200px;">
                    </div>
                    <div class="small text-muted mb-2">Pindai QRIS dengan GoPay, OVO, ShopeePay, DANA, atau M-Banking</div>
                <?php else: ?>
                    <div class="va-code" id="vaNumberText">
                        <?= htmlspecialchars($paymentDetails['number'], ENT_QUOTES); ?>
                    </div>
                    <?php if ($order['payment_method'] !== 'cod'): ?>
                        <div>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-3" onclick="copyVA()">
                                <i class="bi bi-clipboard me-1"></i> Salin Nomor Rekening / VA
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                    <span class="text-muted">Total Tagihan:</span>
                    <span class="fs-4 fw-bold text-danger">Rp <?= number_format($order['grand_total'], 0, ',', '.'); ?></span>
                </div>

                <p class="text-muted small mb-0 max-w-md mx-auto">
                    <?= htmlspecialchars($paymentDetails['instructions'], ENT_QUOTES); ?>
                </p>
            </div>

            <!-- Order Details Overview -->
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <h3 class="h6 fw-bold mb-2"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Alamat Pengiriman</h3>
                        <div class="fw-bold small"><?= htmlspecialchars($order['customer_name'], ENT_QUOTES); ?> (<?= htmlspecialchars($order['phone'], ENT_QUOTES); ?>)</div>
                        <div class="text-muted small"><?= htmlspecialchars($order['address'], ENT_QUOTES); ?></div>
                        <div class="text-muted small"><?= htmlspecialchars($order['city'], ENT_QUOTES); ?>, <?= htmlspecialchars($order['province'], ENT_QUOTES); ?> <?= htmlspecialchars($order['postal_code'], ENT_QUOTES); ?></div>
                        <div class="mt-2 small text-primary fw-bold"><i class="bi bi-truck me-1"></i> Kurir: <?= htmlspecialchars($order['courier'], ENT_QUOTES); ?> (No. Resi: <?= htmlspecialchars($order['awb'], ENT_QUOTES); ?>)</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <h3 class="h6 fw-bold mb-2"><i class="bi bi-bag-check-fill text-primary me-1"></i> Rincian Barang</h3>
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span class="text-truncate" style="max-width: 220px;"><?= $item['qty']; ?>x <?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?></span>
                                <span class="fw-bold text-dark">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Ongkir</span>
                            <span>Rp <?= number_format($order['shipping_cost'], 0, ',', '.'); ?></span>
                        </div>
                        <?php if ($order['discount'] > 0): ?>
                            <div class="d-flex justify-content-between small text-success">
                                <span>Diskon</span>
                                <span>- Rp <?= number_format($order['discount'], 0, ',', '.'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
                <a href="/index.php?Page=tracking&orderId=<?= urlencode($order['order_id']); ?>" class="btn-track">
                    <i class="bi bi-geo"></i> Lacak Pengiriman Pesanan
                </a>
                <a href="/index.php?Page=home" class="btn btn-outline-secondary rounded-pill px-4 py-2 d-flex align-items-center">
                    <i class="bi bi-house me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>

    <script>
        function copyVA() {
            const text = document.getElementById('vaNumberText').textContent.trim();
            navigator.clipboard.writeText(text).then(() => {
                alert('Nomor VA berhasil disalin: ' + text);
            });
        }
    </script>
</body>
</html>
