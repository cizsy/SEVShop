<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: /login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.php");
    exit;
}