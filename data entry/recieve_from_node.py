import socket
import sys
import time
import json

# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Connect the socket to the port on the server given by the caller
com_port = 5556
node_id = "fc:69:47:c:2f:3"
server_address = ('', int(com_port))

print('connecting to %s port %s' % server_address, file=sys.stderr)

sock.bind(server_address)
sock.listen(5)

try:
    while True:
        # Wait for a connection
        print("Waiting for a connection...")
        s, addr = sock.accept()
        print("Connection established!")
        
        # Read data from the client
        data = s.recv(100)
        print(data)
        data_dict = json.loads(data)
        # Add timestamp to the dictionary
        data_dict['datetime'] = time.strftime("%Y-%m-%d %H:%M:%S")
        if(data_dict["node_id"]=="fc:69:47:c:2f:3"):
            # Store data in a file
            with open("received_data.txt", "a") as f:
                f.write(json.dumps(data_dict))
                f.write("\n")
        
        # Wait for 5 seconds
        time.sleep(1)
        
        # Close the socket
        s.close()
finally:
    sock.close()

