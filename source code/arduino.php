<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arduino Control Panel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Arduino Serial Control</h2>
    
    <button onclick="sendCommand('3')">Detect Wood</button>
    <button onclick="sendCommand('1')">Turn Heat Gun ON</button>
    <button onclick="sendCommand('2')">Turn Heat Gun OFF</button>
    
    <h3>Response:</h3>
    <pre id="response">Waiting for response...</pre>

    <script>
        function sendCommand(cmd) {
            $("#response").text("Sending command...");

            $.ajax({
                url: "serial.php",
                type: "GET",
                data: { cmd: cmd },
                success: function(response) {
                    $("#response").text(response);
                },
                error: function() {
                    $("#response").text("Error communicating with Arduino.");
                }
            });
        }
    </script>
</body>
</html>
