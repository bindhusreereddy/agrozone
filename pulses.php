<?php
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
		$sql = "SELECT name, phone, crop, quantity, fertilizers FROM addcrop where crop='Pulses'";
		$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
			echo "name: " . $row["name"]."<br> * phone: " . $row["phone"]."<br> * crop: " . $row["crop"]."<br> * Available Quantity: ". $row["quantity"] . "<br> * Fertilizers used: ". $row["fertilizers"] . "<br>";
		}
	} else {
		echo "0 results";
	}
	$conn->close();
	}
?>

