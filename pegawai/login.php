<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM laboran_kalab WHERE nip = ?");
    $stmt->execute([$nip]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['nip'] = $user['nip'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'laboran') {
            header("Location: laboran/index.php");
        } elseif ($user['role'] == 'kalab') {
            header("Location: kalab/index.php");
        }
        exit;
    } else {
        $error = "NIP atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Laboran/Kalab</title>
    <link href="path/to/sb-admin-2.min.css" rel="stylesheet">
</head>

<?php include '../component/header_auth.php'; ?>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login Laboran/Kalab</h1>
                                </div>
                                <form class="user" method="post" action="login.php">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="nip" placeholder="NIP" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    <?php if (isset($error)): ?>
                                        <div class="text-danger text-center mt-3"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php include '../component/footer_auth.php'; ?>
