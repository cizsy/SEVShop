<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['id_user']);
unset($_SESSION['nama_user']);
unset($_SESSION['email_user']);
unset($_SESSION['role']);

header("Location: /index.php?Page=home");
exit;
