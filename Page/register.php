<?php
require_once __DIR__ . '/../Model/User.php';

$userModel = new User();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_user = $_POST['username'];
    $email_user = $_POST['email'];
    $no_hp = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Password dan konfirmasi password tidak sama.";
    } elseif ($userModel->emailExists($email_user)) {
        $error = "Email sudah dipakai.";
    } else {
        if ($userModel->register($nama_user, $email_user, $password, $no_hp)) {
            header("Location: /index.php?Page=login");
            exit;
        } else {
            $error = "Register gagal.";
        }
    }
}
?>