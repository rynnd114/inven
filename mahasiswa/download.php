<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Memulai sesi untuk mengambil data pengguna
session_start();

// Cek apakah user telah login
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit;
}

// Ambil data pengguna dari database
$nim = $_SESSION['nim'];

// Koneksi ke database (ganti sesuai dengan konfigurasi database Anda)
$mysqli = new mysqli('localhost', 'root', '', 'inven');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query untuk mengambil data pengguna
$userQuery = $mysqli->prepare("SELECT name, telp, alamat FROM users WHERE nim = ?");
$userQuery->bind_param('s', $nim);
$userQuery->execute();
$userQuery->store_result();

// Pastikan data ditemukan
if ($userQuery->num_rows > 0) {
    $userQuery->bind_result($nama, $telepon, $alamat);
    $userQuery->fetch();
} else {
    die("Data pengguna tidak ditemukan.");
}

// Ambil data dari form (atau Anda bisa mengambilnya dari database jika diperlukan)
$jenis_peminjaman = $_POST['jenis_peminjaman'];
$nama_kegiatan = $_POST['nama_kegiatan'];
$hari_tanggal_mulai = $_POST['hari_tanggal_mulai'];
$hari_tanggal_selesai = $_POST['hari_tanggal_selesai'];
$waktu_mulai = $_POST['waktu_mulai'];
$waktu_selesai = $_POST['waktu_selesai'];
$jumlah_peserta = $_POST['jumlah_peserta'];
$jenis_ruangan = $_POST['jenis_ruangan'];
$fasilitas = implode(", ", $_POST['fasilitas']);
$tanggal_pengambilan = $_POST['tanggal_pengambilan'];
$tanggal_pengembalian = $_POST['tanggal_pengembalian'];

// Buat instance TemplateProcessor dan buka template dokumen Word
$templateProcessor = new TemplateProcessor('template.docx'); // Ganti dengan path template Anda

// Mengganti placeholder dalam template dengan data input pengguna
$templateProcessor->setValue('nim', $nim);
$templateProcessor->setValue('name', $nama); // Data nama dari database
$templateProcessor->setValue('telp', $telepon); // Data telepon dari database
$templateProcessor->setValue('alamat', $alamat); // Data alamat dari database
$templateProcessor->setValue('nama_kegiatan', $nama_kegiatan);
$templateProcessor->setValue('hari_tanggal_mulai', $hari_tanggal_mulai);
$templateProcessor->setValue('hari_tanggal_selesai', $hari_tanggal_selesai);
$templateProcessor->setValue('waktu_mulai', $waktu_mulai);
$templateProcessor->setValue('waktu_selesai', $waktu_selesai);
$templateProcessor->setValue('jumlah_peserta', $jumlah_peserta);
$templateProcessor->setValue('jenis_ruangan', $jenis_ruangan);
$templateProcessor->setValue('fasilitas', $fasilitas);
$templateProcessor->setValue('tanggal_pengambilan', $tanggal_pengambilan);
$templateProcessor->setValue('tanggal_pengembalian', $tanggal_pengembalian);
$templateProcessor->setValue('jenis_peminjaman', $jenis_peminjaman);

// Nama file untuk diunduh
$fileName = 'Peminjaman_Lab_' . $nim . '.docx';

// Simpan dokumen dan mengirimkan untuk diunduh
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
$templateProcessor->saveAs("php://output");
exit;
?>
