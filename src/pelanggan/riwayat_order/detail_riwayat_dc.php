<?php
$page_title = "Detail Riwayat Transaksi";
require_once('../_header_pelanggan.php');

$or_number = $_GET['or_number'];
$data = query("SELECT * FROM tb_riwayat_dc WHERE or_number = '$or_number'")[0];

if ($data['id_pelanggan'] != $user['id']) {
    header('Location: ' . url('403.php'));
    exit;
}
?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Detail Riwayat Transaksi</h2>
                    <p class="judul-sm">No Order: <?= $data['or_number'] ?></p>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card-md">
                    <div class="card-title">
                        <h2>Informasi Transaksi - Dry Clean</h2>
                    </div>
                    <div class="card-body">
                        <table class="tabel-detail">
                            <tr>
                                <td><strong>Nomor Order</strong></td>
                                <td><?= $data['or_number'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran</strong></td>
                                <td>
                                    <span style="
                                        background: <?= $data['status'] == 'Sukses' ? '#10b981' : '#fbbf24' ?>;
                                        color: white;
                                        padding: 8px 16px;
                                        border-radius: 8px;
                                        font-weight: 700;
                                        font-size: 14px;
                                    ">
                                        <?= $data['status'] == 'Sukses' ? '✓ LUNAS' : '⏳ PENDING' ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pelanggan</strong></td>
                                <td><?= $data['pelanggan'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>No Telepon</strong></td>
                                <td><?= $data['no_telp'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td><?= $data['alamat'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Paket</strong></td>
                                <td><span class="badge-primary"><?= $data['j_paket'] ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Waktu Kerja</strong></td>
                                <td><?= $data['wkt_kerja'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Berat</strong></td>
                                <td><?= $data['berat'] ?> Kg</td>
                            </tr>
                            <tr>
                                <td><strong>Harga per Kilo</strong></td>
                                <td>Rp. <?= number_format($data['h_perkilo'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Masuk</strong></td>
                                <td><?= $data['tgl_msk'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Selesai</strong></td>
                                <td><?= $data['tgl_klr'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td><?= $data['keterangan'] ?: '-' ?></td>
                            </tr>
                            <tr style="border-top: 3px solid #e5e7eb;">
                                <td><strong>Total Bayar</strong></td>
                                <td><h3 style="color: var(--primary); margin: 0;">Rp. <?= number_format($data['total'], 0, ',', '.') ?></h3></td>
                            </tr>
                            <tr>
                                <td><strong>Nominal Dibayar</strong></td>
                                <td>Rp. <?= number_format($data['nominal_byr'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Kembalian</strong></td>
                                <td>Rp. <?= number_format($data['kembalian'], 0, ',', '.') ?></td>
                            </tr>
                        </table>

                        <div class="form-footer" style="margin-top: 30px;">
                            <div class="buttons">
                                <a href="<?= url('pelanggan/riwayat_order/cetak_riwayat_dc.php?or_number=' . $data['or_number']) ?>" 
                                   class="btn-sm bg-primary" style="color: white;" target="_blank">
                                    Cetak Bukti Pembayaran
                                </a>
                                <a class="btn-sm bg-transparent" href="<?= url('pelanggan/riwayat_saya.php') ?>"> Kembali ke Riwayat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tabel-detail {
    width: 100%;
    border-collapse: collapse;
}
.tabel-detail tr {
    border-bottom: 1px solid #e5e7eb;
}
.tabel-detail td {
    padding: 15px 0;
}
.tabel-detail td:first-child {
    width: 220px;
    color: #6b7280;
}
.badge-primary {
    background: var(--primary);
    color: white;
    padding: 6px 16px;
    border-radius: 6px;
    font-weight: 600;
}
</style>
</body>
</html>