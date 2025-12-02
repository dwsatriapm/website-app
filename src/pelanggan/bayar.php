<?php
session_start();
require_once __DIR__ . '/../../_functions.php';
require_once __DIR__ . '/../../_auth.php';

requireRole('Pelanggan');

 $user = getCurrentUser();
 $id_pelanggan = $user['id'];

 $tipe_order = '';
 $no_order = '';
 $order_data = null;

if (isset($_GET['or_ck_number'])) {
    $tipe_order = 'ck';
    $no_order = mysqli_real_escape_string($koneksi, $_GET['or_ck_number']);
    $query = "SELECT * FROM tb_order_ck WHERE or_ck_number = '$no_order' AND id_pelanggan = '$id_pelanggan'";
} elseif (isset($_GET['or_dc_number'])) {
    $tipe_order = 'dc';
    $no_order = mysqli_real_escape_string($koneksi, $_GET['or_dc_number']);
    $query = "SELECT * FROM tb_order_dc WHERE or_dc_number = '$no_order' AND id_pelanggan = '$id_pelanggan'";
} elseif (isset($_GET['or_cs_number'])) {
    $tipe_order = 'cs';
    $no_order = mysqli_real_escape_string($koneksi, $_GET['or_cs_number']);
    $query = "SELECT * FROM tb_order_cs WHERE or_cs_number = '$no_order' AND id_pelanggan = '$id_pelanggan'";
}

if (!$tipe_order || !$query) {
    header('Location: ' . url('pelanggan/order_saya.php?error=not_found'));
    exit;
}

 $result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) !== 1) {
    header('Location: ' . url('pelanggan/order_saya.php?error=not_found'));
    exit;
}

 $order_data = mysqli_fetch_assoc($result);

 $success_message = '';
 $error_message = '';

if (isset($_POST['bayar'])) {
    $nominal_bayar = (int)$_POST['nominal_bayar'];
    $total_tagihan = $order_data['tot_bayar'];

    if ($nominal_bayar < $total_tagihan) {
        $error_message = "Nominal pembayaran kurang!";
    } else {
        $data_transaksi = [
            'or_number' => $no_order,
            'pelanggan' => $order_data['nama_pel_ck'] ?? $order_data['nama_pel_dc'] ?? $order_data['nama_pel_cs'],
            'no_telp' => $order_data['no_telp_ck'] ?? $order_data['no_telp_dc'] ?? $order_data['no_telp_cs'],
            'alamat' => $order_data['alamat_ck'] ?? $order_data['alamat_dc'] ?? $order_data['alamat_cs'],
            'j_paket' => $order_data['jenis_paket_ck'] ?? $order_data['jenis_paket_dc'] ?? $order_data['jenis_paket_cs'],
            'wkt_kerja' => $order_data['wkt_krj_ck'] ?? $order_data['wkt_krj_dc'] ?? $order_data['wkt_krj_cs'],
            'berat' => $order_data['berat_qty_ck'] ?? $order_data['berat_qty_dc'] ?? null,
            'jml_pcs' => $order_data['jml_pcs'] ?? null,
            'h_perkilo' => $order_data['harga_perkilo'] ?? null,
            'h_perpcs' => $order_data['harga_perpcs'] ?? null,
            'tgl_msk' => $order_data['tgl_masuk_ck'] ?? $order_data['tgl_masuk_dc'] ?? $order_data['tgl_masuk_cs'],
            'tgl_klr' => $order_data['tgl_keluar_ck'] ?? $order_data['tgl_keluar_dc'] ?? $order_data['tgl_keluar_cs'],
            'total' => $total_tagihan,
            'nominal' => $nominal_bayar,
            'keterangan' => $order_data['keterangan_ck'] ?? $order_data['keterangan_dc'] ?? $order_data['keterangan_cs']
        ];

        $transaksi_sukses = false;
        switch ($tipe_order) {
            case 'ck': $transaksi_sukses = transaksi_ck($data_transaksi); break;
            case 'dc': $transaksi_sukses = transaksi_dc($data_transaksi); break;
            case 'cs': $transaksi_sukses = transaksi_cs($data_transaksi); break;
        }

        if ($transaksi_sukses) {
            $delete_query = "DELETE FROM tb_order_{$tipe_order} WHERE or_{$tipe_order}_number = '$no_order'";
            mysqli_query($koneksi, $delete_query);

            header('Location: ' . url('pelanggan/order_saya.php?status=success'));
            exit;
        } else {
            $error_message = "Terjadi kesalahan saat memproses transaksi.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Order | Laundry Kami</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/login.css') ?>"> 
</head>
<body>
    <div class="container" style="max-width: 600px; margin-top: 50px;">
        <div class="card">
            <div class="card-title">
                <h2>Konfirmasi Pembayaran</h2>
            </div>
            <div class="card-body">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" style="padding: 10px; background: #dc2626; color: white; border-radius: 6px; margin-bottom: 15px;">
                        <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <table style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <td style="font-weight: bold; width: 150px;">No. Order</td>
                        <td><?= $no_order ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Jenis Paket</td>
                        <td><?= $order_data['jenis_paket_ck'] ?? $order_data['jenis_paket_dc'] ?? $order_data['jenis_paket_cs'] ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total Tagihan</td>
                        <td style="font-size: 1.2em; color: var(--primary);">Rp. <?= number_format($order_data['tot_bayar'], 0, ',', '.') ?></td>
                    </tr>
                </table>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="nominal_bayar">Nominal Bayar</label>
                        <input type="number" name="nominal_bayar" id="nominal_bayar" class="input-form" value="<?= $order_data['tot_bayar'] ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="bayar" class="btn-login">Bayar Sekarang</button>
                        <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-back" style="display: inline-block; text-align: center; margin-top: 10px;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>