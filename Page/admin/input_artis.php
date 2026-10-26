<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';

$title = "Form Input Artis";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="view_artis.php" class="btn btn-primary">
        <i class="ti ti-list me-1"></i> Lihat Data Artis
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Form Input Artis</h5>

        <form action="/controller/artis_controller.php" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Artis / Group <span class="text-danger">*</span></label>
                <input type="text" name="nama_artis" required class="form-control" placeholder="Cth: BTS / SEVENTEEN / ENHYPEN">
            </div>

            <button type="submit" class="btn btn-primary fw-bold">
                <i class="ti ti-device-floppy me-1"></i> Simpan Artis
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>