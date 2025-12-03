<?php
include '../Component/header.php';
?>

<?php include '../Component/navbar.php';
?>


<div class="view-produk container mb-5 ">
  <div class="row">
    <div class="col-md-12 d-flex flex-wrap shadow bg-white p-4 rounded ">
      <div class="produk-img col-md-6 m-3">
          <img src="/produk cover/dream gbttf.png" alt="go back to the future" class="img-fluid rounded shadow ">
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
    <img src="/produk cover/gbttf det ult pack.jpg" class="img-fluid mb-3" alt="Detail Produk">

    <!-- komen repiuw -->
    <div class="review-container mt-5 ">
    <h2 class="review-title">Customer Reviews</h2>

    <!-- Rating Summary -->
    <div class="rating-summary">
      <div class="overall-rating">
        <div class="rating-number">4.8</div>
        <div>
          <div class="rating-stars">
            <span class="star"><i class="fas fa-star"></i></span>
            <span class="star"><i class="fas fa-star"></i></span>
            <span class="star"><i class="fas fa-star"></i></span>
            <span class="star"><i class="fas fa-star"></i></span>
            <span class="star"><i class="fas fa-star-half-alt"></i></span>
          </div>
          <div class="rating-subtitle">Based on 24 Reviews</div>
        </div>
      </div>

      <div class="rating-bars">
        <div class="rating-row">
          <div class="stars-label">5 <span class="star"><i class="fas fa-star"></i></span></div>
          <div class="rating-bar"><div class="rating-fill" style="width: 70%"></div></div>
          <div class="rating-count">(16)</div>
        </div>
        <div class="rating-row">
          <div class="stars-label">4 <span class="star"><i class="fas fa-star"></i></span></div>
          <div class="rating-bar"><div class="rating-fill" style="width: 20%"></div></div>
          <div class="rating-count">(5)</div>
        </div>
        <div class="rating-row">
          <div class="stars-label">3 <span class="star"><i class="fas fa-star"></i></span></div>
          <div class="rating-bar"><div class="rating-fill" style="width: 8%"></div></div>
          <div class="rating-count">(2)</div>
        </div>
        <div class="rating-row">
          <div class="stars-label">2 <span class="star"><i class="fas fa-star"></i></span></div>
          <div class="rating-bar"><div class="rating-fill" style="width: 4%"></div></div>
          <div class="rating-count">(1)</div>
        </div>
        <div class="rating-row">
          <div class="stars-label">1 <span class="star"><i class="fas fa-star"></i></span></div>
          <div class="rating-bar"><div class="rating-fill" style="width: 0%"></div></div>
          <div class="rating-count">(0)</div>
        </div>
      </div>
    </div>

    <!-- Filter Options -->
    <div class="review-filter">
      <button class="filter-btn active">All Reviews</button>
      <button class="filter-btn">5 Stars</button>
      <button class="filter-btn">4 Stars</button>
      <button class="filter-btn">3 Stars</button>
      <button class="filter-btn">With Photos</button>
    </div>

    <!-- Ripuw 1 -->
    <div class="reviews-list">
      <div class="review-item">
        <div class="review-header">
          <img src="/img/ava1.jpeg" alt="" class="reviewer-avatar">
          <div class="reviewer-info">
            <div class="reviewer-name">orang keren</div>
            <div class="reviewer-stars">
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
            </div>
          </div>
          <div class="review-date">12 Mar 2024</div>
        </div>
        <div class="review-text">
          Freebiesnya banyak banget, good packaging!
        </div>
        <div class="review-helpful">
          <button class="helpful-btn"><i class="fas fa-thumbs-up"></i> Helpful</button>
          <span class="helpful-count">18 people found this helpful</span>
        </div>
      </div>

<!-- review 2 -->
      <div class="review-item">
        <div class="review-header">
          <img src="/img/ava2.jpeg" alt="" class="reviewer-avatar">
          <div class="reviewer-info">
            <div class="reviewer-name">manysa</div>
            <div class="reviewer-stars">
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="far fa-star"></i></span>
            </div>
          </div>
          <div class="review-date">10 Mar 2023</div>
        </div>
        <div class="review-text">
         bagus, barang sesuai deskripsi, packing rapi, pengiriman cepat
        </div>
        <div class="review-helpful">
          <button class="helpful-btn"><i class="fas fa-thumbs-up"></i> Helpful</button>
          <span class="helpful-count">7 people found this helpful</span>
        </div>
      </div>
