<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit;
}

require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    // Ambil data dari form
    $jenis_peminjaman = $_POST['jenis_peminjaman'];
    $nim = $_SESSION['nim'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $hari_tanggal_mulai = $_POST['hari_tanggal_mulai'];
    $hari_tanggal_selesai = $_POST['hari_tanggal_selesai'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $jumlah_peserta = $_POST['jumlah_peserta'];
    $jenis_ruangan = $_POST['jenis_ruangan'];

    // Gabungkan array 'fasilitas' menjadi string
    $fasilitas = isset($_POST['fasilitas']) ? implode(', ', $_POST['fasilitas']) : '';

    $tanggal_pengambilan = $_POST['tanggal_pengambilan'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

    // Proses upload file
    $file_pengajuan = $_FILES['file_pengajuan'];
    $start_date = new DateTime($hari_tanggal_mulai);
    $end_date = new DateTime($hari_tanggal_selesai);
    $interval = $start_date->diff($end_date);
    $periode_peminjaman = $interval->days + 1; // Menambahkan 1 hari untuk periode inklusif

    // Validasi file upload
    if ($file_pengajuan['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $file_pengajuan['tmp_name'];
        $file_name = $file_pengajuan['name'];
        $file_size = $file_pengajuan['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['pdf'];

        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = 'uploads/'; // Pastikan direktori ini ada
            $file_path = $upload_dir . uniqid() . '.' . $file_ext;

            if (move_uploaded_file($file_tmp, $file_path)) {
                // File berhasil diunggah
                $file_pengajuan_url = $file_path;
            } else {
                $error = "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            $error = "Format file tidak didukung. Harap unggah file dalam format PDF";
        }
    } else {
        $error = "Terjadi kesalahan saat mengunggah file.";
    }

    if (!isset($error)) {
        // Simpan data ke database
        try {
            $pdo->beginTransaction();

            // Mengambil nomor surat terakhir
            $stmt = $pdo->prepare("SELECT MAX(nomor_surat) AS last_nomor_surat FROM lab_bookings");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['last_nomor_surat'] !== null) {
                // Jika ada nomor surat sebelumnya, tambahkan 1
                $lastNomorSurat = $result['last_nomor_surat'];
                $nomor_surat = $lastNomorSurat + 1;
            } else {
                // Jika belum ada, mulai dari 13
                $nomor_surat = 13;
            }

            $stmt = $pdo->prepare("
            INSERT INTO lab_bookings (
                nim, nama_kegiatan, hari_tanggal_mulai, hari_tanggal_selesai, waktu_mulai, waktu_selesai,
                jumlah_peserta, periode_peminjaman, jenis_ruangan, fasilitas, tanggal_pengambilan, tanggal_pengembalian, 
                jenis_peminjaman, file_pengajuan, nomor_surat, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu Persetujuan Laboran')
        ");
            $stmt->execute([
                $nim,
                $nama_kegiatan,
                $hari_tanggal_mulai,
                $hari_tanggal_selesai,
                $waktu_mulai,
                $waktu_selesai,
                $jumlah_peserta,
                $periode_peminjaman,
                $jenis_ruangan,
                $fasilitas,
                $tanggal_pengambilan,
                $tanggal_pengembalian,
                $jenis_peminjaman,
                $file_pengajuan_url,
                $nomor_surat // Nomor surat yang baru
            ]);

            $lab_booking_id = $pdo->lastInsertId();

            if ($jenis_peminjaman === 'berulang') {
                $days = $_POST['days'];
                foreach ($days as $day) {
                    $stmt = $pdo->prepare("INSERT INTO lab_booking_days (lab_booking_id, day_of_week) VALUES (?, ?)");
                    $stmt->execute([$lab_booking_id, $day]);
                }
            }

            $pdo->commit();
            $success = "Permintaan peminjaman telah diajukan dan menunggu persetujuan laboran.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Terjadi kesalahan saat memproses peminjaman: " . $e->getMessage();
        }
    }
}


?>

<?php include '../component/header.php'; ?>

<div class="container">
    <h1 class="my-4">Form Peminjaman Lab</h1>
    <?php if (isset($success)) : ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form id="formPeminjaman" method="post" action="form_peminjaman.php" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="nama_kegiatan">Nama Kegiatan</label>
            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
        </div>
        <div class="form-group">
            <label for="jenis_peminjaman">Jenis Peminjaman</label>
            <select class="form-control" id="jenis_peminjaman" name="jenis_peminjaman" required>
                <option value="berturut-turut">Berturut-turut</option>
                <option value="berulang">Berulang</option>
            </select>
        </div>
        <div class="form-group" id="hari_peminjaman" style="display: none;">
            <label>Hari Peminjaman (untuk peminjaman berulang)</label>
            <div class="row">
                <div class="col-sm-6">
                    <input type="checkbox" name="days[]" value="Monday"> Senin
                    <input type="checkbox" name="days[]" value="Tuesday"> Selasa
                    <input type="checkbox" name="days[]" value="Wednesday"> Rabu
                    <input type="checkbox" name="days[]" value="Thursday"> Kamis
                    <input type="checkbox" name="days[]" value="Friday"> Jumat
                    <input type="checkbox" name="days[]" value="Saturday"> Sabtu
                    <input type="checkbox" name="days[]" value="Sunday"> Minggu
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="hari_tanggal_mulai">Hari, Tanggal Mulai</label>
            <input type="date" class="form-control" id="hari_tanggal_mulai" name="hari_tanggal_mulai" required>
        </div>
        <div class="form-group">
            <label for="hari_tanggal_selesai">Hari, Tanggal Selesai</label>
            <input type="date" class="form-control" id="hari_tanggal_selesai" name="hari_tanggal_selesai" required>
        </div>
        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai</label>
            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
        </div>
        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai</label>
            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
        </div>
        <div class="form-group">
            <label for="jumlah_peserta">Jumlah Peserta</label>
            <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" required>
        </div>
        <div class="form-group">
            <label>Jenis Ruangan</label>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="lab_komputasi" name="jenis_ruangan" value="Lab Komputasi" required>
                        <label class="form-check-label" for="lab_komputasi">Lab Komputasi</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="lab_D203" name="jenis_ruangan" value="Lab D203" required>
                        <label class="form-check-label" for="lab_D203">Lab D203</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="lab_D208" name="jenis_ruangan" value="Lab D208" required>
                        <label class="form-check-label" for="lab_D208">Lab D208</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Fasilitas</label>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="meja" name="fasilitas[]" value="Meja">
                        <label class="form-check-label" for="meja">Meja</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="kursi" name="fasilitas[]" value="Kursi">
                        <label class="form-check-label" for="kursi">Kursi</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="komputer" name="fasilitas[]" value="Komputer">
                        <label class="form-check-label" for="komputer">Komputer</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="jaringan_listrik" name="fasilitas[]" value="Jaringan Listrik">
                        <label class="form-check-label" for="jaringan_listrik">Jaringan Listrik</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="jaringan_internet" name="fasilitas[]" value="Jaringan Internet">
                        <label class="form-check-label" for="jaringan_internet">Jaringan Internet</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ac_remote" name="fasilitas[]" value="AC & Remote">
                        <label class="form-check-label" for="ac_remote">AC & Remote</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="projector_monitor_tv" name="fasilitas[]" value="Projector / Monitor TV">
                        <label class="form-check-label" for="projector_monitor_tv">Projector / Monitor TV</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="lainnya" name="fasilitas[]" value="Lainnya">
                        <label class="form-check-label" for="lainnya">Lainnya</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="tanggal_pengambilan">Tanggal Pengambilan</label>
            <input type="date" class="form-control" id="tanggal_pengambilan" name="tanggal_pengambilan" required>
        </div>
        <div class="form-group">
            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
        </div>
        <div class="form-group">
            <label for="file_pengajuan">Upload Surat Pengajuan</label>
            <input type="file" class="form-control" id="file_pengajuan" name="file_pengajuan" required>
        </div>
        <input type="hidden" id="periode_peminjaman" name="periode_peminjaman">
        <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        <button type="button" class="btn btn-success" onclick="downloadWord()">Download Surat Pengajuan</button>

    </form>
</div>

<script>
    function downloadWord() {
        var form = document.getElementById('formPeminjaman');

        // Buat form baru untuk mengirimkan data
        var newForm = new FormData(form);

        // Kirim permintaan menggunakan fetch untuk download.php
        fetch('download.php', {
                method: 'POST',
                body: newForm
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                // Buat URL untuk download file
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'Peminjaman_Lab.pdf'; // Sesuaikan nama file dengan format yang tepat
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<script>
    document.getElementById('jenis_peminjaman').addEventListener('change', function() {
        var hariPeminjaman = document.getElementById('hari_peminjaman');
        if (this.value === 'berulang') {
            hariPeminjaman.style.display = 'block';
        } else {
            hariPeminjaman.style.display = 'none';
        }
    });

    function validateForm() {
        var today = new Date().toISOString().split('T')[0];
        var hariTanggalMulai = document.getElementById('hari_tanggal_mulai').value;
        var hariTanggalSelesai = document.getElementById('hari_tanggal_selesai').value;
        var waktuMulai = document.getElementById('waktu_mulai').value;
        var waktuSelesai = document.getElementById('waktu_selesai').value;
        var tanggalPengambilan = document.getElementById('tanggal_pengambilan').value;
        var tanggalPengembalian = document.getElementById('tanggal_pengembalian').value;

        if (hariTanggalMulai < today) {
            alert('Tanggal mulai tidak boleh kurang dari hari ini.');
            return false;
        }

        if (hariTanggalSelesai < hariTanggalMulai) {
            alert('Tanggal selesai tidak boleh kurang dari tanggal mulai.');
            return false;
        }

        if (tanggalPengambilan < today) {
            alert('Tanggal pengambilan tidak boleh kurang dari hari ini.');
            return false;
        }

        if (tanggalPengembalian < tanggalPengambilan) {
            alert('Tanggal pengembalian tidak boleh kurang dari tanggal pengambilan.');
            return false;
        }

        if (waktuSelesai <= waktuMulai) {
            alert('Waktu selesai tidak boleh kurang dari atau sama dengan waktu mulai.');
            return false;
        }

        // Hitung periode peminjaman
        var startDate = new Date(hariTanggalMulai);
        var endDate = new Date(hariTanggalSelesai);
        var timeDiff = endDate - startDate;
        var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Tambahkan 1 hari untuk inklusif

        document.getElementById('periode_peminjaman').value = daysDiff + ' hari';

        return true;
    }
</script>

<?php include '../component/footer.php'; ?>