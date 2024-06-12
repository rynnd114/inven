<?php
// Fungsi untuk mengubah format tanggal
function formatTanggal($tanggal) {
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


?>
