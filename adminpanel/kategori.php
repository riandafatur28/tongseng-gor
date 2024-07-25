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
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.6.0-web/css/fontawesome.min.css">
</head>

<style>
     .no-decoration{
            text-decoration: none;
        }

        .kotak {
            border: solid;
        }

        .summary-kategori{
            background-color: #365E32;
           
        }
        .breadcrumb-item {
        display: inline; /* Menampilkan item breadcrumb secara horizontal */
        }

        .breadcrumb-item + .breadcrumb-item {
            margin-left: 0.2rem; /* Jarak antara item breadcrumb */
        }

        .navbar {
        position: sticky;
        top: 0; 
        width: 100%; 
        z-index: 1000; 
    }

    </style>
</head>
    <body style="background-color: #157347">
            <?php require "navbar.php" ?>
            <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white">
                    <li class="breadcrumb-item text-white">
                        <a href="../adminpanel" class="text-white no-decoration">
                            <i class="fas fa-home text-white"></i> Home
                        </a>
                    </li>
                    
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        Kategori
                    </li>
                </ol>
            </nav>
        <div class="my-5 text-white col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input nama kategori" class="form-control mt-2 shadow" autocomplete="off" required>
                </div>
                <div class="mt-3">
                <button class="btn btn-primary shadow" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php


            if (isset($_POST['simpan_kategori'])) {
                $kategori = htmlspecialchars($_POST['kategori']);
                $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
                $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

            if ($jumlahDataKategoriBaru > 0) {
                ?>
                <div class="alert alert-warning mt-3 shadow border-1px-solid-white mt-3" role="alert">
                        Kategori telah tersedia
                </div>
                <meta http-equiv="refresh" content="1; url=kategori.php" />
                <?php
            } else {
                $querySimpan = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                if ($querySimpan) {
                    ?>
                    <div class="alert alert-success mt-3 shadow border-1px-solid-white mt-3" role="alert">
                        Kategori baru berhasil disimpan
                    </div>
                    <meta http-equiv="refresh" content="1; url=kategori.php" />
                    <?php
    
                } else {
                    echo mysqli_error($con);
                }
            }
        }
        ?>
        </div>
        
        <div class="mt-3">
            <h2 class="text-white">List Kategori</h2>
                <div class="table-responsive mt-5">
                    <table class="table shadow">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($jumlahKategori==0){
                                ?>
                                    <tr>
                                        <td colspan=3 class="text-center">Data Kategori Tidak Tersedia!</td>
                                    </tr>
                                <?php
                                    } else {
                                        $jumlah = 1;
                                        while($data=mysqli_fetch_array($queryKategori)){
                                ?>
                                    <tr>
                                        <td><?php echo $jumlah; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td>
                                            <a href="kategori-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-primary shadow"><i class="fas fa-search shadow"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                        $jumlah++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>
</html>