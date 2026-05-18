<?php
require_once '../../config/database.php';

$title = "Form Input Artis";

ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="view_artis.php"
       class="btn text-white"
       style="background-color:#1E4ED8; border-radius:8px; padding:8px 18px;">
        Lihat Data
    </a>
</div>

<div class="card">
    <div class="card-body">

        <h5 class="card-title fw-semibold mb-4">
            Form Input Artis
        </h5>

        <div class="card">
            <div class="card-body">

                <form action="../../Controller/Artis_controller.php" method="post">

                    <label class="form-label">
                        Nama Artis
                    </label>

                    <input type="text"
                           name="nama_artis"
                           required
                           class="form-control mb-3">

                    <button type="submit"
                            class="btn btn-primary">
                        Submit
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/partials/layout.php';
?>