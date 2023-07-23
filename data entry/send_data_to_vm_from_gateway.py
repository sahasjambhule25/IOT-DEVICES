import socket
import time

HOST = '172.29.2.82'
PORT = 8000

# Connect to the receiver

while True :
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((HOST, PORT))

    # Send the first line of receive_data.txt to the receiver, if it exists
    with open('received_data.txt', 'r') as f:
        first_line = f.readline().strip()
        if first_line:
            s.sendall(first_line.encode())
            print('Sent data:', first_line)
        else : 
            print("recived_data.txt empty")
            s.close()
            time.sleep(6)
            continue

    # Receive acknowledgement from the receiver and delete the sent line
    msg = s.recv(1024).decode()
    if msg == 'Data received successfully.':
        with open('received_data.txt', 'r') as f:
            lines = f.readlines()
        with open('received_data.txt', 'w') as f:
            f.writelines(lines[1:])
        print('Deleted sent data:', first_line)

    s.close()

    # Wait for 6 seconds and repeat
    time.sleep(6)
