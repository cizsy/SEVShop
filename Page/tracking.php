<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/OrderController.php';
$orderCtrl = new OrderController();

$query = $_GET['orderId'] ?? ($_GET['awb'] ?? ($_GET['q'] ?? ''));
$order = null;

if (!empty($query)) {
    $order = $orderCtrl->trackOrder($query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Pengiriman - SEVShop</title>
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
        .track-wrapper {
            max-width: 950px;
            margin: 35px auto 70px;
            padding: 0 15px;
        }
        .track-search-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
            margin-bottom: 30px;
        }
        .timeline-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(80, 112, 150, 0.08);
            border: 1px solid #edf2f7;
        }
        .timeline-stepper {
            position: relative;
            padding-left: 30px;
        }
        .timeline-stepper::before {
            content: '';
            position: absolute;
            top: 15px;
            bottom: 15px;
            left: 9px;
            width: 3px;
            background: #e2e8f0;
        }
        .timeline-step-item {
            position: relative;
            margin-bottom: 24px;
        }
        .timeline-step-item:last-child {
            margin-bottom: 0;
        }
        .step-bullet {
            position: absolute;
            left: -30px;
            top: 2px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #cbd5e1;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .timeline-step-item.completed .step-bullet {
            border-color: #ec707e;
            background: #ec707e;
        }
        .timeline-step-item.active .step-bullet {
            border-color: #ec707e;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(236, 112, 126, 0.25);
        }
        .search-track-input {
            border-radius: 50px;
            padding: 12px 24px;
            font-size: 15px;
            border: 2px solid #edf2f7;
        }
        .search-track-input:focus {
            border-color: #ec707e;
            box-shadow: 0 0 0 3px rgba(236, 112, 126, 0.15);
        }
        .btn-track-submit {
            background: linear-gradient(135deg, #ff8fa3 0%, #ec707e 100%);
            color: white;
            font-weight: 800;
            border: none;
            border-radius: 50px;
            padding: 12px 28px;
            box-shadow: 0 4px 14px rgba(236, 112, 126, 0.3);
            transition: all 0.2s;
        }
        .btn-track-submit:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(236, 112, 126, 0.45);
        }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../Component/navbar.php'; ?>

    <main class="track-wrapper">
        <!-- Search Box -->
        <div class="track-search-card">
            <h1 class="h4 fw-bold mb-2 text-dark">
                <i class="bi bi-geo-alt-fill text-danger me-2"></i> Lacak Pengiriman Pesanan
            </h1>
            <p class="text-muted small mb-4">
                Masukkan No. Pesanan (misal: <code>SEV-2026...</code>) atau No. Resi Kurir (misal: <code>JNE...</code>) untuk melihat status pengiriman live.
            </p>

            <form action="/index.php" method="get" class="row g-2">
                <input type="hidden" name="Page" value="tracking">
                <div class="col-md-9">
                    <input type="text" name="orderId" class="form-control search-track-input" 
                           value="<?= htmlspecialchars($query, ENT_QUOTES); ?>" 
                           placeholder="Masukkan ID Pesanan atau No. Resi..." required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn-track-submit w-100">
                        <i class="bi bi-search me-1"></i> Lacak
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($query)): ?>
            <?php if ($order): ?>
                <div class="timeline-card">
                    <!-- Order Header Summary -->
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 pb-3 mb-4 border-bottom">
                        <div>
                            <span class="badge bg-danger mb-2 font-weight-normal px-3 py-1 rounded-pill">
                                <?= htmlspecialchars($order['courier'] ?? 'Kurir Pengiriman', ENT_QUOTES); ?>
                            </span>
                            <h2 class="h5 fw-bold text-dark mb-1">
                                Resi: <span class="text-primary font-monospace"><?= htmlspecialchars($order['awb'] ?? '-', ENT_QUOTES); ?></span>
                            </h2>
                            <div class="text-muted small">
                                No. Pesanan: <strong><?= htmlspecialchars($order['order_id'], ENT_QUOTES); ?></strong> • Penerima: <?= htmlspecialchars($order['customer_name'] ?? 'Pelanggan', ENT_QUOTES); ?> (<?= htmlspecialchars($order['city'] ?? '', ENT_QUOTES); ?>)
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success px-3 py-2 rounded-pill fs-7">
                                <i class="bi bi-check2-circle me-1"></i> <?= htmlspecialchars($order['order_status'] ?? 'Aktif', ENT_QUOTES); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Visual Timeline -->
                    <h3 class="h6 fw-bold text-uppercase text-muted mb-4">Milestone Perjalanan Paket</h3>
                    <div class="timeline-stepper">
                        <?php foreach ($order['timeline'] as $idx => $step): ?>
                            <div class="timeline-step-item <?= $step['completed'] ? 'completed' : ($idx === 2 ? 'active' : ''); ?>">
                                <div class="step-bullet">
                                    <?php if ($step['completed']): ?>
                                        <i class="bi bi-check text-white" style="font-size: 14px;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h4 class="h6 fw-bold mb-1 <?= $step['completed'] ? 'text-dark' : 'text-muted'; ?>">
                                        <?= htmlspecialchars($step['status'], ENT_QUOTES); ?>
                                    </h4>
                                    <span class="badge bg-light text-muted small"><?= htmlspecialchars($step['time'], ENT_QUOTES); ?></span>
                                </div>
                                <p class="text-muted small mb-0">
                                    <?= htmlspecialchars($step['description'], ENT_QUOTES); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Items Included -->
                    <?php if (!empty($order['items'])): ?>
                        <div class="mt-4 pt-4 border-top">
                            <h3 class="h6 fw-bold text-muted mb-3">Barang dalam Paket ini:</h3>
                            <div class="row g-2">
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="col-md-6">
                                        <div class="p-2 border rounded-3 d-flex align-items-center gap-2 bg-light">
                                            <i class="bi bi-box-seam text-danger fs-4 ms-1"></i>
                                            <div class="small">
                                                <div class="fw-bold text-truncate" style="max-width: 260px;"><?= htmlspecialchars($item['nama_produk'], ENT_QUOTES); ?></div>
                                                <div class="text-muted"><?= $item['qty']; ?> pcs • Rp <?= number_format($item['harga'], 0, ',', '.'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="timeline-card text-center py-5">
                    <div style="font-size: 50px;">📦🔍</div>
                    <h3 class="fw-bold mt-2">Data Pengiriman Tidak Ditemukan</h3>
                    <p class="text-muted">Nomor pesanan atau resi <strong>"<?= htmlspecialchars($query, ENT_QUOTES); ?>"</strong> belum terdaftar di sistem kami. Mohon periksa kembali nomor yang Anda masukkan.</p>
                    <a href="/index.php?Page=orders" class="btn btn-outline-danger rounded-pill px-4 mt-2">
                        Lihat Riwayat Pesanan Saya
                    </a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Helper card -->
            <div class="timeline-card text-center py-5">
                <div style="font-size: 55px; margin-bottom: 12px;">🚚✨</div>
                <h3 class="fw-bold mb-2">Pantau Status Paket K-Pop Kamu</h3>
                <p class="text-muted max-w-md mx-auto mb-4" style="max-width: 500px;">
                    Setiap pembelian official merchandise di SEVShop dilengkapi dengan nomor resi otomatis dari ekspedisi rekanan kami.
                </p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="/index.php?Page=tracking&orderId=SEV-SAMPLE-01" class="btn btn-sm btn-light border rounded-pill px-3">
                        <i class="bi bi-eye me-1"></i> Coba Lacak Contoh Resi
                    </a>
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <a href="/index.php?Page=orders" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-receipt me-1"></i> Buka Pesanan Saya
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../Component/footer.php'; ?>
</body>
</html>
