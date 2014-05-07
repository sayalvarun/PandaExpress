<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="styles/index.css">
		<link rel="stylesheet" type="text/css" href="styles/login.css">
		<!--<link rel="stylesheet" type="text/css" href="styles/search.css">-->
		<!--<link rel="stylesheet" type="text/css" href="styles/logoutTab.css">-->
		<link rel="stylesheet" type="text/css" href="styles/profile.css">
		<link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="scripts/js/bootstrap.js"></script>
		<script src="scripts/logoutTab.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#customizeTab").click(function(){
					$.post("scripts/customizeQueries.php",
					{
						username:document.getElementById("user").innerHTML,
					},
					function(data,status){
						alert("Status: "+status); 
						//for(i = 0; i < data.length; i++);
							alert("Data: " + data);
					});
				});
			});
		</script>
		<?php
			$con = null;
			$loggedIn = false;
			$user = null;
			$prevPage = "Home";
			$fname = $lname = $addr = $city = $state = $zip = $email = $credit = null;
			$fnameErr = $lnameErr = $addrErr = $cityErr = $stateErr = $zipErr = $emailErr = null;
			
			function startPage()
			{
				global $user, $prevPage;
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					$prevPage = $_POST["page"];
					if($prevPage == "login")
						login();
				}
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
				global $con, $user;
				if(empty($_POST["username"]) || empty($_POST["password"]))
					header("Location:pages/login.php");
				else
				{
					connectToDB();
					$cmd="SELECT * FROM Logins 
						  WHERE username='".$_POST["username"]."' 
						  AND password='".$_POST["password"]."'";
					
					$result=mysqli_query($con,$cmd);
					if(!$result || mysqli_num_rows($result)!=1)
						header("Location:pages/login.php");
					else
					$user = $_POST["username"];
						echo("<script type='text/javascript'>
							    document.getElementById('loginButton').style.display='none';
								document.getElementById('userDropdown').style.display='inline';
								document.getElementById('user').innerHTML=\"".$user."\";
								document.getElementById('login').style.visibility='hidden';
							  </script>");
				}
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
					<li id="loginButton"><a href="pages/login.php">Login</a></li>
					<li class="dropdown" id="userDropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user">-insert Username here-</span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a onclick="changePage('viewProf', 1)">View Profile</a></li>
							<li class="divider"></li>
							<li><a id="customizeTab" onclick="changePage('customize', 2)">Customize Profile</a></li>
							<li class="divider"></li>
							<li><a href="index.php">Log Out</a></li>
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
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
<!--INDEX PAGE STUFFS STARTS HERE-->
				<div id = "index">
		<!-- FLIGHT SEARCH BOX -->
					<div class = "searchElements">
						<p>Search for flight:</p>
						<form method="post" action="searchHandler.php" class = "flightSearchForm">
							<input type="radio" name="flightType" value="OneWay">One Way
							<input type="radio" name="flightType" value="Roundtrip">Round Trip
							<input type="radio" name="flightType" value="MultiCity">Multi City
						</br>					
						<br></br>
						Flying From: <input type="text" name="Departure">
						Flying To: <input type="text" name="Arrival"><br>
						<br></br>
						Departure Date: <input type="date" name="depDate" id="date" value="" />
						Arrival Date: <input type="date" name="arrDate" id="date" value="" />
						<br></br>
						Tickets: <input type="number" name="quantity" min="1" max="20" value = "1">
						<br></br>
						
						<input id = "searchButton" type="submit" value="Search">
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
							<label>First Name <input type="text" name="fname" value="<?php echo $fname; ?>" /></label>
							<br />
							<span class="error"><?php echo $fnameErr; ?></span>
							<br />
							<label>Last Name <input type="text" name="lname" value="<?php echo $lname; ?>" /></label>
							<br />
							<span class="error"><?php echo $lnameErr; ?></span>
							<br />
							<label>Address <input type="text" name="addr" value="<?php echo $addr; ?>" /></label>
							<br />
							<span class="error"><?php echo $addrErr; ?></span>
							<br />
							<label>City <input type="text" name="city" value="<?php echo $city; ?>" /></label>
							<br />
							<span class="error"><?php echo $cityErr; ?></span>
							<br />
							<label>State <input type="text" name="state" value="<?php echo $state; ?>" /></label>
							<br />
							<span class="error"><?php echo $stateErr;?></span>
							<br />
							<label>Zip Code <input type="number" name ="zip" value="<?php echo $zip; ?>" min="0" max="99999" /></label>
							<br />
							<span class="error"><?php echo $zipErr; ?></span>
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
		<?php startPage(); ?>
	</body>
</html>
