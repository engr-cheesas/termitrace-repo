<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Imaging Detection</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="wizthermal.css">
	   <style>
        .thermal-feed {
            text-align: center;
            margin-top: 20px;
        }
        .thermal-image {
            max-width: 100%;
            height: auto;
            border: 2px solid black;
            display: block;
            margin: 0 auto;
        }
        .snapshot {
            margin-top: 20px;
            text-align: center;
        }
        .snapshot img {
            display: none; /* Hide snapshot image initially */
        }
        .btn {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ff914d;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #e6763e;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            margin: 20% auto;
            width: 300px;
            border-radius: 10px;
        }
        .modal button {
            margin: 10px;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .yes {
            background-color: #28a745;
            color: white;
        }
        .no {
            background-color: #dc3545;
            color: white;
        }
        .btn.next {
            display: none; /* Initially hidden */
        }
    </style>
	
</head>
<body>
    <div class="instruction-container">
        <div class="progress-bar">
            <div class="step completed">1</div>
            <div class="line"></div>
            <div class="step active">2</div>
            <div class="line"></div>
            <div class="step">3</div>
            <div class="line"></div>
            <div class="step">4</div>
            <div class="line"></div>
            <div class="step">5</div>
            <div class="line"></div>
            <div class="step">6</div>
        </div>

         <h2 class="title">DETECTION USING THERMAL IMAGING</h2>

         <div class="content">
            <div class="thermal-feed">
                <img id="thermalImage" class="thermal-image" src="thermal.png?<?php echo time(); ?>" alt="Thermal Image">
            </div>

            <div class="snapshot">
                <img id="snapshotImage" class="thermal-image" alt="Snapshot Image"> <br>
                <div class="instruction" id="instructionText">Hold the device steady and position the thermal camera directly against the wood to capture clear heat signatures.</div>
            </div>
        </div>

        <div class="navigation-buttons">
            <button class="btn previous" onclick="goPrevious()">PREVIOUS</button>
            <button class="btn capture" onclick="captureSnapshot()">CAPTURE</button>
            <button class="btn next" onclick="goNext()">NEXT</button>
        </div>
    </div>
    <!-- <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <p>Do you find termite trail?</p>
            <button class="yes" onclick="saveToDatabase('Possible termite infestation')">YES</button>
            <button class="no" onclick="saveToDatabase('No Termite infestation')">NO</button>
        </div>
    </div> -->

	<script>
        let capturedImagePath = "";

         function goPrevious() {
            window.location.href = "../detection/wizard/wizard.html";
        }
        function goNext() {
            window.location.href = "../detection/wizhollowness.html";
        }

        function captureSnapshot() {
            fetch("capture.php")
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === "error") {
                        alert("Error capturing snapshot.");
                        return;
                    }

                    let imgPath = data.image + "?" + new Date().getTime();
                    let findingsText = "";

                    // Match snapshot size to thermal image
                    const thermalImg = document.getElementById("thermalImage");
                    const snapshotImg = document.getElementById("snapshotImage");

                    snapshotImg.src = imgPath;
                    snapshotImg.style.display = "block";

                    // Set same width/height
                    snapshotImg.style.width = thermalImg.offsetWidth + "px";
                    snapshotImg.style.height = thermalImg.offsetHeight + "px";

                    if (data.status === "hotspot" && data.box) {
                        findingsText = `Hotspot temperature: ${data.temperature.toFixed(2)} °C, ` +
                                    `Ambient temperature: ${data.ambient.toFixed(2)} °C, ` +
                                    `Temperature Difference: ${data.temperature_difference.toFixed(2)} °C, `;
                    } else {
                        findingsText = "No hotspot detected.";
                    }

                    let instruction = document.getElementById("instructionText");
                    if (instruction) {
                        instruction.textContent = findingsText;
                    }

                    document.querySelector(".btn.next").style.display = "inline-block";

                    saveToDatabase(findingsText, data.image);
                })
                .catch(error => {
                    alert("Error capturing snapshot.");
                    console.error(error);
                });
        }

        function saveToDatabase(findings) {
            let timestamp = new Date().toISOString().slice(0, 19).replace("T", " "); // Format YYYY-MM-DD HH:MM:SS
            let detectionType = "thermal";

            fetch("save_snapshot.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `image_path=${encodeURIComponent(capturedImagePath)}&timestamp=${encodeURIComponent(timestamp)}&detection_type=${detectionType}&findings=${encodeURIComponent(findings)}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    alert("Data saved successfully!");
                } else {
                    alert("Error saving data.");
                }
            })
            .catch(error => alert("Error saving data."));
        }

        function updateThermalImage() {
            let img = new Image();
            img.src = "thermal.png?" + new Date().getTime();
            
            img.onload = function () {
                document.getElementById("thermalImage").src = img.src;
            };
        }

        setInterval(updateThermalImage, 1000); // Refresh every second
    </script>
</body>
</html>
