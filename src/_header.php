<?php
require_once('_functions.php');
require_once(__DIR__ . '/_auth.php');

// Proteksi: Hanya Admin/Karyawan
requireRole(['Admin', 'Karyawan']);

$user = getCurrentUser();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Laundry Kami | Dashboard</title>
	<link rel="stylesheet" href="<?= url('/assets/css/style.css') ?>">
	<link rel="shortcut icon" href="<?= url('/assets/img/logo/favicon.svg') ?>" type="image/x-icon">
</head>

<body>

	<header>
		<nav>
			<div class="logo">
				<a href="<?= url() ?>">
					<img src="<?= url('/assets/img/logo/logo.png') ?>" style="width: 120px;" alt="Laundry Kami">
				</a>
			</div>
			<ul class="nav-menu">
				<li>
					<!-- GANTI INI -->
					<span id="judul-sm">Halo! <?= $user['nama'] ?> (<?= $user['role'] ?>)</span>
					<ul class="dropdown-menu">
						<li><a href="<?= url('logout.php') ?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="nav-mini">
			<a href="<?= url('dashboard.php') ?>" class="link-nav">Dashboard</a>
			<a href="<?= url('riwayat_transaksi/riwayat.php') ?>" class="link-nav">Riwayat Transaksi</a>

			<!-- HANYA ADMIN YANG BISA MANAGE KARYAWAN -->

			<?php if (hasRole('Admin')) : ?>
				<a href="<?= url('karyawan/karyawan.php') ?>" class="link-nav">Manage Karyawan</a>
				<a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="link-nav">Manage Pelanggan</a>
			<?php endif ?>

			<a href="<?= url('paket/paket.php') ?>" class="link-nav">Daftar Paket</a>
			<a href="<?= url('about.php') ?>" class="link-nav">Tentang Kami</a>
			<a href="<?= url('logout.php') ?>" onclick="return confirm('Yakin ingin keluar?'); " class="link-nav">Logout</a>
		</div>
	</header>