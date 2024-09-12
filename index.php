<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris dan Peminjaman</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .jumbotron {
    background-image: url('style/img/lab.jpg'); /* Ganti dengan path gambar Anda */
    background-size: cover;
    background-position: center;
    color: #000000;
    padding: 100px 20px;
    text-align: center;
    margin-bottom: 0;
    text-shadow: 
        -2px -2px 0 #ffffff,  
         2px -2px 0 #ffffff,
        -2px  2px 0 #ffffff,
         2px  2px 0 #ffffff; /* Outline putih */
}


        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }

        .section-content {
            padding: 50px 0;
            background-color: #fff;
            text-align: center;
        }

        .section-heading {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            background: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 30px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin-bottom: 0;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: #007bff;
            color: #fff;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        .back-to-top:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Inventaris & Peminjaman</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Jumbotron -->
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">SELAMAT DATANG DI SISTEM INVERTARIS DAN PEMINJAMAN LAB FAKULTAS TEKNIK</h1>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading">Tentang Sistem</h2>
                    <p class="text-muted">Sistem ini dirancang untuk mempermudah pengelolaan inventaris laboratorium dan peminjaman ruangan di lingkungan akademik. Kami menyediakan solusi terintegrasi untuk memenuhi kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="login" class="section-content bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading text-center mb-5">LOGIN SEBAGAI</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-user-graduate fa-4x mb-3" style="color: #ffa446;"></i>
                            <h5 class="card-title">Mahasiswa</h5>
                            <p class="card-text">Akses mudah untuk peminjaman laboratorium dan manajemen inventaris laboratorium bagi mahasiswa.</p>
                            <a href="mahasiswa/login.php" class="btn btn-primary btn-block" style="background-color: #ffa446; border-color: #ffa446;">Login</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-user-tie fa-4x mb-3" style="color: #ffa446;"></i>
                            <h5 class="card-title">Laboran</h5>
                            <p class="card-text">Layanan khusus untuk staf akademik dalam manajemen inventaris laboratorium dan peminjaman ruangan.</p>
                            <a href="pegawai/laboran/login.php" class="btn btn-primary btn-block" style="background-color: #ffa446; border-color: #ffa446;">Login</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-user-md fa-4x mb-3" style="color: #ffa446;"></i>
                            <h5 class="card-title">Kalab</h5>
                            <p class="card-text">Manajemen sistem inventaris laboratorium dan peminjaman ruangan oleh Kepala Laboratorium.</p>
                            <a href="pegawai/kalab/login.php" class="btn btn-primary btn-block" style="background-color: #ffa446; border-color: #ffa446;">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Hubungi Kami</h2>
                    <p class="text-muted mb-5">Jika Anda memiliki pertanyaan atau masalah, jangan ragu untuk menghubungi tim kami.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center mx-auto">
                    <i class="fa fa-envelope fa-3x mb-3" style="color: #ffa446;"></i>
                    <p><a style="color: #ffa446;" href="mailto:info@inventaris-peminjaman.com">info@inventaris-peminjaman.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-white mt-5">
        <div class="container p-4">
            <section class="mb-4">
                <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998;" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

                <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee;" href="#!" role="button"><i class="fab fa-twitter"></i></a>

                <a class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39;" href="#!" role="button"><i class="fab fa-google"></i></a>

                <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac;" href="#!" role="button"><i class="fab fa-instagram"></i></a>

                <a class="btn btn-primary btn-floating m-1" style="background-color: #0082ca;" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
            </section>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                &copy; 2024 Sistem Inventaris & Peminjaman. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a class="back-to-top" href="#"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Back to Top Script -->
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });

            $('.back-to-top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
    </script>

</body>

</html>
