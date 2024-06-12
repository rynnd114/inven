<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <!-- Custom fonts for this template-->
    <link href="sb-admin-2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for the project -->
    <link href="sb-admin-2/css/styles.css" rel="stylesheet">

    <!-- Header.php -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-J2BAdmSaPDa4Np+KU5N8F0c2PrU5AnSIQGY76zX4HXg1i1aqPb7Z/kqI3lg6X8L5" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-+4Eys40xCxCWj5/Po0x1mTQdNlJ0lvF51oc1xA7XNH0=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laptop"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Inventory</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room1Collapse" aria-expanded="true" aria-controls="room1Collapse">
                    <i class="fas fa-fw fa-door-open"></i>
                    <span>Room 1</span>
                </a>
                <div id="room1Collapse" class="collapse" aria-labelledby="headingRoom1" data-parent="#accordionSidebar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="room1_laptop.php">
                                <i class="fas fa-fw fa-laptop"></i>
                                <span>Laptop</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room1_furniture.php">
                                <i class="fas fa-fw fa-couch"></i>
                                <span>Furniture</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room1_electronics.php">
                                <i class="fas fa-fw fa-plug"></i>
                                <span>Electronics</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room2Collapse" aria-expanded="true" aria-controls="room2Collapse">
                    <i class="fas fa-fw fa-door-open"></i>
                    <span>Room 2</span>
                </a>
                <div id="room2Collapse" class="collapse" aria-labelledby="headingRoom2" data-parent="#accordionSidebar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="room2_laptop.php">
                                <i class="fas fa-fw fa-laptop"></i>
                                <span>Laptop</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room2_furniture.php">
                                <i class="fas fa-fw fa-couch"></i>
                                <span>Furniture</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room2_electronics.php">
                                <i class="fas fa-fw fa-plug"></i>
                                <span>Electronics</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room3Collapse" aria-expanded="true" aria-controls="room3Collapse">
                    <i class="fas fa-fw fa-door-open"></i>
                    <span>Room 3</span>
                </a>
                <div id="room3Collapse" class="collapse" aria-labelledby="headingRoom3" data-parent="#accordionSidebar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="room3_laptop.php">
                                <i class="fas fa-fw fa-laptop"></i>
                                <span>Laptop</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room3_furniture.php">
                                <i class="fas fa-fw fa-couch"></i>
                                <span>Furniture</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="room3_electronics.php">
                                <i class="fas fa-fw fa-plug"></i>
                                <span>Electronics</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>
                                <img class="img-profile rounded-circle" src="sb-admin-2/img/undraw_profile.svg">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">