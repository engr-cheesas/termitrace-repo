<?php
$output = shell_exec("sudo /home/pi/myenv/bin/python3 /var/www/html/thermal_viewer.py 2>&1");
echo "<pre>$output</pre>";
?>
