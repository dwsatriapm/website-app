<?php
 $page_title = "Order Saya";
require_once('_header_pelanggan.php');

 $id_pelanggan = $user['id'];

// --- AMBIL SEMUA DATA (AKTIF + RIWAYAT) ---
// (Logika yang sama dengan dashboard)
 $order_ck = query("SELECT 'CK' as tipe, id_order_ck as id, or_ck_number as no_order, nama_pel_ck as nama, jenis_paket_ck as paket, berat_qty_ck as qty, 'Kg' as satuan, tot_bayar as total, tgl_masuk_ck as tgl_masuk, tgl_keluar_ck as tgl_keluar, 'Menunggu Pembayaran' as status FROM tb_order_ck WHERE id_pelanggan = '$id_pelanggan'");
 $order_dc = query("SELECT 'DC' as tipe, id_order_dc as id, or_dc_number as no_order, nama_pel_dc as nama, jenis_paket_dc as paket, berat_qty_dc as qty, 'Kg' as satuan, tot_bayar as total, tgl_masuk_dc as tgl_masuk, tgl_keluar_dc as tgl_keluar, 'Menunggu Pembayaran' as status FROM tb_order_dc WHERE id_pelanggan = '$id_pelanggan'");
 $order_cs = query("SELECT 'CS' as tipe, id_order_cs as id, or_cs_number as no_order, nama_pel_cs as nama, jenis_paket_cs as paket, jml_pcs as qty, 'Pcs' as satuan, tot_bayar as total, tgl_masuk_cs as tgl_masuk, tgl_keluar_cs as tgl_keluar, 'Menunggu Pembayaran' as status FROM tb_order_cs WHERE id_pelanggan = '$id_pelanggan'");

 $riwayat_ck = query("SELECT 'CK' as tipe, id_ck as id, or_number as no_order, pelanggan as nama, j_paket as paket, berat as qty, 'Kg' as satuan, total, tgl_msk as tgl_masuk, tgl_klr as tgl_keluar, status FROM tb_riwayat_ck WHERE id_pelanggan = '$id_pelanggan'");
 $riwayat_dc = query("SELECT 'DC' as tipe, id_dc as id, or_number as no_order, pelanggan as nama, j_paket as paket, berat as qty, 'Kg' as satuan, total, tgl_msk as tgl_masuk, tgl_klr as tgl_keluar, status FROM tb_riwayat_dc WHERE id_pelanggan = '$id_pelanggan'");
 $riwayat_cs = query("SELECT 'CS' as tipe, id_cs as id, or_number as no_order, pelanggan as nama, j_paket as paket, jml_pcs as qty, 'Pcs' as satuan, total, tgl_msk as tgl_masuk, tgl_klr as tgl_keluar, status FROM tb_riwayat_cs WHERE id_pelanggan = '$id_pelanggan'");

 $semua_order = array_merge($order_ck, $order_dc, $order_cs, $riwayat_ck, $riwayat_dc, $riwayat_cs);
usort($semua_order, function ($a, $b) {
    $dateA = $a['tgl_masuk'];
    $dateB = $b['tgl_masuk'];
    return strtotime($dateB) - strtotime($dateA);
});
?>

<!-- PERBAIKAN: Notifikasi dengan gaya yang sama -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
            <p>Pembayaran berhasil! Order telah diproses.</p>
            <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-alert btn-success">OK</a>
        </div>
    </div>
<?php endif ?>

