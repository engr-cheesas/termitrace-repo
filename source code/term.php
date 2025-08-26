<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Imaging Detection</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="detection/style.css">
    <style>
        .thermal-feed {
            text-align: center;
            margin-top: 20px;
        }
        .thermal-image {
            max-width: 100%;
            height: auto;
            border: 2px solid black;
        }
        .debug-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            font-size: 14px;
            white-space: pre-wrap;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="instruction-container">
        <h2 class="title">DETECTION USING THERMAL IMAGING</h2>

        <div class="content">
                   <div class="thermal-feed">
                <?php
                // Check if the thermal script is running
                $script_running = shell_exec("pgrep -f thermal_viewer.py");

                if (empty($script_running)) {
                    // Start the Python script if it's not already running
                    $command = "sudo -u www-data /var/www/myenv/bin/python3 /var/www/html/thermal_viewer.py > /var/www/html/thermal_log.txt 2>&1 &";
                    shell_exec($command);
                }
                ?>
                <img id="thermalImage" class="thermal-image" src="thermal.png?<?php echo time(); ?>" alt="Thermal Image">
            </div>

            <div class="snapshot">
                <div class="instruction">INSTRUCTION ON HOW TO HOLD THE DEVICE THEN "Capturing"</div>
            </div>
        </div>

        <div class="navigation-buttons">
            <button class="btn previous" onclick="goPrevious()">PREVIOUS</button>
            <button class="btn next" onclick="goNext()">START</button>
        </div>

        <div class="debug-info">
            <h3>Debug Info</h3>
            <?php
            echo "Script Running: " . (empty($script_running) ? "No" : "Yes") . "\n";
            echo "Last Log:\n";
            echo shell_exec("tail -n 10 /var/www/html/thermal_log.txt");
            ?>
        </div>
    </div>

    <script>
        function goPrevious() {
            window.location.href = "../Detection.html";
        }

        function goNext() {
            window.location.href = "";
        }

        function updateThermalImage() {
            document.getElementById("thermalImage").src = "thermal.png?" + new Date().getTime();
        }
        setInterval(updateThermalImage, 1000); // Refresh every second
    </script>
</body>
</html>
