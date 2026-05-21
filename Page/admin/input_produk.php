<?php
require_once '../../config/database.php';
require_once '../../Model/Product.php';
require_once '../../Model/artis.php';
require_once '../../Model/kategori.php';
require_once '../../Model/penerbit.php';

$productModel = new Product();
$artistModel = new Artis();
$kategoriModel = new Kategori();
$penerbitModel = new Penerbit();

$id = $_GET['id'] ?? null;
$row = $id ? $productModel->getById($id) : [];

$artis_list = $artistModel->readAll();
$kategori_list = $kategoriModel->readAll();
$penerbit_list = $penerbitModel->readAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'          => $_POST['nama_produk'],
        'artis_id'      => $_POST['id_artis'],
        'price'         => $_POST['harga'],
        'stock'         => $_POST['stok'],
        'detail'        => $row['detail'] ?? '',
        'gambar_produk' => $row['gambar_produk'] ?? '',
        'thn_terbit'    => $_POST['thn_terbit'],
        'category_id'   => $_POST['id_kategori'],
        'penerbit_id'   => $_POST['id_penerbit'],
        'komentar_id'   => null,
        'jenis_id'      => null,
        'notice'        => $_POST['notice'] ?? '',
        'terms'         => $_POST['terms'] ?? '',
        'size'          => $_POST['size'] ?? '',
        'contents'      => $_POST['contents'] ?? ''
    ];

    if (!empty($_FILES['gambar_produk']['name'])) {
        $cover = time() . "_cover_" . $_FILES['gambar_produk']['name'];
        move_uploaded_file($_FILES['gambar_produk']['tmp_name'], "../../produk-cover/" . $cover);
        $data['gambar_produk'] = $cover;
    }

    if (!empty($_FILES['detail_produk']['name'])) {
        $detail = time() . "_detail_" . $_FILES['detail_produk']['name'];
        move_uploaded_file($_FILES['detail_produk']['tmp_name'], "../../produk-detail/" . $detail);
        $data['detail'] = $detail;
    }

    $result = $id ? $productModel->update($id, $data) : $productModel->create($data);

    if ($result) {
        header("Location: read_produk.php?status=success");
        exit;
    }
}

$title = $id ? "Edit Produk" : "Form Input Produk";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_produk.php" class="btn btn-primary">Lihat Data</a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <?= $id ? 'Edit Produk' : 'Form Input Produk' ?>
        </h5>

        <form action="" method="post" enctype="multipart/form-data">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" value="<?= $row['nama_produk'] ?? '' ?>" required class="form-control mb-3">

            <label class="form-label">Artis</label>
            <select name="id_artis" class="form-select mb-3" required>
                <option value="">-- Pilih Artis --</option>
                <?php while ($a = $artis_list->fetch_assoc()) { ?>
                    <option value="<?= $a['id_artis'] ?>" <?= (isset($row['id_artis']) && $a['id_artis'] == $row['id_artis']) ? 'selected' : '' ?>>
                        <?= $a['nama_artis'] ?>
                    </option>
                <?php } ?>
            </select>

            <label class="form-label">Harga</label>
            <input type="number" name="harga" value="<?= $row['harga'] ?? 0 ?>" required class="form-control mb-3">

            <label class="form-label">Stok</label>
            <input type="number" name="stok" value="<?= $row['stok'] ?? '' ?>" required class="form-control mb-3">

            <label class="form-label">Gambar Detail Produk</label>
            <input type="file" name="detail_produk" class="form-control mb-3" <?= $id ? '' : 'required' ?>>

            <label class="form-label">Gambar Cover Produk</label>
            <input type="file" name="gambar_produk" class="form-control mb-3" <?= $id ? '' : 'required' ?>>

            <label class="form-label">Tahun Terbit</label>
            <input type="number" name="thn_terbit" value="<?= $row['thn_terbit'] ?? '' ?>" required class="form-control mb-3">

            <label class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select mb-3" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($k = $kategori_list->fetch_assoc()) { ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= (isset($row['id_kategori']) && $k['id_kategori'] == $row['id_kategori']) ? 'selected' : '' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                <?php } ?>
            </select>

            <label class="form-label">Penerbit</label>
            <select name="id_penerbit" class="form-select mb-3" required>
                <option value="">-- Pilih Penerbit --</option>
                <?php while ($pub = $penerbit_list->fetch_assoc()) { ?>
                    <option value="<?= $pub['id_penerbit'] ?>" <?= (isset($row['id_penerbit']) && $pub['id_penerbit'] == $row['id_penerbit']) ? 'selected' : '' ?>>
                        <?= $pub['nama_penerbit'] ?>
                    </option>
                <?php } ?>
            </select>

            <label class="form-label">Notice</label>
            <textarea name="notice" class="form-control mb-3"><?= $row['notice'] ?? '' ?></textarea>

            <label class="form-label">Terms Recommend</label>
            <textarea name="terms" class="form-control mb-3"><?= $row['terms_recomen'] ?? '' ?></textarea>

            <label class="form-label">Size</label>
            <input type="text" name="size" value="<?= $row['size'] ?? '' ?>" class="form-control mb-3">

            <label class="form-label">Contents</label>
            <input type="text" name="contents" value="<?= $row['contents'] ?? '' ?>" class="form-control mb-3">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>