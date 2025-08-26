<?php
include 'dbconnector.php'; // Include database connection

$query = "SELECT image_path, timestamp, detection_type, findings FROM results ORDER BY timestamp DESC";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $detection = $row['detection_type'];
    $findings =$row['findings'];
    

    $data[] = [
        'date' => $row['timestamp'],
        'detection' => $detection,
        'findings' => $findings,
        'image' => $row['image_path']
    ];
}

echo json_encode($data);
?>
