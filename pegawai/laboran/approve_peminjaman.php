<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'laboran') {
    header("Location: login.php");
    exit;
}
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];
    $no_surat = $_POST['no_surat']; // Ambil nomor surat dari input

    $stmt = $pdo->prepare("UPDATE lab_bookings SET status = ?, no_surat = ?, keterangan = 'Sedang Diperiksa Oleh Kalab' WHERE id = ?");
    $stmt->execute([$status, $no_surat, $booking_id]);

    $success = "Status peminjaman telah diperbarui.";
}

$bookings = $pdo->query("SELECT lb.*, u.name AS mahasiswa_name FROM lab_bookings lb JOIN users u ON lb.nim = u.nim WHERE lb.status = 'Menunggu Persetujuan Laboran'")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../../component/header.php'; ?>

<div class="container">
    <h1>Persetujuan Peminjaman Lab oleh Laboran</h1>
    <?php if (isset($success)) : ?>
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
                            <div class="form-group">
                                <label for="no_surat">Nomor Surat:</label>
                                <input type="text" name="no_surat" required class="form-control" placeholder="Masukkan nomor surat">
                            </div>
                            <button type="submit" name="status" value="Menunggu Persetujuan Kalab" class="btn btn-success">Kirim ke Kalab</button>
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
