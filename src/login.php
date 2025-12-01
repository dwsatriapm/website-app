<?php
session_start();
require_once __DIR__ . '/_functions.php';
require_once __DIR__ . '/_auth.php';

// Redirect jika sudah login
if (isLoggedIn()) {
    if (hasRole('Pelanggan')) {
        header('Location: ' . url('pelanggan/dashboard.php'));
    } else {
        header('Location: ' . url('dashboard.php'));
    }
    exit;
}

$error = '';
$login_type = isset($_POST['login_type']) ? $_POST['login_type'] : 'staff';

// Proses Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login_type = $_POST['login_type'];

    if ($login_type === 'staff') {
        // Login Admin/Karyawan (KODE LAMA DIGANTI)
        if (loginStaff($username, $password)) {
            header('Location: ' . url('dashboard.php'));
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        // Login Pelanggan (FITUR BARU)
        if (loginPelanggan($username, $password)) {
            header('Location: ' . url('pelanggan/dashboard.php'));
            exit;
        } else {
            $error = 'Username atau password salah atau akun tidak aktif!';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Kami | Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/logo.png') ?>" type="image/x-icon">
    <style>
        /* Tab Switcher Style */
        .login-tabs {
            display: flex;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--border);
            gap: 10px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            border-radius: var(--radius-xs) var(--radius-xs) 0 0;
        }

        .tab-btn.active {
            color: var(--primary-light);
            background: rgba(99, 102, 241, 0.1);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-light);
        }

        .tab-btn:hover {
            color: var(--primary-light);
            background: rgba(99, 102, 241, 0.05);
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 14px;
        }

        .register-link a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }

        .register-link a:hover {
            color: var(--text-primary);
        }
    </style>
</head>

<body>

    <?php if ($error) : ?>
        <div class="overlay">
            <div class="boxSalah">
                <a href="<?= url('login.php'); ?>" class="close">&times;</a>
                <p><?= $error ?></p>
            </div>
        </div>
    <?php endif ?>

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
                    <!-- TAB SWITCHER - FITUR BARU -->
                    <div class="login-tabs">
                        <button type="button" class="tab-btn active" onclick="switchTab('staff', this)">
                            🔑 Staff/Admin
                        </button>
                        <button type="button" class="tab-btn" onclick="switchTab('customer', this)">
                            👤 Pelanggan
                        </button>
                    </div>

                    <form action="" method="post">
                        <!-- HIDDEN INPUT UNTUK LOGIN TYPE -->
                        <input type="hidden" name="login_type" id="login_type" value="staff">

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

                        <!-- LINK REGISTER - TAMPIL HANYA UNTUK PELANGGAN -->
                        <div class="register-link" id="register-link" style="display: none;">
                            Belum punya akun? <a href="<?= url('register.php') ?>">Daftar di sini</a>
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
                        <h1 id="title-right">Admin Laundry</h1>
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

    <script>
        function switchTab(type, element) {
            const loginType = document.getElementById('login_type');
            const tabs = document.querySelectorAll('.tab-btn');
            const registerLink = document.getElementById('register-link');
            const titleRight = document.getElementById('title-right');

            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            element.classList.add('active');

            // Update hidden input
            loginType.value = type;

            // Show/hide register link & change title
            if (type === 'customer') {
                registerLink.style.display = 'block';
                titleRight.textContent = 'Portal Pelanggan';
            } else {
                registerLink.style.display = 'none';
                titleRight.textContent = 'Admin Laundry';
            }
        }
    </script>
</body>

</html>