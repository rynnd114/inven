<?php
session_start();
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM laboran_kalab WHERE nip = ?");
    $stmt->execute([$nip]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];  // Tambahkan ini
        $_SESSION['nip'] = $user['nip'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = 'kalab';
        
        header("Location: index.php");
        exit;
    } else {
        $error = "NIM atau password salah";
    }
}
?>

<?php include '../../component/header_auth.php'; ?>

<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login Kalab</h1>
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
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../component/footer_auth.php'; ?>
</body>
</html>
