<?php 

session_start();

		//something was posted
		$username = $_POST['username'];
		$Recovery_Password = $_POST['Recovery_Password'];


		if(!empty($username) && !empty($Recovery_Password) )
		{
//echo "inside if";
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "test";
	
	//$port = "3306";
	echo "create a connection";
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
					
					if($user_data['Recovery_Password'] === $Recovery_Password)
					{

						$_SESSION['username'] = $userdata['username'];
						//echo "\n\n$Recovery_Password ";
						//header("Location:user_choice.html");
						die;
					}
					else
					{
						echo "wrong recovery password";
					}
				}
				
			}
			else{
			 echo "NOT REGISTERED! \n\n CLICK HERE TO REGISTER";
			//header("Location:sigin_page.html");
			}
			
			
		}else
		{
			echo "connection error";
			
			
		}