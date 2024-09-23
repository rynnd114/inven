<?php
session_start();
if (!isset($_SESSION['nip']) || $_SESSION['role'] !== 'kalab') {
    header("Location: login.php");
    exit;
}

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

$sql_calendar = "SELECT id, nim, nama_kegiatan, hari_tanggal_mulai, hari_tanggal_selesai, waktu_mulai, waktu_selesai, jumlah_peserta, periode_peminjaman, jenis_ruangan, fasilitas, tanggal_pengambilan, tanggal_pengembalian, status, keterangan, jenis_peminjaman FROM lab_bookings";
$result_calendar = $conn->query($sql_calendar);

$events = [];

while ($row = $result_calendar->fetch_assoc()) {
    $jenis_peminjaman = $row['jenis_peminjaman'];
    $event_color = '';

    switch ($row['status']) {
        case 'Selesai':
            $event_color = '#28a745'; // Hijau
            break;
        case 'Ditolak':
            $event_color = '#dc3545'; // Merah
            break;
        case 'Disetujui':
            $event_color = '#007bff'; // Biru
            break;
        default:
            $event_color = '#ffc107'; // Kuning
    }

    if ($jenis_peminjaman === 'berturut-turut') {
        $start_date = new DateTime($row['hari_tanggal_mulai']);
        $end_date = new DateTime($row['hari_tanggal_selesai']);
        $end_date->modify('+1 day'); // FullCalendar menganggap hari akhir eksklusif

        $time_start = (new DateTime($row['waktu_mulai']))->format('H:i');
        $time_end = (new DateTime($row['waktu_selesai']))->format('H:i');
        $event_title = htmlspecialchars($time_start . ' - ' . $row['jenis_ruangan']);

        $events[] = [
            'title' => $event_title,
            'start' => $start_date->format('Y-m-d'),
            'end' => $end_date->format('Y-m-d'),
            'color' => $event_color,
            'nim' => htmlspecialchars($row['nim']),
            'nama_kegiatan' => htmlspecialchars($row['nama_kegiatan']),
            'hari_tanggal_mulai' => $row['hari_tanggal_mulai'],
            'hari_tanggal_selesai' => $row['hari_tanggal_selesai'],
            'waktu_mulai' => $time_start,
            'waktu_selesai' => $time_end,
            'jumlah_peserta' => htmlspecialchars($row['jumlah_peserta']),
            'periode_peminjaman' => htmlspecialchars($row['periode_peminjaman']),
            'jenis_ruangan' => htmlspecialchars($row['jenis_ruangan']),
            'fasilitas' => htmlspecialchars($row['fasilitas']),
            'tanggal_pengambilan' => $row['tanggal_pengambilan'],
            'tanggal_pengembalian' => $row['tanggal_pengembalian'],
            'status' => htmlspecialchars($row['status']),
            'keterangan' => htmlspecialchars($row['keterangan'])
        ];
    } elseif ($jenis_peminjaman === 'berulang') {
        $lab_booking_id = $row['id'];
        $sql_days = "SELECT day_of_week FROM lab_booking_days WHERE lab_booking_id='$lab_booking_id'";
        $result_days = $conn->query($sql_days);

        while ($day = $result_days->fetch_assoc()) {
            $day_of_week = $day['day_of_week'];
            $events[] = [
                'title' => htmlspecialchars($row['nama_kegiatan']) . ' - ' . htmlspecialchars($row['jenis_ruangan']),
                'daysOfWeek' => [array_search($day_of_week, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])],
                'startTime' => (new DateTime($row['waktu_mulai']))->format('H:i'),
                'endTime' => (new DateTime($row['waktu_selesai']))->format('H:i'),
                'startRecur' => (new DateTime($row['hari_tanggal_mulai']))->format('Y-m-d'),
                'endRecur' => (new DateTime($row['hari_tanggal_selesai']))->format('Y-m-d'),
                'color' => $event_color,
                'nim' => htmlspecialchars($row['nim']),
                'nama_kegiatan' => htmlspecialchars($row['nama_kegiatan']),
                'waktu_mulai' => (new DateTime($row['waktu_mulai']))->format('H:i'),
                'waktu_selesai' => (new DateTime($row['waktu_selesai']))->format('H:i'),
                'jumlah_peserta' => htmlspecialchars($row['jumlah_peserta']),
                'periode_peminjaman' => htmlspecialchars($row['periode_peminjaman']),
                'jenis_ruangan' => htmlspecialchars($row['jenis_ruangan']),
                'fasilitas' => htmlspecialchars($row['fasilitas']),
                'tanggal_pengambilan' => $row['tanggal_pengambilan'],
                'tanggal_pengembalian' => $row['tanggal_pengembalian'],
                'status' => htmlspecialchars($row['status']),
                'keterangan' => htmlspecialchars($row['keterangan'])
            ];
        }
    }
}
?>

