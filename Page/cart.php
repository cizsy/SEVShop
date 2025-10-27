<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SevShop - My Cart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #B3CCE5;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .rewards-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .add-on-badge {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .price-tag {
            font-size: 1.2rem;
            font-weight: 700;
            background: #f5576c;
            border-radius: 10px;
            padding: 5px 12px;
            color: white;
        }

        .item-content {
            display: flex;
            gap: 20px;
        }

        .item-image {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d3748;
        }

        .item-info {
            background: #f7fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .age-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .rating-badge {
            background: #2d3748;
            color: white;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-remove {
            background: #fc8181;
            color: white;
        }

        .btn-wishlist {
            background: #90cdf4;
            color: white;
        }

        .btn-view {
            background: #667eea;
            color: white;
            padding: 10px 20px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .warning-box {
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .warning-icon {
            color: #fc8181;
            font-size: 1.2rem;
        }

        .warning-text {
            font-size: 0.9rem;
            color: #2d3748;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-row:last-of-type {
            border-bottom: 2px solid #cbd5e0;
            margin-bottom: 20px;
        }

        .summary-label {
            color: #718096;
            font-size: 0.95rem;
        }

        .summary-value {
            font-weight: 600;
            color: #2d3748;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .note {
            margin-top: 30px;
            color: white;
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .item-content {
                flex-direction: column;
            }

            .summary-card {
                position: static;
            }
        }
    </style>
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