<!-- ripiuw 3 -->
      <div class="review-item">
        <div class="review-header">
          <img src="/img/ava2.jpeg" alt="" class="reviewer-avatar">
          <div class="reviewer-info">
            <div class="reviewer-name">orang aring</div>
            <div class="reviewer-stars">
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
              <span class="star"><i class="fas fa-star"></i></span>
            </div>
          </div>
          <div class="review-date">June 8, 2023</div>
        </div>
        <div class="review-text">
        keren, aku dapet wishlist aku. makasih banget sev shop
        </div>
        <div class="review-helpful">
          <button class="helpful-btn"><i class="fas fa-thumbs-up"></i> Helpful</button>
          <span class="helpful-count">22 people found this helpful</span>
        </div>
      </div>
    </div>

    <!-- Read More -->
     <a href="/index/reviewPage.html">
    <div class="read-more-btn">
      <button>Load More Reviews</button>
    </div></a>
  </div>
  </div>


   <div class="container-produk-reccomend justify-content-center mt-5 mb-5">
  <a href="#">
        <div class="produk-display-home-header">
            Rekomendasi Produk
        </div>
        </a>
        <a href="#">
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">Rekomendasi</div>
                        <div class="card-body">
                            <img src="/produk cover/nanabnb.png" 
                                 class="product-image" alt="NANA bnb with SEVENTEEN">
                            <h5 class="product-title">NANA bnb with SEVENTEEN</h5>
                             <p class="artist-name">SEVENTEEN</p>
                            <div class="price-section">
                                <span class="currency">IDR</span>
                                <span class="price">Rp. 480.000,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <a href="#">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">Rekomendasi</div>
                        <div class="card-body">
                            <img src="/produk cover/desire unleash set.png" 
                                 class="product-image" alt="Desire Unleash Set">
                            <h5 class="product-title">DESIRE : UNLEASH (Random)</h5>
                            <p class="artist-name">ENHYPEN</p>
                            <div class="price-section">
                                <span class="currency">IDR</span>
                                <span class="price">Rp. 270.000,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <a href="">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">Rekomendasi</div>
                        <div class="card-body">
                            <img src="/produk cover/no genre board game ver random.png" 
                                 class="product-image" alt="4th EP [No Genre] (Board Game ver.) (Random)">
                            <h5 class="product-title">[No Genre] (Board Game ver.) (Random)</h5>
                            <p class="artist-name">BOYNEXTDOOR</p>
                            <div class="price-section">
                                <span class="currency">IDR</span>
                                <span class="price">Rp. 165.000,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <a href="produk.html">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">Rekomendasi</div>
                        <div class="card-body">
                            <img src="/produk cover/dream gbttf.png" 
                                 class="product-image" alt="'Go Back To The Future' (Ultimate Park Ver.)">
                            <h5 class="product-title">'Go Back To The Future' (Ultimate Park Ver.)</h5>
                            <p class="artist-name">NCT DREAM</p>
                            <div class="price-section">
                                <span class="currency">IDR</span>
                                <span class="price">Rp. 270.000,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
</div>

    <?php include '../Component/footer.php';
    ?>


   <script>

    // ===== KODE WISHLIST =====
// Inisialisasi wishlist data di variabel global
if (!window.wishlistData) {
    window.wishlistData = {};
}

// Data produk saat ini
const currentProduct = {
    id: 'nct-dream-gbttf', // ID unik untuk produk ini
    name: "'Go Back To The Future' (Ultimate Park Ver.)",
    group: 'NCT DREAM',
    price: 270000,
    emoji: '🎵',
    image: '/produk cover/dream gbttf.png'
};

// Cek apakah produk sudah di wishlist
function isInWishlist() {
    return window.wishlistData[currentProduct.id] !== undefined;
}

// Update tampilan tombol wishlist
function updateWishlistButton() {
    const wishlistBtn = document.getElementById('wishlistBtn');
    const icon = wishlistBtn.querySelector('i');
    
    if (isInWishlist()) {
        icon.className = 'bi bi-heart-fill';
        wishlistBtn.style.color = '#e91e63';
    } else {
        icon.className = 'bi bi-heart';
        wishlistBtn.style.color = '#666';
    }
}

// Toggle wishlist
function toggleWishlist() {
    if (isInWishlist()) {
        // Hapus dari wishlist
        delete window.wishlistData[currentProduct.id];
        alert('Produk dihapus dari wishlist!');
    } else {
        // Tambah ke wishlist
        window.wishlistData[currentProduct.id] = currentProduct;
        alert('Produk ditambahkan ke wishlist! ❤️');
    }
    
    // Update tampilan button
    updateWishlistButton();
    
    // Trigger event untuk notify halaman wishlist
    window.dispatchEvent(new CustomEvent('wishlistUpdated', { 
        detail: { 
            action: isInWishlist() ? 'add' : 'remove', 
            productId: currentProduct.id 
        }
    }));
}

// Event listener untuk tombol wishlist
document.getElementById('wishlistBtn').addEventListener('click', toggleWishlist);

// Initialize button state saat halaman dimuat
updateWishlistButton();

// fungsi harga
         let currentQuantity = 1;
         const basePrice = 270.000;
    function increaseQuantity() {
        if (currentQuantity < 10) {
            currentQuantity++;
            updateDisplay();
        }
    }

    function decreaseQuantity() {
        if (currentQuantity > 1) {
            currentQuantity--;
            updateDisplay();
        }
    }

    function updateDisplay() { 
    document.getElementById('stok').value = currentQuantity;
    document.getElementById('selected-count').textContent = currentQuantity;
    
    const totalPrice = basePrice * currentQuantity;
    document.getElementById('total-harga').textContent = 
        `Rp. ${totalPrice.toLocaleString('id-ID')}.000,00`;
}

// Animation for rating bars
    document.addEventListener('DOMContentLoaded', function() {
      const ratingFills = document.querySelectorAll('.rating-fill');
      ratingFills.forEach(fill => {
        const width = fill.style.width;
        fill.style.width = '0';
        setTimeout(() => {
          fill.style.width = width;
        }, 300);
      });
    });

    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        // Actual filtering implementation would go here
        console.log('Filtering by: ' + this.textContent);
      });
    });

    // Helpful button functionality
    const helpfulButtons = document.querySelectorAll('.helpful-btn');
    helpfulButtons.forEach(button => {
      button.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-check"></i> Helpful';
        this.style.background = '#e1f7e3';
        this.style.color = '#2e7d32';
      });
    });

    // Load more reviews function
    function loadMoreReviews() {
      alert('Loading more reviews...');
      // Implementation would fetch and display more reviews
    }
    </script>