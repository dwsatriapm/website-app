<?php
require_once('../../_functions.php');
require_once('../../_auth.php');

requireRole('Pelanggan');

$or_number = $_GET['or_number'];
$data = query("SELECT * FROM tb_riwayat_cs WHERE or_number = '$or_number'")[0];

// VALIDASI: Pelanggan hanya bisa cetak riwayat miliknya
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
    <title>Bukti Pembayaran - <?= $data['or_number'] ?></title>
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
        .total-section {
            background: #f3f4f6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
        }
        .lunas-badge {
            background: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #000;
            font-size: 12px;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
        }
        .signature div {
            text-align: center;
        }
        .signature-line {
            width: 150px;
            border-top: 1px solid #000;
            margin-top: 60px;
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
            <p style="margin-top: 10px; font-weight: bold;">BUKTI PEMBAYARAN</p>
        </div>

        <div class="row bold">
            <span>NO ORDER:</span>
            <span><?= $data['or_number'] ?></span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>Tanggal Masuk:</span>
            <span><?= $data['tgl_msk'] ?></span>
        </div>
        <div class="row">
            <span>Tanggal Selesai:</span>
            <span><?= $data['tgl_klr'] ?></span>
        </div>
        <div class="row">
            <span>Pelanggan:</span>
            <span><?= $data['pelanggan'] ?></span>
        </div>
        <div class="row">
            <span>Telepon:</span>
            <span><?= $data['no_telp'] ?></span>
        </div>

        <div class="divider"></div>

        <div class="row bold">
            <span>CUCI SATUAN</span>
        </div>
        <div class="row">
            <span>Paket:</span>
            <span><?= $data['j_paket'] ?></span>
        </div>
        <div class="row">
            <span>Waktu Kerja:</span>
            <span><?= $data['wkt_kerja'] ?></span>
        </div>
        <div class="row">
            <span>Jumlah:</span>
            <span><?= $data['jml_pcs'] ?> Pcs</span>
        </div>
        <div class="row">
            <span>Harga/Pcs:</span>
            <span>Rp <?= number_format($data['h_perpcs'], 0, ',', '.') ?></span>
        </div>

        <div class="divider"></div>

        <div class="total-section">
            <div class="row bold" style="font-size: 16px;">
                <span>TOTAL:</span>
                <span>Rp <?= number_format($data['total'], 0, ',', '.') ?></span>
            </div>
            <div class="row">
                <span>Dibayar:</span>
                <span>Rp <?= number_format($data['nominal_byr'], 0, ',', '.') ?></span>
            </div>
            <div class="row">
                <span>Kembalian:</span>
                <span>Rp <?= number_format($data['kembalian'], 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="lunas-badge">
            ✓ LUNAS - PEMBAYARAN BERHASIL
        </div>

        <div class="signature">
            <div>
                <p style="margin-bottom: 5px;">Pelanggan</p>
                <div class="signature-line"></div>
                <p style="margin-top: 5px;">(<?= $data['pelanggan'] ?>)</p>
            </div>
            <div>
                <p style="margin-bottom: 5px;">Kasir</p>
                <div class="signature-line"></div>
                <p style="margin-top: 5px;">(.....................)</p>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda!</p>
            <p style="margin-top: 5px; font-size: 10px;">Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
            <p style="margin-top: 10px; font-weight: bold;">Simpan bukti ini sebagai tanda terima</p>
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
            margin-right: 10px;
        ">🖨️ Cetak Bukti</button>
        <button onclick="window.close()" style="
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        ">Tutup</button>
    </div>
</body>
</html>