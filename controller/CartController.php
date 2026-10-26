<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/Product.php';

class CartController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!isset($_SESSION['coupon'])) {
            $_SESSION['coupon'] = null;
        }
    }

    public function addToCart($productId, $qty = 1) {
        $productId = (int)$productId;
        $qty = max(1, (int)$qty);

        $product = $this->productModel->getById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Produk tidak ditemukan'];
        }

        $stock = isset($product['stok']) ? (int)$product['stok'] : 999;

        if (isset($_SESSION['cart'][$productId])) {
            $newQty = $_SESSION['cart'][$productId]['qty'] + $qty;
            if ($stock > 0 && $newQty > $stock) {
                $newQty = $stock;
            }
            $_SESSION['cart'][$productId]['qty'] = $newQty;
        } else {
            if ($stock > 0 && $qty > $stock) {
                $qty = $stock;
            }
            $_SESSION['cart'][$productId] = [
                'id_produk' => $product['id_produk'],
                'nama_produk' => $product['nama_produk'],
                'nama_artis' => $product['nama_artis'] ?? '-',
                'harga' => (int)$product['harga'],
                'gambar_produk' => $product['gambar_produk'] ?? '',
                'nama_kategori' => $product['nama_kategori'] ?? '',
                'qty' => $qty,
                'stok' => $stock
            ];
        }

        return [
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cartCount' => $this->getCartCount(),
            'cartSubtotal' => $this->getSubtotal(),
            'item' => $_SESSION['cart'][$productId]
        ];
    }

    public function updateQuantity($productId, $qty) {
        $productId = (int)$productId;
        $qty = (int)$qty;

        if ($qty <= 0) {
            return $this->removeFromCart($productId);
        }

        if (isset($_SESSION['cart'][$productId])) {
            $stock = $_SESSION['cart'][$productId]['stok'];
            if ($stock > 0 && $qty > $stock) {
                $qty = $stock;
            }
            $_SESSION['cart'][$productId]['qty'] = $qty;

            return [
                'success' => true,
                'message' => 'Jumlah produk diperbarui',
                'qty' => $qty,
                'itemSubtotal' => $_SESSION['cart'][$productId]['harga'] * $qty,
                'cartCount' => $this->getCartCount(),
                'cartSubtotal' => $this->getSubtotal(),
                'discount' => $this->getDiscount(),
                'grandTotal' => $this->getGrandTotal()
            ];
        }

        return ['success' => false, 'message' => 'Produk tidak ada di keranjang'];
    }

    public function removeFromCart($productId) {
        $productId = (int)$productId;
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            return [
                'success' => true,
                'message' => 'Produk dihapus dari keranjang',
                'cartCount' => $this->getCartCount(),
                'cartSubtotal' => $this->getSubtotal(),
                'discount' => $this->getDiscount(),
                'grandTotal' => $this->getGrandTotal()
            ];
        }
        return ['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'];
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
        $_SESSION['coupon'] = null;
        return [
            'success' => true,
            'message' => 'Keranjang dikosongkan',
            'cartCount' => 0,
            'cartSubtotal' => 0,
            'discount' => 0,
            'grandTotal' => 0
        ];
    }

    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }

    public function getCartCount() {
        $count = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $count += (int)($item['qty'] ?? 1);
            }
        }
        return $count;
    }

    public function getSubtotal() {
        $subtotal = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $subtotal += ((int)$item['harga'] * (int)$item['qty']);
            }
        }
        return $subtotal;
    }

    public function applyCoupon($code) {
        $code = strtoupper(trim($code));
        $validCoupons = [
            'SEVKPOP10' => ['type' => 'percent', 'value' => 10, 'label' => 'Diskon 10% Spesial K-Pop!'],
            'SEVWELCOME' => ['type' => 'fixed', 'value' => 25000, 'label' => 'Potongan Rp 25.000 Member Baru'],
            'FREESHIP' => ['type' => 'shipping', 'value' => 20000, 'label' => 'Gratis Ongkir hingga Rp 20.000'],
            'SEV50K' => ['type' => 'fixed', 'value' => 50000, 'label' => 'Voucher Belanja Rp 50.000']
        ];

        if (isset($validCoupons[$code])) {
            $_SESSION['coupon'] = [
                'code' => $code,
                'type' => $validCoupons[$code]['type'],
                'value' => $validCoupons[$code]['value'],
                'label' => $validCoupons[$code]['label']
            ];
            return [
                'success' => true,
                'message' => 'Kupon ' . $code . ' berhasil digunakan! (' . $validCoupons[$code]['label'] . ')',
                'coupon' => $_SESSION['coupon'],
                'discount' => $this->getDiscount(),
                'grandTotal' => $this->getGrandTotal()
            ];
        }

        return ['success' => false, 'message' => 'Kode kupon tidak valid atau telah kedaluwarsa.'];
    }

    public function removeCoupon() {
        $_SESSION['coupon'] = null;
        return [
            'success' => true,
            'message' => 'Kupon dihapus',
            'discount' => 0,
            'grandTotal' => $this->getGrandTotal()
        ];
    }

    public function getDiscount() {
        $subtotal = $this->getSubtotal();
        if ($subtotal <= 0 || empty($_SESSION['coupon'])) {
            return 0;
        }

        $coupon = $_SESSION['coupon'];
        if ($coupon['type'] === 'percent') {
            return (int)round(($subtotal * $coupon['value']) / 100);
        } elseif ($coupon['type'] === 'fixed') {
            return min($subtotal, (int)$coupon['value']);
        } elseif ($coupon['type'] === 'shipping') {
            return (int)$coupon['value'];
        }

        return 0;
    }

    public function getGrandTotal($shippingCost = 0) {
        $subtotal = $this->getSubtotal();
        $discount = $this->getDiscount();
        $total = max(0, $subtotal - $discount + (int)$shippingCost);
        return $total;
    }

    public function handleApi() {
        header('Content-Type: application/json');
        $action = $_REQUEST['action'] ?? '';

        switch ($action) {
            case 'add':
                $productId = $_REQUEST['id_produk'] ?? 0;
                $qty = $_REQUEST['qty'] ?? 1;
                echo json_encode($this->addToCart($productId, $qty));
                break;

            case 'update':
                $productId = $_REQUEST['id_produk'] ?? 0;
                $qty = $_REQUEST['qty'] ?? 1;
                echo json_encode($this->updateQuantity($productId, $qty));
                break;

            case 'remove':
                $productId = $_REQUEST['id_produk'] ?? 0;
                echo json_encode($this->removeFromCart($productId));
                break;

            case 'clear':
                echo json_encode($this->clearCart());
                break;

            case 'coupon':
                $code = $_REQUEST['code'] ?? '';
                echo json_encode($this->applyCoupon($code));
                break;

            case 'remove_coupon':
                echo json_encode($this->removeCoupon());
                break;

            case 'summary':
            default:
                echo json_encode([
                    'success' => true,
                    'count' => $this->getCartCount(),
                    'subtotal' => $this->getSubtotal(),
                    'discount' => $this->getDiscount(),
                    'coupon' => $_SESSION['coupon'] ?? null,
                    'items' => $this->getCartItems()
                ]);
                break;
        }
        exit;
    }
}
