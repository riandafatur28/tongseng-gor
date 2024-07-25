<?php
require "session.php";
require "../js/koneksi.php";

$id = intval($_GET['p']);

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id != '$data[kategori_id]'");

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
    <title>Detail Menu</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
        }
        .mt-20 {
            margin-top: 30px;
            margin-bottom: 100px;
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
    <?php require "navbar.php"?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item text-white">
                    <a href="menu.php" class="text-white no-decoration">
                        <i class="fa-solid fa-bowl-rice"></i> Menu
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    Detail Menu
                </li>
            </ol>
        </nav>
        <h2 class="text-white">Detail Menu</h2>
        <div class="col-12 col-md-6 mt-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="menu" class="text-white mt-3">Menu</label>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" class="form-control mt-2 shadow" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mt-3 text-white">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo htmlspecialchars($data['kategori_id']); ?>"><?php echo htmlspecialchars($data['nama_kategori']); ?></option>
                        <?php while ($dataKategori = mysqli_fetch_array($queryKategori)) { ?>
                            <option value="<?php echo htmlspecialchars($dataKategori['id']); ?>"><?php echo htmlspecialchars($dataKategori['nama']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="harga" class="text-white">Harga</label>
                    <input type="number" class="form-control" value="<?php echo htmlspecialchars($data['harga']); ?>" name="harga" required>
                </div>
                <div class="mt-3">
                    <label for="currentFoto" class="text-white">Foto Menu Saat Ini</label>
                    <img src="../image/<?php echo htmlspecialchars($data['foto']); ?>" alt="" width="100px" class="form-control">
                </div>
                <div class="mt-3">
                    <label for="foto" class="text-white">Foto Menu</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="mt-3">
                    <label for="detail" class="text-white">Detail Menu</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"><?php echo htmlspecialchars($data['detail']); ?></textarea>
                </div>
                <div class="mt-3">
                    <label for="ketersediaan_stok" class="text-white">Ketersediaan Menu</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo htmlspecialchars($data['ketersediaan_stok']); ?>"><?php echo htmlspecialchars($data['ketersediaan_stok']); ?></option>
                        <?php if ($data['ketersediaan_stok'] == 'tersedia') { ?>
                            <option value="habis">Habis</option>
                        <?php } else { ?>
                            <option value="tersedia">Tersedia</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mt-20 d-flex justify-content-between">
                    <button class="btn btn-primary shadow" type="submit" name="editBtn">Edit</button>
                    <button class="btn btn-danger shadow" type="submit" name="deleteBtn">Hapus</button>
                </div>
            </form>

            <?php
            if (isset($_POST['editBtn'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                $target_dir = "../image/";
                $imageFileType = strtolower(pathinfo(basename($_FILES["foto"]["name"]), PATHINFO_EXTENSION));
                $random_name = generateRandomString(20);
                $target_file = $target_dir . $random_name . '.' . $imageFileType;

                if ($_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                        $querySimpan = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok', foto='$random_name.$imageFileType' WHERE id='$id'");
                    } else {
                        echo '<div class="alert alert-danger mt-3 shadow border-1px-solid-white" role="alert">Terjadi kesalahan saat mengupload foto.</div>';
                        exit;
                    }
                } else {
                    $querySimpan = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");
                }

                if ($querySimpan) {
                    echo '<div class="alert alert-success mt-3 shadow border-1px-solid-white" role="alert">Data berhasil diperbarui!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=menu.php" />';
                } else {
                    echo '<div class="alert alert-danger mt-3 shadow border-1px-solid-white" role="alert">Terjadi kesalahan saat memperbarui data: ' . mysqli_error($con) . '</div>';
                }
            }

            if (isset($_POST['deleteBtn'])) {
                $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");
                if ($queryDelete) {
                    echo '<div class="alert alert-success mt-3 shadow border-1px-solid-white" role="alert">Data berhasil dihapus!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=menu.php" />';
                } else {
                    echo '<div class="alert alert-danger mt-3 shadow border-1px-solid-white" role="alert">Terjadi kesalahan saat menghapus data: ' . mysqli_error($con) . '</div>';
                }
            }
            ?>
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
