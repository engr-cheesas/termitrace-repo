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
    </style>
</head>
<body>
    <div class="instruction-container">
        <h2 class="title">DETECTION USING THERMAL IMAGING</h2>

        <div class="content">
            <div class="thermal-feed">
                <img id="thermalImage" class="thermal-image" src="thermal.png?<?php echo time(); ?>" alt="Thermal Image" onerror="handleImageError()">
            </div>

            <div class="snapshot">
                <div class="instruction">INSTRUCTION ON HOW TO HOLD THE DEVICE THEN "Capturing"</div>
            </div>
        </div>

        <div class="navigation-buttons">
            <button class="btn previous" onclick="goPrevious()">PREVIOUS</button>
            <button class="btn next" onclick="captureSnapshot()">CAPTURE</button>
        </div>
    </div>

    <script>
        let lastValidImage = "thermal.png"; // Store the last valid image

        function goPrevious() {
            window.location.href = "../Detection.html";
        }

        function captureSnapshot() {
            fetch("capture.php")
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => alert("Error capturing snapshot."));
        }

        function updateThermalImage() {
            let img = document.getElementById("thermalImage");
            let newSrc = "thermal.png?" + new Date().getTime();

            let tempImg = new Image();
            tempImg.src = newSrc;
            tempImg.onload = function () {
                lastValidImage = newSrc; // Update last valid image
                img.src = newSrc;
            };
        }

        function handleImageError() {
            document.getElementById("thermalImage").src = lastValidImage; // Revert to last valid image
        }

        setInterval(updateThermalImage, 1000); // Refresh every second
    </script>
</body>
</html>
