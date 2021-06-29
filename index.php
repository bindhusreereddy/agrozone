<?php
	//include auth.php file on all secure pages
	include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome Home</title>
	<link rel="stylesheet" href="css/cssfile.css"/>
</head>
<body align="center">
	<img src="f3.jpg" width="100%"height="100%">
	<div class="form">
		<p>Welcome <?php echo $_SESSION['username']; ?>!<br><a href="frontpage.html">Home</a>&ensp;&ensp;
		<a href="logout.php">Logout</a></p>
	
	</div>
	<table border="0" align="center">
		<tr>
			<td><button onclick="window.location.href='addcrop.html';">Add Crops</button>&ensp;
			&ensp;<td><button onclick="window.location.href= 'viewcrop.php';">View Crops</button>
		</tr>
	</table>
	
	<!--<img src="f2.jpg" width="100%"height="100%"> -->
	<div class="main">
		
			<ul>
			<!--	<li><a href="frontpage.html">Home</a></li>
				<li><a href="logout.php">Logout</a></li>
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#">services</a></li>
				<li><a href="#">about</a></li>
				<li><a href="contact.html">contact</a></li>-->
			</ul>
		</div>
</body>
</html>