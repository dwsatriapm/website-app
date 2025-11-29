<?php
require_once('db_connect.php');
require_once('../_header.php');

if (!isset($_GET['type']) || !isset($_GET['id'])) {
?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
            <p>Parameter tidak valid!</p>
            <a href="javascript:history.back()" class="btn-alert">OK</a>
        </div>
    </div>
<?php
    exit;
}

$type = $_GET['type'];
$id = $_GET['id'];

if (!is_numeric($id)) {
?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
            <p>ID tidak valid!</p>
            <a href="javascript:history.back()" class="btn-alert">OK</a>
        </div>
    </div>
    <?php
    exit;
}

$result = 0;
$redirect = '';

if ($type === 'ck') {
    $cek = query("SELECT * FROM tb_riwayat_ck WHERE id_ck = '$id'");
    if (count($cek) > 0) {
        $result = del_riwayat_ck($id);
        $redirect = 'riwayat.php';
    } else {
    ?>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
                <p>Data tidak ditemukan di database!</p>
                <a href="<?= url('riwayat_transaksi/riwayat.php') ?>" class="btn-alert">OK</a>
            </div>
        </div>
    <?php
        exit;
    }
} elseif ($type === 'dc') {
    $cek = query("SELECT * FROM tb_riwayat_dc WHERE id_dc = '$id'");
    if (count($cek) > 0) {
        $result = del_riwayat_dc($id);
        $redirect = 'riwayat.php';
    } else {
    ?>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
                <p>Data tidak ditemukan di database!</p>
                <a href="<?= url('riwayat_transaksi/riwayat.php') ?>" class="btn-alert">OK</a>
            </div>
        </div>
    <?php
        exit;
    }
} elseif ($type === 'cs') {
    $cek = query("SELECT * FROM tb_riwayat_cs WHERE id_cs = '$id'");
    if (count($cek) > 0) {
        $result = del_riwayat_cs($id);
        $redirect = 'riwayat.php';
    } else {
    ?>
        <div class="alert">
            <div class="box">
                <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
                <p>Data tidak ditemukan di database!</p>
                <a href="<?= url('riwayat_transaksi/riwayat.php') ?>" class="btn-alert">OK</a>
            </div>
        </div>
    <?php
        exit;
    }
} else {
    ?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
            <p>Tipe transaksi tidak valid!</p>
            <a href="javascript:history.back()" class="btn-alert">OK</a>
        </div>
    </div>
<?php
    exit;
}

if ($result > 0) {
?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
            <p>Riwayat transaksi berhasil dihapus!</p>
            <a href="<?= url('riwayat_transaksi/' . $redirect) ?>" class="btn-alert">OK</a>
        </div>
    </div>
<?php
} else {
?>
    <div class="alert">
        <div class="box">
            <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
            <p>Gagal menghapus riwayat transaksi!</p>
            <a href="<?= url('riwayat_transaksi/' . $redirect) ?>" class="btn-alert">OK</a>
        </div>
    </div>
<?php
}
?>