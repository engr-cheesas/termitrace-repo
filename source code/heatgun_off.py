import serial
import time

# Define the serial port and baud rate
serial_port = "/dev/ttyUSB0"  # Change if necessary
baud_rate = 9600

try:
    # Open serial connection
    ser = serial.Serial(serial_port, baud_rate, timeout=1)
    time.sleep(2)  # Allow time for the connection to establish

    # Send the value '1'
    ser.write(b'2')
    print("Sent: 2")

    # Close the serial connection
    ser.close()

except serial.SerialException as e:
    print(f"Error: {e}")
