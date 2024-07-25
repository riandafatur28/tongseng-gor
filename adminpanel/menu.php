<?php
require "session.php";
require "../js/koneksi.php";

$queryProduk = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($queryProduk);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.6.0-web/css/fontawesome.min.css">
</head>
<style>
    .kotak {
        border: solid;
    }
    .summary-kategori {
        background-color: #365E32;
    }
    .no-decoration {
        text-decoration: none;
    }
    .breadcrumb-item {
        display: inline; /* Menampilkan item breadcrumb secara horizontal */
    }
    .breadcrumb-item + .breadcrumb-item {
        margin-left: 0.2rem; /* Jarak antara item breadcrumb */
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }
    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        text-align: left; /* Mengatur teks ke kiri secara default */
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody + tbody {
        border-top: 2px solid #dee2e6;
    }
    .table .table {
        background-color: #fff;
    }
    .table-responsive {
        display: block;
        width: 100%; /* Lebar 100% untuk responsif */
        overflow-x: auto; /* Menambahkan scrollbar horizontal jika diperlukan */
        -webkit-overflow-scrolling: touch;
    }
    @media (min-width: 758px) {
        .table-responsive {
            overflow-x: visible; /* Menghapus scrollbar horizontal pada layar besar */
        }
        .table {
            width: 200%; /* Lebar tabel 200% pada layar terbesar */
            max-width: none; /* Menghapus batasan max-width */
            margin: 0 auto; /* Memusatkan tabel pada layar besar */
        }
    }
    .mt-20 {
        margin-top: 30px; /* Mengatur jarak atas div */
        margin-bottom: 10px;
    }
    .mt-30 {
        margin-top: 100px;
    }

    .navbar {
    position: sticky;
    top: 0; 
    width: 100%; 
    z-index: 1000; 
}
</style>
<body style="background-color: #157347">
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item text-white">
                    <a href="../adminpanel" class="text-white no-decoration">
                        <i class="fas fa-home text-white"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    Menu
                </li>
            </ol>
        </nav>

        <div class="my-5 text-white col-12 col-md-6">
            <h3>Tambah Menu</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="menu">Menu</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Menu Baru" class="form-control mt-2 shadow" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mt-3">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        while($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div class="mt-3">
                    <label for="foto">Foto Menu</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="mt-3">
                    <label for="detail">Detail Menu</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="mt-3">
                    <label for="ketersediaan_stok">Ketersediaan Menu</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div class="mt-20">
                    <button class="btn btn-primary shadow" type="submit" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
                
                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                $random_name = generateRandomString(20) . '.' . $imageFileType;
                $target_file = $target_dir . $random_name;
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . ".". $imageFileType;
                
                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-warning shadow border-1px-solid-white" role="alert">
                        Nama, Kategori, dan Harga Wajib Diisi!
                    </div>
            <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 500000) {
            ?>
                            <div class="alert alert-warning shadow border-1px-solid-white mt-3" role="alert">
                                Ukuran Gambar Tidak boleh Lebih dari 500 KB
                            </div>
            <?php
                        } elseif ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && 
                                  $imageFileType != 'JPG' && $imageFileType != 'JPEG' && $imageFileType != 'PNG') {
            ?>
                            <div class="alert alert-warning shadow border-1px-solid-white mt-3" role="alert">
                                Gambar Harus bertipe jpg, jpeg, atau png
                            </div>
            <?php
                        } else {
                            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $random_name . "." . $imageFileType)) {
            ?>
                                <div class="alert alert-success shadow border-1px-solid-white mt-3" role="alert">
                                    Gambar berhasil diunggah.
                                </div>
            <?php
                            } else {
            ?>
                                <div class="alert alert-danger shadow border-1px-solid-white mt-3" role="alert">
                                    Terjadi kesalahan saat mengunggah gambar.
                                </div>
            <?php
                            }
                        }
                    } else {
            ?>
                        <div class="alert alert-warning shadow border-1px-solid-white mt-3" role="alert">
                            Tidak ada gambar yang diunggah.
                        </div>
            <?php
                    }
                }
            
                // Query insert to tabel menu
                $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");

                if($queryTambah){

                    ?>
                    <div class="alert alert-success mt-3 shadow border-1px-solid-white mt-3" role="alert">
                        Menu baru berhasil disimpan
                    </div>
                    <meta http-equiv="refresh" content="1; url=menu.php" />
                    <?php
    
                } else {
                    echo mysqli_error($con);
                }
            }
            ?>

            <div class="mt-10 mb-10">
                <h2 class="text-white mt-30">List Menu</h2>
                <div class="table-responsive mt-5">
                    <table class="table shadow">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Ketersediaan menu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($jumlahProduk == 0) {
                            ?>
                                <tr>
                                    <td colspan=6 class="text-center">Menu Tidak Tersedia!</td>
                                </tr>
                            <?php
                            } else {
                                $jumlah = 1;
                                while ($data = mysqli_fetch_array($queryProduk)) {
                            ?>
                                    <tr>
                                        <td><?php echo $jumlah; ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['nama_kategori']; ?></td>
                                        <td><?php echo $data['harga']; ?></td>
                                        <td><?php echo $data['ketersediaan_stok']; ?></td>
                                        <td>
                                            <a href="menu-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-primary shadow"><i class="fas fa-search shadow"></i></a>
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
    </div>

    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/ckeditor.js"></script>
    <script>
    ClassicEditor
        .create(document.querySelector('#detail'))
        .catch(error => {
            console.error(error);
        });
    </script>
</body>
</html>
