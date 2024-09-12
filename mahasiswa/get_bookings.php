<?php
include '../config/database.php';

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
