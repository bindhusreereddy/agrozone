<?php
session_start();
/*include_once 'database.php';*/
if(isset($_POST['submit']))
{
    $username = $_POST['user_id'];
    $result = mysqli_query($conn,"SELECT * FROM users where username='" . $_POST['username'] . "'");
    $row = mysqli_fetch_assoc($result);
	$fetch_username=$row['username'];
	$email = $row['email'];
	$password=$row['password'];
	if($username==$fetch_username) {
				$to = $email;
                $subject = "Password";
                $txt = "Your password is : $password.";
                $headers = "From: password@studentstutorial.com" . "\r\n" .
                "CC: somebodyelse@example.com";
                mail($to,$subject,$txt,$headers);
			}
				else{
					echo 'invalid userid';
				}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="logo.jpg" type="image/icon type">
    <title>forgetpass</title>  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <!--<span class="sr-only">Toggle navigation</span>-->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Login here</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <?php include('menu.php'); ?><!---->
            </div>
        </div>
    </nav>
  <div class="container">
        <div class="col-md-12">
            <div class="row">
            <br><br>
                <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <form method="POST" action="reset.php">
                    <h1>Forgot Password</h1><hr><br>
                        <div class="form-group">
                            <label class="form-control-label" for="username">Enter Email</label>
                            <input type="text" class="form-control form-control-success" name="email" id="username" required>
                        </div>
                      
                        <input type="submit"name="submit" class="btn btn-primary" value="Reset Password"><br><br>
                        

                     </div>

                    </form>

               <br><br><br>
                    </div>
                </div>

              <footer>
            <div class="row">
                
                <div class="col-lg-12">
                <hr>
                   
                </div>
            </div>
        </footer>
    </div>
       
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>    
</body>
</html>