<?php
 $page_title = "Dashboard Pelanggan";
require_once('_header_pelanggan.php');

 $id_pelanggan = $user['id'];

// --- AMBIL SEMUA DATA (AKTIF + RIWAYAT) ---

// 1. Ambil order aktif (belum dibayar)
 $order_ck = query("SELECT 'CK' as tipe, or_ck_number as no_order, jenis_paket_ck as paket, tot_bayar as total, tgl_masuk_ck as tgl_masuk, 'Menunggu Pembayaran' as status FROM tb_order_ck WHERE id_pelanggan = '$id_pelanggan'");
 $order_dc = query("SELECT 'DC' as tipe, or_dc_number as no_order, jenis_paket_dc as paket, tot_bayar as total, tgl_masuk_dc as tgl_masuk, 'Menunggu Pembayaran' as status FROM tb_order_dc WHERE id_pelanggan = '$id_pelanggan'");
 $order_cs = query("SELECT 'CS' as tipe, or_cs_number as no_order, jenis_paket_cs as paket, tot_bayar as total, tgl_masuk_cs as tgl_masuk, 'Menunggu Pembayaran' as status FROM tb_order_cs WHERE id_pelanggan = '$id_pelanggan'");

// 2. Ambil riwayat (sudah dibayar/selesai)
 $riwayat_ck = query("SELECT 'CK' as tipe, or_number as no_order, j_paket as paket, total, tgl_msk as tgl_masuk, status FROM tb_riwayat_ck WHERE id_pelanggan = '$id_pelanggan'");
 $riwayat_dc = query("SELECT 'DC' as tipe, or_number as no_order, j_paket as paket, total, tgl_msk as tgl_masuk, status FROM tb_riwayat_dc WHERE id_pelanggan = '$id_pelanggan'");
 $riwayat_cs = query("SELECT 'CS' as tipe, or_number as no_order, j_paket as paket, total, tgl_msk as tgl_masuk, status FROM tb_riwayat_cs WHERE id_pelanggan = '$id_pelanggan'");

// 3. Gabungkan semua data
 $semua_transaksi = array_merge($order_ck, $order_dc, $order_cs, $riwayat_ck, $riwayat_dc, $riwayat_cs);

// 4. Urutkan berdasarkan tanggal
usort($semua_transaksi, function($a, $b) {
    $dateA = $a['tgl_masuk'];
    $dateB = $b['tgl_masuk'];
    return strtotime($dateB) - strtotime($dateA);
});

// 5. Ambil 5 transaksi terbaru untuk ditampilkan
 $order_terbaru = array_slice($semua_transaksi, 0, 5);

// Hitung ulang statistik
 $total_order = 0;
 $total_riwayat = 0;
foreach ($semua_transaksi as $trans) {
    if ($trans['status'] === 'Menunggu Pembayaran') {
        $total_order++;
    } else {
        $total_riwayat++;
    }
}
?>

<div class="main-content">
    <div class="container">
        <!-- WELCOME SECTION -->
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <p class="judul-sm">Selamat Datang, <span><?= $user['nama'] ?></span></p>
                    <h2 class="judul-md">PORTAL PELANGGAN</h2>
                </div>
                <div class="col-header txt-right">
                    <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-lg bg-primary" style="color: whitesmoke;">+ Buat Order Baru</a>
                </div>
            </div>
        </div>

        <!-- STATISTIK CARDS -->
        <div class="baris">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Order Aktif</p>
                                <h2><?= $total_order ?></h2>
                            </div>
                            <div class="panel-icon">
                                <img src="<?= url('assets/img/order_pelanggan.png') ?>" width="68" alt="icon order">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Riwayat Transaksi</p>
                                <h2><?= $total_riwayat ?></h2>
                            </div>
                            <div class="panel-icon">
                                <img src="<?= url('assets/img/riwayat_pelanggan.png') ?>" width="68" alt="icon riwayat">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Order Selesai</p>
                                <h2><?= $total_riwayat ?></h2>
                            </div>
                            <div class="panel-icon">
                                <img src="<?= url('assets/img/selesai_pelanggan.png') ?>" width="68" alt="icon success">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ORDER TERBARU -->
        <div class="baris">
            <div class="col mt-2">
                <div class="card">
                    <div class="card-title card-flex">
                        <div class="card-col">
                            <h2>Transaksi Terbaru</h2>
                        </div>
                        <div class="card-col txt-right">
                            <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-xs bg-primary" style="color: whitesmoke;">Lihat Semua</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($order_terbaru)) : ?>
                        <div class="tabel-kontainer" style="height: auto;">
                            <table class="tabel-transaksi">
                                <thead>
                                    <tr>
                                        <th class="sticky">No Order</th>
                                        <th class="sticky">Tipe</th>
                                        <th class="sticky">Paket</th>
                                        <th class="sticky">Tanggal</th>
                                        <th class="sticky">Total</th>
                                        <th class="sticky">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_terbaru as $order) : ?>
                                    <tr>
                                        <td><?= $order['no_order'] ?></td>
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
                                        <td><?= date('d/m/Y', strtotime($order['tgl_masuk'])) ?></td>
                                        <td>Rp. <?= number_format($order['total'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php
                                            // Tampilkan status dengan class yang sesuai
                                            $status_class = 'status-pending';
                                            if ($order['status'] === 'Sukses' || $order['status'] === 'Lunas') {
                                                $status_class = 'status-lunas';
                                            } elseif ($order['status'] === 'Diproses') {
                                                $status_class = 'status-process';
                                            }
                                            ?>
                                            <span class="<?= $status_class ?>"><?= htmlspecialchars($order['status']) ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                        <div class="card-flex-column">
                            <img src="<?= url('assets/img/empty.png') ?>" width="150" alt="empty">
                            <p style="color: var(--text-secondary); margin-top: 20px;">Belum ada transaksi</p>
                            <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-sm bg-primary" style="color: whitesmoke; margin-top: 10px;">Buat Order Sekarang</a>
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