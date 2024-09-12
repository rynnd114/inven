<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'laboran') {
    header("Location: login.php");
    exit;
}
require '../../config/database.php';

// Set jumlah data per halaman
$limit = 10;

// Ambil halaman saat ini dari parameter URL (default ke 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil total jumlah data
$totalRows = $pdo->query("SELECT COUNT(*) FROM lab_bookings")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// Ambil data dengan batasan per halaman
$query = $pdo->prepare("SELECT lb.*, u.name AS mahasiswa_name FROM lab_bookings lb JOIN users u ON lb.nim = u.nim LIMIT :limit OFFSET :offset");
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$bookings = $query->fetchAll(PDO::FETCH_ASSOC);

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
?>

<?php include '../../component/header.php'; ?>

<div class="container">
    <h1 class="my-4">Daftar Peminjaman Lab</h1>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama Kegiatan</th>
                    <th>Hari, Tanggal Mulai</th>
                    <th>Hari, Tanggal Selesai</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Jumlah Peserta</th>
                    <th>Periode Peminjaman (Hari)</th>
                    <th>Jenis Ruangan</th>
                    <th>Fasilitas</th>
                    <th>Tanggal Pengambilan</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Unduh Word</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = ($page - 1) * $limit + 1;
                foreach ($bookings as $booking) :
                    // Format tanggal
                    $hari_tanggal_mulai = new DateTime($booking['hari_tanggal_mulai']);
                    $hari_tanggal_mulai_formatted = hariIndonesia($hari_tanggal_mulai->format('l')) . ', ' . $hari_tanggal_mulai->format('d-m-Y');

                    $hari_tanggal_selesai = new DateTime($booking['hari_tanggal_selesai']);
                    $hari_tanggal_selesai_formatted = hariIndonesia($hari_tanggal_selesai->format('l')) . ', ' . $hari_tanggal_selesai->format('d-m-Y');

                    // Format waktu
                    $waktu_mulai = date('H:i', strtotime($booking['waktu_mulai']));
                    $waktu_selesai = date('H:i', strtotime($booking['waktu_selesai']));

                    // Format tanggal pengambilan dan pengembalian
                    $tanggal_pengambilan = new DateTime($booking['tanggal_pengambilan']);
                    $tanggal_pengambilan_formatted = hariIndonesia($tanggal_pengambilan->format('l')) . ', ' . $tanggal_pengambilan->format('d-m-Y');

                    $tanggal_pengembalian = new DateTime($booking['tanggal_pengembalian']);
                    $tanggal_pengembalian_formatted = hariIndonesia($tanggal_pengembalian->format('l')) . ', ' . $tanggal_pengembalian->format('d-m-Y');
                ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo htmlspecialchars($booking['nama_kegiatan']); ?></td>
                        <td><?php echo htmlspecialchars($hari_tanggal_mulai_formatted); ?></td>
                        <td><?php echo htmlspecialchars($hari_tanggal_selesai_formatted); ?></td>
                        <td><?php echo htmlspecialchars($waktu_mulai); ?></td>
                        <td><?php echo htmlspecialchars($waktu_selesai); ?></td>
                        <td><?php echo htmlspecialchars($booking['jumlah_peserta']); ?></td>
                        <td><?php echo htmlspecialchars($booking['periode_peminjaman']); ?> hari</td>
                        <td><?php echo htmlspecialchars($booking['jenis_ruangan']); ?></td>
                        <td><?php echo htmlspecialchars($booking['fasilitas']); ?></td>
                        <td><?php echo htmlspecialchars($tanggal_pengambilan_formatted); ?></td>
                        <td><?php echo htmlspecialchars($tanggal_pengembalian_formatted); ?></td>
                        <td>
                            <?php
                            switch ($booking['status']) {
                                case 'Ditolak':
                                    echo '<span class="badge badge-danger">' . htmlspecialchars($booking['status']) . '</span>';
                                    break;
                                case 'Disetujui':
                                    echo '<span class="badge badge-primary">' . htmlspecialchars($booking['status']) . '</span>';
                                    break;
                                case 'Selesai':
                                    echo '<span class="badge badge-success">' . htmlspecialchars($booking['status']) . '</span>';
                                    break;
                                case 'Menunggu Persetujuan Laboran':
                                    echo '<span class="badge badge-warning">' . htmlspecialchars($booking['status']) . '</span>';
                                    break;
                                default:
                                    echo '<span class="badge badge-secondary">' . htmlspecialchars($booking['status']) . '</span>';
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($booking['keterangan']); ?></td>
                        <td>
                            <?php if ($booking['status'] == 'Menunggu Persetujuan Laboran') : ?>
                                <a href="download_word.php?id=<?php echo $booking['id']; ?>" class="btn btn-secondary">Unduh Word</a>
                            <?php else : ?>
                                <span class="text-muted">Tidak Tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                    $counter++;
                endforeach;
                ?>
                <?php if (empty($bookings)) : ?>
                    <tr>
                        <td colspan="16" class="text-center">Tidak ada peminjaman yang diajukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include '../../component/footer.php'; ?>
