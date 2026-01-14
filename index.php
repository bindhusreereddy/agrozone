<?php
	// include auth.php file on all secure pages
	include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard | Agro-Zone</title>

	<style>
		body {
			margin: 0;
			font-family: "Segoe UI", Arial, sans-serif;
			background-color: #f4f6f8;
		}

		/* Header */
		.header {
			background-color: #1f8f3a;
			color: white;
			padding: 18px;
			text-align: center;
			font-size: 26px;
			font-weight: bold;
		}

		/* Hero Image */
		.hero img {
			width: 100%;
			height: 420px;
			object-fit: cover;
		}

		/* Dashboard card */
		.dashboard {
			max-width: 900px;
			margin: -120px auto 40px;
			background: white;
			padding: 35px;
			border-radius: 14px;
			box-shadow: 0 12px 30px rgba(0,0,0,0.15);
			text-align: center;
		}

		.dashboard h2 {
			margin-top: 0;
			color: #1f8f3a;
		}

		.user-info {
			margin: 15px 0;
			font-size: 16px;
		}

		.user-info a {
			color: #1f8f3a;
			text-decoration: none;
			font-weight: 500;
			margin: 0 10px;
		}

		.user-info a:hover {
			text-decoration: underline;
		}

		/* Action buttons */
		.actions {
			margin-top: 30px;
		}

		.action-btn {
			display: inline-block;
			padding: 14px 28px;
			margin: 10px;
			background-color: #1f8f3a;
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 16px;
			cursor: pointer;
			text-decoration: none;
			transition: background-color 0.2s ease, transform 0.2s ease;
		}

		.action-btn:hover {
			background-color: #176e2d;
			transform: translateY(-2px);
		}

		.footer {
			text-align: center;
			color: #777;
			font-size: 14px;
			margin-bottom: 30px;
		}
	</style>
</head>

<body>

	<div class="header">Agro-Zone</div>

	<div class="hero">
		<img src="f3.jpg" alt="Agro-Zone">
	</div>

	<div class="dashboard">
		<h2>Welcome, <?php echo $_SESSION['username']; ?> 👋</h2>

		<div class="user-info">
			<a href="frontpage.html">Home</a> |
			<a href="logout.php">Logout</a>
		</div>

		<div class="actions">
			<a href="addcrop.php" class="action-btn">➕ Add Crops</a>
			<a href="viewcrop.php" class="action-btn">📋 View Crops</a>
		</div>
	</div>

	<div class="footer">
		© Agro-Zone | Farmer Crop Management System
	</div>

</body>
</html>
