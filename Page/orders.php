<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/OrderController.php';
$orderCtrl = new OrderController();

$orders = $orderCtrl->getAllOrders();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan Saya - SEVShop</title>
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
        .orders-wrapper {
            max-width: 1050px;
            margin: 35px auto 70px;
            padding: 0 15px;
        }
        .order-history-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }
        .order-history-card:hover {
            box-shadow: 0 8px 24px rgba(236, 112, 126, 0.12);
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="orders-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">
                    <i class="bi bi-receipt-cutoff text-danger me-2"></i> Riwayat Pesanan Saya
                </h1>
                <p class="text-muted small mb-0">Daftar transaksi dan status pengiriman pesanan merch Anda.</p>
            </div>
            <a href="/index.php?Page=search" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="bi bi-bag-plus me-1"></i> Belanja Lagi
            </a>
        </div>

        <?php if (empty($orders)): ?>
            <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
                <div style="font-size: 60px; margin-bottom: 12px;">📑✨</div>
                <h3 class="fw-bold mb-2">Belum Ada Riwayat Pesanan</h3>
                <p class="text-muted mb-4">Kamu belum melakukan pemesanan merchandise apa pun di SEVShop.</p>
                <a href="/index.php?Page=search" class="btn btn-danger rounded-pill px-4 py-2 fw-bold" style="background:#ec707e; border:none;">
                    Mulai Belanja Sekarang
                </a>
            </div>
        <?php else: ?>
            <?php foreach (array_reverse($orders) as $order): ?>
                <div class="order-history-card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 mb-3 border-bottom">
                        <div>
                            <span class="badge bg-light text-dark border me-2 font-monospace">
                                <?= htmlspecialchars($order['order_id'], ENT_QUOTES); ?>
                            </span>
                            <span class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y, H:i', strtotime($order['created_at'])); ?>
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill font-weight-normal">
                                <i class="bi bi-truck me-1"></i> <?= htmlspecialchars($order['order_status'] ?? 'Diproses', ENT_QUOTES); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Items overview -->
                    <div class="row g-3 align-items-center">
                        <div class="col-md-7">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center p-1" style="width: 48px; height: 48px;">
                                        <?php if (!empty($item['gambar_produk'])): ?>
                                            <img src="/produk-cover/<?= htmlspecialchars($item['gambar_produk'], ENT_QUOTES); ?>" 
                                                 alt="<?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?>" 
                                                 style="max-width:100%; max-height:100%; object-fit:contain;">
                                        <?php else: ?>
                                            <i class="bi bi-box text-muted"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="small">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 320px;">
                                            <?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?>
                                        </div>
                                        <div class="text-muted"><?= $item['qty']; ?> barang × Rp <?= number_format($item['harga'], 0, ',', '.'); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-md-2 text-md-center border-start border-end py-2">
                            <span class="text-muted small d-block">Total Tagihan</span>
                            <span class="fw-bold text-danger fs-6">
                                Rp <?= number_format($order['grand_total'], 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="col-md-3 text-md-end d-flex flex-column gap-2">
                            <a href="/index.php?Page=tracking&orderId=<?= urlencode($order['order_id']); ?>" class="btn btn-sm btn-outline-dark rounded-pill">
                                <i class="bi bi-geo me-1"></i> Lacak Pengiriman
                            </a>
                            <a href="/index.php?Page=orderSuccess&orderId=<?= urlencode($order['order_id']); ?>" class="btn btn-sm btn-light border rounded-pill">
                                <i class="bi bi-file-text me-1"></i> Detail Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>
</body>
</html>
