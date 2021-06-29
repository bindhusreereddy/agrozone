<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="payment.css" />
	</head>
<body bgcolor="#F5F5DC" background-image="phpimg.jpg">
	<?php
	require('db.php');
	session_start();
	// If form submitted, insert values into the database.
	if (isset($_POST['username'])){
        // removes backslashes
		$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
		$username = mysqli_real_escape_string($con,$username);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con,$password);
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `users` WHERE username='$username'
		and password='".md5($password)."'";
		$result = mysqli_query($con,$query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
        if($rows==1){
			$_SESSION['username'] = $username;
            // Redirect user to index.php
			header("Location: index.php");
         }
		 else{
			echo "<div class='form'>
			<h3>Username/password is incorrect.</h3>
			<br/>Click here to <a href='loginform.php'>Login</a></div>";
		}
    }
	else{
?>

	<div class="form">

	<div class="main-content">
		<h1 align="center">Agro-Zone</h1>
	</div>
	
	<br>
	<h2 align="center">Log In</h2>
	<br>
	<br>
	<form action="" method="post" name="login" align="center">
	
		<input type="text" name="username" placeholder="Username" required /><br>
		<br><input type="password" name="password" placeholder="Password" required /><br>
		<br><input name="submit" type="submit" value="Login" />
	</form>
	<br>
	<p align="center">Not registered yet? <a href='registration.php'>Register Here</a></p>
	<br>
	<p align="center"><a href="forgotp.html">Forgot Password?</a></p>
	</div>
	
	  <br>
	  <br>
	  <br>
	  <br>
	  <div class="main-content">
			<p class="text" text ></p>
      </div>
	<?php } ?>
</body>
</html>