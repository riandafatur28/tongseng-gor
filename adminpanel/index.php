<?php
require "session.php";
require "../js/koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.6.0-web/css/fontawesome.min.css">
    <style>
        body {
            background: url('../image/background_login.png') no-repeat center center fixed;
            background-size: cover;
        }

        .kotak {
            border: solid;
        }

        .summary-kategori, .summary-menu {
            border-radius: 15px;
            color: white;
            padding: 15px;
        }

        .summary-kategori {
            background-color: rgba(129, 162, 99, 0.7);
        }

        .summary-menu {
            background-color: rgba(255, 175, 97, 0.7);
        }

        .no-decoration {
            text-decoration: none;
        }

        .no-decoration:hover {
            color: blue;
        }

        .navbar {
            position: sticky;
            top: 0; 
            width: 100%; 
            z-index: 1000; 
        }
    </style>
</head>
<body>
    <?php require "navbar.php" ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active text-white" aria-current="page">
                    <i class="fas fa-home text-white"></i> Home
                </li>
            </ol>
        </nav>
        <h2 class="text-white">Hallo <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa-solid fa-list fa-7x text-black-50"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Kategori</h3>
                            <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                            <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-menu d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa-solid fa-bowl-rice fa-7x text-black-50"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Menu</h3>
                            <p class="fs-4"><?php echo $jumlahProduk; ?> Menu</p>
                            <p><a href="menu.php" class="text-white no-decoration">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>
</html>
