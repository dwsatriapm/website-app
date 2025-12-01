<?php
require_once('../../_functions.php');
require_once('../../_auth.php');

// Cek apakah user sudah login
if (!isLoggedIn()) {
    header('Location: ' . url('login.php'));
    exit;
}

$user = getCurrentUser();
$nomor_or = $_GET['or_cs_number'];
$data = query("SELECT * FROM tb_order_cs WHERE or_cs_number = '$nomor_or'")[0];

// VALIDASI: Pelanggan hanya bisa bayar order miliknya sendiri
if (hasRole('Pelanggan')) {
    if ($data['id_pelanggan'] != $user['id']) {
        header('Location: ' . url('403.php'));
        exit;
    }
}
?>

<?php if (isset($_POST['bayar'])) { ?>
   <?php if (transaksi_cs($_POST) > 0) : ?>
      <div class="alert">
         <div class="box">
            <img src="<?= url('/assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
            <p>Pembayaran Berhasil!</p>
            <?php if (hasRole('Pelanggan')) : ?>
                <button onclick="window.location='<?= url('pelanggan/riwayat_saya.php') ?>'" class="btn-alert btn-success">Lihat Riwayat</button>
            <?php else : ?>
                <button onclick="window.location='<?= url('riwayat_transaksi/riwayat.php') ?>'" class="btn-alert btn-success">Ok</button>
            <?php endif ?>
         </div>
      </div>
   <?php else : ?>
      <div class="alert">
         <div class="box">
            <img src="<?= url('/assets/img/gagal.png') ?>" height="68" alt="alert gagal">
            <p>Pembayaran Gagal!</p>
            <a href="<?= url("detail_order/detail_cs/bayar.php?or_cs_number=$nomor_or") ?>" class="btn-alert btn-fail">Ok</a>
         </div>
      </div>
   <?php endif ?>
<?php } ?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bayar Order <?= $data['or_cs_number'] ?></title>
   <link rel="stylesheet" href="<?= url('/assets/css/payments.css') ?>">
   <link rel="shortcut icon" href="<?= url('/assets/img/logo/favicon.svg') ?>" type="image/x-icon">
</head>
<body>
   <div class="card-payment">
      <div class="icon-header">
         <img src="<?= url('/assets/img/payment.svg') ?>" alt="Icon Payment" width="178">
      </div>

      <div class="txt">
         <h3>No Order: <?= $data['or_cs_number'] ?></h3>
         <p>Masukkan nominal untuk melakukan transaksi</p>
         <p style="color: var(--primary-light); font-weight: 600; margin-top: 10px;">
            Total: Rp. <?= number_format($data['tot_bayar'], 0, ',', '.') ?>
         </p>
      </div>
      
      <form action="" method="post">
         <input type="hidden" name="or_number" value="<?= $data['or_cs_number'] ?>">
         <input type="hidden" name="pelanggan" value="<?= $data['nama_pel_cs'] ?>">
         <input type="hidden" name="no_telp" value="<?= $data['no_telp_cs'] ?>">
         <input type="hidden" name="alamat" value="<?= $data['alamat_cs'] ?>">
         <input type="hidden" name="j_paket" value="<?= $data['jenis_paket_cs'] ?>">
         <input type="hidden" name="wkt_kerja" value="<?= $data['wkt_krj_cs'] ?>">
         <input type="hidden" name="jml_pcs" value="<?= $data['jml_pcs'] ?>">
         <input type="hidden" name="h_perpcs" value="<?= $data['harga_perpcs'] ?>">
         <input type="hidden" name="tgl_msk" value="<?= $data['tgl_masuk_cs'] ?>">
         <input type="hidden" name="tgl_klr" value="<?= $data['tgl_keluar_cs'] ?>">
         <input type="hidden" name="total" value="<?= $data['tot_bayar'] ?>">
         <input type="hidden" name="keterangan" value="<?= $data['keterangan_cs'] ?>">

         <input type="number" name="nominal" required autofocus autocomplete="off" 
                placeholder="Misalnya: <?= $data['tot_bayar'] ?>" 
                min="<?= $data['tot_bayar'] ?>">
         
         <button type="submit" name="bayar">Bayar Sekarang</button>
         
         <?php if (hasRole('Pelanggan')) : ?>
            <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-back">← Kembali</a>
         <?php else : ?>
            <a href="<?= url('dashboard.php') ?>" class="btn-back">← Kembali</a>
         <?php endif ?>
      </form>
   </div>
</body>
</html>