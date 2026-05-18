<?php
require_once '../../Model/Product.php';

$productModel = new Product();

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    if ($productModel->delete($id)) {
        header("Location: read_produk.php");
        exit;
    }
}

$result = $productModel->readAll();

$title = "Data Produk";
ob_start();
?>

<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data Produk</h5>
            <a href="input_produk.php" class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Artis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Detail</th>
                        <th>Cover</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Notice</th>
                        <th>Terms</th>
                        <th>Size</th>
                        <th>Contents</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_produk']; ?></td>

                                <td><?= htmlspecialchars($row['nama_produk'], ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['nama_artis'] ?? '-', ENT_QUOTES); ?></td>

                                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>

                                <td><?= htmlspecialchars($row['stok'], ENT_QUOTES); ?></td>

                                <td>
                                    <?php if (!empty($row['detail'])): ?>
                                        <img src="/produk-detail/<?= htmlspecialchars($row['detail'], ENT_QUOTES); ?>"
                                             width="80"
                                             alt="detail produk">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['gambar_produk'])): ?>
                                        <img src="/produk-cover/<?= htmlspecialchars($row['gambar_produk'], ENT_QUOTES); ?>"
                                             width="80"
                                             alt="cover produk">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td><?= htmlspecialchars($row['thn_terbit'], ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-', ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['nama_penerbit'] ?? '-', ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['notice'] ?? '-', ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['terms_recomen'] ?? '-', ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['size'] ?? '-', ENT_QUOTES); ?></td>

                                <td><?= htmlspecialchars($row['contents'] ?? '-', ENT_QUOTES); ?></td>

                                <td>
                                    <a href="input_produk.php?id=<?= $row['id_produk']; ?>"
                                       class="btn btn-sm btn-warning mb-1">
                                        Edit
                                    </a>

                                    <a href="read_produk.php?hapus=<?= $row['id_produk']; ?>"
                                       onclick="return confirm('Hapus produk ini?')"
                                       class="btn btn-sm btn-danger mb-1">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="15" class="text-center">Data masih kosong</td>
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