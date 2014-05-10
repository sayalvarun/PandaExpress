<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="../styles/searchHandler.css">
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		</script>		
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<script type="text/javascript">
			function setTable(data, dir)
			{
				data = data.split("~");
				for(i = 1; i < data.length; i++)
				{
					cols = data[i].split("|");
					//if(new Date(cols[4])>=new Date())
					//{
						table=document.getElementById("flights");
						row=document.createElement("tr");
						table.appendChild(row);
						
						ele = document.createElement("td");
						row.appendChild(ele);
						
						check = document.createElement("input");
						check.setAttribute("type", "radio");
						check.setAttribute("name", "resr");
						check.setAttribute("value", cols[0]);
						ele.appendChild(check);
						dataStr="";
						for(j = 0; j < cols.length; j++)
						{
							ele=document.createElement("td");
							ele.innerHTML=cols[j];
							row.appendChild(ele);
							dataStr+=cols[j]+",";
						}
					//}
						
						check.setAttribute("onclick", "myFunction(dataStr, '"+dir+"');");
				}
			}
			
			function myFunction(formInput, identifier){		
				if(identifier === "first"){
					document.getElementById('DepartureInfo').value=formInput;
				}
				else if(identifier === "second"){
					document.getElementById('ArrivalInfo').value=formInput;
				}
				document.getElementById('Parameters').value="AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
			}
		</script>
		
		
		<?php
			$con = null;
			$user = null;
			
			if(isset($_POST["Departure"]) and !empty($_POST["Departure"])){
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
			
			
			function startPage()
			{
				global $radioOut;
				connectToDB();
				setUserName();
				if($radioOut == "OneWay")
					oneWayQueries();
				if($radioOut == "RoundTrip")
					roundTripQueries();
				
			}
			
			function connectToDB()
			{
				global $con;
				$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
			}
			
			function oneWayQueries()
			{
				global $con, $Depart, $Arrive, $depDate, $arrDate;
				$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime , FA.Class, FA.Fare
					from Flight F, Leg L, Fare FA
					where L.AirlineID = FA.AirlineID AND L.AirlineID = F.AirlineID AND F.flightNo = FA.flightNo AND L.flightNo = FA.flightNo
					AND L.flightNo = F.FlightNo	AND DepAirportID = '".$Depart."' AND ArrAirportID = '".$Arrive."' AND date(L.DepTime) = '".$depDate."' AND date(L.ArrTime) = '".$arrDate."' AND FareType != 'Hidden';";
	
				$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
				$parameters = explode(",",$params);
				$data = mysqli_query($con,$cmd);
				$identifier = "first";
				
				printResults($data, $parameters, $identifier);
			}
			
			function roundTripQueries()
			{
				global $con, $Depart, $Arrive, $depDate, $arrDate;
				$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime , FA.Class, FA.Fare
					from Flight F, Leg L , Fare FA
					where L.AirlineID = FA.AirlineID AND L.AirlineID = F.AirlineID AND F.flightNo = FA.flightNo AND L.flightNo = FA.flightNo
					AND L.flightNo = F.FlightNo AND DepAirportID = '".$Depart."' AND date(L.DepTime) = '".$depDate."' AND FareType != 'Hidden';";
				
				$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
				$parameters = explode(",",$params);
				$data = mysqli_query($con,$cmd);
				
				$identifier = "first";
				printResults($data, $parameters, $identifier);
				echo $arrDate;
				
				$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime, FA.Class, FA.Fare 
					from Flight F, Leg L , Fare FA
					where L.AirlineID = FA.AirlineID AND L.AirlineID = F.AirlineID AND F.flightNo = FA.flightNo AND L.flightNo = FA.flightNo
					AND L.flightNo = F.FlightNo AND ArrAirportID = '".$Depart."';";
					 
				$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
				$parameters = explode(",",$params);
				$data = mysqli_query($con,$cmd);

				
				echo"<br><br>";
				
				$identifier = "second";
				printResults($data, $parameters, $identifier);
			}

			//Breaks it: AND date(L.ArrTime) = '".$arrDate.

			function printResults($data, $parameters,$identifier)
			{
				if(count($data)>0){
					$dataStr="";
					while($row = mysqli_fetch_array($data)) 
					{
						//Print "<tr class = 'resultTableRow' onclick='myFunction(this,\"".implode(",",$parameters)."\",\"".$identifier."\")'>";
						$dataStr .= "~".$row["AirlineID"]."|".$row["FlightNo"]."|".$row["DepAirportID"]."|".$row["ArrAirportID"]."|".$row["DepTime"]."|".$row["ArrTime"]."|".$row["Class"]."|".$row["Fare"];
						
						echo("<script type='text/javascript'>
								setTable('".$dataStr."', '".$identifier."');
							  </script>");
					}	
				}
				else{
					echo "Empty result";
				}
			}
			function setUserName()
			{
				global $user;
				if(isset($_COOKIE["user"]))
				{
					$user = $_COOKIE["user"];
					resetPage();
				}	
			}
			function resetPage()
			{
				global $user;
				echo("<script type='text/javascript'>
						resetPage('".$user."');
					  </script>");
			}
			
		?>
	</head>

	<body>
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="logo" class="navbar-brand" href="../index.php">PandaExpress</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="search.php">Book Flight</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="help.php">Help</a></li>
					<li id="loginButton"><a href="login.php">Login</a></li>
					<li class="dropdown" id="userDropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span id="user">-insert Username here-</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="viewProfile.php">View Profile</a></li>
							<li class="divider"></li>
							<li><a href="customizeProfile.php">Customize Profile</a></li>
							<li class="divider"></li>
							<li><a href="auctions.php">Auctions</a></li>
							<li class="divider"></li>
							<li><a href="cancelReservation.php">Cancel Reservation</a></li>
							<li class="divider"></li>
							<li><a href="managerial.php">Manage</a></li>
							<li class="divider"></li>
							<li><a href="../scripts/logout.php">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div id="header">
			<h1 id="companyName"> Search Flights </h1>
		</div>
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<?php echo "<h2>".$radioOut."</h2>";?>
				<table id="flights" class="table">
					<tr>
						<td class='header' colspan=9>Flights</td>
					</tr>
					<tr>
						<td>Select</td>
						<td>AirlineID</td>
						<td>FlightNo</td>
						<td>DepAirportID</td>
						<td>ArrAirportID</td>
						<td>DepTime</td>
						<td>ArrTime</td>
						<td>Class</td>
						<td>Fare</td>
					</tr>
				</table>
				<form method="post" action="reservationBooker.php" class = "flightSearchForm">
					<input id="DepartureInfo" type="hidden" name="DepartureInfo">
					<input id="ArrivalInfo" type="hidden" name="ArrivalInfo">
					<input id="Parameters" type="hidden" name="Parameters">
					<input type="hidden" name="flightType" value="<?php echo($_POST["flightType"]); ?>" />
					<input id = "searchButton" type="submit" value="Book">
				</form>
			</div>
		<?php
			startPage();
		?>

	</body>
</html>
