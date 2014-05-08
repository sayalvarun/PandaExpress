<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="styles/searchHandler.css">
		<link rel="stylesheet" type="text/css" href="styles/logoutTab.css">
		
		<script type="text/javascript">
			function myFunction(row, parameters, identifier){
				var formInput = '';
				
				for(i=0; i<row.cells.length; i++){
					formInput = formInput + row.cells[i].innerHTML + ",";
				}
			
			
				if(identifier === "first"){
					document.getElementById('DepartureInfo').value=formInput;
				}
				else if(identifier === "second"){
					document.getElementById('ArrivalInfo').value=formInput;
				}
				document.getElementById('Parameters').value=parameters;
				
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
				Results:
				<?php
		
				if(isset($_POST["Departure"])){
					$Depart = $_POST["Departure"];
				}
				if(isset($_POST["Arrival"])){
					$Arrive = $_POST["Arrival"];
				}
				if(isset($_POST["depDate"])){
					$depDate = $_POST["depDate"];
				}
				if(isset($_POST["arrDate"])){
					$arrDate =  $_POST["arrDate"];
				}
				if(isset($_POST["quantity"])){
					$tickets = $_POST["quantity"];
				}
				if(isset($_POST["flightType"])){
					$radioOut = $_POST["flightType"];
				}
				$depDay = date('l', strtotime( $depDate));
			
	
				$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
				if (mysqli_connect_errno()) {
			  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				
				echo $radioOut;
	
				if($radioOut == "OneWay"){
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime 
						from Flight F, Leg L 
						where F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo AND DepAirportID = '".$Depart."'
						AND ArrAirportID = '".$Arrive."' AND date(L.DepTime) = '".$depDate."' AND date(L.ArrTime) = '".$arrDate."';";
		
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
					$identifier = "first";
					
					printResults($data, $parameters, $identifier);
				}
	
				if($radioOut == "Roundtrip"){
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime 
						from Flight F, Leg L 
						where F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo AND DepAirportID = '".$Depart."'
						 AND date(L.DepTime) = '".$depDate."';";
					
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
					
					$identifier = "first";
					printResults($data, $parameters, $identifier);
					
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime 
						from Flight F, Leg L 
						where F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo AND ArrAirportID = '".$Depart."'
						 AND date(L.ArrTime) = '".$depDate."';";
						 
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);

					
					echo"<br><br>";
					
					$identifier = "second";
					printResults($data, $parameters, $identifier);
				}

	
	
				function printResults($data, $parameters,$identifier){
					
					if(count($data)>0){
							Print "<table class = 'phpTable'; border cellpadding=3>";
							foreach($parameters as &$value){					
								Print "<th>".$value.":</th> ";
							}
	
							while($row = mysqli_fetch_array($data)) 
							{
								Print "<tr class = 'resultTableRow'; onclick='myFunction(this,\"".implode(",",$parameters)."\",\"".$identifier."\")'>";
								//echo $row['Id'] . " " . $row['Name'];
								//echo "<br>";
								foreach($parameters as &$value){					
								Print "<td>".$row[$value] . "</td> ";
								}	
								Print "<tr>";
							}	
							Print "</table>";
					}
					else{
						echo "Empty result";
					}
				}	
				?>
				
				
				<form method="post" action="pages/reservationBooker.php" class = "flightSearchForm">
					<input id="DepartureInfo" type="hidden" name="DepartureInfo">
					<input id="ArrivalInfo" type="hidden" name="ArrivalInfo">
					<input id="Parameters" type="hidden" name="Parameters">
					<input id = "searchButton" type="submit" value="Book">
				</form>
			</div>
		

	</body>
</html>
