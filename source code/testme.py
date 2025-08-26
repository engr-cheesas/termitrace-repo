import serial
import time

# Open serial port
ser = serial.Serial('/dev/ttyUSB0', 9600, timeout=2)
time.sleep(2)

def send_command(command):
    ser.write((command + "\n").encode())
    lines = []

    start_time = time.time()
    while True:
        if time.time() - start_time > 20:
            print("Timeout reached.")
            break

        response = ser.readline().decode(errors='ignore').strip()
        if response:
            if response == "DONE":
                break
            lines.append(response)
        else:
            time.sleep(0.1)

    if not lines:
        print("No response received.")
        return ["No response"]

    return lines

if __name__ == "__main__":
    lines = send_command("3")
    for line in lines:
        print(line)  # Each line printed normally
