<?php 

//session_start();

		//something was posted
		$username = $_POST['username'];
		$New_Password = $_POST['New_Password'];


		if(!empty($username) && !empty($New_Password) )
		{

	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "test";
	
	//$port = "3306";
	//create a connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	
			//read from database
			$query = "select * from users where  username = $username";
			$result = mysqli_query($conn, $query);
			//echo "\n\n$result - [log statement here]";
			
			
	
			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
					
					$user_data = mysqli_fetch_assoc($result);
					
					//echo"hello";
					$UPDATE = "update users set password = $New_Password where username= $username";
					
					$stmt = $conn->prepare($UPDATE);
					$stmt->bind_param("s",$New_Password);
					$stmt->execute();
					echo "We have changed your password";
					echo "Login with the new details to make sure";
					$stmt->close();
					$conn->close();
					
					
				}
				
			}
			else{
				
			 echo "NOT REGISTERED! \n\n CLICK HERE TO REGISTER";
			//header("Location:registration.php");
			}
			
			
		}else
		{
			echo "connection error";
			
			
		}