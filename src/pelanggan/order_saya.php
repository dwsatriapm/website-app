<?php
$page_title = "Order Saya";
require_once('_header_pelanggan.php');

$id_pelanggan = $user['id'];

// Ambil semua order pelanggan (belum dibayar)
$order_ck = query("SELECT 'CK' as tipe, id_order_ck as id, or_ck_number as no_order, nama_pel_ck as nama, jenis_paket_ck as paket, berat_qty_ck as qty, 'Kg' as satuan, tot_bayar as total, tgl_masuk_ck as tgl_masuk, tgl_keluar_ck as tgl_keluar FROM tb_order_ck WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_order_ck DESC");

$order_dc = query("SELECT 'DC' as tipe, id_order_dc as id, or_dc_number as no_order, nama_pel_dc as nama, jenis_paket_dc as paket, berat_qty_dc as qty, 'Kg' as satuan, tot_bayar as total, tgl_masuk_dc as tgl_masuk, tgl_keluar_dc as tgl_keluar FROM tb_order_dc WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_order_dc DESC");

$order_cs = query("SELECT 'CS' as tipe, id_order_cs as id, or_cs_number as no_order, nama_pel_cs as nama, jenis_paket_cs as paket, jml_pcs as qty, 'Pcs' as satuan, tot_bayar as total, tgl_masuk_cs as tgl_masuk, tgl_keluar_cs as tgl_keluar FROM tb_order_cs WHERE id_pelanggan = '$id_pelanggan' ORDER BY id_order_cs DESC");

$semua_order = array_merge($order_ck, $order_dc, $order_cs);
usort($semua_order, function($a, $b) {
    return strtotime($b['tgl_masuk']) - strtotime($a['tgl_masuk']);
});
?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Order Saya</h2>
                    <p class="judul-sm">Daftar order yang belum dibayar</p>
                </div>
                <div class="col-header txt-right">
                    <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-lg bg-primary" style="color: whitesmoke;">+ Order Baru</a>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($semua_order)) : ?>
                        <div class="tabel-kontainer">
                            <table class="tabel-transaksi">
                                <thead>
                                    <tr>
                                        <th class="sticky">No</th>
                                        <th class="sticky">No Order</th>
                                        <th class="sticky">Tipe</th>
                                        <th class="sticky">Paket</th>
                                        <th class="sticky">Jumlah</th>
                                        <th class="sticky">Total</th>
                                        <th class="sticky">Tanggal Masuk</th>
                                        <th class="sticky">Estimasi Selesai</th>
                                        <th class="sticky" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($semua_order as $order) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= $order['no_order'] ?></strong></td>
                                        <td>
                                            <span style="
                                                background: <?= $order['tipe'] == 'CK' ? '#4338ca' : ($order['tipe'] == 'DC' ? '#059669' : '#0891b2') ?>;
                                                color: white;
                                                padding: 4px 12px;
                                                border-radius: 6px;
                                                font-weight: 600;
                                                font-size: 12px;
                                            ">
                                                <?= $order['tipe'] == 'CK' ? 'Cuci Komplit' : ($order['tipe'] == 'DC' ? 'Dry Clean' : 'Cuci Satuan') ?>
                                            </span>
                                        </td>
                                        <td><?= $order['paket'] ?></td>
                                        <td><?= $order['qty'] ?> <?= $order['satuan'] ?></td>
                                        <td><strong>Rp. <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($order['tgl_masuk'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($order['tgl_keluar'])) ?></td>
                                        <td align="center">
                                            <?php
                                            // Tentukan URL detail berdasarkan tipe
                                            if ($order['tipe'] == 'CK') {
                                                $detail_url = url('detail_order/detail_ck/detail_order_ck.php?or_ck_number=' . $order['no_order']);
                                                $bayar_url = url('detail_order/detail_ck/bayar.php?or_ck_number=' . $order['no_order']);
                                            } elseif ($order['tipe'] == 'DC') {
                                                $detail_url = url('detail_order/detail_dc/detail_order_dc.php?or_dc_number=' . $order['no_order']);
                                                $bayar_url = url('detail_order/detail_dc/bayar.php?or_dc_number=' . $order['no_order']);
                                            } else {
                                                $detail_url = url('detail_order/detail_cs/detail_order_cs.php?or_cs_number=' . $order['no_order']);
                                                $bayar_url = url('detail_order/detail_cs/bayar.php?or_cs_number=' . $order['no_order']);
                                            }
                                            ?>
                                            
                                            <a href="<?= $detail_url ?>" class="btn btn-detail">Detail</a>
                                            <a href="<?= $bayar_url ?>" class="btn btn-cetak">Bayar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                        <div class="card-flex-column">
                            <img src="<?= url('assets/img/empty.png') ?>" width="150" alt="empty">
                            <p style="color: var(--text-secondary); margin-top: 20px; font-size: 16px;">Belum ada order aktif</p>
                            <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-sm bg-primary" style="color: whitesmoke; margin-top: 15px;">Buat Order Sekarang</a>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 Laundry Kami. All rights reserved.</p>
</footer>
</body>
</html>