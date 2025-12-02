<?php
session_start();
require_once __DIR__ . '/_functions.php';
require_once __DIR__ . '/_auth.php';

if (isLoggedIn()) {
    if (hasRole('Pelanggan')) {
        header('Location: ' . url('pelanggan/dashboard.php'));
    } else {
        header('Location: ' . url('dashboard.php'));
    }
    exit;
}

 $success = '';
 $error = '';

if (isset($_POST['register'])) {
    $result = registerPelanggan($_POST);
    
    if ($result['success']) {
        $success = $result['message'];
    } else {
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Kami | Daftar Akun</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/logo.png') ?>" type="image/x-icon">
    
    <style>
        .register-page .box-content {
            display: flex;
            justify-content: center; 
        }

        .register-page .col.box__left {
            width: 100%;
            max-width: 700px; 
            padding: 40px;
            flex-shrink: 0; 
        }

        .register-page .col.box__right {
            display: none;
        }
        
        .register-page .form-grid {
            display: flex;
            gap: 25px; 
        }

        .register-page .form-col-left,
        .register-page .form-col-right {
            flex: 1; 
        }

        .register-page .box__left-form {
            padding: 0;
        }

        .register-page .form-col .box__left-form-group:last-child {
            margin-bottom: 0;
        }

        .alert {
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    position: fixed;
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 70px;
    transition: var(--transition);
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.box1 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 90%;
    max-width: 400px;
    min-height: 100px;
    position: relative;
    padding: 30px 25px;
    background: var(--bg-primary);
    border-radius: var(--radius);
    box-shadow: var(--shadow-xl);
    border: 2px solid var(--border);
    animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes slideDown {
    0% {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.box1 p {
    color: var(--text-primary);
    font-size: 15px;
    text-align: center;
    line-height: 1.6;
    font-weight: 500;
}

.btn-alert {
    border: none;
    text-decoration: none;
    display: inline-block;
    margin-top: 20px;
    padding: 12px 32px;
    cursor: pointer;
    outline: none;
    border-radius: var(--radius-xs);
    text-transform: uppercase;
    transition: var(--transition);
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-md);
}

.btn-success {
    background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #047857 0%, var(--success) 100%);
}

.btn-fail {
    background: linear-gradient(135deg, var(--danger) 0%, #ef4444 100%);
    color: white;
}

.btn-fail:hover {
    background: linear-gradient(135deg, #b91c1c 0%, var(--danger) 100%);
}
    </style>
</head>
<body class="register-page"> 

    <?php if ($success) : ?>
<div class="alert">
    <div class="box1">
        <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
        <p><?= $success ?></p>
        <button onclick="window.location='<?= url('login.php') ?>'" class="btn-alert btn-success">Login Sekarang</button>
    </div>
</div>
<?php endif ?>

<?php if ($error) : ?>
<div class="alert">
    <div class="box1">
        <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
        <p><?= $error ?></p>
        <button onclick="window.location='<?= url('register.php') ?>'" class="btn-alert btn-fail">Coba Lagi</button>
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
                    <h4>Buat Akun Pelanggan</h4>
                </div>

                <div class="box__left-form">
                    <form action="" method="post">
                        <div class="form-grid">
                            <div class="form-col-left form-col">
                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="email" name="email" placeholder="Email" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="text" name="no_telp" placeholder="Nomor Telepon" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="text" name="alamat" placeholder="Alamat Lengkap" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-col-right form-col">
                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="text" name="username" placeholder="Username" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="password" name="password" placeholder="Password (min. 6 karakter)" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="box__left-form-group">
                                    <div class="input-form">
                                        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box__left-form-group">
                            <button type="submit" name="register" class="btn-login mt-1">Daftar</button>
                        </div>

                        <div class="box__left-form-group txt-center mt-1">
                            <p style="color: var(--text-secondary); font-size: 14px;">
                                Sudah punya akun? <a href="<?= url('login.php') ?>" style="color: var(--primary-light); text-decoration: none; font-weight: bold;">Login</a>
                            </p>
                        </div>

                        <div class="box__left-form-group txt-center">
                            <a href="<?= url('index.php') ?>" class="btn-back">← Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>