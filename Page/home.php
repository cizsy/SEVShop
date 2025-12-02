<!-- <?php include '../Component/bagianProduk.php'; ?>

 <?php
// Data Produk untuk Best Seller
$bestSeller = [
    [
        "title" => "NANA bnb with SEVENTEEN",
        "artist" => "SEVENTEEN",
        "price" => 480000,
        "image" => "/produk cover/nanabnb.png",
        "badgeText" => "BEST",
        "badgeClass" => "badge-best"
    ],
    [
        "title" => "DESIRE : UNLEASH (Random)",
        "artist" => "ENHYPEN",
        "price" => 270000,
        "image" => "/produk cover/desire unleash set.png",
        "badgeText" => "BEST",
        "badgeClass" => "badge-best"
    ]
];

// Data Produk untuk New Arrival
$newArrival = [
    [
        "title" => "[No Genre] (Board Game ver.) (Random)",
        "artist" => "BOYNEXTDOOR",
        "price" => 165000,
        "image" => "/produk cover/no genre board game ver random.png",
        "badgeText" => "NEW",
        "badgeClass" => "badge-new"
    ],
    [
        "title" => "'Go Back To The Future' (Ultimate Park Ver.)",
        "artist" => "NCT DREAM",
        "price" => 270000,
        "image" => "/produk cover/dream gbttf.png",
        "badgeText" => "NEW",
        "badgeClass" => "badge-new"
    ]
];
?> -->

<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/../Component/head.php'; ?>

<body>
    <?php include __DIR__ . '/../Component/navbar.php'; ?>
    <?php include __DIR__ . '/../Component/heroo.php'; ?>
    <div class="recart text-center fw-bold fs-4 mt-4">Recommended Artists</div>
<div class="iconArtist d-flex justify-content-center gap-3 flex-wrap mb-4 px-3">
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/SEVENTEEN - HAPPY BURSTDAY Logo.jpeg" class="rounded-3" alt="SEVENTEEN">
    <div class="artist">SEVENTEEN</div>
  </a>
  
  <a href="/index/produkArtis.html" class="artist-item text-center">
    <img src="/logo/h2h logo.jpeg" class="rounded-3" alt="Hearts2Hearts">
    <div class="artist">Hearts2Hearts</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/TWS di TikTok.jpeg" class="rounded-3" alt="TWS">
    <div class="artist">TWS</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/Enhypen logo.jpeg" class="rounded-3" alt="ENHYPEN">
    <div class="artist">ENHYPEN</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/NCT DREAM.jpeg" class="rounded-3" alt="NCT DREAM">
    <div class="artist">NCT DREAM</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/KATSEYE LOGO.jpeg" class="rounded-3" alt="KATSEYE">
    <div class="artist">KATSEYE</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/bndlogo.jpeg" class="rounded-3" alt="BOYNEXTDOOR">
    <div class="artist">BOYNEXTDOOR</div>
  </a>
  
  <a href="#" class="artist-item text-center">
    <img src="/logo/txt.jpeg" class="rounded-3" alt="TXT">
    <div class="artist">TXT</div>
  </a>

</div>



<!-- rekomendasi produk -->
 <div class="container-produk-display justify-content-center mb-5">
  <a href="bestSeller.php">
        <div class="produk-display-home-header">
            BEST SELLER
        </div>
        </a>
        <a href="#">
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">BEST</div>
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
                        <div class="best-badge">BEST</div>
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
                        <div class="best-badge">BEST</div>
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
                <a href="detailProduk.php">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="best-badge">BEST</div>
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

    <!-- Latest Release -->

    <div class="container-produk-display mb-5">
  <a href="#">
        <div class="produk-display-home-header">
            LATEST RELEASE
        </div>
        </a>
        <a href="#">
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="new-badge">NEW</div>
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
                        <div class="new-badge">NEW</div>
                        <div class="card-body">
                            <img src="/produk cover/du random.png" 
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
                        <div class="new-badge">NEW</div>
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
                <a href="#">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="new-badge">NEW</div>
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

<!-- popular products -->
    <div class="container-produk-display mb-5">
  <a href="#">
        <div class="produk-display-home-header">
           POPULAR
        </div>
        </a>
        <a href="#">
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="popular-badge"> POPULAR</div>
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
                        <div class="popular-badge">POPULAR</div>
                        <div class="card-body">
                            <img src="/produk cover/du random.png" 
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
                        <div class="popular-badge">POPULAR</div>
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
                <a href="#">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="popular-badge">POPULAR</div>
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

<!-- preorder produk -->

    <div class="container-produk-display mb-5">
  <a href="#">
        <div class="produk-display-home-header">
           PRE-ORDER
        </div>
        </a>
        <a href="#">
        <div class="cards-container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="po-badge">PRE-ORDER</div>
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
                        <div class="po-badge">PRE-ORDER</div>
                        <div class="card-body">
                            <img src="/produk cover/du random.png" 
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
                        <div class="po-badge">PRE-ORDER</div>
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
                <a href="#">
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="po-badge">PRE-ORDER</div>
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
    <?php include '../Component/footer.php'; ?>
</body>
</html>
