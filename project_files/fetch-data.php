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

// Generate the HTML table row with the latest data
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
