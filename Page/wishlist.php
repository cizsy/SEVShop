<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K-pop Merch Wishlist</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fce4ec;
            color: #333;
        }

        .header {
            background-color: #e91e63;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .wishlist-count {
            background-color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: bold;
            color: #e91e63;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background-color: #f8bbd0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            color: #e91e63;
            margin-bottom: 8px;
        }

        .product-group {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .remove-btn {
            width: 100%;
            padding: 12px;
            border: 2px solid #e91e63;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #e91e63;
            color: white;
        }

        .remove-btn:hover {
            background-color: #c2185b;
            border-color: #c2185b;
        }

        .wishlist-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e91e63;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-wishlist-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .empty-wishlist h2 {
            font-size: 24px;
            color: #e91e63;
            margin-bottom: 10px;
        }

        h2 {
            color: #e91e63;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Wishlist Saya</h1>
        <p>Produk favorit yang ingin kamu beli</p>
    </div>

    <div class="container">
        <div class="wishlist-count">
            Total: <span id="wishlistTotal">0</span> Produk
        </div>
        <div class="products-grid" id="wishlistGrid"></div>
        <div class="empty-wishlist" id="emptyWishlist">
            <h2>Wishlist Masih Kosong</h2>
            <p>Yuk tambahkan produk favorit kamu ke wishlist!</p>
        </div>
    </div>

    <script>
        // Inisialisasi wishlist data
        if (!window.wishlistData) {
            window.wishlistData = {};
        }

        // Fungsi untuk mendapatkan wishlist
        function getWishlist() {
            return window.wishlistData || {};
        }

        // Fungsi untuk format harga
        function formatPrice(price) {
            return 'Rp ' + price.toLocaleString('id-ID');
        }

        // Fungsi untuk render product card
        function renderProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.innerHTML = `
                <div class="wishlist-badge">❤️</div>
                <div class="product-image">${product.emoji || '🎁'}</div>
                <div class="product-name">${product.name}</div>
                <div class="product-group">${product.group || 'K-pop'}</div>
                <div class="product-price">${formatPrice(product.price)}</div>
                <button class="remove-btn" onclick="removeFromWishlist(${product.id})">
                    🗑️ Hapus dari Wishlist
                </button>
            `;
            return card;
        }

        // Fungsi untuk remove dari wishlist
        function removeFromWishlist(productId) {
            if (window.wishlistData && window.wishlistData[productId]) {
                delete window.wishlistData[productId];
            }
            // Trigger event untuk notify halaman lain
            window.dispatchEvent(new CustomEvent('wishlistUpdated', { 
                detail: { action: 'remove', productId: productId }
            }));
            updateWishlistUI();
        }

        // Fungsi untuk update UI wishlist
        function updateWishlistUI() {
            const wishlistGrid = document.getElementById('wishlistGrid');
            const emptyWishlist = document.getElementById('emptyWishlist');
            const wishlistTotal = document.getElementById('wishlistTotal');

            wishlistGrid.innerHTML = '';

            const wishlist = getWishlist();
            const wishlistProducts = Object.values(wishlist);

            if (wishlistProducts.length === 0) {
                emptyWishlist.style.display = 'block';
                wishlistGrid.style.display = 'none';
            } else {
                emptyWishlist.style.display = 'none';
                wishlistGrid.style.display = 'grid';
                wishlistProducts.forEach(product => {
                    wishlistGrid.appendChild(renderProductCard(product));
                });
            }

            wishlistTotal.textContent = wishlistProducts.length;
        }

        // Listen untuk update dari halaman lain
        window.addEventListener('wishlistUpdated', function() {
            updateWishlistUI();
        });

        // Initialize
        updateWishlistUI();

        // Update setiap 500ms untuk sinkronisasi dengan halaman lain
        setInterval(updateWishlistUI, 500);
    </script>
</body>
</html>