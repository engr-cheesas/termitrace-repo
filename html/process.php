<?php
session_start();
require 'dbconnector.php'; // Ensure database connection

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log file path
$log_file = "/var/www/html/error.log";

function log_error($message) {
    global $log_file;
    file_put_contents($log_file, "[" . date("Y-m-d H:i:s") . "] " . $message . "\n", FILE_APPEND);
}

if (isset($_POST["image"])) {
    try {
        $data = $_POST["image"];
        $data = str_replace("data:image/jpeg;base64,", "", $data);
        $data = base64_decode($data);

        // Generate filename with timestamp
        date_default_timezone_set('Asia/Manila'); // Adjust based on your timezone
        $timestamp = date("Ymd-His");
        $datetime_now = date("Y-m-d H:i:s");
        $filename = "img-" . $timestamp . ".jpg";

        // Define paths
        $snapshot_folder = "/var/www/html/snapshots/";
        if (!file_exists($snapshot_folder)) {
            if (!mkdir($snapshot_folder, 0777, true)) {
                log_error("Failed to create directory: " . $snapshot_folder);
                die("error");
            }
        }

        $input_image = $snapshot_folder . $filename;
        $output_image = $snapshot_folder . "result-" . $filename;

        // Save the uploaded image
        if (file_put_contents($input_image, $data) === false) {
            log_error("Failed to save input image: " . $input_image);
            die("error");
        }

        // Run YOLOv8 detection
        $command = "sudo -u pi python3 /var/www/html/yolo_detect.py " . escapeshellarg($input_image) . " " . escapeshellarg($output_image);
        $output = shell_exec($command);
        file_put_contents("/var/www/html/debug.log", "YOLO Output:\n" . $output . "\n", FILE_APPEND);

        // Decode the JSON output from Python
        $lines = explode("\n", trim($output));
        $jsonLine = end($lines);
        $yolo_data = json_decode($jsonLine, true);

        $num_detections = $yolo_data["num_detections"] ?? 0;
        $avg_confidence = $yolo_data["avg_confidence"] ?? 0;
        $max_confidence = $yolo_data["max_confidence"] ?? 0;


        if (!$yolo_data) {  
            log_error("Failed to parse detection result: " . $jsonLine);
            echo json_encode(["error" => "Failed to parse detection results."]);
            exit;
        }

        // Determine findings
        $findings = $yolo_data["findings"];
        $_SESSION["object_detection"] = $findings;


        $relative_output_image = "snapshots/result-" . $filename;

        // // **Extract findings: Check for "termite-holes"**
        // if (strpos($output, "Termite Hole") !== false) {
        //     $findings = "Termite Infestation";
        //     $_SESSION["object_detection"] = $findings;
        // } else {
        //     $findings = "No Infestation";
		// $_SESSION["object_detection"]  = $findings;
        // }

        // Check if YOLO generated the result image
        if (file_exists($output_image)) {
            // Save the result to the database
            $stmt = $conn->prepare("INSERT INTO results (image_path, timestamp, detection_type, findings) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                log_error("Database prepare statement failed: " . $conn->error);
                die("error");
            }

            $detection_type = "Object Detection";
            $stmt->bind_param("ssss", $relative_output_image, $datetime_now, $detection_type, $findings);

            if (!$stmt->execute()) {
                log_error("Database insert failed: " . $stmt->error);
                die("error");
            }

            $stmt->close();
            echo json_encode([
                "image_path" => $relative_output_image,
                "num_detections" => $num_detections,
                "avg_confidence" => $avg_confidence,
                "max_confidence" => $max_confidence,
                "findings" => $findings
            ]);

        } else {
            log_error("YOLO output image not found: " . $output_image);
            echo "error";
        }

        $conn->close();
    } catch (Exception $e) {
        log_error("Exception caught: " . $e->getMessage());
        echo "error";
    }
} else {
    log_error("No image received");
}
