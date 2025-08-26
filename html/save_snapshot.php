<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "termite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get AJAX data
$image_path = $_POST['image_path'];
$timestamp = $_POST['timestamp'];
$detection_type = $_POST['detection_type'];
$findings = $_POST['findings'];
$_SESSION["thermal"] = $findings;
// Insert into database
$sql = "INSERT INTO results (image_path, timestamp, detection_type, findings) VALUES ('$image_path', '$timestamp', '$detection_type', '$findings')";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
