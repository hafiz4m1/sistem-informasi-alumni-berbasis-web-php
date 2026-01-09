    <?php
    include '../koneksi.php';
    session_start();
    if ($_SESSION['status'] != "sudah_login") {
        header("location:../login.php");
    } elseif ($_SESSION['level'] != "admin") {
        header("location:../user/index.php");
    }

    $sort_order = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'asc' : 'desc';
    $new_sort_order = $sort_order == 'asc' ? 'desc' : 'asc';

    $selected_year = isset($_GET['tahun_alumni']) ? $_GET['tahun_alumni'] : '';
    $selected_training = isset($_GET['nama_pelatihan']) ? $_GET['nama_pelatihan'] : '';
    $selected_batch = isset($_GET['angkatan_alumni']) ? $_GET['angkatan_alumni'] : '';
    $search_name = isset($_GET['nama']) ? $_GET['nama'] : '';

    $query_years = mysqli_query($koneksi, "SELECT DISTINCT tahun_alumni FROM kerjakuliah ORDER BY tahun_alumni ASC");
    $query_trainings = mysqli_query($koneksi, "SELECT DISTINCT nama_pelatihan FROM kerjakuliah ORDER BY nama_pelatihan ASC");
    $query_batches = mysqli_query($koneksi, "SELECT DISTINCT angkatan_alumni FROM kerjakuliah ORDER BY angkatan_alumni ASC");

    // Debugging: Periksa jumlah baris untuk setiap query
    $num_years = mysqli_num_rows($query_years);
    $num_trainings = mysqli_num_rows($query_trainings);
    $num_batches = mysqli_num_rows($query_batches);

    // Reset pointer query setelah num_rows
    mysqli_data_seek($query_years, 0);
    mysqli_data_seek($query_trainings, 0);
    mysqli_data_seek($query_batches, 0);
    ?>
    <!doctype html>
    <html lang="en">

    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Data Alumni</title>

        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.css">
        <!-- Style CSS (White)-->
        <link rel="stylesheet" href="assets/css/White.css">
        <!-- Style CSS (Dark)-->
        <link rel="stylesheet" href="assets/css/Dark.css">
        <!-- FontAwesome CSS-->
        <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.css">
        <!-- Icon LineAwesome CSS-->
        <link rel="stylesheet" href="assets/vendors/lineawesome/css/line-awesome.min.css">

        <style>
            .filter-form .form-group {
                display: inline-block;
                margin-right: 15px;
                margin-bottom: 10px;
                vertical-align: top;
            }

            .filter-form .form-group label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
                color: #333;
            }

            .filter-form select,
            .filter-form input[type="text"] {
                padding: 8px 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 14px;
                width: 200px;
                box-sizing: border-box;
            }

            .filter-form select:focus,
            .filter-form input[type="text"]:focus {
                border-color: #007bff;
                outline: none;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .filter-form button,
            .filter-form a {
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                font-size: 14px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                margin-right: 10px;
                margin-top: 25px;
            }

            .filter-form button {
                background-color: #007bff;
                color: white;
            }

            .filter-form button:hover {
                background-color: #0056b3;
            }

            .filter-form a {
                background-color: #6c757d;
                color: white;
            }

            .filter-form a:hover {
                background-color: #545b62;
            }
        </style>

    </head>

    <body>

        <!--Topbar -->
        <div class="topbar transition">
            <div class="bars">
                <button type="button" class="btn transition" id="sidebar-toggle">
                    <i class="las la-bars"></i>
                </button>
            </div>
            <div class="menu">

                <ul>

                    <li>
                        <div class="theme-switch-wrapper">
                            <label class="theme-switch" for="checkbox">
                                <input type="checkbox" id="checkbox" title="Dark Or White" />
                                Dark Mode
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </li>

                    <li>
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><?php echo $_SESSION['nama']; ?></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownProfile">
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="las la-sign-out-alt mr-2"></i> Sign Out
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!--Sidebar-->
        <div class="sidebar transition overlay-scrollbars">
            <div class="logo">
                <h2 style="font-weight: 700;" class="mb-0">SisInfo<span style="font-weight: 500;">Admin</span></h2>
            </div>

            <div class="sidebar-items">
                <div class="accordion" id="sidebar-items">
                    <ul>

                        <p class="menu">Apps</p>

                        <li>
                            <a href="index.php" class="items">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>


                        <p class="menu">Admin Menu</p>

                        <li id="headingTwo">
                            <a href="onclick();" class="submenu-items" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <i class="fas la-wrench"></i>
                                <span>Abilities</span>
                                <i class="fas la-angle-right"></i>
                            </a>
                        </li>
                        <div id="collapseTwo" class="collapse submenu" aria-labelledby="headingTwo" data-parent="#sidebar-items">
                            <ul>

                                <li>
                                    <a href="profileadjust/authlevels.php">Authorization Levels</a>
                                </li>
                                <li>
                                    <a href="profileadjust/approval.php">User Permissions</a>
                                </li>

                            </ul>
                        </div>

                        <p class="menu">Pages</p>

                        <li id="headingThree">
                            <a href="onclick();" class="submenu-items" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                <i class="fas la-cog"></i>
                                <span>Data Alumni</span>
                                <i class="fas la-angle-right"></i>
                            </a>
                        </li>
                        <div id="collapsefour" class="collapse submenu" aria-labelledby="headingThree" data-parent="#sidebar-items">
                            <ul>

                                <li>
                                    <a href="kerja.php">Pelatih</a>
                                </li>

                                <li>
                                    <a href="kerjakuliah.php">Alumni</a>
                                </li>

                            <!--<li>
                                    <a href="kuliah.php">Kuliah</a>
                                </li>

                                <li>
                                    <a href="mencrkrj.php">Mencari Kerja</a>
                                </li>-->

                                <li>
                                    <a href="usaha.php">Usaha</a>
                                </li>

                                <li>
                                    <a href="search.php">Cari Data</a>
                                </li>

                            </ul>
                        </div>
                </div>
            </div>
        </div>

        <div classs="sidebar-overlay"></div>

            
        <!--Content Start-->
        <div class="content transition">
            <div class="container-fluid dashboard">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Alumni</h5>
                            <?php if (isset($_GET['pesan'])) { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($_GET['pesan']); ?>
                                    <button type="button" class="close" onclick="window.location.href='kerjakuliah.php';" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>
                            <!-- Form Filter -->
                            <form class="filter-form mb-3" method="get" action="">
                                <div class="form-group">
                                    <label for="tahun_alumni">Filter by Tahun Alumni:</label>
                                    <select name="tahun_alumni" id="tahun_alumni">
                                        <option value="">All</option>
                                        <?php while ($year = mysqli_fetch_assoc($query_years)) { ?>
                                            <option value="<?php echo $year['tahun_alumni']; ?>" <?php if ($selected_year == $year['tahun_alumni']) echo 'selected'; ?>>
                                                <?php echo $year['tahun_alumni']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pelatihan">Filter by Nama Pelatihan:</label>
                                    <select name="nama_pelatihan" id="nama_pelatihan">
                                        <option value="">All</option>
                                        <?php while ($training = mysqli_fetch_assoc($query_trainings)) { ?>
                                            <option value="<?php echo $training['nama_pelatihan']; ?>" <?php if ($selected_training == $training['nama_pelatihan']) echo 'selected'; ?>>
                                                <?php echo $training['nama_pelatihan']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="angkatan_alumni">Filter by Angkatan Alumni:</label>
                                    <select name="angkatan_alumni" id="angkatan_alumni">
                                        <option value="">All</option>
                                        <?php while ($batch = mysqli_fetch_assoc($query_batches)) { ?>
                                            <option value="<?php echo $batch['angkatan_alumni']; ?>" <?php if ($selected_batch == $batch['angkatan_alumni']) echo 'selected'; ?>>
                                                <?php echo $batch['angkatan_alumni']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($search_name); ?>" placeholder="Cari berdasarkan nama">
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="kerjakuliah.php" class="btn btn-secondary">Reset</a>
                            </form>
                            
                            <div class="mb-3">
                                <a href="crudkerkul/tambah.php" class="btn btn-primary btn-icon"><i class="fas fa-plus"></i>
                                    Tambah Data</a>
                                <a href="crudkerkul/print.php" class="btn btn-info btn-icon" target="_blank"><i class="fas fa-print"></i> Print</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat dan Tanggal Lahir</th>
                                            <th>Agama</th>
                                            <th>Pendidikan</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>Angkatan Alumni</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Tahun Alumni</th>
                                            <th>Gambar:</th>
                                            <th class="text-center" colspan="2">Aksi:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $limit = 5;
                                        $paging = isset($_GET['paging']) ? (int)$_GET['paging'] : 1;
                                        $main_page = ($paging > 1) ? ($paging * $limit) - $limit : 0;

                                        $previous = $paging - 1;
                                        $next = $paging + 1;

                                        $query = mysqli_query($koneksi, "SELECT * FROM kerjakuliah");
                                        $totalquery = mysqli_num_rows($query);
                                        $totalpaging = ceil($totalquery / $limit);

                                        $querydata = mysqli_query($koneksi, "SELECT * FROM kerjakuliah WHERE tahun_alumni LIKE '%$selected_year%' AND nama_pelatihan LIKE '%$selected_training%' AND angkatan_alumni LIKE '%$selected_batch%' AND nama LIKE '%$search_name%' ORDER BY tahun_alumni $sort_order limit $main_page, $limit");
                                        while ($log = mysqli_fetch_assoc($querydata)) { ?>
                                            <tr>
                                                <td><?php echo $log['nama']; ?></td>
                                                <td><?php echo $log['nik']; ?></td>
                                                <td><?php echo $log['jenis_kelamin']; ?></td>
                                                <td><?php echo $log['tempat_lahir'] . ', ' . $log['tanggal_lahir']; ?></td>
                                                <td><?php echo $log['agama']; ?></td>
                                                <td><?php echo $log['pendidikan_terakhir']; ?></td>
                                                <td><?php echo $log['alamat']; ?></td>
                                                <td><?php echo $log['no_telepon']; ?></td>
                                                <td><?php echo $log['angkatan_alumni']; ?></td>
                                                <td><?php echo $log['nama_pelatihan']; ?></td>
                                                <td><?php echo $log['tahun_alumni']; ?></td>
                                                <?php if ($log['gambar'] != "") { ?>
                                                    <td><a href="crudkerkul/lihat.php?id=<?php echo $log['id']; ?>"><img src="crudkerkul/gambar/<?php echo $log['gambar']; ?>" style="width:50px;"></a></td>
                                                <?php } ?>
                                                <?php if ($log['gambar'] == "") { ?>
                                                    <td>Tidak ada gambar</td>
                                                <?php } ?>
                                                <td class="text-center"><a href="crudkerkul/edit.php?id=<?php echo $log['id']; ?>" class="btn btn-warning btn-icon"><i class="fas fa-edit"></i> Edit</a></td>
                                                <td class="text-center"><a href="crudkerkul/cetak_sertifikat.php?id=<?php echo $log['id']; ?>" class="btn btn-success btn-icon"><i class="fas fa-certificate"></i> Cetak Sertifikat</a></td>
                                                <td class="text-center"><a href="crudkerkul/hapus.php?id=<?php echo $log['id']; ?>" class="btn btn-danger btn-icon" onclick="return confirm('Yakin ingin hapus data?')"><i class="fas fa-trash-alt"></i> Hapus</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <?php if (mysqli_num_rows($querydata) > 0) { ?>
                            <ul class="pagination bgadjust justify-content-center">
                                <li class="page-item bgadjust">
                                    <a class="page-link bgadjust bgadjust-hover" <?php if ($paging > 1) {
                                                                                        echo "href='?paging=$previous&tahun_alumni=$selected_year&nama_pelatihan=$selected_training&angkatan_alumni=$selected_batch&nama=$search_name'";
                                                                                    } ?>><i class="fas fa-backward"></i></a>
                                </li>
                                <?php
                                for ($x = 1; $x <= $totalpaging; $x++) {
                                ?>
                                    <li class="page-item bgadjust"><a class="page-link bgadjust bgadjust-hover" href="?paging=<?php echo $x ?>&tahun_alumni=<?php echo $selected_year; ?>&nama_pelatihan=<?php echo $selected_training; ?>&angkatan_alumni=<?php echo $selected_batch; ?>&nama=<?php echo $search_name; ?>"><?php echo $x; ?></a></li>
                                <?php
                                }
                                ?>
                                <li class="page-item bgadjust">
                                    <a class="page-link bgadjust bgadjust-hover" <?php if ($paging < $totalpaging) {
                                                                                        echo "href='?paging=$next&tahun_alumni=$selected_year&nama_pelatihan=$selected_training&angkatan_alumni=$selected_batch&nama=$search_name'";
                                                                                    } ?>><i class="fas fa-forward"></i></a>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="footer transition">
            <hr>
            <p>
                &copy; 2020 All Right Reserved. | Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a>
            </p>
        </div>

        <!-- Loader -->
        <div class="loader">
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="loader-overlay"></div>

        <!-- Library Javascipt-->
        <script src="assets/vendors/bootstrap/js/jquery.min.js"></script>
        <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendors/bootstrap/js/popper.min.js"></script>
        <script src="assets/js/script.js"></script>
    </body>

    </html> 