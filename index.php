<?php
    require "js/koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tongseng Ngarep Gor | Home</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>
    <!-- Banner Start -->
    <section class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Tongseng Ngarep Gor</h1>
            <h3>Mau cari Tongseng?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="menu.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Menu"
                            aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword"
                            autocomplete="off">
                        <button type="submit" class="btn warna1 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- Highlight Start -->
    <section class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>
            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div
                        class="hightlighted-kategori kategori-kambing d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="menu.php?kategori=Menu Daging Kambing">Menu Daging Kambing</a>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="hightlighted-kategori kategori-ayam d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="menu.php?kategori=Menu Daging Ayam">Menu Daging Ayam
                            </a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div
                        class="hightlighted-kategori kategori-minuman d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a href="menu.php?kategori=Minuman">Minuman</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Highlight End -->

    <!-- About Us Start -->
    <section class="container-fluid warna2 py-5">
        <div class="container text-white text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-7 mt-3">Warung Ngarep Gor yang baru dibuka pada tahun 2024 menawarkan pengalaman kuliner yang
                istimewa. Nikmati tongseng kambing yang kaya rasa, dengan potongan daging kambing empuk yang disertai
                sumsum dan tulang, menyajikan kelezatan yang mendalam. Sate kambingnya memukau dengan daging yang juicy
                dan bumbu kacang yang meresap secara sempurna. Sajian nasi gule sate kambing memadukan nasi hangat
                dengan gule kambing yang kental dan sate kambing panggang yang menggugah selera. Akhiri pengalaman
                bersantap Anda dengan keripik pangsit yang renyah atau kesegaran es jeruk. Warung ini adalah destinasi
                sempurna untuk menikmati hidangan istimewa bersama keluarga dan teman.</p>
        </div>
    </section>
    <!-- About Us End -->

    <!-- Menu Start -->
    <section class="container-fluid py-5">
        <div class="container text-center">
            <h3>Menu Kami</h3>

            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($data['nama']); ?>" />
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($data['nama']); ?></h4>
                            <p class="card-text text-truncate"><?php echo htmlspecialchars($data['detail']); ?></p>
                            <p class="card-text text-harga">Rp.
                                <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                            <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>"
                                class="btn warna2 text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-success mt-3 p-2 fs-4" href="menu.php">See More</a>
        </div>
    </section>
    <!-- Menu End -->



    <!-- Footer Start -->
    <?php require "footer.php";?>
    <!-- Footer End -->

    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>

</html>