<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=800, height=400, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>YOLOv8 Detection</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw;
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        #button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 1px; /* Space between video and buttons */
            width: 100%;
        }


        .action-btn {
            /* margin: 5px 0; */
            margin-top: 5px; 
            margin-bottom: 15px;
            padding: 5px 20px;
            font-size: 18px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .action-btn:hover {
            background-color: #e64a19;
        }

        #video-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60%;
            height: 60%;
            max-width: 500px;
            margin-top: 5px;
            margin-bottom: 5px; /* Space between video and buttons */

        }

        video {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2);
        }

        #canvas {
            display: none;
        }

        #result-container {
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            max-width: 500px;
            margin-top: 15px;
        }

        #loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #000;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #loading img {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 800px) {
            body {
                height: auto;
                padding: 10px;
            }

            video, img {
                width: 100%;
                height: auto;
            }

            .action-btn {
                font-size: 16px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div id="video-container">
        <video id="video" autoplay></video>
    </div>

    <!-- Button container -->
    <div id="button-container">
        <button class="action-btn" id="capture">Capture</button>
        <button class="action-btn" id="back-to-selection">Back to Selection</button>
    </div>

    <div id="loading">
        <img src="loading.gif" alt="Processing...">
    </div>

    <canvas id="canvas" width="640" height="400"></canvas>

    <div id="result-container"></div>

    <script>
        $(document).ready(function () {
            // Access camera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    document.getElementById("video").srcObject = stream;
                })
                .catch(function (err) {
                    alert("Camera access denied: " + err);
                });

            // Back to selection
            $("#back-to-selection").click(function () {
                window.location.href = "detection/detection.html";
            });

            // Capture and send image to process.php
            $("#capture").click(function () {
                var canvas = document.getElementById("canvas");
                var context = canvas.getContext("2d");
                var video = document.getElementById("video");

                $("#capture").hide();
                $("#video").hide();
                $("#back-to-selection").hide();
                $("#loading").css("display", "flex");

                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                var imageData = canvas.toDataURL("image/jpeg");

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: { image: imageData },
                    dataType: "json",
                    success: function (response) {
                        console.log("Raw response:", response);
                        $("#loading").hide();
                        $("#result-container").empty();

                        if (!response || response.error) {
                            alert("Error: " + (response.error || "Unknown"));
                            $("#capture").show();
                            $("#video").show();
                            $("#back-to-selection").show();
                            return;
                        }

                        const resultHTML = `
                            <img id="result" src="${response.image_path}" style="max-width:100%;" />
                            <p style="text-align:center; margin-top: 10px;">
                                <strong>Detections:</strong> ${response.num_detections}<br>
                                <strong>Average Confidence:</strong> ${parseFloat(response.avg_confidence).toFixed(2)}<br>
                                <strong>Max Confidence:</strong> ${parseFloat(response.max_confidence).toFixed(2)}<br>
                                <strong>Findings:</strong> ${response.findings}
                            </p>
                            <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                                <button id="try-again" class="action-btn">Try Again</button>
                                <button id="back-to-selection-result" class="action-btn">Back to Selection</button>
                            </div>
                        `;

                        $("#result-container").html(resultHTML).fadeIn();

                        // Dynamic buttons
                        $("#try-again").click(function () {
                            $("#result-container").hide().empty();
                            $("#video").show();
                            $("#capture").show();
                            $("#back-to-selection").show();
                        });

                        $("#back-to-selection-result").click(function () {
                            window.location.href = "detection/detection.html";
                        });
                    },

                    error: function (xhr, status, error) {
                        $("#loading").hide();
                        alert("An error occurred: " + error);
                        console.error("AJAX error:", xhr.responseText);
                        $("#capture").show();
                        $("#video").show();
                        $("#back-to-selection").show();
                    }
                });
            });
        });
    </script>
</body>
</html>
