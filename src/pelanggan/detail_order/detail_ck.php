<?php
$page_title = "Detail Order";
require_once('../_header_pelanggan.php');

$or_number = $_GET['or_ck_number'];
$data = query("SELECT * FROM tb_order_ck WHERE or_ck_number = '$or_number'")[0];

// VALIDASI: Pelanggan hanya bisa lihat order miliknya
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
                    <h2 class="judul-md">Detail Order</h2>
                    <p class="judul-sm">No Order: <?= $data['or_ck_number'] ?></p>
                </div>
                <div class="col-header txt-right">
                    <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-xs bg-transparent">← Kembali</a>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card-md">
                    <div class="card-title">
                        <h2>Informasi Order - Cuci Komplit</h2>
                    </div>
                    <div class="card-body">
                        <table class="tabel-detail">
                            <tr>
                                <td><strong>Nomor Order</strong></td>
                                <td><?= $data['or_ck_number'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pelanggan</strong></td>
                                <td><?= $data['nama_pel_ck'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>No Telepon</strong></td>
                                <td><?= $data['no_telp_ck'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td><?= $data['alamat_ck'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Paket</strong></td>
                                <td><span class="badge-primary"><?= $data['jenis_paket_ck'] ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Waktu Kerja</strong></td>
                                <td><?= $data['wkt_krj_ck'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Berat</strong></td>
                                <td><?= $data['berat_qty_ck'] ?> Kg</td>
                            </tr>
                            <tr>
                                <td><strong>Harga per Kilo</strong></td>
                                <td>Rp. <?= number_format($data['harga_perkilo'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Masuk</strong></td>
                                <td><?= date('d F Y', strtotime($data['tgl_masuk_ck'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estimasi Selesai</strong></td>
                                <td><?= date('d F Y', strtotime($data['tgl_keluar_ck'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td><?= $data['keterangan_ck'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Bayar</strong></td>
                                <td><h3 style="color: var(--primary); margin: 0;">Rp. <?= number_format($data['tot_bayar'], 0, ',', '.') ?></h3></td>
                            </tr>
                        </table>

                        <div class="form-footer" style="margin-top: 30px;">
                            <div class="buttons">
                                <a href="<?= url('detail_order/detail_ck/bayar.php?or_ck_number=' . $data['or_ck_number']) ?>" 
                                   class="btn-sm bg-success" style="color: white;">
                                    💳 Bayar Sekarang
                                </a>
                                <a href="<?= url('pelanggan/detail_order/cetak_ck.php?or_ck_number=' . $data['or_ck_number']) ?>" 
                                   class="btn-sm bg-primary" style="color: white;" target="_blank">
                                    🖨️ Cetak Nota
                                </a>
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
    width: 200px;
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

<footer>
    <p>&copy; 2025 Laundry Kami. All rights reserved.</p>
</footer>
</body>
</html>