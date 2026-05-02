<?php
include __DIR__ . '/../Component/header.php';
?>

<?php include __DIR__ . '/../Component/navbar.php';
?>
<script src="./script/detailproduk.js"></script>


<div class="view-produk container mb-5 ">
  <div class="row">
    <div class="col-md-12 d-flex flex-wrap shadow bg-white p-4 rounded ">
      <div class="produk-img col-md-6 m-3">
          <img src="./produk-cover/dream gbttf.png" alt="go back to the future" class="img-fluid rounded shadow ">
      </div>
        <div class="product-info col-md-6 m-3">
            <div class="d-flex align-items-start mb-3">
                <div class="grow">
                    <div class="nama-artis">NCT DREAM</div>
                    <div class="nama-produk">'Go Back To The Future' (Ultimate Park Ver.)</div>
                </div>
                 <button class="wishlist-btn" id="wishlistBtn">
                    <i class="bi bi-heart"></i>
            </button>
            </div>
            <div class="tag-idr">IDR</div>
            <div class="harga-produk"> Rp. 270.000,00 </div>
          <div class="beli">
            <div class="label-barang">Set</div>
                  <div class="kontrol-barang">
                      <button class="btn-stok" onclick="decreaseQuantity()">-</button>
                      <input type="number" class="input-stok" id="stok" value="1" min="1">
                      <button class="btn-stok" onclick="increaseQuantity()">+</button>
                      <span style="margin-left: auto; font-weight: 600;"> Rp. 270.00,00</span>
                  </div>
          </div>
          <div class="total-harga">
  <div class="selected-info">
      <span id="selected-count">1</span> Barang dipilih<br>
  </div>
  <div id="total-harga" style="font-size: 20px; font-weight: 700;">Rp. 270.000,00</div>
</div>

              <div class="button-group">
              <button class="btn-cart">Masukkan ke Keranjang</button>
              <button class="btn-purchase">Pesan</button>
          </div>
            <div class="shipping-info">
                  <span>📍</span>
                  <span>Tambahkan alamat untuk memeriksa ongkir</span>
              </div>
      </div>
    </div>
  </div>
</div>

  <div class="tabs-section container mt-5">
          <div class="container mt-4">
  <!-- Judul -->
  <h3 class="text-center mb-4">Informasi Produk</h3>

  <!-- Catatan -->
  <div class="alert alert-light border p-3 mb-4">
    <strong>Harap Diperhatikan:</strong>
    <ul class="mb-0">
      <li>Box luar digunakan untuk melindungi produk utama. Kami tidak menerima penukaran atau pengembalian barang akibat kerusakan pada box luar selama proses pengiriman.</li>
      <li>Ukuran produk dapat berbeda sekitar 10 hingga 30 mm karena perbedaan metode pengukuran.</li>
      <li>Warna produk pada gambar mungkin terlihat berbeda dari warna aslinya, tergantung pencahayaan atau layar perangkat.</li>
    </ul>
  </div>

  <!-- Tabel produk -->
  <table class="table table-bordered p-3 mb-4">
    <tr><td><strong>Nama Produk</strong></td><td>	'Go Back To The Future' (Ultimate Park Ver.)</td></tr>
    <tr><td><strong>Label</strong></td><td>SM</td></tr>
    <tr><td><strong>Tanggal Rilis</strong></td><td>2025-04-21</td></tr>
    <tr><td><strong>Isi</strong></td><td> <ul class="mb-0">
      <li>Out Box: 1 jenis</li>
      <li>Skate Box: 1 jenis</li>
      <li>Photobook: 60 halaman</li>
      <li>Mini CD-R: 2 jenis</li>
      <li>CD Holder: 1 jenis</li>
      <li>Paper Figure: 1 dari 7 jenis (acak)</li>
      <li>Sticker Pack: 5 jenis (set)</li>
      <li>Photocard: 1 dari 7 jenis (acak)</li>
      <li>Poster Lipat: 1 jenis (set)</li>
    </ul></td></tr>
    <tr><td><strong>Produsen</strong></td><td>YGPLUS</td></tr>
  </table>

  <!-- Gambar detail produk -->
  <div class="text-center mt-5 mb-4">
    <img src="./produk-cover/gbttf det ult pack.jpg" class="img-fluid mb-3" alt="Detail Produk">


    <?php include __DIR__ . '/../Component/footer.php'; ?>


   