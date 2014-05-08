<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="styles/searchHandler.css">
		
		
		<link rel="stylesheet" type="text/css" href="styles/profile.css">
		<link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="scripts/js/bootstrap.js"></script>
		<script src="scripts/logoutTab.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/logoutTab.css">
		
	
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
				<span id="logo" class="navbar-brand" onclick="changePage('index', 0);">PandaExpress</span>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#">Book Flight</a></li>
					<!--<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
				-->
				</ul>
				<!--<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				-->
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Help</a></li>
					<li id="loginButton"><a href="login.php">Login</a></li>
					<li class="dropdown" id="userDropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user">-insert Username here-</span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a id="viewTab" onclick="changePage('viewProf', 1)">View Profile</a></li>
							<li class="divider"></li>
							<li><a id="customizeTab" onclick="changePage('customize', 2)">Customize Profile</a></li>
							<li class="divider"></li>
							<li><a href="pages/auctions.html">Auctions</a></li>
							<li class="divider"></li>
							<li><a href="index.html">Log Out</a></li>
							<!--<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
							-->
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<?php
		$con = null;
			$user = null;
			
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
		</div>
		<div class = "orange">
			<div class = "info">
				Results:
				<?php
		
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
				
	
				$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
				if (mysqli_connect_errno()) {
			  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				
				echo "<h1>".$radioOut."</h1>";
	
				if($radioOut == "OneWay"){
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime , FA.Class, FA.Fare
						from Flight F, Leg L, Fare FA
						where L.AirlineID = FA.AirlineID AND L.AirlineID = F.AirlineID AND F.flightNo = FA.flightNo AND L.flightNo = FA.flightNo
						AND L.flightNo = F.FlightNo	AND DepAirportID = '".$Depart."' AND ArrAirportID = '".$Arrive."' AND date(L.DepTime) = '".$depDate."' AND date(L.ArrTime) = '"
						.$arrDate."';";
		
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
					$identifier = "first";
					
					printResults($data, $parameters, $identifier);
				}
				else if($radioOut == "Roundtrip"){
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime , FA.Class, FA.Fare
						from Flight F, Leg L , Fare FA
						where L.AirlineID = FA.AirlineID AND L.AirlineID = F.AirlineID AND F.flightNo = FA.flightNo AND L.flightNo = FA.flightNo
						AND L.flightNo = F.FlightNo AND DepAirportID = '".$Depart."'
						 AND date(L.DepTime) = '".$depDate."';";
					
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime,Class,Fare";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
					
					$identifier = "first";
					printResults($data, $parameters, $identifier);
					echo $arrDate;
					
					$cmd = "select F.AirlineID, F.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime, FA.Class, Fa.Fare 
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
