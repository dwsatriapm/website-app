<?php
require_once('db_connect.php');
require_once('_functions.php');
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
					<span id="judul-sm">Halo! <?= ucfirst($_SESSION['master']) ?></span>
					<ul class="dropdown-menu">
						<li><a href="<?= url('logout.php') ?>">Ganti Akun</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="nav-mini">
			<a href="<?= url('dashboard.php') ?>" class="link-nav">Dashboard</a>
			<a href="<?= url('riwayat_transaksi/riwayat.php') ?>" class="link-nav">Riwayat Transaksi</a>
			<a href="<?= url('karyawan/karyawan.php') ?>" class="link-nav">Manage Karyawan</a>
			<a href="<?= url('paket/paket.php') ?>" class="link-nav">Daftar Paket</a>
			<a href="<?= url('about.php') ?>" class="link-nav">Tentang Kami</a>
			<a href="<?= url('logout.php') ?>" onclick="return confirm('Yakin ingin keluar?'); " class="link-nav">Logout</a>
		</div>
	</header>