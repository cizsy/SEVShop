<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "Component/header.php"; ?>
<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">
    
    <?php 
    $page = isset($_GET['Page']) ? $_GET['Page'] : 'home';

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
            echo "Halaman tidak ditemukan: " . htmlspecialchars($page);
            break;
    }
    ?>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
</body>
</html>