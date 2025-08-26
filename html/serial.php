<?php
$port = "/dev/ttyUSB0";  // Change this to match your Arduino port (Windows: COM3, Linux: /dev/ttyUSB0, Mac: /dev/tty.usbserial)
$baudRate = "9600";

if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];

    // Open the serial port
    $serial = fopen($port, "w+");
    if (!$serial) {
        echo "Error opening serial port!";
        exit();
    }

    // Send command to Arduino
    fwrite($serial, $cmd);
    sleep(1); // Wait for response

    // Read response from Arduino
    $response = "";
    while ($line = fgets($serial)) {
        $response .= trim($line) . "\n";
    }

    fclose($serial);
    echo nl2br($response); // Return response to the web page
}
?>
