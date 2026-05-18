<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_user = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM `user` WHERE email_user = ? LIMIT 1");
    $stmt->bind_param("s", $email_user);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama_user'] = $user['nama_user'];
        $_SESSION['email_user'] = $user['email_user'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: /Page/admin/index.php");
        } else {
            header("Location: /index.php?Page=home");
        }

        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SEVShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>

    <style>
        body {
            background: linear-gradient(135deg, #B3CCE5, #f7cfd1);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            max-width: 620px;
            margin: auto;
            padding: 45px;
            border-radius: 25px;
            background-color: #ffffffcc;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .logo-img {
            max-width: 190px;
            display: block;
            margin: 0 auto 20px;
        }

        .custom-btn {
            background-color: #ffaeac;
            color: #111;
            border: none;
            font-weight: 600;
            padding: 10px;
        }

        .custom-btn:hover {
            background-color: #ec707e;
            color: #111;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
        }

        .divider {
            border: none;
            border-top: 2px solid #fff;
            margin: 25px 0;
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: #f1f1f1;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        a {
            color: #111;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">

            <a href="/index.php?Page=home">
                <img src="/logo/Shopnavbar-removebg-preview.png" alt="SEVShop Logo" class="logo-img">
            </a>

            <h3 class="text-center mb-2">Masuk Akun SEVShop</h3>
            <p class="text-center text-muted mb-4">
                Silakan masuk menggunakan akun yang sudah terdaftar.
            </p>

            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error, ENT_QUOTES); ?>
                </div>
            <?php } ?>

            <form action="" method="post">

                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="email"
                           class="form-control"
                           id="username"
                           name="username"
                           placeholder="your@email.com"
                           required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           placeholder="Masukkan password"
                           required>
                </div>

                <button type="submit" class="btn custom-btn w-100">
                    Log In
                </button>

                <div class="option text-center mt-3">
                    <div>
                        <a href="#">Lupa Password?</a>
                    </div>

                    <div class="mt-3">
                        Tidak memiliki akun?
                        <a href="/index.php?Page=register">Daftar di sini</a>
                    </div>
                </div>
            </form>

            <hr class="divider">

            <p class="text-center mb-3">Or</p>

            <button class="btn-google" type="button">
                <img src="/logo/Google__G__logo.svg.png" alt="Google">
                Continue with Google
            </button>

        </div>
    </div>
</body>
</html>