<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit;
}
?>

<?php include '../component/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Form Pengajuan Jadwal Laboratorium</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Isi Formulir Pengajuan</h6>
                </div>
                <div class="card-body">
                    <form action="proses_pengajuan.php" method="post">
                        <div class="form-group">
                            <label for="hari">Pilih Hari:</label>
                            <select class="form-control" name="hari" id="hari" required>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ruangan1">Ruangan 1:</label>
                            <select class="form-control" name="ruangan1" id="ruangan1" required>
                                <option value="D203">D203</option>
                                <option value="D208">D208</option>
                                <option value="Lab. Komputasi">Lab. Komputasi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ruangan2">Ruangan 2:</label>
                            <select class="form-control" name="ruangan2" id="ruangan2" required>
                                <option value="D208">D208</option>
                                <option value="D203">D203</option>
                                <option value="Lab. Komputasi">Lab. Komputasi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kelas1">Kelas:</label>
                            <select class="form-control" name="kelas1" id="kelas1" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="A1">A1 & A2</option>
                                <option value="B1">B1 & B2</option>
                                <option value="C1">C1 & C2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jam_awal">Pilih Jam:</label>
                            <select class="form-control" name="jam_awal" id="jam_awal" required>
                                <option value="07.30 - 08.30">07.30 - 09.30</option>
                                <option value="08.30 - 09.30">08.30 - 10.30</option>
                                <option value="09.30 - 10.30">09.30 - 11.30</option>
                                <option value="10.30 - 11.30">10.30 - 12.30</option>
                                <option value="11.30 - 12.30">11.30 - 13.30</option>
                                <option value="12.30 - 13.30">12.30 - 14.30</option>
                                <option value="13.30 - 14.30">13.30 - 15.30</option>
                                <option value="14.30 - 15.30">14.30 - 16.30</option>
                                <option value="15.30 - 16.30">15.30 - 17.30</option>
                                <option value="16.30 - 17.30">16.30 - 18.30</option>
                                <option value="17.30 - 18.30">17.30 - 19.30</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="angkatan">Angkatan:</label>
                            <input type="text" class="form-control" name="angkatan" id="angkatan" required>
                        </div>

                        <div class="form-group">
                            <label for="kegiatan">Mata Kuliah:</label>
                            <input type="text" class="form-control" name="kegiatan" id="kegiatan" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Ajukan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../component/footer.php'; ?>
