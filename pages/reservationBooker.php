<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="../styles/reservationBooker.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
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
				else{
					header("location: login.php");
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
				<a id="logo" class="navbar-brand" href="../index.php">PandaExpress</span>
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
			<h1> Reservation Information </h1>
		</div>
		<div class = "searchAreaBorder">
			<div class = "searchArea">
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
				
				echo "<h2>Heading There</h2>";
				for($i=0; $i<count($paramArray); $i++){ //Confirmation formatting should be done here
					echo $paramArray[$i];
					echo " : ";
					echo $thereInfo[$i];
					print "<br></br>";
				}
				
				print "<br></br>";
				
				
				
				if(count($backInfo)>1){
					echo "<h2>Heading Back</h2>";
					for($i=0; $i<count($paramArray); $i++){ //Confirmation formatting should be done here
						echo $paramArray[$i];
						echo " : ";
						echo $backInfo[$i];
						print "<br></br>";
					}
				}
	
				if(isset($_COOKIE["user"])){
					$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					
					$cmd = "select C.CreditCardNo from customer C, logins L
							where C.id = L.id AND L.username = '".$_COOKIE["user"]."' AND C.CreditCardNo IS NOT NULL;";
					$parameters = "CreditCardNo";
							
					$data = mysqli_query($con,$cmd);
						

					$count = mysqli_num_rows($data);
					if($count == 0){
						print "We don't have your creditCardNo on file, if you wish to continue, please enter it below";
						print "<form method='post' action='addCreditCard.php' class = 'flightSearchForm'>
								<input id='credCard' type='text' name='cardInfo'>
								<input id = 'confirmButton' type='submit' value='Save'>
							   </form>";
					}
					
					
				}
				
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
				
				$cmd = "select max(Id) as maxId from ReservationPassenger;";
				$data = mysqli_query($con,$cmd);
				
				while($row = mysqli_fetch_array($data)) {
					$openId = (int) $row["maxId"];
				}
				
				
				$price = (int) $thereInfo[7];
				if(!empty($backInfo) && $_POST["flightType"]=="Roundtrip"){
					$price2 = $backInfo[7];
				}
				else{
					$price2=0;
				}
				$price = $price + $price2;
				
				//echo $openNumber;
				//echo($thereInfo[0]."', ".$thereInfo[1]);
				$cmd = "INSERT INTO Reservation VALUES (".$openNumber.", NOW(), 100, ".$price.", NULL, ".$accountNo.");";
				$data = mysqli_query($con,$cmd);
				$cmd = "INSERT INTO Includes VALUES (".$openNumber.", '".$thereInfo[0]."', ".$thereInfo[1].", 1, date(NOW()));"; 
				$data = mysqli_query($con,$cmd);
				if(!empty($backInfo) && $_POST["flightType"]=="Roundtrip"){
					$cmd = "INSERT INTO Includes VALUES (".$openNumber.", '".$backInfo[0]."', ".$backInfo[1].", 1, date(NOW()));"; 
					$data = mysqli_query($con,$cmd);
				}
				
				echo "<h2>Reservation successful.</h2>";
				
			
				
				
				//select max(ResrNo) as maxResrNo from reservation;
				/*
				$cmd = "INSERT INTO ReservationPassenger VALUES(".$openNumber.", 2,".$accountNo.", '10B', 'First', 'Steak');";
				$data = mysqli_query($con,$cmd);
				*/
				?>
				
				
				
			</div>
			<?php setUserName(); ?>

	</body>
</html>
