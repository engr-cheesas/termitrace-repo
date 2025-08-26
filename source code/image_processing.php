<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOLO USB Camera</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>USB Camera Capture & YOLO Detection</h2>
    
    <video id="video" width="640" height="480" autoplay></video>
    <br>
    <button id="capture">Capture</button>
    <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>

    <h3>Result:</h3>
    <img id="resultImage" src="" width="640" height="480">

    <script>
        $(document).ready(function () {
            // Access the camera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    document.getElementById("video").srcObject = stream;
                })
                .catch(function (err) {
                    console.log("Camera error: ", err);
                });

            $("#capture").click(function () {
                let canvas = document.getElementById("canvas");
                let context = canvas.getContext("2d");
                let video = document.getElementById("video");

                // Draw video frame on canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convert to Base64
                let imageData = canvas.toDataURL("image/jpeg");

                // Send to PHP for YOLO processing
                $.ajax({
                    url: "process.php",
                    type: "POST",
                    data: { image: imageData },
                    success: function (response) {
                        $("#resultImage").attr("src", response);
                    }
                });
            });
        });
    </script>
</body>
</html>
