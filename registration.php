<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration | Agro-Zone</title>
    <link rel="stylesheet" href="ui.css">
</head>
<body>

<div class="header">Agro-Zone</div>

<?php
require('db.php');

if (isset($_REQUEST['username'])) {

    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($con, $username);

    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con, $email);

    $phone = stripslashes($_REQUEST['phone']);
    $phone = mysqli_real_escape_string($con, $phone);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    $trn_date = date("Y-m-d H:i:s");

    $query = "INSERT INTO users (username, email, phone, password, trn_date)
              VALUES ('$username', '$email', '$phone', '".md5($password)."', '$trn_date')";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<div class='container'>
                <h3 style='text-align:center;color:green'>
                    You are registered successfully.
                </h3>
                <p style='text-align:center'>
                    <a href='loginform.php'>Click here to Login</a>
                </p>
              </div>";
    }

} else {
?>

<div class="container">
    <h2 style="text-align:center">Registration</h2>

    <form method="post" align="center">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Register">
    </form>

    <div style="text-align:center;margin-top:15px">
        <a href="loginform.php">Already have an account? Login</a>
    </div>

    <div style="text-align:center;margin-top:20px">
        <a href="frontpage.html">
            <button type="button" class="back-btn">← Back to Home</button>
        </a>
    </div>
</div>

<?php } ?>

<style>
.back-btn {
    background-color: #777;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}
.back-btn:hover {
    background-color: #555;
}
</style>

</body>
</html>
