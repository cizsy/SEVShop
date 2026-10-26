<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../Model/Product.php';

$productModel = new Product();

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    if ($productModel->delete($id)) {
        header("Location: read_produk.php?status=deleted");
        exit;
    }
}

$result = $productModel->readAll();

$title = "Data Produk";
ob_start();
?>

<div class="card">
    <div class="card-body">

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Produk berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Produk berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Produk</h5>
            <a href="input_produk.php" class="btn btn-primary">+ Tambah Produk</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Nama Produk</th>
                        <th>Artis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_produk']; ?></td>

                                <td>
                                    <?php if (!empty($row['gambar_produk'])): ?>
                                        <img src="/produk-cover/<?= htmlspecialchars($row['gambar_produk'], ENT_QUOTES); ?>"
                                             width="60" class="rounded border"
                                             alt="cover produk">
                                    <?php else: ?>
                                        <span class="text-muted small">No Image</span>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-bold"><?= htmlspecialchars($row['nama_produk'], ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['nama_artis'] ?? '-', ENT_QUOTES); ?></td>

                                <td class="text-danger fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>

                                <td><?= htmlspecialchars($row['stok'], ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['thn_terbit'], ENT_QUOTES); ?></td>

                                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['nama_kategori'] ?? '-', ENT_QUOTES); ?></span></td>

                                <td><?= htmlspecialchars($row['nama_penerbit'] ?? '-', ENT_QUOTES); ?></td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="input_produk.php?id=<?= $row['id_produk']; ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="read_produk.php?hapus=<?= $row['id_produk']; ?>"
                                           onclick="return confirm('Hapus produk ini?')"
                                           class="btn btn-sm btn-danger">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada data produk. Klik "+ Tambah Produk" untuk menambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>