<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SevShop - My Cart</title>
    <link rel="icon" type="image/png" href="/logo/favicon.png"/>
    <link rel="stylesheet" href="/css/cart.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>My Cart</h1>
            <button class="rewards-btn">SevShop Rewards ✨ IDR 0.00</button>
        </div>

<!-- LIST BARANG ===============================================-->
        <div class="main-content">
            <div class="cart-items">
                <div class="cart-item">
                    <div class="item-header">
                        <span class="add-on-badge">Add-On</span>
                        <span class="price-tag">IDR 350.000</span>
                    </div>

                    <div class="item-content">
                        <img src="https://images.unsplash.com/photo-1614680376593-902f74cf0d41?w=400&h=400&fit=crop" alt="BTS Album" class="item-image">
                        
                        <div class="item-details">
                            <h3 class="item-title">BTS - MAP OF THE SOUL : 7 Album</h3>
                            
                            <div class="item-info">
                                <div class="age-rating">
                                    <span class="rating-badge">ALL</span>
                                    <span style="color: #718096; font-size: 0.9rem;">Official Merchandise</span>
                                </div>
                                <p style="color: #718096; font-size: 0.85rem;">Includes: Photobook, CD, Photocard, Poster</p>
                            </div>

                            <div class="item-actions">
                                <div class="action-buttons">
                                    <button class="btn btn-remove" onclick="removeItem(this)">Remove</button>
                                    <button class="btn btn-wishlist">Move to wishlist</button>
                                </div>
                                <button class="btn btn-view">View Product</button>
                            </div>

                            <!-- <div class="warning-box">
                                <span class="warning-icon">⚠</span>
                                <span class="warning-text">Purchasing this item requires: <strong>Minimum purchase IDR 500.000</strong>. Add more products to your cart to proceed with checkout.</span>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="item-header">
                        <span class="add-on-badge">Add-On</span>
                        <span class="price-tag">IDR 250.000</span>
                    </div>

                    <div class="item-content">
                        <img src="https://images.unsplash.com/photo-1593720213428-28a5b9e94613?w=400&h=400&fit=crop" alt="Blackpink Lightstick" class="item-image">
                        
                        <div class="item-details">
                            <h3 class="item-title">BLACKPINK Official Light Stick Ver 2</h3>
                            
                            <div class="item-info">
                                <div class="age-rating">
                                    <span class="rating-badge">ALL</span>
                                    <span style="color: #718096; font-size: 0.9rem;">Concert Light Stick</span>
                                </div>
                                <p style="color: #718096; font-size: 0.85rem;">Bluetooth connectivity, Official YG Product</p>
                            </div>

                            <div class="item-actions">
                                <div class="action-buttons">
                                    <button class="btn btn-remove" onclick="removeItem(this)">Remove</button>
                                    <button class="btn btn-wishlist">Move to wishlist</button>
                                </div>
                                <button class="btn btn-view">View Product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <h2 class="summary-title">Total Belanja</h2>
                
                <div class="summary-row">
                    <span class="summary-label">Harga</span>
                    <span class="summary-value" id="totalPrice">IDR 600.000</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Pajak</span>
                    <span class="summary-value">Akan dihitung ketika dipesan</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value" id="subtotal">IDR 600.000</span>
                </div>

                <button class="checkout-btn" onclick="checkout()">Check Out</button>
            </div>
        </div>

        <!-- <p class="note">* The lowest price offered on SevShop in the last 30 days before discount</p> -->
    </div>

    <script>
        function removeItem(button) {
            const cartItem = button.closest('.cart-item');
            const priceText = cartItem.querySelector('.price-tag').textContent;
            const price = parseInt(priceText.replace(/[^0-9]/g, ''));
            
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                cartItem.remove();
                updateTotal();
            }, 300);
        }

        function updateTotal() {
            const items = document.querySelectorAll('.cart-item');
            let total = 0;
            
            items.forEach(item => {
                const priceText = item.querySelector('.price-tag').textContent;
                const price = parseInt(priceText.replace(/[^0-9]/g, ''));
                total += price;
            });
            
            document.getElementById('totalPrice').textContent = `IDR ${total.toLocaleString('id-ID')}`;
            document.getElementById('subtotal').textContent = `IDR ${total.toLocaleString('id-ID')}`;
            
            if (items.length === 0) {
                document.querySelector('.cart-items').innerHTML = '<div style="text-align: center; padding: 50px; color: white; font-size: 1.2rem;">Your cart is empty</div>';
            }
        }

        function checkout() {
            alert('Proceeding to checkout...');
        }
    </script>
</body>
</html>