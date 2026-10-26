<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$page = isset($_GET['Page']) ? $_GET['Page'] : 'home';

// Handle JSON API endpoints before any HTML output
if ($page === 'api_cart') {
    require_once __DIR__ . '/controller/CartController.php';
    $cartCtrl = new CartController();
    $cartCtrl->handleApi();
    exit;
}

switch ($page) {
    case 'home':
        include "Page/home.php";
        break;

    case 'login':
        include "Page/login.php";
        break;

    case 'register':
        include "Page/register.php";
        break;

    case 'cart':
        include "Page/cart.php";
        break;

    case 'checkout':
        include "Page/checkout.php";
        break;

    case 'orderSuccess':
        include "Page/orderSuccess.php";
        break;

    case 'tracking':
        include "Page/tracking.php";
        break;

    case 'orders':
        include "Page/orders.php";
        break;

    case 'search':
        include "Page/search.php";
        break;

    case 'wishlist':
        include "Page/wishlist.php";
        break;

    case 'review':
        include "Page/review.php";
        break;

    case 'detailProduk':
        include "Page/detailProduk.php";
        break;

    case 'bestSeller':
        include "Page/bestSeller.php";
        break;

    case 'maintenance':
        include "Page/maintenance.php";
        break;

    case 'search_artis':
        include "Page/search_artis.php";
        break;

    case 'artistProduk':
        include "Page/artistProduk.php";
        break;

    default:
        include "Component/header.php";
        echo "<div class='container my-5 text-center py-5'>
                <h1 class='display-4 fw-bold text-danger'>404</h1>
                <p class='fs-5 text-muted'>Halaman <strong>" . htmlspecialchars($page, ENT_QUOTES) . "</strong> tidak ditemukan.</p>
                <a href='/index.php?Page=home' class='btn btn-danger rounded-pill px-4'>Kembali ke Beranda</a>
              </div>";
        include "Component/footer.php";
        break;
}
?>