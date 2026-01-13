<?php
    // Enter your Host, username, password, database below.
    // Password is empty because XAMPP default MySQL has no password
    $con = mysqli_connect("localhost","root","","agrozone");

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>