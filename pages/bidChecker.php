<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../styles/searchHandler.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		
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
			<h1> Auction </h1>
		</div>
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<?php
					if(isset($_POST["bidAmount"]) and !empty($_POST["bidAmount"])){
						$bidAmount = $_POST["bidAmount"];
					}
					if(isset($_POST["hiddenAmount"]) and !empty($_POST["hiddenAmount"])){
						$hiddenAmount = $_POST["hiddenAmount"];
					}
					if(isset($_POST["DepartureInfo"]) and !empty($_POST["DepartureInfo"])){
						$departureInfo = $_POST["DepartureInfo"];
					}
					if(isset($_COOKIE["user"]) and !empty($_COOKIE["user"])){
						$username = $_COOKIE["user"];
					}
					
					
					if((int) $hiddenAmount < (int) $bidAmount){
						echo "Your flight has been reserved.";
						$departureArray = explode(",", $departureInfo);
						
						$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
						if (mysqli_connect_errno()) {
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}
						
						$cmd = "select max(ResrNo) as maxResrNo from reservation;";
							
						$data = mysqli_query($con,$cmd);
					
						while($row = mysqli_fetch_array($data)) {
							$openNumber = (int) $row["maxResrNo"] + 1;
						}
						
						$cmd = "select C.AccountNo from customer C, logins L
								where C.id = L.id AND L.username = '".$_COOKIE["user"]."';";
				
								$data = mysqli_query($con,$cmd);
		
								while($row = mysqli_fetch_array($data)) {
									$accountNo = (int) $row["AccountNo"];
						}
						
						$cmd = "INSERT INTO Reservation VALUES (".$openNumber.", NOW(), 100, ".$bidAmount.", NULL, ".$accountNo.");";
						$data = mysqli_query($con,$cmd);
						$cmd = "INSERT INTO Includes VALUES (".$openNumber.", '".$departureArray[0]."', ".$departureArray[1].", 1, date(NOW()));"; 
						$data = mysqli_query($con,$cmd);
						$cmd = "INSERT INTO Auctions values (".$accountNo.", '".$departureArray[0]."', '".$departureArray[1]."' , 'Economy' , date((NOW())),".$bidAmount.", '1');";
						$data = mysqli_query($con,$cmd);
					}
					else{
						echo "Bidding Failed : Insufficient funds.";
						//header('Location: auctions.php');
					}
					
					
					
					$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					
					$cmd = "select ";
		
					$params = "AirlineID,FlightNo,DepAirportID,ArrAirportID,DepTime,ArrTime";
					$parameters = explode(",",$params);
					$data = mysqli_query($con,$cmd);
				?>
			</div>
		<?php setUserName(); ?>
	</body>	
</html>