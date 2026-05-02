

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
