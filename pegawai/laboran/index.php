<?php
session_start();
if (!isset($_SESSION['nip']) || $_SESSION['role'] !== 'laboran') {
    header("Location: login.php");
    exit;
}

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

include '../../config/database.php';

$sql_active = "SELECT COUNT(*) as count FROM lab_bookings WHERE status='Disetujui'";
$result_active = $conn->query($sql_active);
$active_count = $result_active->fetch_assoc()['count'];

$sql_completed = "SELECT COUNT(*) as count FROM lab_bookings WHERE status='Selesai'";
$result_completed = $conn->query($sql_completed);
$completed_count = $result_completed->fetch_assoc()['count'];

$sql_pending = "SELECT COUNT(*) as count FROM lab_bookings WHERE (status='Menunggu Persetujuan Laboran' OR status='Menunggu Persetujuan Kalab')";
$result_pending = $conn->query($sql_pending);
$pending_count = $result_pending->fetch_assoc()['count'];

$sql_rejected = "SELECT COUNT(*) as count FROM lab_bookings WHERE status='Ditolak'";
$result_rejected = $conn->query($sql_rejected);
$rejected_count = $result_rejected->fetch_assoc()['count'];

// Mendapatkan peminjaman terbaru
$sql_recent = "SELECT id, jenis_ruangan, hari_tanggal_mulai, status, keterangan FROM lab_bookings ORDER BY hari_tanggal_mulai DESC LIMIT 10";
$result_recent = $conn->query($sql_recent);
?>

<?php include '../../component/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laboran</title>
    <link href="/style/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Laboran</h1>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Peminjaman Selesai</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $completed_count ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Peminjaman Aktif</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $active_count ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Menunggu Persetujuan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pending_count ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Dibatalkan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rejected_count ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Lab</th>
                                                <th>Tanggal Peminjaman</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1;
                                            while ($row = $result_recent->fetch_assoc()) :
                                                $hari_tanggal_mulai = new DateTime($row['hari_tanggal_mulai']);
                                                $hari = hariIndonesia($hari_tanggal_mulai->format('l'));
                                                $formattedDate = $hari . ', ' . $hari_tanggal_mulai->format('d-m-Y'); ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?= htmlspecialchars($row['jenis_ruangan']) ?></td>
                                                    <td><?= htmlspecialchars($formattedDate) ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($row['status']) {
                                                            case 'Ditolak':
                                                                echo '<span class="badge badge-danger">' . htmlspecialchars($row['status']) . '</span>';
                                                                break;
                                                            case 'Disetujui':
                                                                echo '<span class="badge badge-primary">' . htmlspecialchars($row['status']) . '</span>';
                                                                break;
                                                            case 'Selesai':
                                                                echo '<span class="badge badge-success">' . htmlspecialchars($row['status']) . '</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge badge-warning">' . htmlspecialchars($row['status']) . '</span>';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                                </tr>
                                            <?php $counter++;
                                            endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Kalender Peminjaman</h6>
                            </div>
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Lab:</strong> <span id="eventLab"></span></p>
                    <p><strong>Jadwal Peminjaman:</strong> <span id="eventDate"></span></p>
                    <p><strong>Status:</strong> <span id="eventStatus"></span></p>
                    <p><strong>Keterangan:</strong> <span id="eventDescription"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: '470px',
        initialView: 'dayGridMonth',
        events: 'get_bookings.php',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'id', // Mengatur bahasa ke Indonesia
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari',
            list: 'Daftar'
        },
        allDayText: 'Sepanjang Hari',
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        timeFormat: { // Format waktu
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        eventTimeFormat: { // Format waktu untuk event
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        dayMaxEventRows: 3, // Mengatur agar maksimal 3 event yang ditampilkan per hari
        moreLinkText: function(num) { // Mengatur teks yang ditampilkan saat ada lebih dari 3 event
            return "+" + num + " more";
        },
        eventClick: function(info) {
            var start = new Date(info.event.start);
            var end = new Date(info.event.end);
            var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
            var timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };

            var startTimeStr = start.toLocaleDateString('id-ID', options) + ', ' + start.toLocaleTimeString('id-ID', timeOptions).replace('.', ':') + ' WITA';
            var endTimeStr = end.toLocaleTimeString('id-ID', timeOptions).replace('.', ':') + ' WITA';

            $('#eventTitle').text(info.event.title);
            $('#eventLab').text(info.event.extendedProps.lab);
            $('#eventDate').text(startTimeStr + ' - ' + endTimeStr);
            $('#eventStatus').text(info.event.extendedProps.status);
            $('#eventDescription').text(info.event.extendedProps.description);

            $('#eventDetailModal').modal('show');
        }
    });
    calendar.render();
});
</script>
</body>

</html>

<?php include '../../component/footer.php'; ?>
