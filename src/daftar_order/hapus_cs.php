<?php
require_once('db_connect.php');
require_once('../_header.php');
$cs_number = $_GET['or_cs_number'];
?>

<?php if (del_or_cs($cs_number) > 0) : ?>
	<div class="alert">
		<div class="box">
			<img src="<?= url('/assets/img/berhasil.png') ?>" height="68" alt="alert sukses">
			<p>Data Berhasil Di Hapus</p>
			<button onclick="window.location='http://localhost:4124/dashboard.php'" class="btn-alert">Ok</button>
		</div>
	</div>
<?php else : ?>
	<div class="alert">
		<div class="box">
			<img src="<?= url('/assets/img/gagal.png') ?>" height="68" alt="alert gagal">
			<p>Data Gagal Di Hapus</p>
			<button onclick="window.location='http://localhost:4124/dashboard.php'" class="btn-alert">Ok</button>
		</div>
	</div>
<?php endif ?>