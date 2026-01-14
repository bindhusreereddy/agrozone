<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login | Agro-Zone</title>
    <link rel="stylesheet" href="ui.css">
</head>
<body>

<div class="header">Agro-Zone</div>

<?php
require('db.php');
session_start();

if (isset($_POST['username'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='".md5($password)."'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='container'>
                <h3 style='color:red;text-align:center'>Invalid username or password</h3>
                <p style='text-align:center'><a href='loginform.php'>Try Again</a></p>
              </div>";
    }

} else {
?>

<div class="container">
    <h2 style="text-align:center">Log In</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>

    <!-- Register -->
    <p style="text-align:center;margin-top:15px">
        Not registered yet? <a href="registration.php">Register Here</a>
    </p>

    <!-- Forgot Password (RESTORED) -->
    <p style="text-align:center;margin-top:8px">
        <a href="forgotp.html">Forgot Password?</a>
    </p>

    <!-- Back to Front Page -->
    <div style="text-align:center;margin-top:20px">
        <a href="frontpage.html">
            <button type="button" class="back-btn">← Back to Home</button>
        </a>
    </div>
</div>

<?php } ?>

<!-- Back button styling (safe, local) -->
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
