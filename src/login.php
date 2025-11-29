<?php
session_start();
require_once __DIR__ . '/_functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Kami | Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/logo.png') ?>" type="image/x-icon">
</head>

<body>

    <?php if (isset($_SESSION['login']) && isset($_SESSION['master'])) : ?>
        <script>
            window.location = '<?= url('dashboard.php') ?>'
        </script>
    <?php endif ?>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = mysqli_prepare($koneksi, "SELECT * FROM master WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $hasil = mysqli_fetch_assoc($result);

            if (password_verify($password, $hasil['password'])) {
                $_SESSION['master'] = $username;
                $_SESSION['login'] = true; ?>
                <script>
                    window.location = "<?= url('dashboard.php') ?>";
                </script>
            <?php
            } else { ?>
                <div class="overlay">
                    <div class="boxSalah">
                        <a href="<?= url('login.php'); ?>" class="close">&times;</a>
                        <p>Password Salah!</p>
                    </div>
                </div>
            <?php
            }
        } else { ?>
            <div class="overlay">
                <div class="boxSalah">
                    <a href="<?= url('login.php'); ?>" class="close">&times;</a>
                    <p>Username & password salah!</p>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <div class="box">
        <div class="box-content">
            <div class="col box__left">
                <div class="logo">
                    <img src="<?= url('assets/img/logo/logo.png') ?>" alt="">
                </div>
                <div class="box__left-title">
                    <h4>Login untuk masuk</h4>
                </div>

                <div class="box__left-form">
                    <form action="" method="post">
                        <div class="box__left-form-group">
                            <div class="input-form">
                                <input type="text" name="username" placeholder="Username" required autocomplete="off">
                            </div>
                        </div>

                        <div class="box__left-form-group">
                            <div class="input-form">
                                <input type="password" name="password" placeholder="Password" required autocomplete="off">
                            </div>
                        </div>

                        <div class="box__left-form-group">
                            <button type="submit" name="login" class="btn-login mt-1">Login</button>
                        </div>

                        <div class="box__left-form-group txt-center mt-1">
                            <a href="<?= url('index.php') ?>" class="btn-back">← Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col box__right">
                <div class="box__right-content">
                    <div class="text__right">
                        <h1>Admin Laundry</h1>
                    </div>
                    <img src="<?= url('assets/img/orang.png') ?>" alt="" class="box-img-orang">
                    <div class="bubble-1"></div>
                    <div class="bubble-2"></div>
                    <div class="bubble-3"></div>
                    <div class="bubble-4"></div>
                    <div class="bubble-5"></div>
                    <div class="bubble-6"></div>
                    <div class="garis garis-sm garis-1"></div>
                    <div class="garis garis-md garis-2"></div>
                    <div class="garis garis-sm garis-3"></div>
                    <div class="garis garis-md garis-4"></div>
                    <div class="garis garis-md garis-5"></div>
                    <div class="garis garis-lg garis-6"></div>
                    <div class="garis garis-lg garis-7"></div>
                    <div class="garis garis-xl garis-8"></div>
                    <div class="garis garis-sm garis-9"></div>
                    <div class="garis garis-md garis-10"></div>
                    <div class="garis garis-sm garis-11"></div>
                    <div class="garis garis-md garis-12"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>