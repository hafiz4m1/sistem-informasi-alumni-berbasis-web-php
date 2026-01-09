<?php
include '../../koneksi.php';
session_start();
if ($_SESSION['status'] != "sudah_login") {
    header("location:../../login.php");
    die;
} elseif ($_SESSION['level'] != "admin") {
    header("location:../../user/index.php");
    die;
}
if (!isset($_POST['submit'])) {
    echo '<a href="https://instagram.com/al_nv23">Report Here</a><br>';
    die('Go-To Hell Shit. Anyway if you find any other bugs. reports it right away!');
}

$nama_mahker = $_POST['nama'];
$nik = $_POST['nik'];
$jenis_kelamin = $_POST['gender'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$agama = $_POST['agama'];
$pendidikan_terakhir = $_POST['pendidikan_terakhir'];
$alamat = $_POST['alamat'];
$no_telepon = $_POST['no_telepon'];
$angkatan_alumni = $_POST['angkatan_alumni'];
$nama_pelatihan = $_POST['nama_pelatihan'];
$tahun_alumni = $_POST['tahun_alumni'];
$gambar = $_FILES['gambar']['name'];

if ($gambar != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $x = explode('.', $gambar);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $angka_acak     = rand(1, 999);
    $nama_gambar_baru = $angka_acak . '-' . $gambar;
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        move_uploaded_file($file_tmp, 'gambar/' . $nama_gambar_baru);
        $query = "INSERT INTO kerjakuliah (nama, nik, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, pendidikan_terakhir, alamat, no_telepon, angkatan_alumni, nama_pelatihan, tahun_alumni, gambar) 
                  VALUES ('$nama_mahker', '$nik', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$agama', '$pendidikan_terakhir', '$alamat', '$no_telepon', '$angkatan_alumni', '$nama_pelatihan', '$tahun_alumni', '$nama_gambar_baru')";
        $result = mysqli_query($koneksi, $query);
        if (!$result) {
            die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                " - " . mysqli_error($koneksi));
        } else {
            header("location:../kerjakuliah.php?pesan=Data berhasil ditambah.");
        }
    } else {
        header("location:../kerjakuliah.php?pesan=Ekstensi yang diperbolehkan hanya PNG dan JPG");
    }
} else {
    $query = "INSERT INTO kerjakuliah (nama, nik, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, pendidikan_terakhir, alamat, no_telepon, angkatan_alumni, nama_pelatihan, tahun_alumni, gambar) 
              VALUES ('$nama_mahker', '$nik', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$agama', '$pendidikan_terakhir', '$alamat', '$no_telepon', '$angkatan_alumni', '$nama_pelatihan', '$tahun_alumni', null)";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
            " - " . mysqli_error($koneksi));
    } else {
        header("location:../kerjakuliah.php?pesan=Data berhasil ditambah.");
    }
}
