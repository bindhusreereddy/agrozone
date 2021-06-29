<html>
<head>
	<meta charset="utf-8">
	<title>Registration</title>
	<link rel="stylesheet" href="payment.css" />
	</head>
<body bgcolor="#F5F5DC">
	<?php
	require('db.php');
	// If form submitted, insert values into the database.
	if (isset($_REQUEST['username'])){
        // removes backslashes
		$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
		$username = mysqli_real_escape_string($con,$username); 
		$email = stripslashes($_REQUEST['email']);
		$email = mysqli_real_escape_string($con,$email);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con,$password);
		$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `users` (username, password, email, trn_date)
		VALUES ('$username', '".md5($password)."', '$email', '$trn_date')";
			$result = mysqli_query($con,$query);
			if($result){
				echo "<div class='form'>
				<h3>You are registered successfully.</h3>
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
	<h2 align="center">Registration</h2>
	<br>
	<br>
		<form name="registration" action="" method="post" align="center">
			<input type="text" name="username" placeholder="Username" required /><br>
			<br><input type="email" name="email" placeholder="Email" required /><br>
			<br><input type="password" name="password" placeholder="Password" required /><br>
			<br><input type="submit" name="submit" value="Register" />
		</form>
</div>

	  <br>
	  <br>
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