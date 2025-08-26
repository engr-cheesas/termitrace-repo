<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arduino Serial Response</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 24px;
            font-family: Arial, sans-serif;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="result">Click the button to test</div>
    <button id="sendCommand">Send Command</button>

    <script>
        $(document).ready(function() {
            $("#sendCommand").click(function() {
                $("#result").html("Sending command...");
                
                $.get("serial.php", function(data) {
                    $("#result").html(data.replace(/\n/g, "<br>"));  // Show response with line breaks
                }).fail(function() {
                    $("#result").html("Error communicating with Arduino.");
                });
            });
        });
    </script>
</body>
</html>