<?php include '../../component/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kalab</title>
    <link href="/style/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.global.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/tooltipster/dist/css/tooltipster.bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
    <style>
        .legend {
            display: flex;
            flex-direction: column;
        }

        .legend-item {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .legend-color {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 1px solid #000;
            vertical-align: middle;
        }
    </style>
    <style>
        .ditolak {
            background-color: #dc3545 !important;
            /* warna merah */
            color: white;
        }

        .disetujui {
            background-color: #007bff !important;
            /* warna biru */
            color: white;
        }

        .selesai {
            background-color: #28a745 !important;
            /* warna hijau */
            color: white;
        }

        .menunggu {
            background-color: #ffc107 !important;
            /* warna kuning */
            color: white;
        }

        .informatika {
            background-color: red;
            color: white;
        }

        .sistem-informasi {
            background-color: blue;
            color: white;
        }

        .arsitektur {
            background-color: orange;
            color: black;
        }

        .sipil {
            background-color: yellow;
            color: black;
        }

        .teknik-kimia {
            background-color: purple;
            color: white;
        }
    </style>
    <style>
        .fc-event {
            margin-bottom: 5px;
            /* Jarak antar event */
            padding: 5px;
            /* Padding dalam event */
            border-radius: 5px;
            /* Sudut bulat */
        }
    </style>

    <style>
        .prodi-informatika {
            background-color: #cce5ff;
            /* Warna biru muda */
        }

        .prodi-sistem-informasi {
            background-color: #e2e3e5;
            /* Warna abu-abu */
        }

        .prodi-arsitektur {
            background-color: #d4edda;
            /* Warna hijau muda */
        }

        .prodi-sipil {
            background-color: #fff3cd;
            /* Warna kuning muda */
        }

        .prodi-teknik-kimia {
            background-color: #f8d7da;
            /* Warna merah muda */
        }
    </style>


    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .informatika {
            background-color: red;
            color: white;
        }

        .sistem-informasi {
            background-color: blue;
            color: white;
        }

        .arsitektur {
            background-color: orange;
            color: black;
        }

        .sipil {
            background-color: yellow;
            color: black;
        }

        .teknik-kimia {
            background-color: purple;
            color: white;
        }
    </style>

</head>

<body id="page-top">

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Kalab</h1>
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
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var calendarEl = document.getElementById('calendar');
                                        var calendar = new FullCalendar.Calendar(calendarEl, {
                                            locale: 'id', // Mengatur locale ke bahasa Indonesia
                                            initialView: 'dayGridMonth',
                                            events: <?= json_encode($events); ?>,
                                            dayMaxEventRows: 4, // Mengatur agar maksimal 4 event yang ditampilkan per hari
                                            moreLinkText: function(num) { // Mengatur teks yang ditampilkan saat ada lebih dari 4 event
                                                return "+" + num + " more";
                                            },
                                            eventClick: function(info) {
                                                var options = {
                                                    weekday: 'long',
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric'
                                                };
                                                var startDate = new Date(info.event.extendedProps.hari_tanggal_mulai).toLocaleDateString('id-ID', options);
                                                var endDate = info.event.extendedProps.hari_tanggal_selesai ? new Date(info.event.extendedProps.hari_tanggal_selesai).toLocaleDateString('id-ID', options) : '-';
                                                var tanggalPengambilan = info.event.extendedProps.tanggal_pengambilan ? new Date(info.event.extendedProps.tanggal_pengambilan).toLocaleDateString('id-ID', options) : '-';
                                                var tanggalPengembalian = info.event.extendedProps.tanggal_pengembalian ? new Date(info.event.extendedProps.tanggal_pengembalian).toLocaleDateString('id-ID', options) : '-';

                                                $('#modalNIM').text(info.event.extendedProps.nim);
                                                $('#modalNamaKegiatan').text(info.event.extendedProps.nama_kegiatan);
                                                $('#modalStartDate').text(startDate);
                                                $('#modalEndDate').text(endDate);
                                                $('#modalWaktuMulai').text(info.event.extendedProps.waktu_mulai);
                                                $('#modalWaktuSelesai').text(info.event.extendedProps.waktu_selesai);
                                                $('#modalJumlahPeserta').text(info.event.extendedProps.jumlah_peserta);
                                                $('#modalPeriodePeminjaman').text(info.event.extendedProps.periode_peminjaman);
                                                $('#modalJenisRuangan').text(info.event.extendedProps.jenis_ruangan);
                                                $('#modalFasilitas').text(info.event.extendedProps.fasilitas);
                                                $('#modalTanggalPengambilan').text(tanggalPengambilan);
                                                $('#modalTanggalPengembalian').text(tanggalPengembalian);
                                                $('#modalStatus').text(info.event.extendedProps.status);
                                                $('#modalDescription').text(info.event.extendedProps.keterangan);

                                                $('#eventDetailModal').modal('show');
                                            }
                                        });
                                        calendar.render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">Detail Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>NIM:</strong> <span id="modalNIM"></span></p>
                    <p><strong>Nama Kegiatan:</strong> <span id="modalNamaKegiatan"></span></p>
                    <p><strong>Tanggal Mulai:</strong> <span id="modalStartDate"></span></p>
                    <p><strong>Tanggal Selesai:</strong> <span id="modalEndDate"></span></p>
                    <p><strong>Waktu Mulai:</strong> <span id="modalWaktuMulai"></span></p>
                    <p><strong>Waktu Selesai:</strong> <span id="modalWaktuSelesai"></span></p>
                    <p><strong>Jumlah Peserta:</strong> <span id="modalJumlahPeserta"></span></p>
                    <p><strong>Periode Peminjaman:</strong> <span id="modalPeriodePeminjaman"></span></p>
                    <p><strong>Jenis Ruangan:</strong> <span id="modalJenisRuangan"></span></p>
                    <p><strong>Fasilitas:</strong> <span id="modalFasilitas"></span></p>
                    <p><strong>Tanggal Pengambilan:</strong> <span id="modalTanggalPengambilan"></span></p>
                    <p><strong>Tanggal Pengembalian:</strong> <span id="modalTanggalPengembalian"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Keterangan:</strong> <span id="modalDescription"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jadwal Laboratorium</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h6 class="font-weight-bold">Legenda Prodi:</h6>
                <div class="legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: red;"></span> Informatika
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: blue;"></span> Sistem Informasi
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: orange;"></span> Arsitektur
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: yellow;"></span> Sipil
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: purple;"></span> Teknik Kimia
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-xs" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Jam</th>
                            <?php
                            $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];
                            foreach ($days as $day) {
                                echo "<th colspan='3' class='text-center'>$day</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                echo "<th class='text-center'>D203</th><th class='text-center'>D208</th><th class='text-center'>Lab. Komputasi</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Koneksi ke database
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "inven"; // Sesuaikan dengan nama database Anda

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Slot waktu
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

                        foreach ($timeSlots as $index => $slot) {
                            echo "<tr>";
                            echo "<td class='text-center'>$slot</td>";

                            foreach ($days as $day) {
                                foreach (["D203", "D208", "Lab. Komputasi"] as $ruangan) {
                                    $query = "SELECT * FROM jadwal_lab WHERE hari='$day' AND (ruangan1='$ruangan' OR ruangan2='$ruangan') AND waktu='$slot'";
                                    $result = $conn->query($query);
                                    $display = '';
                                    $prodi_class = '';
                                    $bg_color = '';
                                    $text_color = '';

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();

                                        // Tentukan warna latar belakang dan teks berdasarkan prodi
                                        switch ($row['prodi']) {
                                            case 'IF':
                                                $bg_color = 'red';
                                                $text_color = 'white';
                                                break;
                                            case 'SI':
                                                $bg_color = 'blue';
                                                $text_color = 'white';
                                                break;
                                            case 'Arsitektur':
                                                $bg_color = 'orange';
                                                $text_color = 'black';
                                                break;
                                            case 'Sipil':
                                                $bg_color = 'yellow';
                                                $text_color = 'black';
                                                break;
                                            case 'Teknik Kimia':
                                                $bg_color = 'purple';
                                                $text_color = 'white';
                                                break;
                                        }

                                        // Tampilkan output untuk kedua ruangan
                                        if ($row['ruangan1'] == $ruangan && !empty($row['kelas1'])) {
                                            $display .= htmlspecialchars($row['prodi']) . " - " . htmlspecialchars($row['angkatan']) . "<br>" . htmlspecialchars($row['kegiatan']) . "<br>" . htmlspecialchars($row['kelas1']) . "<br>";
                                        }

                                        if ($row['ruangan2'] == $ruangan && !empty($row['kelas2'])) {
                                            $display .= htmlspecialchars($row['prodi']) . " - " . htmlspecialchars($row['angkatan']) . "<br>" . htmlspecialchars($row['kegiatan']) . "<br>" . htmlspecialchars($row['kelas2']) . "<br>";
                                        }

                                        // Periksa apakah slot berikutnya sama untuk menggabungkan sel
                                        $merge_query = "SELECT * FROM jadwal_lab 
                                        WHERE hari='$day' 
                                        AND (ruangan1='$ruangan' OR ruangan2='$ruangan') 
                                        AND waktu='{$timeSlots[$index + 1]}'";
                                        $merge_result = $conn->query($merge_query);
                                        $merge = ($merge_result->num_rows > 0) && ($merge_result->fetch_assoc()['prodi'] == $row['prodi']);

                                        // Tampilkan data dengan gaya yang sesuai
                                        if (!empty($display)) {
                                            if ($merge) {
                                                echo "<td style='background-color: $bg_color; color: $text_color;' rowspan='2'>" . nl2br($display) . "</td>";
                                                $skipNext = true; // Lewati baris berikutnya
                                            }
                                        } else {
                                            echo "<td></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                            }
                            echo "</tr>";

                            // Lewati baris berikutnya jika menggabungkan
                            if (isset($skipNext) && $skipNext) {
                                unset($skipNext);
                                continue;
                            }
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include '../../component/footer.php'; ?>
    </div>

    <?php if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jadwal berhasil dihapus.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menghapus session setelah Swal muncul
                    window.history.replaceState(null, null, window.location.pathname);
                }
            });
        </script>
        <?php unset($_SESSION['delete_success']); // Hapus session setelah menampilkan alert 
        ?>
    <?php endif; ?>

</body>

</html>



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

</body>

</html>