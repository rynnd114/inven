<?php
// Mulai sesi
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inven"; // Sesuaikan dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    die("Pengguna tidak terautentikasi.");
}

// Ambil data dari form
// Ambil data dari form
$hari = $_POST['hari'];
$ruangan1 = $_POST['ruangan1']; // Bisa berupa array
$ruangan2 = $_POST['ruangan2']; // Bisa berupa array
$jam_awal = $_POST['jam_awal'];
$kegiatan = $_POST['kegiatan'];
$angkatan = $_POST['angkatan'];
$kelas1 = $_POST['kelas1'];
$user_id = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

$kelasMapping = [
    'A' => 'A',
    'B' => 'B',
    'C' => 'C',
    'A1' => 'A2',
    'B1' => 'B2',
    'C1' => 'C2',
    // Tambahkan aturan lain jika perlu
];

$kelas2 = isset($kelasMapping[$kelas1]) ? $kelasMapping[$kelas1] : '';

// Daftar waktu dalam urutan
$timeSlots = [
    "07.30 - 08.30",
    "08.30 - 09.30",
    "09.30 - 10.30",
    "10.30 - 11.30",
    "11.30 - 12.30",
    "12.30 - 13.30",
    "13.30 - 14.30",
    "14.30 - 15.30",
    "15.30 - 16.30",
    "16.30 - 17.30",
    "17.30 - 18.30",
    "18.30 - 19.30"
];

// Temukan indeks waktu awal
$jam_awal_index = array_search($jam_awal, $timeSlots);

// Pastikan jam akhir berada dalam batas waktu
if ($jam_awal_index !== false && $jam_awal_index + 1 < count($timeSlots)) {
    $jam_akhir = $timeSlots[$jam_awal_index + 1];

    // Ambil data prodi dari profil pengguna
    $prodi_sql = "SELECT prodi FROM users WHERE id = ?";
    $stmt = $conn->prepare($prodi_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($prodi);
    $stmt->fetch();
    $stmt->close();

    if ($prodi) {
        // Periksa apakah kedua slot waktu tersedia untuk masing-masing ruangan
        $check_sql = "SELECT * FROM jadwal_lab 
                      WHERE hari = ? 
                      AND (ruangan1 = ? OR ruangan2 = ?) 
                      AND (waktu = ? OR waktu = ?)";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("sssss", $hari, $ruangan1, $ruangan2, $jam_awal, $jam_akhir);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "Jadwal sudah ada untuk ruangan 1 atau 2, silakan pilih waktu atau ruangan yang lain.";
            $stmt->close();
            $conn->close();
            exit;
        }

        // Masukkan data ke dalam tabel untuk kedua slot waktu berturut-turut
        $insert_sql = "INSERT INTO jadwal_lab (hari, ruangan1, ruangan2, waktu, kegiatan, angkatan, kelas1, kelas2, prodi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);

        // Insert pertama
        $stmt->bind_param("sssssssss", $hari, $ruangan1, $ruangan2, $jam_awal, $kegiatan, $angkatan, $kelas1, $kelas2, $prodi);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            $stmt->close();
            $conn->close();
            exit;
        }

        // Insert kedua
        $stmt->bind_param("sssssssss", $hari, $ruangan1, $ruangan2, $jam_akhir, $kegiatan, $angkatan, $kelas1, $kelas2, $prodi);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        } else {
            echo "Pengajuan berhasil diajukan untuk ruangan $ruangan1 dan $ruangan2!";
        }


        $stmt->close();
    } else {
        echo "Gagal mendapatkan data prodi pengguna.";
    }
} else {
    echo "Waktu yang dipilih tidak valid.";
}

$conn->close();
