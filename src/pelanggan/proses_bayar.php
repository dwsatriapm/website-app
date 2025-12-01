<?php
require_once __DIR__ . '/../_functions.php';
require_once __DIR__ . '/../_auth.php';

// Hanya pelanggan yang bisa akses halaman ini
requireRole('Pelanggan');

if (!isset($_POST['tipe_order']) || !isset($_POST['no_order']) || !isset($_POST['nominal_bayar'])) {
    header('Location: order_saya.php?error=invalid');
    exit;
}

 $id_pelanggan = $_SESSION['user_id'];
 $tipe_order = $_POST['tipe_order']; // ck, dc, atau cs
 $no_order = mysqli_real_escape_string($koneksi, $_POST['no_order']);
 $nominal_bayar = (int)$_POST['nominal_bayar'];

// Tentukan tabel dan kolom berdasarkan tipe order
switch ($tipe_order) {
    case 'ck':
        $table_order = 'tb_order_ck';
        $col_no_order = 'or_ck_number';
        $table_riwayat = 'tb_riwayat_ck';
        break;
    case 'dc':
        $table_order = 'tb_order_dc';
        $col_no_order = 'or_dc_number';
        $table_riwayat = 'tb_riwayat_dc';
        break;
    case 'cs':
        $table_order = 'tb_order_cs';
        $col_no_order = 'or_cs_number';
        $table_riwayat = 'tb_riwayat_cs';
        break;
    default:
        header('Location: order_saya.php?error=invalid_type');
        exit;
}

// --- VERIFIKASI KEAMANAN: PASTIKAN INI ORDER MILIK USER YANG SEDANG LOGIN ---
 $query = "SELECT * FROM $table_order WHERE $col_no_order = '$no_order' AND id_pelanggan = '$id_pelanggan'";
 $result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) !== 1) {
    // Jika order tidak ditemukan atau bukan milik user, hentikan proses
    die("Akses ditolak: Order tidak valid.");
}

 $order_data = mysqli_fetch_assoc($result);
 $total_tagihan = $order_data['tot_bayar'];

if ($nominal_bayar < $total_tagihan) {
    header('Location: order_saya.php?error=insufficient');
    exit;
}

// --- PROSES PEMBAYARAN ---
 $kembalian = $nominal_bayar - $total_tagihan;

// Siapkan data untuk fungsi transaksi
 $data_transaksi = [
    'or_number' => $no_order,
    'pelanggan' => $order_data['nama_pel_ck'] ?? $order_data['nama_pel_dc'] ?? $order_data['nama_pel_cs'],
    'no_telp' => $order_data['no_telp_ck'] ?? $order_data['no_telp_dc'] ?? $order_data['no_telp_cs'],
    'alamat' => $order_data['alamat_ck'] ?? $order_data['alamat_dc'] ?? $order_data['alamat_cs'],
    'j_paket' => $order_data['jenis_paket_ck'] ?? $order_data['jenis_paket_dc'] ?? $order_data['jenis_paket_cs'],
    'wkt_kerja' => $order_data['wkt_krj_ck'] ?? $order_data['wkt_krj_dc'] ?? $order_data['wkt_krj_cs'],
    'berat' => $order_data['berat_qty_ck'] ?? $order_data['berat_qty_dc'] ?? null,
    'jml_pcs' => $order_data['jml_pcs'] ?? null,
    'h_perkilo' => $order_data['harga_perkilo'] ?? $order_data['harga_perkilo'] ?? null,
    'h_perpcs' => $order_data['harga_perpcs'] ?? null,
    'tgl_msk' => $order_data['tgl_masuk_ck'] ?? $order_data['tgl_masuk_dc'] ?? $order_data['tgl_masuk_cs'],
    'tgl_klr' => $order_data['tgl_keluar_ck'] ?? $order_data['tgl_keluar_dc'] ?? $order_data['tgl_keluar_cs'],
    'total' => $total_tagihan,
    'nominal' => $nominal_bayar,
    'keterangan' => $order_data['keterangan_ck'] ?? $order_data['keterangan_dc'] ?? $order_data['keterangan_cs']
];

// Panggil fungsi transaksi yang sudah ada
 $transaksi_sukses = false;
switch ($tipe_order) {
    case 'ck': $transaksi_sukses = transaksi_ck($data_transaksi); break;
    case 'dc': $transaksi_sukses = transaksi_dc($data_transaksi); break;
    case 'cs': $transaksi_sukses = transaksi_cs($data_transaksi); break;
}

if ($transaksi_sukses) {
    // Jika transaksi berhasil, hapus order dari tabel order aktif
    $delete_query = "DELETE FROM $table_order WHERE $col_no_order = '$no_order'";
    mysqli_query($koneksi, $delete_query);
    
    header('Location: order_saya.php?status=success');
} else {
    header('Location: order_saya.php?error=transaction_failed');
}