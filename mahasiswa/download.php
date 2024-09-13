<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Memulai sesi untuk mengambil data pengguna
session_start();

function hariIndonesia($day) {
    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    return $hari[$day];
}

// Cek apakah user telah login
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
require '../config/database.php';

// Ambil data pengguna berdasarkan NIM
$nim = $_SESSION['nim'];
$sql = "SELECT * FROM users WHERE nim = '$nim'";
$result = $conn->query($sql);

// Memeriksa apakah data ditemukan
if ($result->num_rows > 0) {
    // Mengambil data pengguna
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $alamat = $row['alamat'];
    $telp = $row['telp'];
    $prodi = $row['prodi'];
    // Tambahkan data lainnya jika diperlukan
} else {
    echo "Data pengguna tidak ditemukan.";
    exit;
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
$today = hariIndonesia(date('l')) . ', ' . date('d-m-Y');
$dateMulai = new DateTime($hari_tanggal_mulai);
$dateSelesai = new DateTime($hari_tanggal_selesai);
$interval = $dateMulai->diff($dateSelesai);
$periode_peminjaman = $interval->days;



// Buat instance TemplateProcessor dan buka template dokumen Word
$templateProcessor = new TemplateProcessor('template.docx'); // Ganti dengan path template Anda

// Mengganti placeholder dalam template dengan data input pengguna
$templateProcessor->setValue('nim', $nim);
$templateProcessor->setValue('nama', $name); // Contoh mengganti dengan nama pengguna
$templateProcessor->setValue('alamat', $alamat); // Contoh mengganti dengan alamat pengguna
$templateProcessor->setValue('telp', $telp); // Contoh mengganti dengan telp pengguna
$templateProcessor->setValue('prodi', $prodi); // Contoh mengganti dengan prodi pengguna
$templateProcessor->setValue('nama_kegiatan', $nama_kegiatan);
$templateProcessor->setValue('hari_tanggal_mulai', hariIndonesia(date('l', strtotime($hari_tanggal_mulai))) . ', ' . date('d-m-Y', strtotime($hari_tanggal_mulai)));
$templateProcessor->setValue('hari_tanggal_selesai', hariIndonesia(date('l', strtotime($hari_tanggal_selesai))) . ', ' . date('d-m-Y', strtotime($hari_tanggal_selesai)));
$templateProcessor->setValue('periode_peminjaman', $periode_peminjaman);
$templateProcessor->setValue('waktu_mulai', $waktu_mulai);
$templateProcessor->setValue('waktu_selesai', $waktu_selesai);
$templateProcessor->setValue('jumlah_peserta', $jumlah_peserta);
$templateProcessor->setValue('jenis_ruangan', $jenis_ruangan);
$templateProcessor->setValue('fasilitas', $fasilitas);
$templateProcessor->setValue('tanggal_pengambilan', hariIndonesia(date('l', strtotime($tanggal_pengambilan))) . ', ' . date('d-m-Y', strtotime($tanggal_pengambilan)));
$templateProcessor->setValue('tanggal_pengembalian', hariIndonesia(date('l', strtotime($tanggal_pengembalian))) . ', ' . date('d-m-Y', strtotime($tanggal_pengembalian)));
$templateProcessor->setValue('jenis_peminjaman', $jenis_peminjaman);
$templateProcessor->setValue('tanggal_hari_ini', $today);


// Nama file untuk diunduh
$fileName = 'Peminjaman_Lab_' . $nim . '.docx';

// Simpan dokumen dan mengirimkan untuk diunduh
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
$templateProcessor->saveAs("php://output");
exit;
?>
