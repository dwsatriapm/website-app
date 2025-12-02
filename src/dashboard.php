<?php
require_once __DIR__ . '/_functions.php';
require_once __DIR__ . '/_auth.php';

requireRole(['Admin', 'Karyawan']);

$user = getCurrentUser();
$jml_karyawan = count(query('SELECT * FROM master LIMIT 20 OFFSET 1'));

require_once __DIR__ . '/_header.php';
?>

<div id="main" class="main-content">
    <div class="container">
        <div class="baris">
            <div class="selamat-datang">
                <div class="col-header">
                    <p class="judul-sm">Selamat Datang <span><?= ucfirst($_SESSION['master']) ?></span></p>
                    <h2 class="judul-md">Dashboard</h2>
                </div>

                <div class="col-header txt-right">
                    <a href="<?= url('order/order.php') ?>" class="btn-lg bg-primary" style="color: whitesmoke;">+ Order Baru</a>
                </div>
            </div>
        </div>

        <div class="baris">
            <div class="col col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Jumlah Karyawan</p>
                                <h2><?= $jml_karyawan ?></h2>
                            </div>
                            <div class="panel-icon">
                                <img src="<?= url('assets/img/team.png') ?>" alt="karyawan" height="48">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Total Order</p>
                                <h2><?= jmlOrder(); ?></h2>
                            </div>

                            <div class="panel-icon">
                                <img src="<?= url('assets/img/total_order.png') ?>" alt="order" height="48">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-panel">
                            <div class="panel-header">
                                <p>Jumlah Paket Tersedia</p>
                                <h2><?= jmlPaket(); ?></h2>
                            </div>

                            <div class="panel-icon">
                                <img src="<?= url('assets/img/jumlah_paket.png') ?>" alt="paket" height="48">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="baris">
            <?php require_once __DIR__ . '/daftar_order/daf_or_ck.php'; ?>
        </div>

        <div class="baris">
            <?php require_once __DIR__ . '/daftar_order/daf_or_dc.php'; ?>
        </div>

        <div class="baris">
            <?php require_once __DIR__ . '/daftar_order/daf_or_cs.php'; ?>
        </div>

    </div>
</div>

<?php

?>