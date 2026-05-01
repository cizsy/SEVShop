<?php
// session_start();
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php?Page=login');
    exit;
}

require_once('../config/Database.php');
require_once('../controller/controllers.php');
require_once('../controller/ProductController.php');



$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$productController = new ProductController();
$productController-> handleRequest();



// Routes for admin panel

?>