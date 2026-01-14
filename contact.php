<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "agrozone";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Database connection failed");
}

$name = $_POST['name'];
$phone = $_POST['phn'];
$email = $_POST['mail'];
$message = $_POST['msg'];

if (!empty($name) && !empty($phone) && !empty($email) && !empty($message)) {

    $stmt = $conn->prepare(
        "INSERT INTO contact_us (name, phone, email, message) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $name, $phone, $email, $message);
    $stmt->execute();
    $stmt->close();

    echo "<script>
            alert('Thank you! Your message has been sent.');
            window.location.href='frontpage.html';
          </script>";
} else {
    echo "All fields are required";
}

$conn->close();
?>
