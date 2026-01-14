<?php

$username = $_POST['username'] ?? '';
$New_Password = $_POST['New_Password'] ?? '';

if (!empty($username) && !empty($New_Password)) {

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "agrozone";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("DB Connection Failed: " . $conn->connect_error);
    }

    // Check if user exists
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        // Update password
        $hashed = md5($New_Password);
        $update = "UPDATE users SET password='$hashed' WHERE username='$username'";

        if (mysqli_query($conn, $update)) {
            echo "✅ Password updated successfully.<br>";
            echo "<a href='loginform.php'>Login here</a>";
        } else {
            echo "❌ Error updating password";
        }

    } else {
        echo "❌ User not registered";
    }

    $conn->close();

} else {
    echo "❌ Username or Password is empty";
}
?>