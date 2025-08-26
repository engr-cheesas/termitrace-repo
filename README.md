# 🐜 Termite Detection and Extermination System using Machine Learning  

## 🚀 Features  
- Non-chemical, eco-friendly termite control  
- Multi-modal detection for higher reliability  
- Extermination with safety logic  
- Portable, user-friendly hardware design

---

## ⚙️ How It Works  

<img width="797" height="475" alt="Instruction" src="https://github.com/user-attachments/assets/ab5b0b4a-1656-42f4-b3f8-3a2ffa242e56" />

1. **Image Detection**  
   - Detects termite holes using a trained ML model.  
   <img width="2048" height="1536" alt="Image Detection" src="https://github.com/user-attachments/assets/3012b93f-94b0-458d-9518-1d35f194c329" />

2. **Acoustic Analysis**  
   - Detects hollow wood sound patterns.  
   <img width="800" height="477" alt="Solid Wood Detected" src="https://github.com/user-attachments/assets/28e546a5-61a0-4c47-b4e8-16d67972a2e3" />
  <img width="798" height="477" alt="Papery-sounding Wood Detected" src="https://github.com/user-attachments/assets/1fc1d3eb-05e1-4284-ad36-bbc90ec744aa" />

3. **Thermal Imaging**  
   - Identifies temperature anomalies in infested wood.  
   <img width="800" height="472" alt="Thermal Scan Example" src="https://github.com/user-attachments/assets/8c21d358-0887-41e1-82b3-dccc2c6ae428" />
   <img width="794" height="484" alt="Hotspot Detected" src="https://github.com/user-attachments/assets/0e77693e-9aa5-467f-8ffb-4cdafbfeb5d5" />
   <img width="798" height="478" alt="No Hotspot Detected" src="https://github.com/user-attachments/assets/6179b7fe-dd35-4ff0-afc3-796f2cfd2907" />

4. **Detection Result**
   - Displays the result of the three detection methods that serve as the basis for the system to enable or disable the extermination component.
     <img width="799" height="474" alt="Positive Detection" src="https://github.com/user-attachments/assets/0a9b68b5-1592-4359-8c7b-1b2402962049" />
     <img width="793" height="475" alt="Negative Detection" src="https://github.com/user-attachments/assets/7be7fba7-ad76-4ec9-81c2-056bac053a8d" />

4. **Hot Air Extermination**  
   - Applies heat when infestation is confirmed.
   <img width="799" height="473" alt="Result for Enabled Extermination" src="https://github.com/user-attachments/assets/74135b63-ccdb-4e36-b305-0f23bb1fb436" />
   <img width="799" height="478" alt="Result for Disabled Extermination" src="https://github.com/user-attachments/assets/47d07111-9561-4604-af34-300fe4feca3f" />
 
---

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


