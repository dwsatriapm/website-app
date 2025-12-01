<?php
$page_title = "Buat Order Baru";
require_once('_header_pelanggan.php');

$id_pelanggan = $user['id'];
$data_pelanggan = getPelangganById($id_pelanggan);

// Ambil daftar paket
$paket_ck = query("SELECT * FROM tb_cuci_komplit");
$paket_dc = query("SELECT * FROM tb_dry_clean");
$paket_cs = query("SELECT * FROM tb_cuci_satuan");

$success = '';
$error = '';

// Proses order
if (isset($_POST['order'])) {
    $jenis_layanan = $_POST['jenis_layanan'];
    
    // Data yang akan dikirim ke fungsi order
    $data_order = [
        'id_pelanggan' => $id_pelanggan,
        'nama_pel_' . $jenis_layanan => $data_pelanggan['nama_lengkap'],
        'no_telp_' . $jenis_layanan => $data_pelanggan['no_telp'],
        'alamat_' . $jenis_layanan => $data_pelanggan['alamat'],
        'jenis_paket_' . $jenis_layanan => $_POST['jenis_paket'],
        'tgl_masuk_' . $jenis_layanan => $_POST['tgl_masuk'],
        'tgl_keluar_' . $jenis_layanan => $_POST['tgl_keluar'],
        'keterangan_' . $jenis_layanan => $_POST['keterangan']
    ];
    
    if ($jenis_layanan === 'ck' || $jenis_layanan === 'dc') {
        $data_order['berat_qty_' . $jenis_layanan] = $_POST['jumlah'];
    } else {
        $data_order['jml_pcs'] = $_POST['jumlah'];
    }
    
    // Panggil fungsi order sesuai jenis layanan
    $result = 0;
    if ($jenis_layanan === 'ck') {
        $result = order_ck($data_order);
    } elseif ($jenis_layanan === 'dc') {
        $result = order_dc($data_order);
    } elseif ($jenis_layanan === 'cs') {
        $result = order_cs($data_order);
    }
    
    if ($result > 0) {
        $success = 'Order berhasil dibuat! Silakan lakukan pembayaran.';
    } else {
        $error = 'Gagal membuat order. Silakan coba lagi.';
    }
}
?>

<?php if ($success) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
        <p><?= $success ?></p>
        <a href="<?= url('pelanggan/order_saya.php') ?>" class="btn-alert btn-success">Lihat Order Saya</a>
    </div>
</div>
<?php endif ?>

<?php if ($error) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
        <p><?= $error ?></p>
        <a href="<?= url('pelanggan/buat_order.php') ?>" class="btn-alert btn-fail">OK</a>
    </div>
</div>
<?php endif ?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Buat Order Baru</h2>
                    <p class="judul-sm">Pilih layanan dan isi detail order Anda</p>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card-md">
                    <div class="card-title">
                        <h2>Form Order</h2>
                    </div>

                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row-input">
                                <div class="col-form m-1">
                                    <div class="form-grup">
                                        <label for="nama">Nama Pelanggan</label>
                                        <input type="text" value="<?= $data_pelanggan['nama_lengkap'] ?>" disabled>
                                    </div>

                                    <div class="form-grup">
                                        <label for="no-telp">Nomor Telepon</label>
                                        <input type="text" value="<?= $data_pelanggan['no_telp'] ?>" disabled>
                                    </div>

                                    <div class="form-grup">
                                        <label for="alamat">Alamat</label>
                                        <textarea rows="4" disabled><?= $data_pelanggan['alamat'] ?></textarea>
                                    </div>
                                </div>

                                <div class="col-form m-1">
                                    <div class="form-grup">
                                        <label for="jenis_layanan">Pilih Jenis Layanan</label>
                                        <select name="jenis_layanan" id="jenis_layanan" required onchange="updatePaketOptions()">
                                            <option value="">-- Pilih Jenis Layanan --</option>
                                            <option value="ck">Cuci Komplit</option>
                                            <option value="dc">Dry Clean (Cuci Kering)</option>
                                            <option value="cs">Cuci Satuan</option>
                                        </select>
                                    </div>

                                    <div class="form-grup">
                                        <label for="jenis_paket">Pilih Paket</label>
                                        <select name="jenis_paket" id="jenis_paket" required>
                                            <option value="">-- Pilih Jenis Layanan Dulu --</option>
                                        </select>
                                    </div>

                                    <div class="form-grup">
                                        <label for="jumlah">Jumlah (<span id="satuan_label">Kg/Pcs</span>)</label>
                                        <input type="number" name="jumlah" id="jumlah" min="1" required placeholder="Masukkan jumlah">
                                    </div>

                                    <div class="form-grup">
                                        <label for="tgl_masuk">Tanggal Order Masuk</label>
                                        <input type="date" name="tgl_masuk" id="tgl_masuk" required>
                                    </div>

                                    <div class="form-grup">
                                        <label for="tgl_keluar">Estimasi Tanggal Selesai</label>
                                        <input type="date" name="tgl_keluar" id="tgl_keluar" required>
                                    </div>

                                    <div class="form-grup">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="4" placeholder="Tambahkan catatan khusus (opsional)"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-footer">
                                <div class="buttons">
                                    <button type="submit" name="order" class="btn-sm bg-primary" style="color: whitesmoke;">Buat Order</button>
                                    <a href="<?= url('pelanggan/dashboard.php') ?>" class="btn-sm bg-transparent">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data paket dari PHP
    const paketData = {
        ck: <?= json_encode($paket_ck) ?>,
        dc: <?= json_encode($paket_dc) ?>,
        cs: <?= json_encode($paket_cs) ?>
    };

    function updatePaketOptions() {
        const jenisLayanan = document.getElementById('jenis_layanan').value;
        const paketSelect = document.getElementById('jenis_paket');
        const satuanLabel = document.getElementById('satuan_label');
        
        // Reset options
        paketSelect.innerHTML = '<option value="">-- Pilih Paket --</option>';
        
        if (jenisLayanan) {
            const pakets = paketData[jenisLayanan];
            const satuanField = (jenisLayanan === 'ck' || jenisLayanan === 'dc') ? 'Kg' : 'Pcs';
            satuanLabel.textContent = satuanField;
            
            pakets.forEach(paket => {
                const option = document.createElement('option');
                if (jenisLayanan === 'ck') {
                    option.value = paket.nama_paket_ck;
                    option.textContent = `${paket.nama_paket_ck} - ${paket.waktu_kerja_ck} (Rp. ${parseInt(paket.tarif_ck).toLocaleString('id-ID')}/${satuanField})`;
                } else if (jenisLayanan === 'dc') {
                    option.value = paket.nama_paket_dc;
                    option.textContent = `${paket.nama_paket_dc} - ${paket.waktu_kerja_dc} (Rp. ${parseInt(paket.tarif_dc).toLocaleString('id-ID')}/${satuanField})`;
                } else {
                    option.value = paket.nama_cs;
                    option.textContent = `${paket.nama_cs} - ${paket.waktu_kerja_cs} (Rp. ${parseInt(paket.tarif_cs).toLocaleString('id-ID')}/${satuanField})`;
                }
                paketSelect.appendChild(option);
            });
        }
    }
    
    // Set tanggal hari ini sebagai default
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tgl_masuk').value = today;
        
        // Set tanggal keluar 2 hari dari sekarang sebagai default
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 2);
        document.getElementById('tgl_keluar').value = tomorrow.toISOString().split('T')[0];
    });
</script>

</body>
</html>