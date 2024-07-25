<?php
session_start();
require "../js/koneksi.php";

// Pastikan koneksi berhasil
if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['resetbtn'])) {
    $username = htmlspecialchars($_POST['username']);
    $new_password = htmlspecialchars($_POST['new_password']);

    // Hash password baru
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Menggunakan prepared statements untuk menghindari SQL injection
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username ditemukan, perbarui password
        $stmt = $con->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $username);

        if ($stmt->execute()) {
            $success_message = "Password berhasil diperbarui. Anda akan dialihkan ke halaman login.";
            header('Refresh: 2; url=login.php'); // Mengalihkan ke halaman login setelah 2 detik
            exit(); // Menghentikan eksekusi lebih lanjut setelah redirect
        } else {
            $error_message = "Terjadi kesalahan: " . mysqli_error($con);
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }

    $stmt->close();
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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
            padding: 2rem;
            border-radius: 0.5rem;
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
    </style>
</head>
<body>
    <div class="main">
        <div class="content">
            <h1 class="text-white">Lupa Password</h1>
            <div class="login-box p-5 shadow">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                    </div>
                    <div>
                        <button class="btn btn-success form-control mt-3" type="submit" name="resetbtn">Reset Password</button>
                    </div>
                </form>

                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php elseif (isset($success_message)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
