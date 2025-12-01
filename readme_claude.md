ai claude

yang sudah dilakukan
<!-- 1 -->
1️⃣ Update Database Schema
Jalankan SQL ini di PHPMyAdmin:
-- 1. Tambah kolom role di tabel master (untuk Admin & Karyawan)
ALTER TABLE `master` 
MODIFY `level` ENUM('Admin', 'Karyawan') NOT NULL DEFAULT 'Karyawan';

-- 2. Buat tabel baru untuk pelanggan
CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `no_telp` VARCHAR(15) NOT NULL,
  `alamat` TEXT NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `foto_profil` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Tambah kolom id_pelanggan di tabel order (Foreign Key)
ALTER TABLE `tb_order_ck` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_order_ck`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

ALTER TABLE `tb_order_dc` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_order_dc`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

ALTER TABLE `tb_order_cs` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_order_cs`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

-- 4. Tambah kolom id_pelanggan di tabel riwayat
ALTER TABLE `tb_riwayat_ck` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_ck`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

ALTER TABLE `tb_riwayat_dc` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_dc`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

ALTER TABLE `tb_riwayat_cs` 
ADD COLUMN `id_pelanggan` INT(11) DEFAULT NULL AFTER `id_cs`,
ADD INDEX `idx_pelanggan` (`id_pelanggan`);

-- 5. Insert data pelanggan contoh
INSERT INTO `tb_pelanggan` 
(`nama_lengkap`, `email`, `no_telp`, `alamat`, `username`, `password`, `status`) 
VALUES 
('John Doe', 'john@customer.com', '081234567890', 'Jl. Contoh No. 123', 'johndoe', '$2y$10$rBG6s0gdPJDrNU9NXNxsAOGNIKDZAS..15cUo/i5xieIbcw2gxa1e', 'active'),
('Jane Smith', 'jane@customer.com', '081234567891', 'Jl. Pelanggan No. 456', 'janesmith', '$2y$10$rBG6s0gdPJDrNU9NXNxsAOGNIKDZAS..15cUo/i5xieIbcw2gxa1e', 'active');

-- Password default untuk testing: 'password123'

<!-- 2 -->
2️⃣ Buat File Konfigurasi Session & Auth
File: _auth.php (Buat file baru)
<?php
// Session management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

// Fungsi untuk cek role user
function hasRole($role) {
    if (!isLoggedIn()) return false;
    
    if (is_array($role)) {
        return in_array($_SESSION['user_role'], $role);
    }
    
    return $_SESSION['user_role'] === $role;
}

// Fungsi untuk redirect jika belum login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . url('login.php'));
        exit;
    }
}

// Fungsi untuk redirect jika tidak punya akses
function requireRole($role) {
    requireLogin();
    
    if (!hasRole($role)) {
        header('Location: ' . url('403.php')); // Forbidden page
        exit;
    }
}

// Fungsi untuk logout
function logout() {
    session_unset();
    session_destroy();
    header('Location: ' . url('login.php'));
    exit;
}

// Fungsi untuk get user info
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    return [
        'id' => $_SESSION['user_id'],
        'nama' => $_SESSION['user_nama'],
        'username' => $_SESSION['user_username'],
        'email' => $_SESSION['user_email'] ?? null,
        'role' => $_SESSION['user_role']
    ];
}
?>

<!-- 3 -->
3️⃣ Update File _function.php - Tambah Fungsi Auth
Tambahkan fungsi-fungsi ini di _function.php:
// ==========================================
// FUNGSI AUTHENTICATION & AUTHORIZATION
// ==========================================

// Login untuk Admin & Karyawan
function loginStaff($username, $password) {
    global $koneksi;
    
    $username = mysqli_real_escape_string($koneksi, $username);
    
    $query = "SELECT * FROM master WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['level'];
            $_SESSION['login_time'] = time();
            
            return true;
        }
    }
    
    return false;
}

// Login untuk Pelanggan
function loginPelanggan($username, $password) {
    global $koneksi;
    
    $username = mysqli_real_escape_string($koneksi, $username);
    
    $query = "SELECT * FROM tb_pelanggan WHERE username = '$username' AND status = 'active'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id_pelanggan'];
            $_SESSION['user_nama'] = $user['nama_lengkap'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = 'Pelanggan';
            $_SESSION['login_time'] = time();
            
            return true;
        }
    }
    
    return false;
}

// Register Pelanggan Baru
function registerPelanggan($data) {
    global $koneksi;
    
    $nama = htmlspecialchars($data['nama_lengkap']);
    $email = htmlspecialchars($data['email']);
    $no_telp = htmlspecialchars($data['no_telp']);
    $alamat = htmlspecialchars($data['alamat']);
    $username = htmlspecialchars($data['username']);
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];
    
    // Validasi
    if ($password !== $confirm_password) {
        return ['success' => false, 'message' => 'Password tidak cocok!'];
    }
    
    if (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password minimal 6 karakter!'];
    }
    
    // Cek username sudah ada
    $check_username = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE username = '$username'");
    if (mysqli_num_rows($check_username) > 0) {
        return ['success' => false, 'message' => 'Username sudah digunakan!'];
    }
    
    // Cek email sudah ada
    $check_email = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        return ['success' => false, 'message' => 'Email sudah terdaftar!'];
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert ke database
    $query = "INSERT INTO tb_pelanggan (nama_lengkap, email, no_telp, alamat, username, password, status) 
              VALUES ('$nama', '$email', '$no_telp', '$alamat', '$username', '$hashed_password', 'active')";
    
    if (mysqli_query($koneksi, $query)) {
        return ['success' => true, 'message' => 'Registrasi berhasil! Silakan login.'];
    }
    
    return ['success' => false, 'message' => 'Gagal mendaftar. Coba lagi.'];
}

// Get Pelanggan by ID
function getPelangganById($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $query = "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id'";
    $result = mysqli_query($koneksi, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

<!-- 4 -->
4️⃣ Buat Halaman Login Baru dengan Tab
File: login.php (Update yang sudah ada)
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

<!-- 5 -->
buat File register.php (Halaman Registrasi Pelanggan)
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
</head>
<body>

    <?php if ($success) : ?>
    <div class="overlay">
        <div class="boxSalah" style="background: #10b981;">
            <p style="color: white;"><?= $success ?></p>
            <a href="<?= url('login.php'); ?>" style="background: white; color: #10b981; padding: 8px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px; display: inline-block;">
                Login Sekarang
            </a>
        </div>
    </div>
    <?php endif ?>

    <?php if ($error) : ?>
    <div class="overlay">
        <div class="boxSalah">
            <a href="<?= url('register.php'); ?>" class="close">&times;</a>
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
                    <h4>Buat Akun Pelanggan</h4>
                </div>

                <div class="box__left-form">
                    <form action="" method="post">
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
            
            <div class="col box__right">
                <div class="box__right-content">
                    <div class="text__right">
                        <h1>Bergabung dengan Kami</h1>
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

