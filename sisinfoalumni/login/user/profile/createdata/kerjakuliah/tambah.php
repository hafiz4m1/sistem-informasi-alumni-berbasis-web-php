<?php
session_start();
include('../../../../koneksi.php');
define('DirKerKul', TRUE);
include 'tambah_user.php';
if ($_SESSION['status'] != "sudah_login") {
    header("location:../login.php");
    die;
}
if ($_SESSION['level'] != "user") {
    header("location:../login.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Request Tambah Data Alumni</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/css/util.css">
	<link rel="stylesheet" type="text/css" href="../../../../admin/crud/css/main.css">
<!--===============================================================================================-->
	<script src="../../../css/js/livepreview.js"></script>
</head>
<body>


	<div class="container-contact100">
			<div class="wrap-contact100" style=" width: 1000px;">
			<form class="contact100-form validate-form" enctype="multipart/form-data" method="POST" action="proses_tambah.php">
				<span class="contact100-form-title">
					Request Tambah Data Alumni
				</span>

				<div class="wrap-input100 validate-input" data-validate="Ketik lengkap namamu !">
					<span class="label-input100">Nama</span>
					<input class="input100" type="text" name="nama" placeholder="Masukkan namamu!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Ketik angka NIK!">
					<span class="label-input100">NIK</span>
					<input class="input100" type="text" name="nik" placeholder="Masukkan NIK kamu!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Jenis kelamin dibutuhkan!">
					<span class="label-input100">Jenis Kelamin</span>
					<div>
						<select class="selection-2" name="gender">
							<option value="Pria">Pria</option>
							<option value="Wanita">Wanita</option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Tempat Lahirmu">
					<span class="label-input100">Tempat Lahir</span>
					<input class="input100" type="text" name="tempat_lahir" placeholder="Masukkan nama Tempat!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Tahun Kerjamu!">
					<span class="label-input100">Kapan kamu Lahir?</span><br>
					<input class="input100" type="date" name="tanggal_lahir">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Agama Mu!">
					<span class="label-input100">Agama</span>
					<input class="input100" type="text" name="agama" placeholder="Masukkan Agamamu!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Pendidikan Terakhirmu!">
					<span class="label-input100">Pendidikan</span>
					<div>
						<select class="selection-2" name="pendidikan_terakhir" required>
							<option value="SD/MI">SD/MI</option>
							<option value="SMP/MTS">SMP/MTS</option>
							<option value="SMA/SMK">SMA/SMK</option>
							<option value="Sarjana S1">Sarjana S1</option>
							<option value="PascaSarjana S2">Pasca Sarjana S2</option>>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Alamatmu!">
					<span class="label-input100">alamat</span>
					<input class="input100" type="text" name="alamat" placeholder="Masukkan Alamatmu!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan No Teleponmu!">
					<span class="label-input100">No Telepon</span>
					<input class="input100" type="text" name="no_telepon" placeholder="Masukkan No Teleponmu!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan Angkatan Alumni!">
					<span class="label-input100">Angkatan Alumni</span>
					<input class="input100" type="text" name="angkatan_alumni" placeholder="Masukkan Angkatan Alumni!">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Masukkan nama perusahaannya!">
					<span class="label-input100">Jenis pelatihanmu</span>
					<div>
						<select class="selection-2" name="nama_pelatihan" required>
							
							<optgroup label="Pengelolaan BUM Desa">
								<option value="Pengelolaan BUM Desa Manajerial dan Kepemimpinan">Pengelolaan BUM Desa Manajerial dan Kepemimpinan</option>
								<option value="Pengelolaan BUM Desa Pengelolaan Keuangan">Pengelolaan BUM Desa Pengelolaan Keuangan</option>
								<option value="Pengelolaan BUM Desa Pemasaran dan Pengembangan Usaha">Pengelolaan BUM Desa Pemasaran dan Pengembangan Usaha</option>
								<option value="Pengelolaan BUM Desa Kewirausahaan Desa">Pengelolaan BUM Desa Kewirausahaan Desa</option>
							</optgroup>

							<optgroup label="Pembangunan Desa Wisata">
								<option value="Pembangunan Desa Wisata Manajemen Destinasi Wisata">Pembangunan Desa Wisata Manajemen Destinasi Wisata</option>
								<option value="Pembangunan Desa Wisata Pemasaran Digital Pariwisata">Pembangunan Desa Wisata Pemasaran Digital Pariwisata</option>
								<option value="Pembangunan Desa Wisata Pelatihan Pemandu Lokal">Pembangunan Desa Wisata Pelatihan Pemandu Lokal</option>
								<option value="Pembangunan Desa Wisata Pengembangan Paket Wisata">Pembangunan Desa Wisata Pengembangan Paket Wisata</option>
								<option value="Pembangunan Desa Wisata Konservasi Budaya dan Lingkungan">Pembangunan Desa Wisata Konservasi Budaya dan Lingkungan</option>
							</optgroup>

							<optgroup label="Kader Pemberdayaan Masyarakat Desa">
								<option value="Kader Pemberdayaan Masyarakat Desa Teknik Fasilitasi dan Advokasi">Kader Pemberdayaan Masyarakat Desa Teknik Fasilitasi dan Advokasi</option>
								<option value="Kader Pemberdayaan Masyarakat Desa Pemetaan Potensi dan Masalah Desa">Kader Pemberdayaan Masyarakat Desa Pemetaan Potensi dan Masalah Desa</option>
								<option value="Kader Pemberdayaan Masyarakat Desa Penyusunan Rencana Aksi Pemberdayaan">Kader Pemberdayaan Masyarakat Desa Penyusunan Rencana Aksi Pemberdayaan</option>
							</optgroup>

							<optgroup label="Calon Transmigran">
								<option value="Calon Transmigran Keterampilan Pertanian dan Peternakan">Calon Transmigran Keterampilan Pertanian dan Peternakan</option>
								<option value="Calon Transmigran Kewirausahaan dan Koperasi">Calon Transmigran Kewirausahaan dan Koperasi</option>
								<option value="Calon Transmigran Adaptasi Sosial dan Budaya">Calon Transmigran Adaptasi Sosial dan Budaya</option>
							</optgroup>

							<optgroup label="Produk Unggulan Kawasan Desa">
								<option value="Produk Unggulan Kawasan Desa Identifikasi dan Pengembangan Produk Lokal">Produk Unggulan Kawasan Desa Identifikasi dan Pengembangan Produk Lokal</option>
								<option value="Produk Unggulan Kawasan Desa Standarisasi dan Sertifikasi Produk">Produk Unggulan Kawasan Desa Standarisasi dan Sertifikasi Produk</option>
								<option value="Produk Unggulan Kawasan Desa Pemasaran dan Distribusi">Produk Unggulan Kawasan Desa Pemasaran dan Distribusi</option>
							</optgroup>

						</select>
					</div>
					<span class="focus-input100"></span>
				</div>



				<div class="wrap-input100 validate-input" data-validate="Tahun berapa anda menjadi alumni!">
					<span class="label-input100">Alumni Tahun berapa?</span><br>
					<input class="input100" type="year" min="1900" max="2099" step="1" value="2000" name="tahun_alumni" />
					<span class="focus-input100"></span>
				</div>

				<img id="preview" src="" alt="" width="320px" />

				<div class="wrap-input100">
					<span class="label-input100">Foto Profil</span><br>
					<input type="file" name="gambar" accept="image/*" onchange="showLive(this,'preview')" />
					<span class="focus-input100"></span>
				</div>
				<input type="hidden" name="permissions" value="1" />
				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<?php 
						$statuspers = mysqli_query($koneksi, "SELECT * FROM users where nama='$_SESSION[nama]'");
						$datastats = mysqli_fetch_assoc($statuspers);
						if($datastats['permissions'] != 1) { ?>
						<button class="contact100-form-btn" type="submit" name="submit">
							<span>
								Request
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
						<?php } ?>
					</div>
				</div>
				<?php if($datastats['permissions'] == 1){ ?>
						<span>
							You already requested a things. <a href="../../profile.php">See Here.</a>
						</span>
						<?php } ?>
				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
				<a href="../../profile.php" class="contact100-form-btn">Kembali</a>
				</div>
				</div>
			</form>
		</div>
	</div>
	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="../../../../admin/crud/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/vendor/bootstrap/js/popper.js"></script>
	<script src="../../../../admin/crud/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/vendor/daterangepicker/moment.min.js"></script>
	<script src="../../../../admin/crud/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../../../../admin/crud/js/main.js"></script>
	<script src="../../../../admin/crudkerkul/js/val.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="../../../../admin/crud/css/googlemanager.js"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
