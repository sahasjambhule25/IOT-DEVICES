<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-HLVwlmUJpg6Q2C/h40g4Ih4jjyaKW9sd1FZImzIpepB7/WwPzzLKe69WJy8UVVfEUKaI9P+oLRGTnqbL7T2TtQ=="
        crossorigin="anonymous" />
    <style>
        /* Center all content on the page */
        body {
            /* background-color: #754141; */
            background-image: url("https://images.unsplash.com/photo-1651432615809-393df961145b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
        }

        /* Add some basic styling to the table */
        table {
            border-collapse: collapse;
            width: 30%;
            margin: 0 auto;
            /* center the table horizontally */
        }

        th,
        td {
            font-weight: 800;
            color: rgb(63, 8, 17);
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #1b6666;
            background-color: beige;
        }

        th {
            background-color: #67b171;
        }

        /* Add some basic styling to the date/time divs */
        .datetime {
            display: inline-block;
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .datetime-left {
            float: left;
            margin-left: 50px;
        }

        .datetime-right {
            float: right;
            margin-right: 50px;
        }

        /* Add styling to the tag at the bottom left */
            .tag {
                position: fixed;
                bottom: 0;
                left: 0;
                margin: 10px;
                padding: 10px;
                background-color: #f2f2f2;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
    </style>
</head>

<body>
    <h1 style="color: #ddd;">Welcome to Systems Lab!</h1>
    <h2 style="color: #ddd;">Zone::Grp1</h2>


    <table id="data-table">
    <thead>
        <tr>
            <th>Date/Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
            <th>Node ID</th>
            <th>Device</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "cec");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch the last entry from the data table
        $sql = "SELECT * FROM data ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);

        // Display the data in the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["datetime"] . "</td>";
                echo "<td>" . $row["temp"] . "</td>";
                echo "<td>" . $row["humi"] . "</td>";
                echo "<td>" . $row["node_id"] . "</td>";
                echo "<td>" . $row["device"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </tbody>
</table>

    <!-- Add two divs to show the current date and time -->
    <div class="datetime datetime-left" style="color: #ddd;">Loading...</div>
    <div class="datetime datetime-right" style="color: #ddd;">Loading...</div>
    <!-- Add a tag at the bottom left -->
    <div class="tag"><a href="./2.php">See other details</a></div>
    <!-- Add a clock at the bottom right -->
    <script>
        function updateDateTime() {
            const now = new Date();
            const leftDiv = document.querySelector('.datetime-left');
            const rightDiv = document.querySelector('.datetime-right');
            leftDiv.innerText = now.toLocaleDateString();
            rightDiv.innerText = now.toLocaleTimeString();
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
<script>
    // Function to fetch the latest data from the server
    function fetchData() {
        fetch('fetch-data.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('#data-table tbody').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Call the fetchData() function every 5 seconds to update the table
    setInterval(fetchData, 5000);
</script>

</html>