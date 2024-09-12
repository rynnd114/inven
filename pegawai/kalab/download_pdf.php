<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'kalab') {
    header("Location: login.php");
    exit;
}

require '../../config/database.php';
require '../../vendor/autoload.php'; // Pastikan path ke autoload.php benar

// Pastikan tidak ada keluaran sebelum instansiasi TCPDF
ob_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];

    $stmt = $pdo->prepare("SELECT lb.*, u.name AS mahasiswa_name FROM lab_bookings lb JOIN users u ON lb.nim = u.id WHERE lb.id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        // Instansiasi TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Tambahkan logo dan kop surat
        $logo = 'style/img/image.png'; // Path ke logo
        $pdf->Image($logo, 15, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 15, 'Nama Institusi Anda', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Alamat Institusi Anda', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Telepon: (021) 123456', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Email: info@institusi.ac.id', 0, 1, 'C');
        $pdf->Ln(10);

        // Tambahkan detail peminjaman
        $html = '<h1>Detail Peminjaman Lab</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<tr><td>Nama Mahasiswa:</td><td>' . htmlspecialchars($booking['mahasiswa_name']) . '</td></tr>';
        $html .= '<tr><td>Nama Lab:</td><td>' . htmlspecialchars($booking['lab_name']) . '</td></tr>';
        $html .= '<tr><td>Tanggal:</td><td>' . htmlspecialchars($booking['booking_date']) . '</td></tr>';
        $html .= '<tr><td>Waktu Mulai:</td><td>' . htmlspecialchars($booking['start_time']) . '</td></tr>';
        $html .= '<tr><td>Waktu Selesai:</td><td>' . htmlspecialchars($booking['end_time']) . '</td></tr>';
        $html .= '<tr><td>Keperluan:</td><td>' . htmlspecialchars($booking['reason']) . '</td></tr>';
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Kosongkan buffer output
        ob_end_clean();

        // Output PDF
        $pdf->Output('peminjaman_lab.pdf', 'I');
    } else {
        echo "Peminjaman tidak ditemukan.";
    }
} else {
    echo "Invalid request.";
}
