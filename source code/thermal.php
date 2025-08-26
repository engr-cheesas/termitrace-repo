<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thermal Imaging Detection</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f9f9f9;
    }

    .instruction-container {
      max-width: 900px;
      margin: auto;
      text-align: center;
    }

    .title {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .content {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 20px;
      flex-wrap: wrap;
    }

    .thermal-feed,
    .snapshot {
      flex: 1 1 300px;
      text-align: center;
    }

    .thermal-image {
      width: 100%;
      max-width: 400px;
      height: auto;
      border: 2px solid black;
      display: block;
      margin: auto;
    }

    #snapshotImage {
      display: none;
    }

    .text-output {
      text-align: center;
      margin-top: 20px;
      font-size: 16px;
      font-weight: 500;
      color: #333;
    }

    .navigation-buttons {
      margin-top: 30px;
    }

    .btn {
      margin: 0 10px;
      padding: 10px 20px;
      font-size: 16px;
      background: #ff914d;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .btn:hover {
      background: #e6763e;
    }
  </style>
</head>
<body>
  <div class="instruction-container">
    <h2 class="title">DETECTION USING THERMAL IMAGING</h2>

    <div class="content">
      <div class="thermal-feed">
        <img id="thermalImage" class="thermal-image" src="thermal.png?<?php echo time(); ?>" alt="Thermal Feed" />
      </div>

      <div class="snapshot">
        <img id="snapshotImage" class="thermal-image" alt="Snapshot" />
      </div>
    </div>

    <div class="text-output" id="instructionText">
      Hold the device steady and position the thermal camera directly against the wood to capture clear heat signatures.
    </div>

    <div class="navigation-buttons">
      <button class="btn previous" onclick="goPrevious()">BACK</button>
      <button class="btn capture" onclick="captureSnapshot()">CAPTURE</button>
    </div>
  </div>

  <script>
    function goPrevious() {
      window.location.href = "/detection/detection.html";
    }

    function saveToDatabase(findings, imagePath, timestamp) {
  const detectionType = "thermal";

  fetch("save_snapshot.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `image_path=${encodeURIComponent(imagePath)}&timestamp=${encodeURIComponent(timestamp)}&detection_type=${detectionType}&findings=${encodeURIComponent(findings)}`
  })
    .then(response => response.text())
    .then(data => {
      if (data === "success") {
        alert("Snapshot saved!");
      } else {
        alert("Error saving data.");
      }
    })
    .catch(error => {
      alert("Error saving data.");
      console.error(error);
    });
}

function captureSnapshot() {
  fetch("capture.php")
    .then(response => response.json())
    .then(data => {
      if (data.status === "error") {
        alert("Error capturing snapshot.");
        return;
      }

      const imgPath = data.image + "?" + new Date().getTime();
      const thermalImg = document.getElementById("thermalImage");
      const snapshotImg = document.getElementById("snapshotImage");

      snapshotImg.src = imgPath;
      snapshotImg.style.display = "block";
      snapshotImg.style.width = thermalImg.offsetWidth + "px";
      snapshotImg.style.height = thermalImg.offsetHeight + "px";

      let findingsText = "";

      if (data.status === "hotspot" && data.box) {
        findingsText = `Hotspot Detected: ${data.temperature.toFixed(2)} °C | Ambient: ${data.ambient.toFixed(2)} °C | ΔT: ${data.temperature_difference.toFixed(2)} °C`;
      } else {
        findingsText = "No hotspot detected.";
      }

      document.getElementById("instructionText").textContent = findingsText;

      // Save actual timestamp from PHP
      saveToDatabase(findingsText, data.image, data.timestamp);
    })
    .catch(error => {
      alert("Error capturing snapshot.");
      console.error(error);
    });
}


    function updateThermalImage() {
      const img = new Image();
      img.src = "thermal.png?" + new Date().getTime();
      img.onload = function () {
        document.getElementById("thermalImage").src = img.src;
      };
    }

    setInterval(updateThermalImage, 1000);
  </script>
</body>
</html>