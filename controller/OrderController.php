<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/CartController.php';

class OrderController {
    private $cartController;

    public function __construct() {
        $this->cartController = new CartController();
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }
    }

    public function createOrder($data) {
        $cartItems = $this->cartController->getCartItems();
        if (empty($cartItems)) {
            return ['success' => false, 'message' => 'Keranjang belanja kosong! Silakan pilih produk terlebih dahulu.'];
        }

        $recipientName = trim($data['recipient_name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $address = trim($data['address'] ?? '');
        $city = trim($data['city'] ?? '');
        $province = trim($data['province'] ?? '');
        $postalCode = trim($data['postal_code'] ?? '');
        $notes = trim($data['notes'] ?? '');
        $courier = trim($data['courier'] ?? 'jne');
        $paymentMethod = trim($data['payment_method'] ?? 'bca_va');

        if (empty($recipientName) || empty($phone) || empty($address) || empty($city)) {
            return ['success' => false, 'message' => 'Mohon lengkapi seluruh informasi pengiriman yang wajib diisi.'];
        }

        // Courier rates & names
        $courierList = [
            'jne' => ['name' => 'JNE Reguler (2-3 Hari)', 'cost' => 18000, 'prefix' => 'JNE'],
            'jnt' => ['name' => 'J&T Express (1-2 Hari)', 'cost' => 22000, 'prefix' => 'JT'],
            'sicepat' => ['name' => 'SiCepat BEST (1-2 Hari)', 'cost' => 19000, 'prefix' => 'SCP'],
            'dhl' => ['name' => 'DHL Express (Next Day)', 'cost' => 45000, 'prefix' => 'DHL']
        ];

        $courierInfo = $courierList[$courier] ?? $courierList['jne'];
        $shippingCost = $courierInfo['cost'];

        $subtotal = $this->cartController->getSubtotal();
        $discount = $this->cartController->getDiscount();
        $grandTotal = max(0, $subtotal - $discount + $shippingCost);

        // Generate Order ID & AWB
        $orderId = 'SEV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        $awb = $courierInfo['prefix'] . rand(100000000, 999999999) . 'ID';

        $now = date('Y-m-d H:i:s');

        // Initial timeline
        $timeline = [
            [
                'status' => 'Pesanan Dibuat',
                'description' => 'Pesanan Anda #' . $orderId . ' berhasil dibuat di sistem SEVShop.',
                'time' => date('d M Y, H:i', strtotime($now)),
                'completed' => true
            ],
            [
                'status' => 'Menunggu Pembayaran',
                'description' => 'Silakan lakukan pembayaran sebelum batas waktu berakhir.',
                'time' => date('d M Y, H:i', strtotime($now)),
                'completed' => true
            ],
            [
                'status' => 'Sedang Dikemas (Packing)',
                'description' => 'Official K-Pop merch pesanan Anda sedang disiapkan dengan bubble wrap tebal.',
                'time' => 'Estimasi hari ini',
                'completed' => false
            ],
            [
                'status' => 'Diserahkan ke Kurir (' . $courierInfo['name'] . ')',
                'description' => 'No. Resi pengiriman: ' . $awb,
                'time' => 'Dalam proses',
                'completed' => false
            ],
            [
                'status' => 'Pesanan Tiba di Tujuan',
                'description' => 'Paket diterima oleh penerima.',
                'time' => 'Estimasi 2-3 hari kerja',
                'completed' => false
            ]
        ];

        // Simulated Virtual Account / QRIS info
        $paymentDetails = $this->generatePaymentDetails($paymentMethod, $grandTotal);

        $order = [
            'order_id' => $orderId,
            'user_id' => $_SESSION['id_user'] ?? null,
            'customer_name' => $recipientName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'province' => $province,
            'postal_code' => $postalCode,
            'notes' => $notes,
            'courier' => $courierInfo['name'],
            'shipping_cost' => $shippingCost,
            'awb' => $awb,
            'payment_method' => $paymentMethod,
            'payment_details' => $paymentDetails,
            'payment_status' => ($paymentMethod === 'cod') ? 'COD (Bayar di Tempat)' : 'Menunggu Pembayaran',
            'order_status' => 'Diproses',
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon_applied' => $_SESSION['coupon'] ?? null,
            'grand_total' => $grandTotal,
            'created_at' => $now,
            'timeline' => $timeline
        ];

        // Save order to session store
        $_SESSION['orders'][$orderId] = $order;
        $_SESSION['last_order_id'] = $orderId;

        // Clear cart after checkout
        $this->cartController->clearCart();

        return [
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'orderId' => $orderId,
            'order' => $order
        ];
    }

    private function generatePaymentDetails($method, $amount) {
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        switch ($method) {
            case 'bca_va':
                return [
                    'label' => 'BCA Virtual Account',
                    'number' => '80777' . rand(10000000, 99999999),
                    'instructions' => 'Transfer tepat sesuai nominal ke nomor Virtual Account BCA di atas via BCA Mobile, KlikBCA, atau ATM BCA.',
                    'expires_at' => $expires
                ];
            case 'mandiri_va':
                return [
                    'label' => 'Mandiri Virtual Account',
                    'number' => '88908' . rand(10000000, 99999999),
                    'instructions' => 'Transfer ke nomor Virtual Account Mandiri via Livin by Mandiri atau ATM Mandiri.',
                    'expires_at' => $expires
                ];
            case 'bri_va':
                return [
                    'label' => 'BRI BRIVA',
                    'number' => '12800' . rand(10000000, 99999999),
                    'instructions' => 'Bayar melalui menu BRIVA pada aplikasi BRImo atau ATM BRI.',
                    'expires_at' => $expires
                ];
            case 'bni_va':
                return [
                    'label' => 'BNI Virtual Account',
                    'number' => '98800' . rand(10000000, 99999999),
                    'instructions' => 'Bayar via BNI Mobile Banking atau ATM BNI.',
                    'expires_at' => $expires
                ];
            case 'qris':
            case 'gopay':
            case 'shopeepay':
            case 'ovo':
            case 'dana':
                return [
                    'label' => 'QRIS (GoPay, OVO, ShopeePay, DANA, BCA)',
                    'number' => 'NMID: ID102003891028',
                    'instructions' => 'Buka aplikasi E-Wallet atau Mobile Banking Anda, pilih Scan QRIS lalu pindai QR code di bawah.',
                    'expires_at' => $expires,
                    'qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SEVSHOP-QRIS-' . $amount . '-' . rand(1000, 9999)
                ];
            case 'cod':
                return [
                    'label' => 'Cash On Delivery (COD)',
                    'number' => 'Bayar saat kurir mengantar paket',
                    'instructions' => 'Siapkan uang pas sejumlah Rp ' . number_format($amount, 0, ',', '.') . ' saat kurir mengantarkan paket ke alamat Anda.',
                    'expires_at' => null
                ];
            case 'cc':
            default:
                return [
                    'label' => 'Kartu Kredit / Debit Online',
                    'number' => 'Visa / Mastercard / JCB',
                    'instructions' => 'Pembayaran kartu debit/kredit terenkripsi SSL 256-bit 3D Secure.',
                    'expires_at' => $expires
                ];
        }
    }

    public function getOrder($orderId) {
        $orderId = trim($orderId);
        if (isset($_SESSION['orders'][$orderId])) {
            return $_SESSION['orders'][$orderId];
        }
        return null;
    }

    public function getAllOrders() {
        return array_values($_SESSION['orders'] ?? []);
    }

    public function getUserOrders($userId = null) {
        $userId = $userId ?? ($_SESSION['id_user'] ?? null);
        $orders = [];
        if (isset($_SESSION['orders']) && is_array($_SESSION['orders'])) {
            foreach ($_SESSION['orders'] as $order) {
                if ($userId !== null && isset($order['user_id']) && $order['user_id'] == $userId) {
                    $orders[] = $order;
                }
            }
        }
        return $orders;
    }

    public function trackOrder($query) {
        $query = strtoupper(trim($query));
        if (empty($query)) {
            return null;
        }

        if (isset($_SESSION['orders'][$query])) {
            return $_SESSION['orders'][$query];
        }

        foreach ($_SESSION['orders'] ?? [] as $order) {
            if (strtoupper($order['order_id']) === $query || strtoupper($order['awb'] ?? '') === $query) {
                return $order;
            }
        }

        // If not found in session, create a simulated mock order for tracking demo if user searches a known pattern
        if (strpos($query, 'SEV-') === 0 || strpos($query, 'JNE') === 0 || strpos($query, 'JT') === 0) {
            return [
                'order_id' => $query,
                'customer_name' => 'K-Pop Fan Customer',
                'courier' => 'JNE Reguler',
                'awb' => 'JNE981240182ID',
                'payment_status' => 'Lunas',
                'order_status' => 'Dalam Pengiriman',
                'grand_total' => 450000,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'items' => [
                    [
                        'nama_produk' => 'Official Lightstick & Photocard Special Set',
                        'nama_artis' => 'SEVENTEEN',
                        'qty' => 1,
                        'harga' => 432000
                    ]
                ],
                'timeline' => [
                    ['status' => 'Pesanan Dibuat', 'description' => 'Pesanan berhasil dikonfirmasi sistem SEVShop.', 'time' => '2 hari lalu, 10:15', 'completed' => true],
                    ['status' => 'Pembayaran Berhasil', 'description' => 'Pembayaran Rp 450.000 telah diverifikasi.', 'time' => '2 hari lalu, 10:20', 'completed' => true],
                    ['status' => 'Paket Selesai Dikemas', 'description' => 'Barang telah dipacking rapi dengan bubble wrap dan box kardus.', 'time' => 'Kemarin, 14:00', 'completed' => true],
                    ['status' => 'Dalam Pengiriman (In Transit)', 'description' => 'Paket tiba di DC Hub Jakarta menuju kota tujuan.', 'time' => 'Hari ini, 08:30', 'completed' => true],
                    ['status' => 'Pesanan Tiba di Tujuan', 'description' => 'Kurir sedang mengantar ke alamat penerima.', 'time' => 'Estimasi tiba sore ini', 'completed' => false]
                ]
            ];
        }

        return null;
    }
}
