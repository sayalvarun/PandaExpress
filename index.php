<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="styles/index.css">
		<link rel="stylesheet" type="text/css" href="styles/login.css">
		<!--<link rel="stylesheet" type="text/css" href="styles/search.css">-->
		<link rel="stylesheet" type="text/css" href="styles/logoutTab.css">
		<link rel="stylesheet" type="text/css" href="styles/profile.css">
		<link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">  
		
		<script src="scripts/js/bootstrap.js"></script>
		<script src="scripts/logoutTab.js"></script>
		<?php
			$con = null;
			$loggedIn = false;
			$user = null;
			$fname = $lname = $addr = $city = $state = $zip = $email = $credit = null;
			$fnameErr = $lnameErr = $addrErr = $cityErr = $stateErr = $zipErr = $emailErr = null;
			if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$user = empty($_POST["uname"]);
				login();
			}
			function connectToDB()
			{
				global $con;
				// Create connection
				$con=mysqli_connect("localhost","root","","pandaexpress");

				// Check connection
				if (mysqli_connect_errno()) {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				
			}
			function login()
			{
				global $con;
				connectToDB();
				$cmd="SELECT * FROM Logins 
					  WHERE username='".$_POST["username"]."' 
					  AND password='".$_POST["password"]."'";
				
				$result=mysqli_query($con,$cmd);
				if(!$result || mysqli_num_rows($result)!=0)
					header("Location:pages/login.php");
			}		
		?>
	</head>

	<body>
		<!--<div class= "topBar">
		</div>
		<br />
		-->
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
			  <a class="navbar-brand" href="#">PandaExpress</a>
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
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">-insert Username here-<b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a onclick="changePage('viewProf', 1)">View Profile</a></li>
					<li class="divider"></li>
					<li><a onclick="changePage('customize', 2)">Customize Profile</a></li>
					<li class="divider"></li>
					<li><a href="index-navbar.html">Log Out</a></li>
					<!--<li class="divider"></li>
					<li><a href="#">One more separated link</a></li>
					-->
				  </ul>
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div id="header">
			<h1 id="companyName"> Panda Express </h1>
			<!--
			<ul class="logoutTab">
				<li id="username">Username <span onclick="clickedUsername();" id="triangle"> &#9660 </span></li>
				<ul id ="tabOps">
					<li><span onclick="changePage('viewProf', 1);">View Profile</span></li>
					<li><span onclick="changePage('customize', 2);">Customize Profile</span></li>
					<li><span onclick="changePage('index', 0);">Home</span></li>
					<li><a href="index.php"><span>Log Out</span></a></li>
				</ul>
			</ul>
			-->
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
<!--INDEX PAGE STUFFS STARTS HERE-->
				<div id = "index">
		<!-- FLIGHT SEARCH BOX -->
					<div class = "searchElements">
						<p>Search for flight:</p>
						<form>
							<input type="radio" name="flightType" value="OneWay">One Way
							<input type="radio" name="flightType" value="Roundtrip">Round Trip
							<input type="radio" name="flightType" value="MultiCity">Multi City
						</form>
						<form class = "flightSearchForm">
							Flying From: <input type="text" name="Departure">
							Flying To: <input type="text" name="Arrival"><br>
						</form>
						<br>
						<p>Departure Date: <input type="date" name="date" id="date" value="" />
						Arrival Date: <input type="date" name="date" id="date" value="" /></p>
						<br>
						Tickets: <input type="number" name="quantity" min="1" max="20" value = "1">
						<br>
						<form action = "pages/flightResult.html">
							<input id = "searchButton" type="submit" value="Search">
						</form>
					</div>
		<!-- LOGIN BOX -->			
					<div id="container">  
						<div id="containerHead"><h3>Login</h3></div>     
						<form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label for="username">Username:</label>
							<input type="text" id="username" name="username">
							<br />
							<label for="password">Password:</label>
							<input type="password" id="password" name="password">
							<div id="lower">
								<input type="checkbox"><label for="checkbox">Keep me logged in</label>
								<input type="submit" value="Login">
								<br />
								<span> Don't have an account? <a href = "pages/registration.php">Sign Up</a></span>
								<br />
							</div><!--/ lower-->
						</form>
					</div>
				</div>
<!-- VIEW PROFILE STARTS HERE -->
				<div id="viewProf">
					<div class = "container">
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
						<br />
					</div>
				</div>
<!-- CUSTOMIZE PROFILE STARTS HERE -->
				<div id ="customize">
					<div class = "container">
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>*First Name <input type="text" name="fname" value="<?php echo $fname; ?>" /></label>
							<br />
							<span class="error"><?php echo $fnameErr; ?></span>
							<br />
							<label>*Last Name <input type="text" name="lname" value="<?php echo $lname; ?>" /></label>
							<br />
							<span class="error"><?php echo $lnameErr; ?></span>
							<br />
							<label>*Address <input type="text" name="addr" value="<?php echo $addr; ?>" /></label>
							<br />
							<span class="error"><?php echo $addrErr; ?></span>
							<br />
							<label>*City <input type="text" name="city" value="<?php echo $city; ?>" /></label>
							<br />
							<span class="error"><?php echo $cityErr; ?></span>
							<br />
							<label>*State <input type="text" name="state" value="<?php echo $state; ?>" /></label>
							<br />
							<span class="error"><?php echo $stateErr;?></span>
							<br />
							<label>*Zip Code <input type="number" name ="zip" value="<?php echo $zip; ?>" min="0" max="99999" /></label>
							<br />
							<span class="error"><?php echo $zipErr;?></span>
							<br />
							<br />
						<!-- FIELDS REQUIRED FOR CUSTOMER TABLE -->	
							<label>Credit Card <input type="number" name="cc" value="<?php echo $credit; ?>" min="0" max="999999999999" /></label>
							<br />
							<label>Email <input type="email" name="email" value="<?php echo $email; ?>" /></label>
							<br />
							<input type="submit" />
						</form>
					</div>
				</div>
			</div>
		</div>
<!--
			<br></br><br></br><br></br><br></br><br></br><br></br>
			<br></br><br></br><br></br><br></br><br></br><br></br>
			<br></br><br></br><br></br><br></br><br></br><br></br>
			<br></br><br></br><br></br><br></br><br></br><br></br>
		
			<div id="navBar">
				<p> This will be the navigation area</p>
			</div>
		-->
		
	</body>
</html>
