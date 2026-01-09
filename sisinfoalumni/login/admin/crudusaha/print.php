<?php
include '../crudkerkul/starter.php'; // Perbaiki path berdasarkan struktur folder Anda

// Tambahkan pengecekan koneksi untuk debugging
if (!$koneksi) {
    die("Koneksi database gagal. Periksa starter.php.");
}

$sort_order = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'asc' : 'desc';
$new_sort_order = $sort_order == 'asc' ? 'desc' : 'asc';
$selected_year = isset($_GET['tahun_usaha']) ? mysqli_real_escape_string($koneksi, $_GET['tahun_usaha']) : '';
$selected_business_type = isset($_GET['jenis_usaha']) ? mysqli_real_escape_string($koneksi, $_GET['jenis_usaha']) : '';

$query_years = mysqli_query($koneksi, "SELECT DISTINCT tahun_usaha FROM usaha ORDER BY tahun_usaha ASC");
$query_business_types = mysqli_query($koneksi, "SELECT DISTINCT jenis_usaha FROM usaha ORDER BY jenis_usaha ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print | Usaha</title>
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
        /* Kolom No. sampai Tahun Usaha rata tengah */
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

        .business-header {
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
                <label for="tahun_usaha">Filter by Tahun Usaha:</label>
                <select name="tahun_usaha" id="tahun_usaha" class="form-control">
                    <option value="">All</option>
                    <?php while ($year = mysqli_fetch_assoc($query_years)) { ?>
                        <option value="<?php echo $year['tahun_usaha']; ?>" <?php if ($selected_year == $year['tahun_usaha']) echo 'selected'; ?>>
                            <?php echo $year['tahun_usaha']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_usaha">Filter by Jenis Usaha:</label>
                <select name="jenis_usaha" id="jenis_usaha" class="form-control">
                    <option value="">All</option>
                    <?php while ($business_type = mysqli_fetch_assoc($query_business_types)) { ?>
                        <option value="<?php echo $business_type['jenis_usaha']; ?>" <?php if ($selected_business_type == $business_type['jenis_usaha']) echo 'selected'; ?>>
                            <?php echo $business_type['jenis_usaha']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <?php
    $query = mysqli_query($koneksi, "SELECT DISTINCT jenis_usaha FROM usaha WHERE jenis_usaha LIKE '%$selected_business_type%' ORDER BY jenis_usaha ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        $jenis_usaha = $row['jenis_usaha'];
        echo "<h2 class='business-header'>Data Alumni: Membuka Usaha - $jenis_usaha</h2>";
        echo "<table>
                <tr>
                    <th class='centered' style='width:35px;'>No.</th>
                    <th class='centered'>Nama</th>
                    <th class='centered'>Jenis Kelamin</th>
                    <th class='centered'>Alamat Usaha</th>
                    <th class='centered'>Tahun Usaha</th>
                </tr>";
        $query_alumni = mysqli_query($koneksi, "SELECT * FROM usaha WHERE jenis_usaha='$jenis_usaha' AND tahun_usaha LIKE '%$selected_year%' ORDER BY tahun_usaha $sort_order");
        $no = 1;
        while ($alumni = mysqli_fetch_assoc($query_alumni)) {
            echo "<tr>";
            echo "<td class='centered' style='width:35px;'>" . $no . "</td>";
            echo "<td class='centered'>" . $alumni['nama'] . "</td>";
            echo "<td class='centered'>" . $alumni['jenis_kelamin'] . "</td>";
            echo "<td class='centered'>" . $alumni['alamat_usaha'] . "</td>";
            echo "<td class='centered'>" . $alumni['tahun_usaha'] . "</td>";
            echo "</tr>";
            $no++;
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