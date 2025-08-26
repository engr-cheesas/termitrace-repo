import sys
import json
from ultralytics import YOLO

input_image = sys.argv[1]
output_image = sys.argv[2]

model = YOLO("/home/pi/runs/detect/train/weights/best.pt")
results = model(input_image, conf=0.45)

for r in results:
    r.save(filename=output_image)

# Analyze detections
termite_scores = []
for r in results:
    for box in r.boxes:
        cls_id = int(box.cls[0])
        class_name = model.names[cls_id]
        conf = float(box.conf[0])
        if "termite" in class_name.lower():
            termite_scores.append(conf)

# Convert confidence to percentage
percent_scores = [round(c * 100, 2) for c in termite_scores]

avg_conf = round(sum(percent_scores) / len(percent_scores), 2) if percent_scores else 0.0
max_conf = round(max(percent_scores), 2) if percent_scores else 0.0

# Decision logic

if avg_conf > 50:
    findings = "Possible Termite Infestation Detected"
else:
    findings = "No Termite Infestation Detected"

# Prepare result JSON
detection_info = {
    "num_detections": len(percent_scores),
    "avg_confidence": avg_conf,
    "max_confidence": max_conf,
    "findings": findings
}

print(json.dumps(detection_info))
