<?php
include 'starter.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = mysqli_query($koneksi, "SELECT * FROM kerjakuliah WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Sertifikat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px;
            background-color: #f4f4f4;
        }

        .certificate {
            border: 5px solid #4CAF50;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .certificate h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .certificate p {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }

        .signature .name {
            margin-top: 50px;
            font-weight: bold;
        }

        .print-button {
            text-align: right;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="print-button">
        <button onclick="window.print()">Cetak</button>
    </div>
    <div class="certificate">
        <img src="../../../images/Logo balai.png" alt="Logo" class="logo">
        <h1>Sertifikat Pelatihan</h1>
        <p>Diberikan kepada:</p>
        <p><strong><?php echo $data['nama']; ?></strong></p>
        <p>Atas partisipasinya dalam pelatihan:</p>
        <p><strong><?php echo $data['nama_pelatihan']; ?></strong></p>
        <p>Pada tahun:</p>
        <p><strong><?php echo $data['tahun_alumni']; ?></strong></p>
        <div class="signature">
            <p>Banjarmasin, <?php echo date('d F Y'); ?></p>
            <p class="name">Nama Pejabat</p>
            <p>Jabatan Pejabat</p>
        </div>
    </div>
</body>

</html>