<?php if (isset($_GET['error'])) : ?>
    <?php if ($_GET['error'] == 'insufficient') : ?>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
                <p>Nominal pembayaran kurang.</p>
                <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-alert btn-fail">OK</a>
            </div>
        </div>
    <?php else : ?>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
                <p>Terjadi kesalahan, silakan coba lagi.</p>
                <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-alert btn-fail">OK</a>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Semua Order Saya</h2>
                    <p class="judul-sm">Daftar semua order Anda beserta statusnya</p>
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
                                            <th class="sticky">Status</th>
                                            <th class="sticky" style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($semua_order as $order) : ?>
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
                                                <td align="center">
                                                    <?php
                                                    // Tentukan URL detail
                                                    if ($order['status'] === 'Menunggu Pembayaran') {
    // Jika belum bayar → Akses halaman pelanggan
    if ($order['tipe'] == 'CK') {
        $detail_url = url('pelanggan/detail_order/detail_ck.php?or_ck_number=' . $order['no_order']);
    } elseif ($order['tipe'] == 'DC') {
        $detail_url = url('pelanggan/detail_order/detail_dc.php?or_dc_number=' . $order['no_order']);
    } else {
        $detail_url = url('pelanggan/detail_order/detail_cs.php?or_cs_number=' . $order['no_order']);
    }
} else {
    // Jika sudah bayar (Sukses/Lunas) → Akses riwayat pelanggan
    if ($order['tipe'] == 'CK') {
        $detail_url = url('pelanggan/riwayat_order/detail_riwayat_ck.php?or_number=' . $order['no_order']);
    } elseif ($order['tipe'] == 'DC') {
        $detail_url = url('pelanggan/riwayat_order/detail_riwayat_dc.php?or_number=' . $order['no_order']);
    } else {
        $detail_url = url('pelanggan/riwayat_order/detail_riwayat_cs.php?or_number=' . $order['no_order']);
    }
}
?>

                                                    <a href="<?= $detail_url ?>" class="btn btn-detail">Detail</a>

                                                    <!-- Tombol Bayar hanya muncul jika status "Menunggu Pembayaran" -->
                                                    <?php if ($order['status'] === 'Menunggu Pembayaran') : ?>
                                                        <button class="btn btn-cetak" onclick="tampilkanModalPembayaran('<?= strtolower($order['tipe']) ?>', '<?= $order['no_order'] ?>', '<?= $order['total'] ?>')">
                                                            Bayar
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="card-flex-column">
                                <img src="<?= url('assets/img/empty.png') ?>" width="150" alt="empty">
                                <p style="color: var(--text-secondary); margin-top: 20px; font-size: 16px;">Belum ada order</p>
                                <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-sm bg-primary" style="color: whitesmoke; margin-top: 15px;">Buat Order Sekarang</a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HTML Modal -->
<div id="modalPembayaran" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Pembayaran</h3>
            <span class="close-btn" onclick="tutupModalPembayaran()">&times;</span>
        </div>
        <form id="formPembayaran" action="proses_bayar.php" method="post">
            <div class="modal-body">
                <input type="hidden" name="tipe_order" id="tipe_order">
                <input type="hidden" name="no_order" id="no_order">
                <div class="form-group"><label>Total Tagihan:</label><input type="text" id="totalTagihan" readonly></div>
                <div class="form-group"><label for="nominal_bayar">Nominal Bayar:</label><input type="number" name="nominal_bayar" id="nominal_bayar" required></div>
                <div class="form-group"><label>Kembalian:</label><input type="text" id="kembalian" readonly></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="tutupModalPembayaran()">Batal</button>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </div>
        </form>
    </div>
</div>

<!-- CSS dan JavaScript Modal -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 99999 !important;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
        animation: fadeIn 0.3s;
    }

    .modal-content {
        position: relative;
        background-color: var(--bg-primary);
        margin: 5% auto;
        padding: 0;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        width: 90%;
        max-width: 500px;
        z-index: 100000 !important;
        animation: slideIn 0.4s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header,
    .modal-footer {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        justify-content: flex-end;
    }

    .modal-body {
        padding: 20px;
    }

    .close-btn {
        color: var(--text-secondary);
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover {
        color: var(--text-primary);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius-xs);
        background: var(--bg-secondary);
        color: var(--text-primary);
    }
</style>

<script>
    function tampilkanModalPembayaran(tipe, noOrder, total) {
        const modal = document.getElementById('modalPembayaran');
        if (!modal) {
            console.error("Modal tidak ditemukan!");
            return;
        }

        document.getElementById('tipe_order').value = tipe;
        document.getElementById('no_order').value = noOrder;
        document.getElementById('totalTagihan').value = 'Rp. ' + Number(total).toLocaleString('id-ID');
        document.getElementById('nominal_bayar').value = total;
        hitungKembalian();

        modal.style.display = 'block';
    }

    function tutupModalPembayaran() {
        document.getElementById('modalPembayaran').style.display = 'none';
    }

    function hitungKembalian() {
        const totalText = document.getElementById('totalTagihan').value;
        const total = parseInt(totalText.replace(/[^\d]/g, ''));
        const nominal = parseInt(document.getElementById('nominal_bayar').value) || 0;
        const kembalian = nominal - total;
        document.getElementById('kembalian').value = 'Rp. ' + kembalian.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nominalInput = document.getElementById('nominal_bayar');
        if (nominalInput) {
            nominalInput.addEventListener('input', hitungKembalian);
        }

        window.onclick = function (event) {
            const modal = document.getElementById('modalPembayaran');
            if (event.target == modal) {
                tutupModalPembayaran();
            }
        }
    });
</script>

</body>
</html>