import serial
import time

SERIAL_PORT = "/dev/ttyUSB0"  # Adjust as needed (e.g., COM3 on Windows)
BAUD_RATE = 9600

arduino = serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=2)
time.sleep(2)  # Wait for Arduino to initialize

commands = ["1", "2", "3"]  # The 3 commands

for i, cmd in enumerate(commands, start=1):
    arduino.write(cmd.encode())  # Send command
    print(f"Sent {i}: {cmd}")

    # Wait for response only on the 3rd command
    if i == 3:
        while True:
            response = arduino.readline().decode().strip()
            if response:
                print(f"Arduino: {response}")
            if response == "DONE":
                break  # Stop waiting once "DONE" is received

    time.sleep(1)  # Small delay before sending the next command

arduino.close()
