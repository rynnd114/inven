<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $name = $_POST['name'];
    $prodi = $_POST['prodi'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("
        INSERT INTO users (nim, name, prodi, alamat, telp, password) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    if ($stmt->execute([$nim, $name, $prodi, $alamat, $telp, $password])) {
        $_SESSION['nim'] = $nim;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = 'mahasiswa';
        header("Location: login.php");
        exit;
    } else {
        $error = "Pendaftaran gagal, coba lagi.";
    }
}
?>

<?php include '../component/header_auth.php'; ?>

<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Daftar Mahasiswa</h1>
                            </div>
                            <form class="user" method="post" action="register.php">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nim" placeholder="NIM" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="name" placeholder="Nama" required>
                                </div>
                                <div class="form-group">
                                    <select name="prodi" required>
                                        <option value="">Pilih Prodi</option>
                                        <option value="IF">Informatika (IF)</option>
                                        <option value="SI">Sistem Informasi (SI)</option>
                                        <option value="Arsitektur">Arsitektur</option>
                                        <option value="Sipil">Sipil</option>
                                        <option value="Teknik Kimia">Teknik Kimia</option>
                                    </select><br>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control form-control-user" name="alamat" placeholder="Alamat" rows="2" required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="telp" placeholder="Nomor Telepon" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                                <?php if (isset($error)): ?>
                                    <div class="text-danger text-center mt-3"><?php echo $error; ?></div>
                                <?php endif; ?>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../component/footer_auth.php'; ?>