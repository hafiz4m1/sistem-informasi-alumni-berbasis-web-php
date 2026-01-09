<?php
include '../../koneksi.php';
session_start();
if ($_SESSION['status'] != "sudah_login") {
	header("location:../../login.php");
} elseif ($_SESSION['level'] != "admin") {
	header("location:../../user/index.php");
}
if (isset($_GET['id'])) {
	$id = ($_GET["id"]);
	$query = "SELECT * FROM `kerja` where id='$id'";
	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		die("Query Error: " . mysqli_errno($koneksi) .
			" - " . mysqli_error($koneksi));
	}
	$data = mysqli_fetch_assoc($result);
	if (!count($data)) {
		echo "<script>alert('Data tidak ditemukan pada database');window.location='edit.php';</script>";
	}
} else {
	echo "<script>alert('Masukkan data id.');window.location='edit.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Edit Data Pelatih</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<script src="../assets/js/livepreview.js"></script>
</head>

<body>


	<div class="container-contact100">
		<div class="wrap-contact100" style=" width: 1000px;">
			<form class="contact100-form validate-form" enctype="multipart/form-data" method="POST" action="proses_edit.php" onsubmit="return validateForm();">
				<input name="id" value="<?php echo $data['id']; ?>" hidden />
				<span class="contact100-form-title">
					Edit Data Pelatih
				</span>

				<div class="wrap-input100">
					<span class="label-input100 validate-input" data-validate="Masukkan namamu!">Nama</span>
					<input class="input100" type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100">
					<span class="label-input100 validate-input" data-validate="Jenis kelamin dibutuhkan!">Jenis Kelamin</span>
					<div>
						<select class="selection-2" name="gender">
							<option value="Pria" <?php if ($data['jenis_kelamin'] == 'Pria'): ?> selected="selected" <?php endif; ?>>Pria</option>
							<option value="Wanita" <?php if ($data['jenis_kelamin'] == 'Wanita'): ?> selected="selected" <?php endif; ?>>Wanita</option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan nama perusahaannya!">
					<span class="label-input100">Pendidikan Terakhir</span>
					<div>
						<select class="selection-2" name="pendidikan_terakhir" required>
							<option value="SD/MI" <?php if ($data['pendidikan_terakhir'] == 'SD/MI') echo 'selected'; ?>>SD/MI</option>
							<option value="SMP/MTS" <?php if ($data['pendidikan_terakhir'] == 'SMP/MTS') echo 'selected'; ?>>SMP/MTS</option>
							<option value="SMA/SMK" <?php if ($data['pendidikan_terakhir'] == 'SMA/SMK') echo 'selected'; ?>>SMA/SMK</option>
							<option value="Sarjana S1" <?php if ($data['pendidikan_terakhir'] == 'Sarjana  S1') echo 'selected'; ?>>Sarjana S1</option>
							<option value="PascaSarjana S2" <?php if ($data['pendidikan_terakhir'] == 'Pasca Sarjana S2') echo 'selected'; ?>>Pasca Sarjana S2</option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>

							<div class="wrap-input100 validate-input" data-validate="Masukkan nama perusahaannya!">
					<span class="label-input100">Jenis pelatihanmu</span>
					<div>
						<select class="selection-2" name="jenis_pelatihan" required>
							<option value="Pelatihan Pengelolaan BUM Desa" <?php if ($data['jenis_pelatihan'] == 'Pelatihan Pengelolaan BUM Desa') echo 'selected'; ?>>Pelatihan Pengelolaan BUM Desa</option>
							<option value="Pelatihan Pembangunan Desa Wisata" <?php if ($data['jenis_pelatihan'] == 'Pelatihan Pembangunan Desa Wisata') echo 'selected'; ?>>Pelatihan Pembangunan Desa Wisata</option>
							<option value="Pelatihan Kader Pemberdayaan Masyarakat Desa" <?php if ($data['jenis_pelatihan'] == 'Pelatihan Kader Pemberdayaan Masyarakat Desa') echo 'selected'; ?>>Pelatihan Kader Pemberdayaan Masyarakat Desa</option>
							<option value="Pelatihan Berbasis Kompetensi Calon Transmigran" <?php if ($data['jenis_pelatihan'] == 'Pelatihan Berbasis Kompetensi Calon Transmigran') echo 'selected'; ?>>Pelatihan Berbasis Kompetensi Calon Transmigran</option>
							<option value="Pelatihan Produk Unggulan Kawasan Desa" <?php if ($data['jenis_pelatihan'] == 'Pelatihan Produk Unggulan Kawasan Desa') echo 'selected'; ?>>Pelatihan Produk Unggulan Kawasan Desa</option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>
			

				<div class="wrap-input100 validate-input" data-validate="Masukkan tahun kerjamu!">
					<span class="label-input100">Kapan kamu berkerja?</span><br>
					<input class="input100" type="number" min="1900" max="2099" step="1" value="<?php echo $data['tahun_kerja']; ?>" name="tahun" required />
					<span class="focus-input100"></span>
				</div>

				<img id="preview" src="gambar/<?php echo $data['gambar']; ?>" alt="" width="320px" />

				<div class="wrap-input100">
					<span class="label-input100">Foto Profil</span><br>
					<input type="file" name="gambar" accept="image/*" onchange="showLive(this,'preview')" />
					<span class="focus-input100"></span>
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" type="submit" name="submit">
							<span>
								Submit
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</div>
				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<a href="../kerja.php" class="contact100-form-btn">Kembali</a>
					</div>
				</div>
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script src="js/val.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="css/googlemanager.js"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>

<script>
function validateForm() {
	var nama = document.getElementsByName('nama')[0].value.trim();
	var gender = document.getElementsByName('gender')[0].value;
	var pendidikan = document.getElementsByName('pendidikan_terakhir')[0].value;
	var jenis = document.getElementsByName('jenis_pelatihan')[0].value;
	var tahun = document.getElementsByName('tahun')[0].value.trim();
	if (!nama || !gender || !pendidikan || !jenis || !tahun) {
		alert('Semua kolom wajib diisi!');
		return false;
	}
	return true;
}
</script>
</body>

</html>