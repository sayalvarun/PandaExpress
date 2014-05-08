<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="../styles/reservationBooker.css">
		<!--<link rel="stylesheet" type="text/css" href="styles/logoutTab.css"> -- TO IMPLEMENT LATER!!!!!!!!!!! --> 
		
		<script type="text/javascript">
			function myFunction(row, identifier){
				
				
			}
		</script>
	</head>

	<body>

		<div id="header">
			<h1> Search Results: </h1>
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
				<?php
				
				
		
				if(isset($_POST["DepartureInfo"])){
					$DepartString = $_POST["DepartureInfo"];
					$thereInfo = explode(",",$DepartString);
				}
				if(isset($_POST["ArrivalInfo"])){
					$ArriveString = $_POST["ArrivalInfo"];
					$backInfo = explode(",",$ArriveString);
				}
				if(isset($_POST["Parameters"])){
					$ParamString = $_POST["Parameters"];
					$paramArray = explode(",",$ParamString);
				}
				
				echo "<h1>Heading There:</h1>";
				for($i=0; $i<count($paramArray); $i++){ //Confirmation formatting should be done here
					echo $paramArray[$i];
					echo " : ";
					echo $thereInfo[$i];
					print "<br></br>";
				}
				
				print "<br></br>";
				
				if(count($backInfo)>0){
					echo "<h1>Heading Back:</h1>";
					for($i=0; $i<count($paramArray); $i++){ //Confirmation formatting should be done here
						echo $paramArray[$i];
						echo " : ";
						echo $backInfo[$i];
						print "<br></br>";
					}
				}
	
				?>
				
				
				
			</div>
		

	</body>
</html>
