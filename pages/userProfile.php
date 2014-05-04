<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		
		<script src="../scripts/logoutTab.js"></script>
	</head>

  <body>
		<div id="header">
			<h1> User Profile </h1>
			<ul class="logoutTab">
				<li id="username">Username <span onclick="clickedUsername();" id="triangle"> &#9660 </span></li>
				<ul id ="tabOps">
					<li><a href="userProfile.html">View Profile</a>
					<li><a href="customizeProfile.php">Customize Profile</a></li>
					<li><a href="../index.html">Log Out</a></li>
				</ul>
			</ul>
		</div>
		<div class = "orange">
			<div class = "info">
				<p> Name: armpit invader</p>
				<p> Address: 1234 Main Street
					<div id="addr">
						<span id = "city"> idontcare</span>,
						<span id = "state"> ny </span>	
						<span id = "zip">54321</span> 
					</div>
				</p>
				<p> Email: bopit@gmail.com</p>
				<p> Credit Card: 123456789100</p>
				<!-- ---------CURRENT RESERVATION----------- -->
				<div class="reservations">
					<table class="table">
						<tr>
							<td colspan="5" class="header">Current Reservations</td>
						</tr>
						<tr>
							<td>Reservation Number</td>
							<td>Departure City</td>
							<td>Arrival City</td>
							<td>Departure Time</td>
							<td>Arrival Time</td>
						</tr>
						<tr>
							<td>111</td>
							<td>Atlanta</td>
							<td>Boston</td>
							<td>5:40:00</td>
							<td>7:40:00</td>
						</tr>
						<tr>
							<td>512</td>
							<td>New York</td>
							<td>London</td>
							<td>3:30:00</td>
							<td>6:00:00</td>
						</tr>
					</table>
				</div>
				<br />
				<!-- --------PAST RESERVATIONS------------ -->
				<div class="reservations">
					<table class="table">
						<tr>
							<td colspan="5" class="header">Previous Flights</td>
						</tr>
						<tr>
							<td>Reservation Number</td>
							<td>Departure City</td>
							<td>Arrival City</td>
							<td>Departure Time</td>
							<td>Arrival Time</td>
						</tr>
						<tr>
							<td>111</td>
							<td>Atlanta</td>
							<td>Boston</td>
							<td>5:40:00</td>
							<td>7:40:00</td>
						</tr>
						<tr>
							<td>512</td>
							<td>New York</td>
							<td>London</td>
							<td>3:30:00</td>
							<td>6:00:00</td>
						</tr>
					</table>
				</div>
			</div>
			
		</div>
  </body>
  
  
</html>