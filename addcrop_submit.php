<?php
$name        = $_POST['name'];
$phone       = $_POST['phone'];
$crop        = $_POST['crop'];
$quantity    = $_POST['quantity'];
$fertilizers = $_POST['fertilizers'];

if (!empty($name) && !empty($phone) && !empty($crop) && !empty($quantity) && !empty($fertilizers)) {

    $conn = new mysqli("localhost", "root", "", "agrozone");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $INSERT = "INSERT INTO addcrop (name, phone, crop, quantity, fertilizers)
               VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("sssss", $name, $phone, $crop, $quantity, $fertilizers);

    if ($stmt->execute()) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Crop Added | Agro-Zone</title>
            <style>
                body {
                    margin: 0;
                    font-family: "Segoe UI", Arial, sans-serif;
                    background-color: #f4f6f8;
                }
                .header {
                    background-color: #1f8f3a;
                    color: white;
                    padding: 22px;
                    text-align: center;
                    font-size: 26px;
                    font-weight: bold;
                }
                .container {
                    max-width: 500px;
                    margin: 60px auto;
                    background: white;
                    padding: 35px;
                    border-radius: 14px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
                    text-align: center;
                }
                h2 {
                    color: #1f8f3a;
                    margin-bottom: 15px;
                }
                p {
                    color: #444;
                    margin-bottom: 25px;
                }
                .btn {
                    display: inline-block;
                    margin: 8px;
                    padding: 10px 18px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-size: 14px;
                    color: white;
                }
                .btn-add {
                    background-color: #1f8f3a;
                }
                .btn-add:hover {
                    background-color: #176e2d;
                }
                .btn-view {
                    background-color: #555;
                }
                .btn-view:hover {
                    background-color: #333;
                }
            </style>
        </head>
        <body>

        <div class="header">Agro-Zone</div>

        <div class="container">
            <h2>Crop Added Successfully!</h2>
            <p>Your crop details have been saved.</p>

            <a href="addcrop.php" class="btn btn-add">➕ Add Another Crop</a>
            <a href="viewcrop.php" class="btn btn-view">👁 View Crops</a>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "All fields are required";
}
?>
