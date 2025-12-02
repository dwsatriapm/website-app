<?php
require_once('../../_functions.php');
require_once('../../_auth.php');

requireRole('Pelanggan');

$or_number = $_GET['or_ck_number'];
$data = query("SELECT * FROM tb_order_ck WHERE or_ck_number = '$or_number'")[0];

// VALIDASI: Pelanggan hanya bisa cetak order miliknya
if ($data['id_pelanggan'] != $_SESSION['user_id']) {
    header('Location: ' . url('403.php'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Order - <?= $data['or_ck_number'] ?></title>
    <link rel="shortcut icon" href="<?= url('assets/img/logo/favicon.svg') ?>" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            padding: 20px;
            background: #f9fafb;
        }
        .nota {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 2px solid #000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .row.bold {
            font-weight: bold;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 15px 0;
        }
        .total {
            background: #000;
            color: white;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }
        .total h2 {
            font-size: 24px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #000;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            background: #fbbf24;
            color: #000;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }
        @media print {
            body {
                background: white;
            }
            .nota {
                box-shadow: none;
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="nota">
        <div class="header">
            <h1>🧺 LAUNDRY KAMI</h1>
            <p>Jl. Contoh No. 123, Bandung</p>
            <p>Telp: 0812-3456-7890</p>
            <div class="status-badge">BELUM DIBAYAR</div>
        </div>

        <div class="row bold">
            <span>NO ORDER:</span>
            <span><?= $data['or_ck_number'] ?></span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>Tanggal:</span>
            <span><?= date('d/m/Y', strtotime($data['tgl_masuk_ck'])) ?></span>
        </div>
        <div class="row">
            <span>Pelanggan:</span>
            <span><?= $data['nama_pel_ck'] ?></span>
        </div>
        <div class="row">
            <span>Telepon:</span>
            <span><?= $data['no_telp_ck'] ?></span>
        </div>

        <div class="divider"></div>

        <div class="row bold">
            <span>CUCI KOMPLIT</span>
        </div>
        <div class="row">
            <span>Paket:</span>
            <span><?= $data['jenis_paket_ck'] ?></span>
        </div>
        <div class="row">
            <span>Waktu Kerja:</span>
            <span><?= $data['wkt_krj_ck'] ?></span>
        </div>
        <div class="row">
            <span>Berat:</span>
            <span><?= $data['berat_qty_ck'] ?> Kg</span>
        </div>
        <div class="row">
            <span>Harga/Kg:</span>
            <span>Rp <?= number_format($data['harga_perkilo'], 0, ',', '.') ?></span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>Estimasi Selesai:</span>
            <span><?= date('d/m/Y', strtotime($data['tgl_keluar_ck'])) ?></span>
        </div>

        <div class="total">
            <h2>Rp <?= number_format($data['tot_bayar'], 0, ',', '.') ?></h2>
            <p style="font-size: 12px; margin-top: 5px;">Total yang harus dibayar</p>
        </div>

        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda!</p>
            <p style="margin-top: 10px;">Simpan nota ini sebagai bukti</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="
            background: #4338ca;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        ">🖨️ Cetak Nota</button>
        <button onclick="window.close()" style="
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
        ">Tutup</button>
    </div>
</body>
</html>