<?php 
$page_title = "Manage Pelanggan";
require_once('../_header.php');

// Proteksi: Hanya Admin
requireRole('Admin');

$pelanggan_list = query("SELECT * FROM tb_pelanggan ORDER BY created_at DESC");
?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Manage Pelanggan</h2>
                    <p class="judul-sm">Kelola akun pelanggan laundry</p>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card">
                    <div class="card-title card-flex">
                        <div class="card-col">
                            <h2>Daftar Pelanggan</h2>
                        </div>
                        <div class="card-col txt-right">
                            <span style="background: var(--success); color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600;">
                                Total: <?= count($pelanggan_list) ?> Pelanggan
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($pelanggan_list)) : ?>
                        <div class="tabel-kontainer">
                            <table class="tabel-transaksi">
                                <thead>
                                    <tr>
                                        <th class="sticky">No</th>
                                        <th class="sticky">Nama Lengkap</th>
                                        <th class="sticky">Username</th>
                                        <th class="sticky">Email</th>
                                        <th class="sticky">No Telepon</th>
                                        <th class="sticky">Alamat</th>
                                        <th class="sticky">Status</th>
                                        <th class="sticky">Terdaftar Sejak</th>
                                        <th class="sticky" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($pelanggan_list as $pelanggan) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= $pelanggan['nama_lengkap'] ?></strong></td>
                                        <td><?= $pelanggan['username'] ?></td>
                                        <td><?= $pelanggan['email'] ?></td>
                                        <td><?= $pelanggan['no_telp'] ?></td>
                                        <td style="max-width: 200px;"><?= substr($pelanggan['alamat'], 0, 50) ?>...</td>
                                        <td>
                                            <span style="
                                                background: <?= $pelanggan['status'] == 'active' ? '#10b981' : '#ef4444' ?>;
                                                color: white;
                                                padding: 4px 12px;
                                                border-radius: 6px;
                                                font-weight: 600;
                                                font-size: 12px;
                                            ">
                                                <?= $pelanggan['status'] == 'active' ? 'Aktif' : 'Nonaktif' ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($pelanggan['created_at'])) ?></td>
                                        <td align="center">
                                            <a href="<?= url('manage_pelanggan/edit_pelanggan.php?id=' . $pelanggan['id_pelanggan']) ?>" 
                                               class="btn btn-edit">Edit</a>
                                            
                                            <a href="<?= url('manage_pelanggan/hapus_pelanggan.php?id=' . $pelanggan['id_pelanggan']) ?>" 
                                               class="btn btn-hapus"
                                               onclick="return confirm('Yakin ingin menghapus pelanggan ini?\n\nNama: <?= $pelanggan['nama_lengkap'] ?>\nUsername: <?= $pelanggan['username'] ?>\n\n⚠️ Semua order dan riwayat transaksi pelanggan ini akan ikut terhapus!')">
                                               Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                        <div class="card-flex-column">
                            <img src="<?= url('assets/img/empty.png') ?>" width="150" alt="empty">
                            <p style="color: var(--text-secondary); margin-top: 20px; font-size: 16px;">Belum ada pelanggan terdaftar</p>
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