<?php
include 'starter.php';

$sort_order = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'asc' : 'desc';
$new_sort_order = $sort_order == 'asc' ? 'desc' : 'asc';
$selected_training = isset($_GET['jenis_pelatihan']) ? $_GET['jenis_pelatihan'] : '';
$query_trainings = mysqli_query($koneksi, "SELECT DISTINCT jenis_pelatihan FROM kerja ORDER BY jenis_pelatihan ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelatih</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            font-size: 11px;
            background: #fff;
        }
        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-break: break-word;
            font-size: 10.5px;
        }
        th,
        td {
            border: 1px solid black;
            padding: 5px 4px;
            text-align: left;
            vertical-align: top;
        }
        /* Kolom No. sampai Tahun Alumni rata tengah */
        th.centered, td.centered {
            text-align: center !important;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
        }
        h1,
        h2,
        h3 {
            text-align: center;
            margin: 0.2em 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header img {
            width: 100px;
            height: 100px;
            margin-right: 40px;
        }

        .header div {
            text-align: center;
        }
        .header h1 {
            font-size: 1.2em;
            margin-right: 100px;
        }
        .header h2 {
            font-weight: bold;
            font-size: 1.1em;
            margin-right: 100px;
        }
        .header h3 {
            font-size: 1em;
            margin-right: 100px;
        }

        hr {
            border: 2px solid black;
        }

        .training-header {
            font-size: 1.3em;
        }

        .print-button {
            text-align: right;
            margin-bottom: 20px;
        }
        @media print {
            .print-button,
            .filter-form {
                display: none;
            }
            body {
                margin: 0;
                background: #fff;
            }
            .container {
                margin: 0;
                width: 100%;
                max-width: 100%;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th, td {
                font-size: 10px;
                padding: 4px 2px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="../../../images/Logo balai.png" alt="Logo">
            <div>
                <h1>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h1>
                <h2>KEMENTRIAN DESA</h2>
                <h2>PEMBANGUNAN DAERAH TERTINGGAL DAN TRANSMIGRASI</h2>
                <h2>BALAI PELATIAHAN DAN PEMBERDAYAAN DESA DAERAH TERTINGGAL DAN TRANSMIGRASI BANJARMASIN</h2>
                <h3>Handli Bakti, Alalak Utara, Barito Kuala Regency, Kalamantan Selatan Telepon: (0511) 472-0000</h3>
            </div>
        </div>
        <hr>
        <div class="print-button">
            <button onclick="window.print()">Cetak</button>
        </div>
        <div class="filter-form">
            <form method="GET" action="print.php">
            <div class="form-group">
                <label for="jenis_pelatihan">Filter by Jenis Pelatihan:</label>
                <select name="jenis_pelatihan" id="jenis_pelatihan" class="form-control">
                    <option value="">All</option>
                    <?php while ($training = mysqli_fetch_assoc($query_trainings)) { ?>
                        <option value="<?php echo $training['jenis_pelatihan']; ?>" <?php if ($selected_training == $training['jenis_pelatihan']) echo 'selected'; ?>>
                            <?php echo $training['jenis_pelatihan']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <?php
    $query = mysqli_query($koneksi, "SELECT DISTINCT jenis_pelatihan FROM `kerja` WHERE jenis_pelatihan LIKE '%$selected_training%' ORDER BY jenis_pelatihan ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        $jenis_pelatihan = $row['jenis_pelatihan'];
        echo "<h2 class='training-header'>Daftar Pelatih: $jenis_pelatihan</h2>";
        echo "<table>
                <tr>
                    <th class='centered' style='width:35px;'>No.</th>
                    <th class='centered'>Nama</th>
                    <th class='centered'>Jenis Kelamin</th>
                    <th class='centered'>Pendidikan Terakhir</th>
                    <th class='centered'>Tahun Kerja</th>
                </tr>";
        $query_pelatih = mysqli_query($koneksi, "SELECT * FROM `kerja` WHERE jenis_pelatihan='$jenis_pelatihan' ORDER BY jenis_pelatihan $sort_order");
        if ($query_pelatih === false) {
            echo "<tr><td colspan='6' class='centered'>Query error: " . mysqli_error($koneksi) . "</td></tr>";
        } else {
            $no = 1;
            if (mysqli_num_rows($query_pelatih) == 0) {
                echo "<tr><td colspan='6' class='centered'>Tidak ada data untuk ditampilkan</td></tr>";
            } else {
                while ($pelatih = mysqli_fetch_assoc($query_pelatih)) {
                    if ($no > 3) break;
                    echo "<tr>";
                    echo "<td class='centered' style='width:35px;'>" . $no . "</td>";
                    echo "<td class='centered'>" . $pelatih['nama'] . "</td>";
                    echo "<td class='centered'>" . $pelatih['jenis_kelamin'] . "</td>";
                    echo "<td class='centered'>" . $pelatih['pendidikan_terakhir'] . "</td>";
                    echo "<td class='centered'>" . $pelatih['tahun_kerja'] . "</td>";
                    echo "</tr>";
                    $no++;
                }
            }
        }
        echo "</table><br>";
    }
    ?>

    <div style="text-align: right;"></div>
    <strong>Tanda Tangan</strong><br>
    ________________<br>
    Nama Pejabat<br>
    Jabatan Pejabat
    </div>

    <!-- Script printToPDF dihapus, hanya window.print digunakan pada tombol Cetak -->
</body>

</html>