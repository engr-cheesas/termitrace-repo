<?php
if (isset($_POST['command'])) {
    $command = $_POST['command'];
    
    // Set the correct serial port (Check your system for the correct port)
    $serialPort = "/dev/ttyUSB0"; // Linux/Mac (Example: /dev/ttyUSB0 or /dev/ttyS0)
    // $serialPort = "COM3"; // Windows Example

    $baudRate = "9600";

    // Send the command to Arduino
    $fp = fopen($serialPort, "w");
    if ($fp) {
        fwrite($fp, $command);
        fclose($fp);
        echo "Sent: $command";
    } else {
        echo "Failed to open serial port!";
    }
} else {
    echo "No command received.";
}
?>
