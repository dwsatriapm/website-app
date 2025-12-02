<?php
require_once('../_functions.php');
require_once('../_auth.php');

requireRole('Admin');

$id = $_GET['id'];

$pelanggan = getPelangganById($id);

if (!$pelanggan) {
    header('Location: ' . url('manage_pelanggan/pelanggan.php'));
    exit;
}

mysqli_query($koneksi, "DELETE FROM tb_order_ck WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_order_dc WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_order_cs WHERE id_pelanggan = '$id'");

mysqli_query($koneksi, "DELETE FROM tb_riwayat_ck WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_riwayat_dc WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_riwayat_cs WHERE id_pelanggan = '$id'");

$result = mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE id_pelanggan = '$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pelanggan</title>
    <link rel="stylesheet" href="<?= url('assets/css/payments.css') ?>">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/favicon.svg') ?>" type="image/x-icon">
</head>
<body>
    <?php if ($result) : ?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="sukses">
            <p>Akun pelanggan <strong><?= $pelanggan['nama_lengkap'] ?></strong> berhasil dihapus!</p>
            <a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="btn-alert btn-success">OK</a>
        </div>
    </div>
    <?php else : ?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="gagal">
            <p>Gagal menghapus akun pelanggan!</p>
            <a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="btn-alert btn-fail">OK</a>
        </div>
    </div>
    <?php endif ?>
</body>
</html>