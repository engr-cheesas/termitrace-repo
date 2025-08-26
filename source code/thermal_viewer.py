import matplotlib
matplotlib.use('Agg')  # Use non-GUI backend to prevent freezing
import time
import numpy as np
import board
import busio
import adafruit_mlx90640
import matplotlib.pyplot as plt
import matplotlib.patches as patches
import json
import sys
import shutil 
from datetime import datetime

IMAGE_PATH = "/var/www/html/thermal.png"
HOTSPOT_THRESHOLD = 2  # Degrees Celsius above ambient

# Initialize I2C and sensor
try:
    i2c = busio.I2C(board.SCL, board.SDA)
    mlx = adafruit_mlx90640.MLX90640(i2c)
    mlx.refresh_rate = adafruit_mlx90640.RefreshRate.REFRESH_4_HZ
except Exception as e:
    print(json.dumps({"status": "error", "message": "Sensor not detected"}))
    sys.exit(1)

def detect_hotspot_box(data_array, threshold):
    rows, cols = np.where(data_array >= threshold)
    if len(rows) == 0:
        return None
    return (
        int(np.min(rows)),  # top
        int(np.min(cols)),  # left
        int(np.max(rows)),  # bottom
        int(np.max(cols))   # right
    )

def capture_and_process():
    frame = np.zeros((24 * 32,), dtype=float)
    try:
        mlx.getFrame(frame)
        data_array = np.reshape(frame, (24, 32))
        ambient = np.median(data_array)
        max_temp = np.max(data_array)
        temp_diff = max_temp - ambient

        threshold_temp = ambient + HOTSPOT_THRESHOLD
        box = detect_hotspot_box(data_array, threshold_temp)

        # MODIFIED: Determine if this is within the expected termite ΔT range
        if box and temp_diff <= 6.5:
            valid_hotspot = True
        else:
            valid_hotspot = False
            box = None  # discard box if invalid

        # Plot and save image
        plt.figure(figsize=(6, 4))
        flipped_data = np.fliplr(data_array)
        ax = plt.gca()
        im = ax.imshow(flipped_data, cmap='inferno', interpolation='bilinear')
        plt.colorbar(im, label='Temperature [°C]')
        plt.axis('off')

        if valid_hotspot:
            y1, x1, y2, x2 = box
            width = x2 - x1
            height = y2 - y1
            flipped_x1 = 31 - x2  # Flip because image is flipped horizontally

            # Draw rectangle
            rect = patches.Rectangle((flipped_x1, y1), width, height, linewidth=2, edgecolor='cyan', facecolor='none')
            ax.add_patch(rect)
            ax.text(flipped_x1, y1 - 1, 'Hotspot Detected', color='cyan', fontsize=10, weight='bold', backgroundcolor='black')

        plt.savefig(IMAGE_PATH, format='png', bbox_inches='tight')
        plt.close()

        snapshot_filename = "thermal_snapshot.png"
        snapshot_path = f"/var/www/html/snapshots/{snapshot_filename}"
        snapshot_json_path = f"snapshots/{snapshot_filename}"
        shutil.copyfile(IMAGE_PATH, snapshot_path)

        # Output JSON for frontend and log
        result = {
            "status": "hotspot" if valid_hotspot else "clear",
            "box": box if valid_hotspot else None,
            "temperature": round(float(max_temp), 2),
            "ambient": round(float(ambient), 2),
            "temperature_difference": round(float(temp_diff), 2),
            "image": snapshot_json_path
        }

        print(json.dumps(result))

        with open("/var/www/html/thermal_result.json", "w") as result_file:
            json.dump(result, result_file)

    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))

# Run the snapshot
capture_and_process()


