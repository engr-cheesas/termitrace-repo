<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="detection/detection.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap"
      rel="stylesheet"
    />
<style>
/* General button styling */
.menu-btn {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #3498db; /* Blue color */
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.menu-btn:hover {
  background-color: #2980b9; /* Darker blue on hover */
}

/* Disabled button styling */
.menu-btn:disabled,
.disabled-btn {
  background-color: #bdc3c7; /* Grey color when disabled */
  color: #7f8c8d; /* Lighter grey text */
  cursor: not-allowed; /* Lock the button */
}

.menu-btn.logout {
  background-color: #e74c3c; /* Red color for logout */
}

.menu-btn.logout:hover {
  background-color: #c0392b; /* Darker red on hover */
}

</style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="dashboard-container">
      <div class="logo-container">
        <img src="../images/logo.png" alt="Termitrace Logo" class="logo" />
      </div>
      <div class="menu">
        <!-- Exterminate On button initially enabled, Exterminate Off disabled -->
        <button class="menu-btn" id="btnOn">Exterminate On</button>
        <button class="menu-btn" id="btnOff" disabled>Exterminate Off</button>
        <button class="menu-btn logout" onclick="handleBack()">Back</button>
      </div>
    </div>

    <script>
      function handleBack() {
        window.location.href = "../dashboard.html";
      }

      // Handle button clicks for heatgun control
      $(document).ready(function() {
        $("#btnOn").click(function() {
          $.ajax({
            url: "run_python.php",
            type: "POST",
            data: { action: "on" },
            success: function(response) {
              // Disable "Exterminate On" and enable "Exterminate Off"
              $("#btnOn").prop("disabled", true).addClass("disabled-btn");
              $("#btnOff").prop("disabled", false).removeClass("disabled-btn");
            },
            error: function(xhr, status, error) {
              alert("Error: " + error);
            }
          });
        });

        $("#btnOff").click(function() {
          $.ajax({
            url: "run_python.php",
            type: "POST",
            data: { action: "off" },
            success: function(response) {
              // Disable "Exterminate Off" and enable "Exterminate On"
              $("#btnOff").prop("disabled", true).addClass("disabled-btn");
              $("#btnOn").prop("disabled", false).removeClass("disabled-btn");
            },
            error: function(xhr, status, error) {
              alert("Error: " + error);
            }
          });
        });
      });
    </script>
  </body>
</html>
