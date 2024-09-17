<?php
session_start();
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Dapatkan detail jadwal berdasarkan id
    $stmt = $pdo->prepare("SELECT kegiatan FROM jadwal_lab WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $jadwal = $stmt->fetch();

    if ($jadwal) {
        // Hapus semua jadwal yang memiliki kegiatan yang sama
        $stmt = $pdo->prepare("DELETE FROM jadwal_lab WHERE kegiatan = :kegiatan");
        $stmt->execute(['kegiatan' => $jadwal['kegiatan']]);

        // Set session untuk menampilkan SweetAlert
        $_SESSION['delete_success'] = true;
    }

    // Redirect ke index.php tanpa parameter query
    header("Location: index.php");
    exit;
} else {
    echo "ID tidak ditemukan!";
}
?>
