<?php
    require "js/koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // get produk by nama produk/keywoard
    if (isset($_GET['keyword'])) {
        $keyword = mysqli_real_escape_string($con, $_GET['keyword']);
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$keyword%'");
    }
    // Get produk by kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
       
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    }
    // Get Produk Default
    else{
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tongseng Ngarep Gor || Menu</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- Banner Start -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Menu Kami</h1>
        </div>
    </div>
    <!-- Banner End -->


    <!-- Body Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
                    <a class="no-decoration" href="menu.php?kategori=<?php echo $kategori['nama'];?>">
                        <li class="list-group-item"><?php echo $kategori['nama'];?></li>
                    </a>
                    <?php }?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Menu Kami</h3>
                <div class="row">
                    <?php
                         if($countData<1){ 
                        ?>
                    <h4 class="text-center my-5"> Menu Yang Anda Cari Tidak Tersedia</h4>
                    <?php
                    }
                    ?>

                    <?php while($produk = mysqli_fetch_array($queryProduk)){?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']?>" class="card-img-top" alt="" />
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $produk['nama']?></h4>
                                <p class="card-text text-truncate"><?php echo $produk['detail']?></p>
                                <p class="card-text text-harga">Rp.<?php echo $produk['harga']?>
                                </p>
                                <a href="produk-detail.php?nama=<?php echo $produk['nama']?>"
                                    class="btn warna2 text-white">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <!-- Body End -->

    <!-- Footer Start -->
    <?php require "footer.php";?>
    <!-- Footer End -->

    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>

</html>