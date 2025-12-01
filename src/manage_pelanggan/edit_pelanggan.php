<?php 
$page_title = "Edit Pelanggan";
require_once('../_header.php');

// Proteksi: Hanya Admin
requireRole('Admin');

$id = $_GET['id'];
$pelanggan = getPelangganById($id);

if (!$pelanggan) {
    header('Location: ' . url('manage_pelanggan/pelanggan.php'));
    exit;
}

$success = '';
$error = '';

if (isset($_POST['update'])) {
    $nama = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $status = $_POST['status'];
    
    // Cek email duplikat
    $check = query("SELECT * FROM tb_pelanggan WHERE email = '$email' AND id_pelanggan != '$id'");
    if (count($check) > 0) {
        $error = 'Email sudah digunakan pelanggan lain!';
    } else {
        $query = "UPDATE tb_pelanggan SET 
                    nama_lengkap = '$nama',
                    email = '$email',
                    no_telp = '$no_telp',
                    alamat = '$alamat',
                    status = '$status'
                  WHERE id_pelanggan = '$id'";
        
        if (mysqli_query($koneksi, $query)) {
            $success = 'Data pelanggan berhasil diperbarui!';
            $pelanggan = getPelangganById($id); // Refresh
        } else {
            $error = 'Gagal memperbarui data!';
        }
    }
}

// Reset password
if (isset($_POST['reset_password'])) {
    $new_password = 'password123'; // Default password
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    
    $query = "UPDATE tb_pelanggan SET password = '$hashed' WHERE id_pelanggan = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $success = "Password berhasil direset menjadi: <strong>$new_password</strong>";
    } else {
        $error = 'Gagal reset password!';
    }
}
?>

<?php if ($success) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
        <p><?= $success ?></p>
        <a href="<?= url('manage_pelanggan/edit_pelanggan.php?id=' . $id) ?>" class="btn-alert btn-success">OK</a>
    </div>
</div>
<?php endif ?>

<?php if ($error) : ?>
<div class="alert">
    <div class="box">
        <img src="<?= url('assets/img/gagal.png') ?>" height="68" alt="alert gagal">
        <p><?= $error ?></p>
        <a href="<?= url('manage_pelanggan/edit_pelanggan.php?id=' . $id) ?>" class="btn-alert btn-fail">OK</a>
    </div>
</div>
<?php endif ?>

<div class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <h2 class="judul-md">Edit Pelanggan</h2>
                    <p class="judul-sm">Username: <?= $pelanggan['username'] ?></p>
                </div>
                <div class="col-header txt-right">
                    <a href="<?= url('manage_pelanggan/pelanggan.php') ?>" class="btn-xs bg-transparent">← Kembali</a>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col mt-2">
                <div class="card-md">
                    <div class="card-title">
                        <h2>Informasi Pelanggan</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="form-input">
                            <div class="form-grup">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="<?= $pelanggan['nama_lengkap'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= $pelanggan['email'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label>Nomor Telepon</label>
                                <input type="text" name="no_telp" value="<?= $pelanggan['no_telp'] ?>" required>
                            </div>
                            
                            <div class="form-grup">
                                <label>Alamat</label>
                                <textarea name="alamat" rows="3" required><?= $pelanggan['alamat'] ?></textarea>
                            </div>
                            
                            <div class="form-grup">
                                <label>Status Akun</label>
                                <select name="status" required>
                                    <option value="active" <?= $pelanggan['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="inactive" <?= $pelanggan['status'] == 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                            
                            <div class="form-footer">
                                <div class="buttons">
                                    <button type="submit" name="update" class="btn-sm bg-primary" style="color: whitesmoke;">Simpan Perubahan</button>
                                    <button type="submit" name="reset_password" class="btn-sm" style="background: var(--warning); color: white;" 
                                            onclick="return confirm('Reset password ke default: password123?')">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
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