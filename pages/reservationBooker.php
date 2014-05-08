<html>
	<head>
		<title>Panda Express!</title>
		<link rel="stylesheet" type="text/css" href="../styles/reservationBooker.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		
	
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
							<li><a href="../index.html">Log Out</a></li>
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
			
			
			global $user;
			if(isset($_COOKIE["user"]))
			{
				$user = $_COOKIE["user"];
				resetPage();
			}
			else{
				header("location: login.php");
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
		<div id="header">
			<h1> Search Results: </h1>
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
				
				
				
				if(count($backInfo)>1){
					echo "<h1>Heading Back:</h1>";
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
				if(!empty($backInfo)){
					$price2 = $backInfo[7];
				}
				else{
					$price2=0;
				}
				$price = $price + $price2;
				
				echo $openNumber;
				echo($thereInfo[0]."', ".$thereInfo[1]);
				$cmd = "INSERT INTO Reservation VALUES (".$openNumber.", NOW(), 100, ".$price.", NULL, ".$accountNo.");";
				$data = mysqli_query($con,$cmd);
				$cmd = "INSERT INTO Includes VALUES (".$openNumber.", '".$thereInfo[0]."', ".$thereInfo[1].", 1, date(NOW()));"; 
				$data = mysqli_query($con,$cmd);
				if(!empty($backInfo)){
					$cmd = "INSERT INTO Includes VALUES (".$openNumber.", '".$backInfo[0]."', ".$backInfo[1].", 1, date(NOW()));"; 
					$data = mysqli_query($con,$cmd);
				}
				
				echo "<h1>reservation successful!</h1>";
				
			
				
				
				//select max(ResrNo) as maxResrNo from reservation;
				/*
				$cmd = "INSERT INTO ReservationPassenger VALUES(".$openNumber.", 2,".$accountNo.", '10B', 'First', 'Steak');";
				$data = mysqli_query($con,$cmd);
				*/
				?>
				
				
				
			</div>
			

	</body>
</html>
