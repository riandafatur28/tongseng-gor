<?php
    require "js/koneksi.php";
    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tongseng Ngarep Gor || Detail Menu</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    /* Gaya untuk keseluruhan section */
    .container-fluid {
        background-color: #f8f9fa;
        padding: 5rem 0;
    }

    /* Gaya untuk gambar */
    .container .row .col-md-5 img {
        border: 6px solid #343a40;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .container .row .col-md-5 img:hover {
        transform: scale(1.03);
    }

    /* Gaya untuk konten teks */
    .container .row .col-md-6 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: 2px solid #343a40;
        border-radius: 12px;
        padding: 2rem;
        background-color: #ffffff;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease-in-out;
    }

    .container .row .col-md-6:hover {
        background-color: #f1f1f1;
    }

    .container .row .col-md-6 h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #343a40;
        border-bottom: 3px solid #343a40;
        padding-bottom: 0.5rem;
    }

    .container .row .col-md-6 p {
        margin-bottom: 1rem;
        color: #6c757d;
    }

    .container .row .col-md-6 .text-harga {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
    }

    .container .row .col-md-6 .fs-5 {
        font-size: 1.25rem;
    }

    .container .row .col-md-6 strong {
        color: black;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {

        .container .row .col-md-5,
        .container .row .col-md-6 {
            margin-bottom: 1.5rem;
        }

        .container .row .col-md-6 h1 {
            font-size: 1.75rem;
        }

        .container .row .col-md-6 p {
            font-size: 1rem;
        }

        .container .row .col-md-6 .text-harga {
            font-size: 1.25rem;
        }
    }

    /* Gaya untuk produk terkait */
    .container-fluid.warna1 {
        background-color: #9CA986;
        padding: 4rem 0;
    }

    .container-fluid.warna1 h2 {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 700;
        border-bottom: 3px solid #ffffff;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    /* Gaya untuk gambar thumbnail */
    .img-thumbnail {
        padding: 0.25rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }

    /* Pastikan gambar menggunakan ukuran fluid untuk responsif */
    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    /* Mengatur padding dan margin untuk kolom */
    .col-md-6,
    .col-lg-3 {
        padding: 0.5rem;
    }

    /* Margin bawah pada kolom */
    .mb-3 {
        margin-bottom: 1rem;
    }

    /* Responsif: mengurangi margin dan padding untuk layar kecil */
    @media (max-width: 768px) {
        .img-thumbnail {
            padding: 0.125rem;
        }

        .col-md-6,
        .col-lg-3 {
            padding: 0.25rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }
    }

    .produk-terkait-image {
        height: 100%;
        width: 100%;
        object-fit: center;
        object-position: center;
    }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <img src="image/<?php echo htmlspecialchars($produk['foto']); ?>" class="w-100"
                        alt="<?php echo htmlspecialchars($produk['nama']); ?>">
                </div>
                <div class="col-md-6 offset-md-1">
                    <h1><?php echo htmlspecialchars($produk['nama']); ?></h1>
                    <p class="fs-5"><?php echo htmlspecialchars($produk['detail']); ?></p>
                    <p class="text-harga">Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                    <p class="fs-5">Status Ketersediaan:
                        <strong><?php echo htmlspecialchars($produk['ketersediaan_stok']); ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terkait Start -->
    <div class="container-fluid py-5 warna1">
        <div class="container">
            <h2 class="text-center text-white mb-5">Menu Terkait</h2>

            <div class="row justify-content-center">
                <?php while($data=mysqli_fetch_array($queryProdukTerkait)){?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $data['nama'];?>">
                        <img src="image/<?php echo $data['foto']?>" class="img-fluid img-thumbnail produk-terkait-image"
                            alt="">
                    </a>
                </div>
                <?php } ?>
            </div>

        </div>
    </div>
    <!-- Produk Terkait End -->

    <!-- Footer Start -->
    <?php require "footer.php"; ?>
    <!-- Footer End -->

    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>

</html>