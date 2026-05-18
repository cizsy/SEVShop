<?php 
$page = isset($_GET['Page']) ? $_GET['Page'] : 'home';

switch ($page) {
    case 'home':
    case 'login':
    case 'register':
    case 'cart':
    case 'wishlist':
    case 'review':
    case 'detailProduk':
    case 'bestSeller':
    case 'h2hproduk':
    case 'maintenance':
    case 'search_artis':
    case 'artistProduk':
        include "../Page/{$page}.php";
        break;
        
    default:
        echo "Halaman tidak ditemukan.";
        break;
}
?>