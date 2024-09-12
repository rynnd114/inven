<?php
require_once '../vendor/autoload.php'; // Pastikan path ini sesuai dengan lokasi autoload.php PHPWord

use PhpOffice\PhpWord\TemplateProcessor;

// Fungsi untuk mengubah nama hari ke bahasa Indonesia
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

// Pastikan pengguna sudah login
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit;
}

require '../config/database.php';

$nim = $_SESSION['nim'];
$bookingId = $_GET['id']; // Ambil ID peminjaman dari parameter URL

// Query untuk mengambil data peminjaman
$queryBooking = "SELECT * FROM lab_bookings WHERE id = ?";
$stmtBooking = $pdo->prepare($queryBooking);
$stmtBooking->execute([$bookingId]);
$booking = $stmtBooking->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die('Peminjaman tidak ditemukan.');
}

// Query untuk mengambil data pengguna
$queryUser = "SELECT * FROM users WHERE nim = ?";
$stmtUser = $pdo->prepare($queryUser);
$stmtUser->execute([$nim]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Data pengguna tidak ditemukan.');
}

// Load template Word
$templatePath = 'template.docx'; // Path ke file template
$templateProcessor = new TemplateProcessor($templatePath);

// Tanggal hari ini dalam format bahasa Indonesia
$today = hariIndonesia(date('l')) . ', ' . date('d-m-Y');

// Ganti placeholder dengan data dari database
$templateProcessor->setValue('nim', $booking['nim']);
$templateProcessor->setValue('nama_kegiatan', $booking['nama_kegiatan']);
$templateProcessor->setValue('hari_tanggal_mulai', hariIndonesia(date('l', strtotime($booking['hari_tanggal_mulai']))) . ', ' . date('d-m-Y', strtotime($booking['hari_tanggal_mulai'])));
$templateProcessor->setValue('hari_tanggal_selesai', hariIndonesia(date('l', strtotime($booking['hari_tanggal_selesai']))) . ', ' . date('d-m-Y', strtotime($booking['hari_tanggal_selesai'])));
$templateProcessor->setValue('waktu_mulai', date('H:i', strtotime($booking['waktu_mulai'])));
$templateProcessor->setValue('waktu_selesai', date('H:i', strtotime($booking['waktu_selesai'])));
$templateProcessor->setValue('jumlah_peserta', $booking['jumlah_peserta']);
$templateProcessor->setValue('periode_peminjaman', $booking['periode_peminjaman']);
$templateProcessor->setValue('jenis_ruangan', $booking['jenis_ruangan']);
$templateProcessor->setValue('fasilitas', $booking['fasilitas']);
$templateProcessor->setValue('tanggal_pengambilan', hariIndonesia(date('l', strtotime($booking['tanggal_pengambilan']))) . ', ' . date('d-m-Y', strtotime($booking['tanggal_pengambilan'])));
$templateProcessor->setValue('tanggal_pengembalian', hariIndonesia(date('l', strtotime($booking['tanggal_pengembalian']))) . ', ' . date('d-m-Y', strtotime($booking['tanggal_pengembalian'])));
$templateProcessor->setValue('catatan_peminjaman', $booking['catatan_peminjaman']);

// Ganti placeholder tambahan dengan data pengguna
$templateProcessor->setValue('nama', $user['name']);
$templateProcessor->setValue('nim', $user['nim']);
$templateProcessor->setValue('prodi', $user['prodi']);
$templateProcessor->setValue('alamat', $user['alamat']);
$templateProcessor->setValue('telp', $user['telp']);

// Ganti placeholder untuk tanggal hari ini
$templateProcessor->setValue('tanggal_hari_ini', $today);

// Simpan file Word yang telah diproses
$outputPath = 'booking_' . $bookingId . '.docx'; // Path untuk menyimpan file hasil
$templateProcessor->saveAs($outputPath);

// Unduh file Word
header("Content-Description: File Transfer");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"" . basename($outputPath) . "\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($outputPath));
readfile($outputPath);
exit;
?>
