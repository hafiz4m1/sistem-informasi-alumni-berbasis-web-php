<?php
if (!defined('DirKerKul')) {
    die('Direct Access Not Permitted.');
}
if (isset($_POST['submit'])) {

    $nama_kerkul = $_POST['nama'];
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
    $pers = $_POST['permissions'];
    $nameuser = $_SESSION['nama'];

    $validation = mysqli_query($koneksi, "SELECT * FROM users where nama='$nameuser'");
    $dataval = mysqli_fetch_assoc($validation);
    $access = $dataval['permissions'];
    if ($access == "1") {
        header("location:../../profile.php?pesan=Access Denied.");
    }
    if (empty($access)) {
        if ($gambar != "") {
            $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
            $x = explode('.', $gambar);
            $ekstensi = strtolower(end($x));
            $file_tmp = $_FILES['gambar']['tmp_name'];
            $angka_acak     = rand(1, 999);
            $nama_gambar_baru = $angka_acak . '-' . $gambar;
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                move_uploaded_file($file_tmp, '../../../../admin/crudkerkul/gambar/' . $nama_gambar_baru);
                $query = "INSERT INTO request (jenis_table,nama,jenis_kelamin,tempat_lahir,tanggal_lahir,agama,pendidikan_terakhir,alamat,no_telepon,angkatan_alumni,nama_pelatihan,tahun_alumni,requested_by,gambar) values ('kerjakuliah','$nama_kerkul','$jenis_kelamin','$tempat_lahir','$tanggal_lahir','$agama','$pendidikan_terakhir','$alamat','$no_telepon','$angkatan_alumni','$nama_pelatihan','$tahun_alumni','$nameuser','$nama_gambar_baru')";
                $result = mysqli_query($koneksi, $query);
                if (!$result) {
                    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                        " - " . mysqli_error($koneksi));
                } else {
                    mysqli_query($koneksi, "UPDATE users SET permissions = '$pers' where nama='$nameuser'");
                    header("location:../../profile.php?pesan=Permintaan berhasil diproses.");
                }
            } else {
                mysqli_query($koneksi, "UPDATE users SET permissions = '0' where nama='$nameuser'");
                header("location:../../profile.php?pesan=Format yang diperbolehkan hanya PNG dan JPEG");
            }
        } else {
            $query =  "INSERT INTO request (jenis_table,nama,jenis_kelamin,tempat_lahir,tanggal_lahir,agama,pendidikan_terakhir,alamat,no_telepon,angkatan_alumni,nama_pelatihan,tahun_alumni,requested_by,gambar) values ('kerjakuliah','$nama_kerkul','$jenis_kelamin','$tempat_lahir','$tanggal_lahir','$agama','$pendidikan_terakhir','$alamat','$no_telepon','$angkatan_alumni','$nama_pelatihan','$tahun_alumni','$nameuser',null)";
            $result = mysqli_query($koneksi, $query);
            if (!$result) {
                die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                    " - " . mysqli_error($koneksi));
            } else {
                mysqli_query($koneksi, "UPDATE users SET permissions = '$pers' where nama='$nameuser'");
                header("location:../../profile.php?pesan=Permintaan berhasil diproses.");
            }
        }
    }
}
