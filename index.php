<!DOCTYPE html>
<html lang="en">
    <?php include "component/header.php"; ?>
<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">
    
    <?php 
        // 1. Get the page from the URL (e.g., index.php?Page=cart)
        $page = isset($_GET['Page']) ? $_GET['Page'] : 'home';

        // 2. The Router Logic
        // This acts as a whitelist to ensure only valid files are loaded
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
            case 'detailProduk':
                include "Page/detailProduk.php";
                break;
            // Add your other cases here...
            default:
                include "Page/home.php"; // Fallback if page doesn't exist
                break;
        }
    ?>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
</body>
</html>