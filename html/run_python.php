<?php
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Define Python scripts
    $python_on_script = 'heatgun_on.py';
    $python_off_script = 'heatgun_off.py';

    // Determine which script to run based on the action
    if ($action == 'on') {
        $command = "python3 $python_on_script";  // Use python3 if you're using Python 3
    } elseif ($action == 'off') {
        $command = "python3 $python_off_script";  // Use python3 if you're using Python 3
    } else {
        echo "Invalid action!";
        exit;
    }

    // Execute the Python script
    $output = shell_exec($command);
    
    // Output the result
    echo "Python script executed: " . $output;
} else {
    echo "No action specified.";
}
?>
