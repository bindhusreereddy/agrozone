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
		$sql = "SELECT name, phone, crop, quantity, fertilizers FROM addcrop where crop='onion'";
		$result = $conn->query($sql);
	echo "<table border='1'>

	<tr>

	<th>name</th>

	<th>Mobile</th>

	<th>crop</th>
	
	<th>Available Quantity</th>
	
	<th>Fertilizers used</th>

	</tr>";
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
			
			echo "<tr>";

			echo "<td>" . $row["name"] . "</td>";

			echo "<td>" . $row["phone"] . "</td>";

			echo "<td>" . $row["crop"] . "</td>";

			echo "<td>" . $row["quantity"] . "</td>";
			
			echo "<td>" . $row["fertilizers"] . "</td>";

			echo "</tr>";

		}

		echo "</table>";
			
		
	} else {
		echo "0 results";
	}
	$conn->close();
	}
?>

