<!DOCTYPE html>
<html>
<head>
    <title>Sugar Cane | Agro-Zone</title>
    <link rel="stylesheet" href="ui.css">
</head>
<body>

<div class="header">Agro-Zone</div>

<div class="container">
    <h2 style="text-align:center">Sugar Cane Crop Details</h2>

<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "agrozone";

// create a connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
} else {

    $sql = "SELECT name, phone, crop, quantity, fertilizers FROM addcrop WHERE crop='Sugar Cane'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<table class='styled-table'>";
        echo "<tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Crop</th>
                <th>Available Quantity</th>
                <th>Fertilizers Used</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['crop'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['fertilizers'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "<p style='text-align:center;color:red'>No sugar cane crop records found.</p>";
    }

    $conn->close();
}
?>

</div>

</body>
</html>
