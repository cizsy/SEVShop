<?php 

$page = isset($_GET['Page']) ? $_GET['Page'] : 'home';

if ($page == 'home') {
    include "../Page/home.php";
} else if ($page == 'login') {
    include "../Page/login.php";
} else if ($page == 'register') {
    include "../Page/register.php";
} else if ($page == 'cart') {
    include "../Page/cart.php";
} else if ($page == 'wishlist') {
    include "../Page/wishlist.php";
} else if ($page == 'review') {
    include "../Page/review.php";
} else if ($page == 'detailProduk') {
    include "../Page/detailProduk.php";
} else if ($page == 'bestSeller') {
    include "../Page/bestSeller.php";
} else if ($page == 'h2hproduk') {
    include "../Page/h2hproduk.php";
} else if ($page == 'maintenance') {
    include "../Page/maintenance.php";
} else {
    echo "Halaman tidak ditemukan.";
}
?>