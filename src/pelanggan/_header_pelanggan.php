<?php
// Path relatif dari folder pelanggan ke root
require_once(__DIR__ . '/../_functions.php');
require_once(__DIR__ . '/../_auth.php');

// Proteksi: Hanya pelanggan yang bisa akses
requireRole('Pelanggan');

 $user = getCurrentUser();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= isset($page_title) ? $page_title : 'Portal Pelanggan' ?> | Laundry Kami</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/favicon.svg') ?>" type="image/x-icon">
</head>
<body>

    <header>
        <nav>
            <div class="logo">
                <a href="<?= url('pelanggan/dashboard.php') ?>">
                    <img src="<?= url('assets/img/logo/logo.png') ?>" style="width: 120px;" alt="Laundry Kami">
                </a>
            </div>
            <ul class="nav-menu">
                <li>
                    <!-- Tampilkan nama dan role pelanggan -->
                    <span id="judul-sm">Halo! <?= $user['nama'] ?> (Pelanggan)</span>
                    <ul class="dropdown-menu">
                        <li><a href="<?= url('pelanggan/profil.php') ?>">Profil Saya</a></li>
                        <li><a href="<?= url('logout.php') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Navigasi Khusus Pelanggan -->
        <div id="nav-mini">
            <a href="<?= url('pelanggan/dashboard.php') ?>" class="link-nav">Dashboard</a>
            <a href="<?= url('pelanggan/buat_order.php') ?>" class="link-nav">Buat Order Baru</a>
            <a href="<?= url('pelanggan/order_saya.php') ?>" class="link-nav">Order Saya</a>
            <a href="<?= url('pelanggan/riwayat_saya.php') ?>" class="link-nav">Riwayat Transaksi</a>
            <a href="<?= url('pelanggan/profil.php') ?>" class="link-nav">Profil Saya</a>
            <a href="<?= url('logout.php') ?>" onclick="return confirm('Yakin ingin keluar?');" class="link-nav">Logout</a>
        </div>
    </header>