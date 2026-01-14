<?php
include("auth.php"); // ensures user is logged in
session_start();

$loggedUser = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "agrozone");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, phone, crop, quantity, fertilizers
        FROM addcrop
        WHERE name = '$loggedUser'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Crops | Agro-Zone</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f4f6f8;
        }
        .header {
            background-color: #1f8f3a;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f8f3a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #1f8f3a;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f1f7f3;
        }
        .actions {
            text-align: center;
            margin-top: 25px;
        }
        .btn {
            display: inline-block;
            padding: 10px 18px;
            margin: 5px;
            background-color: #1f8f3a;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #176e2d;
        }
        .no-data {
            text-align: center;
            color: #777;
            font-size: 16px;
        }
    </style>
</head>

<body>

<div class="header">Agro-Zone</div>

<div class="container">
    <h2>My Added Crops</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Crop</th>
                <th>Available Quantity</th>
                <th>Fertilizers Used</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['crop']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['fertilizers']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-data">No crops added yet.</p>
    <?php } ?>

    <div class="actions">
        <a href="addcrop.php" class="btn">➕ Add Crop</a>
        <a href="customer.html" class="btn">🏠 Home</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
