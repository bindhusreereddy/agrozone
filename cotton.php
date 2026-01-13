<!DOCTYPE html>
<html>
<head>
    <title>Cotton | Agro-Zone</title>
    <link rel="stylesheet" href="ui.css">
</head>
<body>

<div class="header">Agro-Zone</div>

<div class="container">
    <h2 style="text-align:center">Cotton Crop Details</h2>

<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "agrozone";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, phone, crop, quantity, fertilizers FROM addcrop WHERE crop='Cotton'";
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
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['crop']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['fertilizers']}</td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "<p style='text-align:center;color:red'>No cotton crops found.</p>";
}

$conn->close();
?>

</div>

</body>
</html>
