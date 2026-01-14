<?php
session_start();
require('db.php');

if (!isset($_SESSION['username'])) {
    die("User not logged in");
}

$username = $_SESSION['username'];

$query = "SELECT phone FROM users WHERE username='$username'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$phone = $row['phone'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Crop | Agro-Zone</title>

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
            max-width: 520px;
            margin: 40px auto;
            background: white;
            padding: 30px 35px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 500;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 500;
            color: #444;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[readonly] {
            background-color: #f0f0f0;
            color: #666;
        }

        textarea {
            resize: vertical;
        }

        .btn-group {
            text-align: center;
            margin-top: 25px;
        }

        .btn-group input {
            width: 120px;
            margin: 0 8px;
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #1f8f3a;
            color: white;
        }

        .submit-btn:hover {
            background-color: #176e2d;
        }

        .reset-btn {
            background-color: #888;
            color: white;
        }

        .reset-btn:hover {
            background-color: #666;
        }
    </style>
</head>

<body>

<div class="header">Agro-Zone</div>

<div class="container">

    <h2>Add Your Crop</h2>

    <form action="addcrop_submit.php" method="POST">

        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($username); ?>" readonly>

        <label>Phone Number</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" readonly>

        <label>Select Crop</label>
        <select name="crop" required>
            <option value="Rice">Rice</option>
            <option value="Wheat">Wheat</option>
            <option value="Onion">Onion</option>
            <option value="Sugar Cane">Sugar Cane</option>
            <option value="Maize">Maize</option>
            <option value="Cotton">Cotton</option>
        </select>

        <label>Quantity (in kgs)</label>
        <input type="text" name="quantity" required>

        <label>Fertilizers & Pesticides Used</label>
        <textarea rows="4" name="fertilizers" required></textarea>

        <div class="btn-group">
            <input type="submit" value="Submit" class="submit-btn">
            <input type="reset" value="Reset" class="reset-btn">
        </div>

    </form>

</div>

</body>
</html>
