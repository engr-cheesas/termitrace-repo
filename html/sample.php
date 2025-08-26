<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arduino Serial Control</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        #output { font-size: 20px; font-weight: bold; margin-top: 20px; }
        button { font-size: 18px; padding: 10px 20px; }
    </style>
</head>
<body>

    <h1>Arduino Serial Control</h1>
    <button id="sendCommand">Start Process</button>
    <div id="output"></div>

    <script>
        $(document).ready(function() {
            $("#sendCommand").click(function() {
                $("#output").html("Waiting for response...<br>");

                $.get("serial.php", function(data) {
                    $("#output").html(data);
                });
            });
        });
    </script>

</body>
</html>
