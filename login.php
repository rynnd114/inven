<?php
require 'config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - SB Admin 2</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .bg-auth-image {
            background: url('img/auth-bg.jpg') no-repeat center center;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">

<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-auth-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
                            <form class="user" action="login.php" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="register.php">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
