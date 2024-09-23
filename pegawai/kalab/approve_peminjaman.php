<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'kalab') {
    header("Location: login.php");
    exit;
}
require '../../config/database.php';
require_once '../../vendor/autoload.php'; // Pastikan Anda sudah menggunakan autoloader untuk Ilovepdf atau PHPWord


use Ilovepdf\OfficepdfTask;
use PhpOffice\PhpWord\TemplateProcessor;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Update booking status
    $stmt = $pdo->prepare("UPDATE lab_bookings SET status = ?, keterangan = 'Peminjaman Lab Disetujui' WHERE id = ?");
    $stmt->execute([$status, $booking_id]);

    if ($status === 'Disetujui') {
        // Fetch booking data for generating PDF
        $stmt = $pdo->prepare("SELECT lb.*, u.name AS mahasiswa_name FROM lab_bookings lb JOIN users u ON lb.nim = u.nim WHERE lb.id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            // Generate PDF file
            $nim = $booking['nim'];
            $name = $booking['mahasiswa_name'];
            $nama_kegiatan = $booking['nama_kegiatan'];
            $hari_tanggal_mulai = $booking['hari_tanggal_mulai'];
            $hari_tanggal_selesai = $booking['hari_tanggal_selesai'];
            $waktu_mulai = $booking['waktu_mulai'];
            $waktu_selesai = $booking['waktu_selesai'];
            $jenis_ruangan = $booking['jenis_ruangan'];
            $created_at = $booking['created_at'];
            $nomor_surat = $booking['nomor_surat'];
            $no_surat = $booking['no_surat'];

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

            // Load Word template
            $templateProcessor = new TemplateProcessor('persetujuan.docx');
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
            // Save Word file
            $timestamp = time(); // Mendapatkan timestamp saat ini
            $wordFileName = "Peminjaman_Lab_{$nim}_{$timestamp}.docx"; // Tambahkan timestamp
            $templateProcessor->saveAs($wordFileName);

            // Convert Word to PDF
            $myTask = new OfficepdfTask('project_public_724dffd41cb42180e78c09e24472f128_Vt_Zb511767074f37ae52dc81c20df4130f67', 'secret_key_bfa4958293f2b590114ad795db88fbc2_FzXVRa122028f7a23d69330fd9a8fadb8e6c2'); // Ganti dengan public_id dan secret_key Anda
            $file = $myTask->addFile($wordFileName);

            try {
                $myTask->execute();
                $outputDirectory = 'uploads'; // Make sure this folder exists
                $pdfFileName = "Peminjaman_Lab_{$nim}_{$timestamp}.pdf"; // Tambahkan timestamp
                $myTask->download($outputDirectory);

                if (file_exists($wordFileName)) {
                    unlink($wordFileName); // Delete Word file after conversion
                }

                // Update PDF path in database
                $pdfPath = $outputDirectory . '/' . $pdfFileName;
                $stmt = $pdo->prepare("UPDATE lab_bookings SET file_persetujuan = ? WHERE id = ?");
                $stmt->execute([$pdfPath, $booking_id]);
            } catch (Exception $e) {
                echo 'Error konversi PDF: ' . $e->getMessage();
            }
        }

        $success = "Status peminjaman telah diperbarui dan file PDF diunggah.";
    } else {
        $success = "Status peminjaman telah diperbarui.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Update booking status
    $stmt = $pdo->prepare("UPDATE lab_bookings SET status = ?, keterangan = 'Peminjaman Lab Disetujui' WHERE id = ?");
    $stmt->execute([$status, $booking_id]);

    $success = "Status peminjaman telah diperbarui.";
}

// Fetch bookings awaiting approval
$bookings = $pdo->query("SELECT lb.*, u.name AS mahasiswa_name FROM lab_bookings lb JOIN users u ON lb.nim = u.nim WHERE lb.status = 'Menunggu Persetujuan Kalab'")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../../component/header.php'; ?>







<div class="container">
    <h1>Persetujuan Peminjaman Lab oleh Kalab</h1>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Nama Lab</th>
                <th>Tanggal</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking) :
                $hari_tanggal_mulai = new DateTime($booking['hari_tanggal_mulai']);
                $formattedDate = $hari_tanggal_mulai->format('l, d-m-Y');

                // Format waktu
                $waktu_mulai = date('H:i', strtotime($booking['waktu_mulai']));
                $waktu_selesai = date('H:i', strtotime($booking['waktu_selesai'])); ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['mahasiswa_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['jenis_ruangan']); ?></td>
                    <td><?php echo htmlspecialchars($formattedDate); ?></td>
                    <td><?php echo htmlspecialchars($waktu_mulai); ?></td>
                    <td><?php echo htmlspecialchars($waktu_selesai); ?></td>
                    <td><?php echo htmlspecialchars($booking['nama_kegiatan']); ?></td>
                    <td>
                        <form action="approve_peminjaman.php" method="post">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="status" value="Disetujui" class="btn btn-success">Setujui Permintaan</button>
                            <button type="submit" name="status" value="Ditolak" class="btn btn-danger">Tolak</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($bookings)) : ?>
                <tr>
                    <td colspan="7">Tidak ada peminjaman yang menunggu persetujuan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../../component/footer.php'; ?>