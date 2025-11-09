<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEV Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   <link rel="icon" type="image/png" href="/logo/favicon.png"/>
    <link rel="stylesheet" href="/css/h2hproduk.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>

<body>
<?php include '../Component/navbar.php'; ?>

<div class="artist-hero-section">
  <div class="artist-hero-wrapper">
    <div class="artist-hero-item">
  <a href="#" title="Teenieping Artist">
  <img src="/produk cover/heroteenieping.png" alt="Teenieping Artist Banner" class="artist-hero-image">
  <span class="visually-hidden">Teenieping Artist</span>
</a>
</div>
    <div class="artist-hero-item">
      <a href="#">
      <img src="/produk cover/hers2u.png" alt="Artist Banner" class="artist-hero-image">
      </a>
    </div>
  </div>
</div>

 <div class="container-produk">
<div class="header">
    <h1>PRODUK</h1>
    <div class="tabs">
        <button class="tab active" data-tab="merch">MERCH</button>
        <button class="tab" data-tab="membership">MEMBERSHIP</button>
        <button class="tab" data-tab="album">ALBUM</button>
    </div>
</div>

<div id="merch" class="tab-content">
    <div class="product-grid">
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/10cm doll.png" alt="" srcset=""></div>
            <div class="product-name">Teenieping 10cm Doll</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 260.000,00</div>
        </div>
        
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/cahol set.png" alt="" srcset=""></div>
            <div class="product-name">Photo Card Holder Set</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 220.000,00</div>
        </div>

        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/removable luggage sticker.png" alt="" srcset=""></div>
            <div class="product-name">Removable Luggage Sticker</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 90.000,00</div>

        </div>
<div id="membership" class="tab-content">
</div>

<div id="membership" class="tab-content" hidden>
    <div class="product-grid">
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/s2u membership.png"></div>
            <div class="product-name">S2U Membership</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 395.000,00</div>
        </div>
<div id="album" class="tab-content">
</div>

<div id="album" class="tab-content">
    <div class="product-grid">
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/The 1st Single [The Chase] (Minibook Ver.)(SMART ALBUM) (Random).png"></div>
            <div class="product-name">The 1st Single [The Chase] (Minibook Ver.) (Random)</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 215.000,00</div>
        </div>
        
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/The 1st Single [The Chase] (Package Ver.).png"></div>
            <div class="product-name">The 1st Single [The Chase] (Package Ver.)</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 290.000,00</div>
        </div>
        
        <div class="product-card special-card">
            <div class="product-image"><img src="/produk cover/The 1st Single [The Chase] (Photobook Ver.) (Random).png"></div>
            <div class="product-name">The 1st Single [The Chase] (Photobook Ver.)</div>
            <div class="product-price">IDR</div>
            <div class="product-amount">Rp. 200.000,00</div>
        </div>
    </div>
</div>
</div>

<?php include '../Component/footer.php'; ?>


    <script>
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                tab.classList.add('active');

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });

                // Show corresponding tab content
                const tabId = tab.getAttribute('data-tab');
                const targetContent = document.getElementById(tabId);
                if (targetContent) {
                    targetContent.style.display = 'block';
                    // Reset animation
                    const grid = targetContent.querySelector('.product-grid');
                    grid.style.animation = 'none';
                    setTimeout(() => {
                        grid.style.animation = 'fadeInUp 0.6s ease forwards';
                    }, 10);
                }
            });
        });

        // Add click effects to product cards
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('click', () => {
                // Add a pulse effect
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 100);
                
                // You can add more functionality here, like opening a modal or redirecting
                console.log('Product clicked:', card.querySelector('.product-name').textContent);
            });
        });

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', () => {
            // Animate cards on load
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    
</body>