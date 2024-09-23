<?php
require_once '../vendor/autoload.php'; // Pastikan path ke autoload.php sesuai dengan lokasi Composer Anda

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
    $alamat = $row['alamat'];
    $telp = $row['telp'];
    $prodi = $row['prodi'];
    // Tambahkan data lainnya jika diperlukan
} else {
    echo "Data pengguna tidak ditemukan.";
    exit;
}
// Mengambil nomor surat terakhir
$stmt = $pdo->prepare("SELECT MAX(nomor_surat) AS last_nomor_surat FROM lab_bookings");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $result['last_nomor_surat'] !== null) {
    $lastNomorSurat = $result['last_nomor_surat'];
    $nomor_surat = $lastNomorSurat + 1;
} else {
    $nomor_surat = 13;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari inputan pengguna

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

    // Konversi tanggal ke format Indonesia
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
    $today = hariIndonesia(date('l')) . ', ' . date('d-m-Y');
    $dateMulai = new DateTime($hari_tanggal_mulai);
    $dateSelesai = new DateTime($hari_tanggal_selesai);
    $interval = $dateMulai->diff($dateSelesai);
    $periode_peminjaman = $interval->days + 1;

    // Load template Word
    $templateProcessor = new TemplateProcessor('template.docx'); // Ganti dengan path template Anda
    $templateProcessor->setValue('nim', $nim);
    $templateProcessor->setValue('nama', $name);
    $templateProcessor->setValue('alamat', $alamat);
    $templateProcessor->setValue('telp', $telp);
    $templateProcessor->setValue('prodi', $prodi);
    $templateProcessor->setValue('jenis_peminjaman', $jenis_peminjaman);
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
    $templateProcessor->setValue('tanggal_hari_ini', $today);
    $templateProcessor->setValue('bulan_tahun', $formatBulanTahun);
    $templateProcessor->setValue('nomor_surat', $nomor_surat);

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
