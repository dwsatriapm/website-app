<?php
$page_title = "Profil Saya";
require_once('_header_pelanggan.php');

$id_pelanggan = $user['id'];
$data_pelanggan = getPelangganById($id_pelanggan);

$success = '';
$error = '';

if (isset($_POST['update_profil'])) {
    $nama = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    
    $check_email = query("SELECT * FROM tb_pelanggan WHERE email = '$email' AND id_pelanggan != '$id_pelanggan'");
    if (count($check_email) > 0) {
        $error = 'Email sudah digunakan pengguna lain!';
    } else {
        $query = "UPDATE tb_pelanggan SET 
                    nama_lengkap = '$nama',
                    email = '$email',
                    no_telp = '$no_telp',
                    alamat = '$alamat'
                  WHERE id_pelanggan = '$id_pelanggan'";
        
        if (mysqli_query($koneksi, $query)) {
            $success = 'Profil berhasil diperbarui!';
            $_SESSION['user_nama'] = $nama;
            $_SESSION['user_email'] = $email;
            $data_pelanggan = getPelangganById($id_pelanggan); 
        } else {
            $error = 'Gagal memperbarui profil!';
        }
    }
}

if (isset($_POST['ganti_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $confirm_password = $_POST['confirm_password'];
    
    if (!password_verify($password_lama, $data_pelanggan['password'])) {
        $error = 'Password lama tidak sesuai!';
    } elseif ($password_baru !== $confirm_password) {
        $error = 'Konfirmasi password tidak cocok!';
    } elseif (strlen($password_baru) < 6) {
        $error = 'Password baru minimal 6 karakter!';
    } else {
        $hashed = password_hash($password_baru, PASSWORD_DEFAULT);
        $query = "UPDATE tb_pelanggan SET password = '$hashed' WHERE id_pelanggan = '$id_pelanggan'";
        
        if (mysqli_query($koneksi, $query)) {
            $success = 'Password berhasil diubah!';
        } else {
            $error = 'Gagal mengubah password!';
        }
    }
}
?>

<?php if ($success) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
        <p><?= $success ?></p>
        <a href="<?= url('pelanggan/profil.php') ?>" class="btn-alert btn-success">OK</a>
    </div>
</div>
<?php endif ?>

<?php if ($error) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
        <p><?= $error ?></p>
        <a href="<?= url('pelanggan/profil.php') ?>" class="btn-alert btn-fail">OK</a>
    </div>
</div>
<?php endif ?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Profil Saya</h2>
                    <p class="judul-sm">Kelola informasi profil Anda</p>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card">
                    <div class="card-title">
                        <h2>Informasi Pribadi</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="form-input">
                            <div class="form-grup">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama" value="<?= $data_pelanggan['nama_lengkap'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?= $data_pelanggan['email'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" value="<?= $data_pelanggan['no_telp'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" required><?= $data_pelanggan['alamat'] ?></textarea>
                            </div>
                            
                            <div class="form-grup">
                                <label>Username</label>
                                <input type="text" value="<?= $data_pelanggan['username'] ?>" disabled>
                                <small style="color: var(--text-tertiary);">Username tidak dapat diubah</small>
                            </div>
                            
                            <div class="form-footer">
                                <div class="buttons">
                                    <button type="submit" name="update_profil" class="btn-sm bg-primary" style="color: whitesmoke;">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col mt-2">
                <div class="card">
                    <div class="card-title">
                        <h2>Ganti Password</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="form-input">
                            <div class="form-grup">
                                <label for="password_lama">Password Lama</label>
                                <input type="password" name="password_lama" id="password_lama" required>
                            </div>
                            
                            <div class="form-grup">
                                <label for="password_baru">Password Baru</label>
                                <input type="password" name="password_baru" id="password_baru" required>
                            </div>
                            
                            <div class="form-grup">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" id="confirm_password" required>
                            </div>
                            
                            <div class="form-footer">
                                <div class="buttons">
                                    <button type="submit" name="ganti_password" class="btn-sm bg-primary" style="color: whitesmoke;">Ganti Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>