<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$crop = $_POST['crop'];
$quantity = $_POST['quantity'];
$fertilizers = $_POST['fertilizers'];

//echo $firstname."<br>".$email."<br>".$gender."<br>".$qual."<br>".$lang;
	
if(!empty($name)||!empty($phone)|| !empty($crop)|| !empty($quantity)|| !empty($fertilizers) ){
	//echo "inside if";
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "test";
	
	//$port = "3306";
	//create a connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);


	if(mysqli_connect_error()){
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
	else{
		//$SELECT = "SELECT email From tablenew Where email = ? Limit 1";
		$INSERT = "INSERT Into addcrop (name, phone, crop, quantity, fertilizers) values(?, ?, ?, ?, ?)";
		//prepare a statement
	/*	$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		
		if($rnum==0){
			//$stmt->close();*/
			
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("sssss", $name, $phone, $crop, $quantity, $fertilizers);
			$stmt->execute();
			echo "Your Crop details Inserted Successfully";
		/*}
		else{
			echo "Someone already registered using this email";
		}*/
		$stmt->close();
		$conn->close();
	}
}
else{
	echo "All field are Required";
	die();
}
?>