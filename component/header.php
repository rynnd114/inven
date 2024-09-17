<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan role sudah tersimpan di session saat user login
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$name = $_SESSION['name'] ?? 'Guest';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Inventaris dan Peminjaman</title>
    <link href="style/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="style/assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="style/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="style/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="style/assets/vendor/aos/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/tooltipster/dist/css/tooltipster.bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
    <style>
        .ditolak {
            background-color: #dc3545 !important;
            /* warna merah */
            color: white;
        }

        .disetujui {
            background-color: #007bff !important;
            /* warna biru */
            color: white;
        }

        .selesai {
            background-color: #28a745 !important;
            /* warna hijau */
            color: white;
        }

        .menunggu {
            background-color: #ffc107 !important;
            /* warna kuning */
            color: white;
        }
    </style>
    <style>
        body {
            background-color: #FFA500;
            /* Warna oranye */
        }

        .contaier {
            /*perbsesar ukurannya */
            width: 100%;
            margin: 0 auto;

        }

        .btn-primary {
            background-color: #FFA500;
            border-color: #FFA500;
        }

        .btn-primary:hover {
            background-color: #FF8C00;
            border-color: #FF8C00;
        }

        .card {
            border-color: #FFA500;
        }

        .text-primary {
            color: #FFA500 !important;
        }

        .table {
            width: 100%;
            table-layout: auto;
        }

        .table th,
        .table td {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }
        
        .informatika {
            background-color: red;
            color: white;
        }

        .sistem-informasi {
            background-color: blue;
            color: white;
        }

        .arsitektur {
            background-color: orange;
            color: black;
        }

        .sipil {
            background-color: yellow;
            color: black;
        }

        .teknik-kimia {
            background-color: purple;
            color: white;
        }
    </style>

    
    <!-- Tambahkan CSS lain jika diperlukan -->
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-computer" style="color: #FFD43B;"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIPL</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Heading -->
            <div class="sidebar-heading">
                <?php
                if ($role == 'mahasiswa') {
                    echo "Mahasiswa Menu";
                } elseif ($role == 'laboran') {
                    echo "Laboran Menu";
                } elseif ($role == 'kalab') {
                    echo "Kalab Menu";
                }
                ?>
            </div>

            <!-- Menu Items -->
            <?php
            if ($role == 'mahasiswa') {
                echo '<li class="nav-item active">
                    <a class="nav-link" href="/inven/mahasiswa/index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
                <li class="nav-item">
    <a class="nav-link" href="/inven/mahasiswa/form_peminjaman.php">
        <i class="fas fa-fw fa-calendar"></i>
        <span>Form Peminjaman</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/inven/mahasiswa/form_penjadwalan.php">
        <i class="fas fa-fw fa-calendar"></i>
        <span>Form Penjadwalan</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/inven/mahasiswa/list_peminjaman.php">
        <i class="fas fa-fw fa-list"></i>
        <span>Status Peminjaman</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="/inven/mahasiswa/list_penjadwalan.php">
        <i class="fas fa-fw fa-list"></i>
        <span>List Penjadwalan</span></a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room1Collapse" aria-expanded="true" aria-controls="room1Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D203</span>
    </a>
    <div id="room1Collapse" class="collapse" aria-labelledby="headingRoom1" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/D203/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/D203/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room2Collapse" aria-expanded="true" aria-controls="room2Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D208</span>
    </a>
    <div id="room2Collapse" class="collapse" aria-labelledby="headingRoom2" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/D208/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/D208/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room3Collapse" aria-expanded="true" aria-controls="room3Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>Lab Komputasi</span>
    </a>
    <div id="room3Collapse" class="collapse" aria-labelledby="headingRoom3" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/komputasi/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/mahasiswa/komputasi/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="/inven/mahasiswa/room1_electronics.php">
        <i class="fas fa-fw fa-plug"></i>
        <span>Electronics</span>
    </a>
</li>

';
            } elseif ($role == 'laboran') {
                echo '<!-- Nav Item - Dashboard -->
<li class="nav-item active">
                    <a class="nav-link" href="/inven/pegawai/laboran/index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item">
        <a class="nav-link" href="/inven/pegawai/laboran/approve_peminjaman.php">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Approve Peminjaman</span>
        </a>
    </li>
 <li class="nav-item">
        <a class="nav-link" href="/inven/pegawai/laboran/list_peminjaman.php">
            <i class="fas fa-fw fa-list"></i>
            <span>Daftar Peminjaman</span>
        </a>
    </li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room1Collapse" aria-expanded="true" aria-controls="room1Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D203</span>
    </a>
    <div id="room1Collapse" class="collapse" aria-labelledby="headingRoom1" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/D203/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/D203/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room2Collapse" aria-expanded="true" aria-controls="room2Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D208</span>
    </a>
    <div id="room2Collapse" class="collapse" aria-labelledby="headingRoom2" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/D208/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/D208/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room3Collapse" aria-expanded="true" aria-controls="room3Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>Lab Komputasi</span>
    </a>
    <div id="room3Collapse" class="collapse" aria-labelledby="headingRoom3" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/komputasi/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/laboran/komputasi/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="room1_electronics.php">
        <i class="fas fa-fw fa-plug"></i>
        <span>Electronics</span>
    </a>
</li>';
            } elseif ($role == 'kalab') {
                echo '<li class="nav-item">
                    <a class="nav-link" href="/inven/pegawai/kalab/index.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                  </li>
                  <li class="nav-item">
        <a class="nav-link" href="/inven/pegawai/kalab/approve_peminjaman.php">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Approve Peminjaman</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/inven/pegawai/kalab/list_peminjaman.php">
            <i class="fas fa-fw fa-list"></i>
            <span>Daftar Peminjaman</span>
        </a>
    </li>
                  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room1Collapse" aria-expanded="true" aria-controls="room1Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D203</span>
    </a>
    <div id="room1Collapse" class="collapse" aria-labelledby="headingRoom1" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/D203/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/D203/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room2Collapse" aria-expanded="true" aria-controls="room2Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>D208</span>
    </a>
    <div id="room2Collapse" class="collapse" aria-labelledby="headingRoom2" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/D208/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/D208/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room3Collapse" aria-expanded="true" aria-controls="room3Collapse">
        <i class="fas fa-fw fa-door-open"></i>
        <span>Lab Komputasi</span>
    </a>
    <div id="room3Collapse" class="collapse" aria-labelledby="headingRoom3" data-parent="#accordionSidebar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/komputasi/laptop/index.php">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Laptop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/inven/pegawai/kalab/komputasi/furniture/index.php">
                    <i class="fas fa-fw fa-couch"></i>
                    <span>Furniture</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="room1_electronics.php">
        <i class="fas fa-fw fa-plug"></i>
        <span>Electronics</span>
    </a>
</li>';
            }
            ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                                <img class="img-profile rounded-circle" src="style/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">