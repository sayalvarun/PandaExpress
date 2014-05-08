<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../styles/searchHandler.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		
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
			
			
				
				document.getElementById('DepartureInfo').value=formInput;
				document.getElementById('hiddenAmount').value=identifier;
				
			}
		</script>
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
				<span id="logo" class="navbar-brand">PandaExpress</span>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../index.php">Book Flight</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Help</a></li>
					<li id="loginButton"><a href="login.php">Login</a></li>
					<li class="dropdown" id="userDropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user">-insert Username here-</span><b class="caret"></b></a>
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
			<h1> Search Results: </h1>
		</div>
		<div class = "orange">
			<div class = "info">
				Results:
				<?php
					if(isset($_POST["auctionSearch"]) and !empty($_POST["auctionSearch"])){
						$searchDest = $_POST["auctionSearch"];
					}
					
					$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					
					$cmd = "SELECT F.Fare
							FROM Fare F, Leg L
							WHERE L.AirlineID = F.AirlineID
							AND L.flightNo = F.flightNo
							AND L.ArrAirportID =  '".$searchDest."' AND F.FareType = 'HIDDEN';";
		
					$params = "Fare";
					$data = mysqli_query($con,$cmd);
					
					while($row = mysqli_fetch_array($data)) 
					{
						$hiddenFare = (int) $row[$params];
					}
					
					$cmd = "SELECT L.AirlineID, L.FlightNo, L.DepAirportID, L.ArrAirportID, L.DepTime, L.ArrTime
							FROM Fare F, Leg L
							WHERE L.AirlineID = F.AirlineID
							AND L.flightNo = F.flightNo
							AND L.ArrAirportID =  '".$searchDest."' AND F.FareType = 'HIDDEN';";
		
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
					
					if(mysqli_num_rows($data) == 0){
						print "<h1>No results found!</h1>";
					}
					else{
						printResults($data, $parameters, $hiddenFare);
					}
					
					
				

				function printResults($data, $parameters,$hiddenFare){
					
					if(count($data)>0){
							Print "<table class = 'phpTable'; border cellpadding=3>";
							foreach($parameters as &$value){					
								Print "<th>".$value.":</th> ";
							}
	
							while($row = mysqli_fetch_array($data)) 
							{
								Print "<tr class = 'resultTableRow'; onclick='myFunction(this,\"".implode(",",$parameters)."\",\"".$hiddenFare."\")'>";
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
				
				
				<form method="post" action="bidChecker.php" class = "flightSearchForm">
					<input id="DepartureInfo" type="text" name="DepartureInfo">
					Bid:<input id="bidAmount" type="text" name="bidAmount">
					<input id="hiddenAmount" type="hidden" name="hiddenAmount">
					<input id = "searchButton" type="submit" value="Bid">
				</form>
			</div>
			
			<?php setUserName(); ?>
	</body>
</html>