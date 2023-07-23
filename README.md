For Running this project there are some prerequisite for set up of environment
1. Download & Install Xampp for running app locally
2. Download & Install Python3

Steps:-
1. After downloading Xampp copy project_files folder in C:\xampp\htdocs 
2. Create Database
   a. Start the Xampp control panel and activate Apache and SQL server.
   b. Once successfully started, open your browser and go to "http://localhost/phpmyadmin/".
   c. On the left-side panel, click on "New" to create a new database named "cec". Inside the "cec" database, create a table named "data".
   d. In that table create coloumns as follows:-
		  id Primary	int(11)				No	None				AUTO_INCREMENT
		  datetime	timestamp				No	current_timestamp()	ON UPDATE CURRENT_TIMESTAMP()
		  temp		int(11)				No	None			
		  humi		int(11)				No	None			
		  node_id	text	utf8mb4_general_ci	No	None			
		  device	text	utf8mb4_general_ci	No	None

3. To start the web app service, open a new tab in your browser and enter "http://localhost/project_files/main.php". This will display the frontend of the web app.

4. Open the "sender.py" file and replace the IP address with your machine's IP address. To get the IP address on your machine, open a new command prompt and enter the command "ipconfig". Copy the IPV4 address of your internet connection (e.g., wifi, ethernet) and paste it as the IP address in the "sender.py" file. You can also modify the sample data in the file.

5. Open the "data entry" folder and run the terminal within it.

6. First, run the command "python recieve.py" to receive data on your machine and store it in the database. To send entries, run the "python send_data_to_vm_from_gateway.py" command in the command prompt of the gateway.

7. To check new entries, go to "http://localhost/project_files/main.php". For checking data with filters up to the current date, click on "See Other Details".

8. To send data to the gateway, use Putty, and on the gateway, copy the file named "recieve_from_node.py" from the "data entry" folder. Run the command "python recieve_from_node.py" on the gateway to receive data from the sensor. Also, run "python send_data_to_vm_from_gateway.py" on another terminal on the gateway. Before running the file, make sure to update the IP address on the cloud VM in the Python file.
