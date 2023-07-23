import socket
import csv
import json
import mysql.connector

HOST = ''  # all available interfaces
PORT = 8000

# Connect to the MySQL database
cnx = mysql.connector.connect(user='root', password='', host='localhost', database='cec')
cursor = cnx.cursor()

a_msg="Data received successfully."

# Listen for incoming connections and receive data
while True:
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.bind((HOST, PORT))
        s.listen()
        conn, addr = s.accept()
        with conn:
            print('Connected by', addr)
            data_str = conn.recv(1024).decode()
            print(data_str)
            
            try:
                # Parse the received JSON data
                data = json.loads(data_str)
            except json.JSONDecodeError as e:
                continue
            # Parse the received JSON data
            
            
            # Insert the data into the MySQL database
            query = ("INSERT INTO data (datetime, temp, humi, node_id, device) VALUES (%s, %s, %s, %s, %s)")
            values = (data['datetime'], data['temp'], data['humi'], data['node_id'], data['device'])
            cursor.execute(query, values)
            cnx.commit()
            conn.sendall(a_msg.encode())
            
    # Close the database connection
cnx.close()
