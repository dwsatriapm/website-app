<?php
require_once('../_header.php');
$dc_number = $_GET['or_dc_number'];
?>

<?php if (del_or_dc($dc_number) > 0) : ?>
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