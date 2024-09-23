<?php
require_once '../vendor/autoload.php';

use Ilovepdf\OfficepdfTask;
use PhpOffice\PhpWord\TemplateProcessor;

session_start();

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
} else {
    echo "Data pengguna tidak ditemukan.";
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data peminjaman berdasarkan ID
    $sql = "SELECT * FROM lab_bookings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa apakah data ditemukan
    if ($data = mysqli_fetch_assoc($result)) {
        // Mengambil data peminjaman
        $nim = $data['nim'];

        $id = $data['id'];
        $nama_kegiatan = $data['nama_kegiatan'];
        $hari_tanggal_mulai = $data['hari_tanggal_mulai'];
        $hari_tanggal_selesai = $data['hari_tanggal_selesai'];
        $waktu_mulai = $data['waktu_mulai'];
        $waktu_selesai = $data['waktu_selesai'];
        $jenis_ruangan = $data['jenis_ruangan'];
        $created_at = $data['created_at'];
        $nomor_surat = $data['nomor_surat'];
        $no_surat = $data['no_surat'];

        // Menghitung selisih hari
        $dateMulai = new DateTime($hari_tanggal_mulai);
        $dateSelesai = new DateTime($hari_tanggal_selesai);
        $interval = $dateMulai->diff($dateSelesai);
        $periode_peminjaman = $interval->days + 1;

        function hariIndonesia($day)
        {
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
        $today = date('d F Y');

        function bulanRomawi($bulan)
        {
            $romawi = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII'
            ];

            return $romawi[$bulan];
        }

        $bulan = date('n'); // Mengambil bulan dalam bentuk angka (1-12)
        $tahun = date('Y'); // Mengambil tahun

        $formatBulanTahun = bulanRomawi($bulan) . '/' . $tahun;

        $format4 = date('d F Y', strtotime($created_at));
        $format4 = str_replace(
            array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
            $format4
        );

        $format5 = date('d F Y', strtotime($hari_tanggal_mulai));
        $format5 = str_replace(
            array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
            $format5
        );

        // Menentukan format tanggal
        

        // Load template Word
        $templatePath = 'persetujuan.docx'; // Path ke file template
        $templateProcessor = new TemplateProcessor($templatePath);
        $templateProcessor->setValue('nama', $name);
        $templateProcessor->setValue('nama_kegiatan', $nama_kegiatan);
        $templateProcessor->setValue('waktu_mulai', date('H.i', strtotime($waktu_mulai)));
        $templateProcessor->setValue('waktu_selesai', date('H.i', strtotime($waktu_selesai)));
        $templateProcessor->setValue('tanggal_pengajuan', $format4);
        $templateProcessor->setValue('jenis_ruangan', $jenis_ruangan);
        $templateProcessor->setValue('tanggal_hari_ini', $today);
        $templateProcessor->setValue('bulan_tahun', $formatBulanTahun);
        $templateProcessor->setValue('nomor_surat', $nomor_surat);
        $templateProcessor->setValue('no_surat', $no_surat);

        if ($periode_peminjaman == 1) {
            $templateProcessor->setValue('hari_tanggal', hariIndonesia(date('l', strtotime($hari_tanggal_mulai))) . ', ' . $format5);
        } elseif ($periode_peminjaman >= 2) {
            $format6 = date('d F Y', strtotime($hari_tanggal_selesai));
            $format6 = str_replace(
                array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
                array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
                $format6
            );
            $templateProcessor->setValue('hari_tanggal', hariIndonesia(date('l', strtotime($hari_tanggal_mulai))) . ', ' . $format5 . ' - ' . hariIndonesia(date('l', strtotime($hari_tanggal_selesai))) . ', ' . $format6);
        }



        // Simpan dokumen Word sementara
        $wordFileName = "Peminjaman_Lab_{$nim}.docx";
        $templateProcessor->saveAs($wordFileName);

        // Konversi Word ke PDF menggunakan Ilovepdf
        $myTask = new OfficepdfTask('project_public_724dffd41cb42180e78c09e24472f128_Vt_Zb511767074f37ae52dc81c20df4130f67', 'secret_key_bfa4958293f2b590114ad795db88fbc2_FzXVRa122028f7a23d69330fd9a8fadb8e6c2'); // Ganti dengan public_id dan secret_key Anda
        $file = $myTask->addFile($wordFileName);

        try {
            $myTask->execute();
            $outputDirectory = 'downloads'; // Pastikan folder ini ada dan memiliki izin tulis
            $pdfFileName = "Peminjaman_Lab_{$nim}.pdf";
            $myTask->download($outputDirectory);

            if (file_exists($wordFileName)) {
                unlink($wordFileName); // Hapus file Word setelah konversi
            }

            // Menampilkan PDF di browser
            $pdfFilePath = $outputDirectory . '/' . $pdfFileName;
            if (file_exists($pdfFilePath)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $pdfFileName . '"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                readfile($pdfFilePath);
            } else {
                echo "File PDF tidak ditemukan.";
            }
        } catch (Exception $e) {
            echo 'Error konversi PDF: ' . $e->getMessage();
        }
    } else {
        echo "Form tidak disubmit dengan benar.";
    }
}
