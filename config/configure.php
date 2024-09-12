<?php
// Fungsi untuk mengubah format tanggal
function formatTanggal($tanggal)
{
    // Buat array dengan nama hari dalam bahasa Indonesia
    $nama_hari = array(
        "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
    );

    // Buat array dengan nama bulan dalam bahasa Indonesia
    $nama_bulan = array(
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    );

    // Ubah format tanggal menjadi array
    $date = new DateTime($tanggal);
    $tanggal_array = explode('-', $date->format('Y-m-d'));

    // Ambil nama hari dari array nama hari
    $nama_hari_index = $date->format('w');
    $nama_hari = $nama_hari[$nama_hari_index];

    // Ambil nama bulan dari array nama bulan
    $nama_bulan = $nama_bulan[intval($tanggal_array[1]) - 1];

    // Format tanggal yang sudah diperbaiki
    $tanggal_formatted = $nama_hari . ', ' . $tanggal_array[2] . ' ' . $nama_bulan . ' ' . $tanggal_array[0];

    return $tanggal_formatted;
}
// config/configure.php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

// Set timezone to WITA
date_default_timezone_set('Asia/Makassar');

// Debugging: Tampilkan waktu saat ini
$currentDateTime = date('Y-m-d H:i');

// Ambil waktu dan tanggal saat ini
$currentDateTime = (new DateTime())->format('Y-m-d H:i:s');

// Update status to "Ditolak" if the start time has passed and the booking is still pending
$updateQuery = "UPDATE lab_bookings 
                SET status = 'Ditolak', keterangan = 'Silahkan Ajukan Kembali' 
                WHERE status = 'Menunggu Persetujuan Laboran' 
                AND (CONCAT(hari_tanggal_mulai, ' ', waktu_mulai) < ?)";
$stmt = $pdo->prepare($updateQuery);
$updateSuccess = $stmt->execute([$currentDateTime]);

// Update status to "Selesai" if the end time has passed and the booking is still approved
$doneQuery = "UPDATE lab_bookings 
              SET status = 'Selesai' 
              WHERE status = 'Disetujui' 
              AND (CONCAT(hari_tanggal_selesai, ' ', waktu_selesai) < ?)";
$stmt = $pdo->prepare($doneQuery);
$doneSuccess = $stmt->execute([$currentDateTime]);

// Fetch updated bookings
$bookings = $pdo->query("SELECT lb.*, u.name AS mahasiswa_name 
                         FROM lab_bookings lb 
                         JOIN users u ON lb.nim = u.nim")
                 ->fetchAll(PDO::FETCH_ASSOC);


