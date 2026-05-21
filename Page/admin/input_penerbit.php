<?php
require_once '../../Model/penerbit.php';

$penerbitModel = new Penerbit();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penerbit = $_POST['nama_penerbit'];

    if ($penerbitModel->create($nama_penerbit)) {
        header("Location: read_penerbit.php");
        exit;
    } else {
        echo "Gagal menambahkan data penerbit.";
    }
}

$title = "Form Input Penerbit";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_penerbit.php" class="btn btn-primary">
        Lihat Data
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Form Input Penerbit</h5>

        <form action="" method="post">
            <label class="form-label">Nama Penerbit</label>
            <input type="text" name="nama_penerbit" required class="form-control mb-3">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>