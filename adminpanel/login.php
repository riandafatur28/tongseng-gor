<?php
    session_start();
    require "../js/koneksi.php";

    // Pastikan koneksi berhasil
    if (!$con) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    if (isset($_POST['loginbtn'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Menggunakan prepared statements untuk menghindari SQL injection
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (password_verify($password, $data['password'])) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['login'] = true;
                header('Location: ../adminpanel');
                exit(); // Menghentikan eksekusi lebih lanjut setelah redirect
            } else {
                $error_message = "Password Anda Salah!";
            }
        } else {
            $error_message = "Akun Anda tidak tersedia!";
        }

        $stmt->close();
    }

    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tongseng Ngarep Gor</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <style>
        .main {
            height: 100vh;
            width: 100%;
            background-image: url('../image/background_login.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            text-align: center; /* Center align text */
        }


        .login-box {
            width: 500px;
            max-width: 90vw; /* Mengatur lebar maksimum agar responsif */
            margin: 0 auto;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.6); /* Warna latar belakang box */
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        @media (max-width: 600px) {
            .login-box {
                padding: 5px;
            }
        }

        .form-group label {
            font-family: 'Poppins', sans-serif;
            color: green;
            font-weight: bold;
        }

        .form-group input {
            font-family: 'Poppins', sans-serif;
            color: green;
        }

        .alert {
            width: 500px;
            text-align: center;
            margin: 10px auto;
        }

        .link p {
            color: white; /* Warna teks p */
        }

        .link span {
            color: blue; /* Warna teks span */
            text-decoration: underline; /* Garis bawah pada span */
        }

        .link span a {
            color: blue; /* Warna tautan */
            text-decoration: none; /* Menghapus garis bawah default tautan */
        }

        .link span a:hover {
            text-decoration: underline; /* Garis bawah saat hover */
        }
    </style>
</head>
<body>
    <div class="main">
    <div class="content">
    <h1 class="text-white">Login</h1>
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
            </form>

            <?php if (isset($error_message)) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
                <div class="link mt-3">
                    <p>Belum Punya Akun? <span><a href="register.php"> Buat Akun</a></span></p>
                </div>
                <div class="link mt-3">
                    <p>Lupa Password? <span><a href="lupapassword.php"> Ubah</a></span></p>
                </div>
    </div>
    </div>
</body>
</html>
