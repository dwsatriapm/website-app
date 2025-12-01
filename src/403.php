<?php require_once('_functions.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
    <link rel="shortcut icon" href="<?= url('assets/img/logo/favicon.svg') ?>" type="image/x-icon">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: var(--bg-secondary);">
    <div style="text-align: center; max-width: 500px; padding: 40px;">
        <h1 style="font-size: 120px; color: var(--danger); margin: 0; font-weight: 900;">403</h1>
        <h2 style="color: var(--text-primary); margin: 20px 0; font-size: 28px;">Akses Ditolak</h2>
        <p style="color: var(--text-secondary); margin-bottom: 30px; font-size: 16px; line-height: 1.6;">
            Anda tidak memiliki izin untuk mengakses halaman ini. Silakan login dengan akun yang sesuai.
        </p>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="<?= url('login.php') ?>" style="
                display: inline-block;
                padding: 12px 30px;
                background: var(--primary);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                transition: var(--transition);
            ">Kembali ke Login</a>
            
            <a href="javascript:history.back()" style="
                display: inline-block;
                padding: 12px 30px;
                background: var(--bg-tertiary);
                color: var(--text-primary);
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                border: 2px solid var(--border);
                transition: var(--transition);
            ">Kembali</a>
        </div>
    </div>
</body>
</html>