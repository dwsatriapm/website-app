<?php
$page_title = "Riwayat Transaksi Saya";
require_once('_header_pelanggan.php');

$id_pelanggan = $user['id'];

// Ambil riwayat transaksi pelanggan (sudah dibayar)
$riwayat_ck = query("SELECT 'CK' as tipe, id_ck as id, or_number as no_order, pelanggan as nama, j_paket as paket, berat as qty, 'Kg' as satuan, total, nominal_byr, kembalian, status, tgl_msk, tgl_klr FROM tb_riwayat_ck WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_ck DESC");

$riwayat_dc = query("SELECT 'DC' as tipe, id_dc as id, or_number as no_order, pelanggan as nama, j_paket as paket, berat as qty, 'Kg' as satuan, total, nominal_byr, kembalian, status, tgl_msk, tgl_klr FROM tb_riwayat_dc WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_dc DESC");

$riwayat_cs = query("SELECT 'CS' as tipe, id_cs as id, or_number as no_order, pelanggan as nama, j_paket as paket, jml_pcs as qty, 'Pcs' as satuan, total, nominal_byr, kembalian, status, tgl_msk, tgl_klr FROM tb_riwayat_cs WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_cs DESC");

$semua_riwayat = array_merge($riwayat_ck, $riwayat_dc, $riwayat_cs);
usort($semua_riwayat, function($a, $b) {
    return $b['id'] - $a['id'];
});
?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Riwayat Transaksi</h2>
                    <p class="judul-sm">Daftar transaksi yang sudah selesai</p>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($semua_riwayat)) : ?>
                        <div class="tabel-kontainer">
                            <table class="tabel-transaksi">
                                <thead>
                                    <tr>
                                        <th class="sticky">No</th>
                                        <th class="sticky">No Order</th>
                                        <th class="sticky">Tipe</th>
                                        <th class="sticky">Paket</th>
                                        <th class="sticky">Jumlah</th>
                                        <th class="sticky">Total Bayar</th>
                                        <th class="sticky">Uang Dibayar</th>
                                        <th class="sticky">Kembalian</th>
                                        <th class="sticky">Status</th>
                                        <th class="sticky">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($semua_riwayat as $riwayat) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= $riwayat['no_order'] ?></strong></td>
                                        <td>
                                            <span style="
                                                background: <?= $riwayat['tipe'] == 'CK' ? '#4338ca' : ($riwayat['tipe'] == 'DC' ? '#059669' : '#0891b2') ?>;
                                                color: white;
                                                padding: 4px 12px;
                                                border-radius: 6px;
                                                font-weight: 600;
                                                font-size: 12px;
                                            ">
                                                <?= $riwayat['tipe'] == 'CK' ? 'Cuci Komplit' : ($riwayat['tipe'] == 'DC' ? 'Dry Clean' : 'Cuci Satuan') ?>
                                            </span>
                                        </td>
                                        <td><?= $riwayat['paket'] ?></td>
                                        <td><?= $riwayat['qty'] ?> <?= $riwayat['satuan'] ?></td>
                                        <td><strong>Rp. <?= number_format($riwayat['total'], 0, ',', '.') ?></strong></td>
                                        <td>Rp. <?= number_format($riwayat['nominal_byr'], 0, ',', '.') ?></td>
                                        <td>Rp. <?= number_format($riwayat['kembalian'], 0, ',', '.') ?></td>
                                        <td><span class="status-lunas"><?= $riwayat['status'] ?></span></td>
                                        <td><?= $riwayat['tgl_msk'] ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                        <div class="card-flex-column">
                            <img src="<?= url('assets/img/empty.png') ?>" width="150" alt="empty">
                            <p style="color: var(--text-secondary); margin-top: 20px; font-size: 16px;">Belum ada riwayat transaksi</p>
                            <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-sm bg-primary" style="color: whitesmoke; margin-top: 15px;">Buat Order Pertama</a>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>