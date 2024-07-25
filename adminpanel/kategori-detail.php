<?php
require "session.php";
require "../js/koneksi.php";

// Mengamankan data dari input
$id = mysqli_real_escape_string($con, $_GET['p']);

// Mengambil data kategori berdasarkan ID
$query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome-free-6.6.0-web/css/fontawesome.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
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
                    <a href="kategori.php" class="text-white no-decoration">
                        <i class="fa-solid fa-list text-white"></i> Kategori
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    Detail Kategori
                </li>
            </ol>
        </nav>
        <h2 class="text-white">Detail Kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori" class="text-white">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control mt-2" autocomplete="off" value="<?php echo htmlspecialchars($data['nama']); ?>">
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-primary shadow" type="submit" name="editBtn">Edit</button>
                    <button class="btn btn-danger shadow" type="submit" name="deleteBtn">Hapus</button>
                </div>
            </form>

            <?php
            if (isset($_POST['editBtn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                if ($data['nama'] == $kategori) {
                    ?>
                    <div class="alert alert-info mt-3 shadow border-1px-solid-white" role="alert">
                        Tidak ada perubahan pada kategori.
                    </div>
                    <meta http-equiv="refresh" content="1; url=kategori.php" />
                    <?php
                } else {
                    $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahData = mysqli_num_rows($query);

                    if ($jumlahData > 0) {
                        ?>
                        <div class="alert alert-warning mt-3 shadow border-1px-solid-white" role="alert">
                            Kategori telah tersedia
                        </div>
                        <?php
                    } else {
                        $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        if ($querySimpan) {
                            ?>
                            <div class="alert alert-success mt-3 shadow border-1px-solid-white" role="alert">
                                Kategori berhasil diupdate
                            </div>
                            <meta http-equiv="refresh" content="1; url=kategori.php" />
                            <?php
                        } else {
                            echo '<div class="alert alert-danger mt-3 shadow border-1px-solid-white" role="alert">
                                    Terjadi kesalahan: ' . mysqli_error($con) . '
                                  </div>';
                        }
                    }
                }
            }

            if (isset($_POST['deleteBtn'])) {
                // Cek apakah ada produk dengan kategori_id yang sama
                $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
                $dataCount = mysqli_num_rows($queryCheck);

                if ($dataCount > 0) {
                    ?>
                    <div class="alert alert-warning mt-3 shadow border-1px-solid-white" role="alert">
                        Kategori tidak bisa dihapus karena terdapat produk terkait.
                    </div>
                    <meta http-equiv="refresh" content="1; url=kategori.php" />
                    <?php
                } else {
                    $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");

                    if ($queryDelete) {
                        ?>
                        <div class="alert alert-success mt-3 shadow border-1px-solid-white" role="alert">
                            Kategori berhasil dihapus
                        </div>
                        <meta http-equiv="refresh" content="1; url=kategori.php" />
                        <?php
                    } else {
                        echo '<div class="alert alert-danger mt-3 shadow border-1px-solid-white" role="alert">
                                Terjadi kesalahan: ' . mysqli_error($con) . '
                              </div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../fontawesome/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>
</html>
