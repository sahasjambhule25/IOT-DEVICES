<!DOCTYPE html>
<html>

<head>
    <title>Other Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-HLVwlmUJpg6Q2C/h40g4Ih4jjyaKW9sd1FZImzIpepB7/WwPzzLKe69WJy8UVVfEUKaI9P+oLRGTnqbL7T2TtQ=="
        crossorigin="anonymous" />
    <style>
        body {
            /* background-color: #754141; */
            background-image: url("https://images.unsplash.com/photo-1541278107931-e006523892df?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-label {
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            border-radius: 10px;
        }

        .input-group-addon {
            border-radius: 10px;
        }

        .btn-submit {
            border-radius: 10px;
        }
    </style>
</head>

<body>
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form class="bg-light p-4 rounded" action="fetch-filter.php" method="post">
                <h1 class="text-center mb-4">Other Details</h1>
                <div class="form-group">
                    <label for="datetime">Date and Time:</label>
                    <input type="datetime-local" id="datetime" name="datetime" class="form-control">
                </div>
                <div class="form-group">
                    <label for="parameter">Parameter:</label>
                    <select class="form-control" name="parameter" id="parameter">
                        <option value="" selected>Select the parameter</option>
                        <option value="temp">Temperature</option>
                        <option value="humi">Humidity</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class='container'>   
<?php
// Get the input values from the form
$datetime = $_POST['datetime'];
$parameter = $_POST['parameter'];

// Create a connection to the MySQL database
$servername = "localhost";  // Replace with your server name
$username = "root";         // Replace with your MySQL username
$password = "";             // Replace with your MySQL password
$dbname = "cec";            // Replace with your database name
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Build SQL query based on the selected parameter
if ($parameter == 'humi') {
    $sql = "SELECT  datetime, humi, node_id, device FROM data WHERE datetime >= '$datetime' AND datetime <= NOW()";
} elseif ($parameter == 'temp') {
    $sql = "SELECT  datetime, temp, node_id, device FROM data WHERE datetime >= '$datetime' AND datetime <= NOW()";
} else {
    die("Invalid parameter value.");
}

// Execute the query and get the result
$result = $conn->query($sql);

// Check if there is any data returned from the query
if ($result->num_rows > 0) {
    // Output the data as a table
    echo '<div class="table-responsive"><table class="table table-striped table-bordered" style="font-weight: bold; border: 2px solid #ccc; background-color: #f5f5f5;">';
    echo '<thead class="thead-dark"><tr>';
    
    // Output table headers for all columns
    $fields = mysqli_fetch_fields($result);
    foreach ($fields as $field) {
      echo '<th scope="col">'.$field->name.'</th>';
    }
    echo '</tr></thead>';
    
    // Output each row of the result set
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      foreach ($fields as $field) {
        echo '<td>'.$row[$field->name].'</td>';
      }
      echo '</tr>';
    }
    echo '</tbody></table></div>';
  } else {
    echo 'No data found.';
  }
  


// Close the database connection
$conn->close();
?>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha384-HaIBY86JWu8PJbhhIyBV3JxkpFkULw+sLz5f+J83J24MjKgKLfwpMNHUlsuvlQRn" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNVQ8vc"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha384-m0/dhYRRa0f+/SCzj8CfWAllyvclvcstjHzG5R5QwhYKN1DUv5q3FzBTHtxG2NSe"
        crossorigin="anonymous"></script>

    <script>
        $(function () {
            var maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 3); // Set maximum date to three days from today
            $('#date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                endDate: maxDate,
                todayHighlight: true
            });
        });
    </script>

</html>