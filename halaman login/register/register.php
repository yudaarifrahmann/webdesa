<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMc6VI7dWrZmy4y64yQQYKVJZXFsm6ZX7R6ibkR" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
require('koneksi.php');
session_start();

$error = '';
$validate = '';
if (isset($_SESSION['user'])) header('Location: ../halaman login/admin/admindesa/index.php');


if (isset($_POST['submit'])) {
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $name = stripslashes($_POST['name']);
    $name = mysqli_real_escape_string($con, $name);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $repass = stripslashes($_POST['repassword']);
    $repass = mysqli_real_escape_string($con, $repass);

    
    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
        if ($password == $repass) {
            if (cek_nama($username, $con) == 0) {
                $pass = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (username, name, email, password) VALUES ('$username', '$name', '$email', '$pass')";
                $result = mysqli_query($con, $query);
               
                if ($result) {
                    echo "<div class='text-center animate__animated animate__fadeIn'>
                            <svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'>
                                <circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/>
                                <path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/>
                            </svg>
                            <p>Register Berhasil! Mengalihkan ke halaman login...</p>
                          </div>";
                    
                    
                    header("refresh:2;url=login.php");
                    exit();             
                } else {
                    $error = 'Register User Gagal !!';
                }
            } else {
                $error = 'Username sudah terdaftar !!';
            }
        } else {
            $validate = 'Password tidak sama !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}

function cek_nama($username, $con) {
    $nama = mysqli_real_escape_string($con, $username);
    $query = "SELECT * FROM users WHERE username = '$nama'";
    if ($result = mysqli_query($con, $query)) return mysqli_num_rows($result);
}
?>
<section class="container-fluid mb-4">
    <section class="row justify-content-center">
        <section class="col-12 col-sm-6 col-md-4">
            <form class="form-container" action="register.php" method="POST">
                <h4 class="text-center font-weight-bold">Sign-Up</h4>
                <?php if ($error != '') { ?>
                    <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                <?php } ?>

                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="InputEmail" name="email" aria-describedby="emailHelp" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                    <?php if ($validate != '') { ?>
                        <p class="text-danger"><?= $validate; ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-Password">
                    <?php if ($validate != '') { ?>
                        <p class="text-danger"><?= $validate; ?></p>
                    <?php } ?>
                </div>
                <div class="button-container">
                    <button type="submit" name="submit" class="btn btn-register btn-block">Register</button>
                    <a href="login.php" class="btn btn-primary btn-block">
                        Login <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </form>
        </section>
    </section>
</section>

<!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan yang terakhir Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
