<?php
include '../../config/database.php';

$sql = "SELECT id, lab_name, booking_date, start_time, end_time, status, keterangan FROM lab_bookings";
$result = $conn->query($sql);

$events = array();

while ($row = $result->fetch_assoc()) {
    $events[] = array(
        'title' => $row['lab_name'],
        'start' => $row['booking_date'] . 'T' . $row['start_time'],
        'end' => $row['booking_date'] . 'T' . $row['end_time'],
        'extendedProps' => array(
            'lab' => $row['lab_name'],
            'status' => $row['status'],
            'description' => $row['keterangan'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time']
        ),
        'className' => strtolower($row['status'])
    );
}

echo json_encode($events);
?>


<?php
// session_start();
// require '../config/database.php';
// require '../config/configure.php';

// $nim = $_SESSION['nim'];

// $query = "SELECT lab_name, booking_date, start_time, end_time, status FROM lab_bookings WHERE nim = ?";
// $stmt = $pdo->prepare($query);
// $stmt->execute([$nim]);
// $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $events = [];
// foreach ($bookings as $booking) {
//     $events[] = [
//         'title' => $booking['lab_name'],
//         'start' => $booking['booking_date'] . 'T' . $booking['start_time'],
//         'end' => $booking['booking_date'] . 'T' . $booking['end_time'],
//         'className' => strtolower($booking['status']), // Menambahkan class berdasarkan status
//     ];
// }

// header('Content-Type: application/json');
// echo json_encode($events);
?>
