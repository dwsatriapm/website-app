<?php
require_once('../_functions.php');
require_once('../_auth.php');

// Proteksi: Hanya Admin
requireRole('Admin');

$id = $_GET['id'];

// Hapus semua data terkait pelanggan
$pelanggan = getPelangganById($id);

if (!$pelanggan) {
    header('Location: ' . url('manage_pelanggan/pelanggan.php'));
    exit;
}

// Hapus order pelanggan
mysqli_query($koneksi, "DELETE FROM tb_order_ck WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_order_dc WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_order_cs WHERE id_pelanggan = '$id'");

// Hapus riwayat pelanggan
mysqli_query($koneksi, "DELETE FROM tb_riwayat_ck WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_riwayat_dc WHERE id_pelanggan = '$id'");
mysqli_query($koneksi, "DELETE FROM tb_riwayat_cs WHERE id_pelanggan = '$id'");

// Hapus akun pelanggan
$result = mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE id_pelanggan = '$id'");

if ($result) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="<?= url('assets/css/payment.css') ?>">
    </head>
    <body>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="sukses">
                <p>Akun pelanggan berhasil dihapus!</p>
                <a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="btn-alert btn-success">OK</a>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="<?= url('assets/css/payment.css') ?>">
    </head>
    <body>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="gagal">
                <p>Gagal menghapus akun pelanggan!</p>
                <a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="btn-alert btn-fail">OK</a>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>