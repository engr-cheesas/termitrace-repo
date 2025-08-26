# 🐜 Termite Detection and Extermination System using Machine Learning  

## 📌 Overview  
This project presents a **Termite Detection and Extermination System** designed for regular household wooden structures.  
The system integrates **acoustic sensing, thermal imaging, and machine learning-based image detection** to identify termite infestations, while extermination is performed through a **directed hot air mechanism**.  

Developed as a Computer Engineering thesis at Bulacan State University, the project followed the **Spiral Model (SDLC)** to ensure iterative design, risk analysis, and continuous improvements.  

<img width="802" height="469" alt="image" src="https://github.com/user-attachments/assets/0ef810f7-4d27-46c5-ab02-16d4e51707fe" />

---

## 🐜 Problem Statement  
- Termite infestations cause **severe and often hidden structural damage**, especially in humid regions like the Philippines.  
- Existing solutions rely on **expensive equipment, manual inspections, or chemical pesticides**, which pose health and environmental risks.  
- No integrated system exists that provides **both detection and extermination** in a single device accessible to homeowners.  

---

## 💡 Proposed Solution  
Our system combines **non-invasive detection** and **eco-friendly extermination** using multiple technologies:  

- 🎥 **Image Detection (Machine Learning):** Identifies termite holes with **88% accuracy** and **96% precision**.  
- 🔊 **Acoustic Analysis:** Detects anomalies in wood via knocking frequency response.  
- 🌡️ **Thermal Imaging:** Detects temperature variations caused by termite activity.  
- 🔥 **Hot Air Extermination:** Achieved **100% extermination in softwood** and up to **82.5% efficiency overall**.  
- 🧠 **Rule-Based Wizard:** Triggers extermination **only if at least two detection methods confirm infestation**, minimizing false positives.  

---

## ⚙️ System Architecture  

### Hardware Components  
- Raspberry Pi 4B (main controller)  
- Arduino Nano (sub-controller)  
- MLX90640 Thermal Camera  
- MAX9814 Acoustic Sensor  
- USB Camera  
- Hot Air Blower (for extermination)  

### Software Components  
- Python (image detection, ML model integration)  
- OpenCV (image processing)  
- Embedded C / Arduino IDE (sensor control)  
- Spiral Model methodology for iterative development  

---

## 📊 Key Results  

### Detection Performance  
- **Image Detection:** 88% accuracy, 96% precision, 80.67% recall  
- **Acoustic Analysis:** Infested wood ~1362 Hz vs. Uninfested ~2757 Hz  
- **Thermal Imaging:** +2.73°C average anomaly in heavily infested samples  

### Extermination Efficiency  
- Hardwood: 52.17% average extermination  
- Softwood: 82.50% average extermination  
- **Full extermination at ≥50°C and +19°C temp rise**  

### User Evaluation (ISO/IEC 25010:2023)  
- ✅ Functional Suitability – High  
- ✅ Usability – Highest rating  
- ✅ Safety – High  
- ⚠️ Performance Efficiency – Needs improvement  

---

## 🚀 Features  
- Non-chemical, eco-friendly termite control  
- Multi-modal detection for higher reliability  
- Extermination with safety logic  
- Portable, user-friendly hardware design  

---


