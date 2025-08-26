<?php
$resultPath = "/var/www/html/thermal_result.json";
$snapshotFolder = "/var/www/html/snapshots/";

date_default_timezone_set('Asia/Manila'); // Set timezone
$timestamp = date("Ymd-His");
$datetime_now = date("Y-m-d H:i:s");
$filename = "thermal-" . $timestamp . ".png";
$newImagePath = $snapshotFolder . $filename;
$relativeImagePath = "snapshots/" . $filename;

if (!file_exists($snapshotFolder)) {
    if (!mkdir($snapshotFolder, 0777, true)) {
        echo json_encode(["status" => "error", "message" => "Failed to create snapshot directory."]);
        exit;
    }
}

if (file_exists($resultPath)) {
    $json = file_get_contents($resultPath);
    $data = json_decode($json, true);

    if ($data && isset($data['image'])) {
        $staticImagePath = "/var/www/html/" . $data['image'];

        if (file_exists($staticImagePath)) {
            copy($staticImagePath, $newImagePath);
            $data['image'] = $relativeImagePath;
            $data['timestamp'] = $datetime_now; // 🔥 Add timestamp
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Static thermal image not found.';
        }
    }

    echo json_encode($data);
} else {
    echo json_encode(["status" => "error", "message" => "No result available."]);
}
?>
