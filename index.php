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
				$("#viewTab").click(function(){
					$.post("scripts/UserInfoQueries.php",
					{
						username:document.getElementById("user").innerHTML,
					},
					function(data,status){
						data = data.split("~");
						
						document.getElementById("vName").innerHTML=data[0]+" "+data[1];
						document.getElementById("vAddr").innerHTML=data[2];
						document.getElementById("vCity").innerHTML=data[3];
						document.getElementById("vState").innerHTML=data[4];
						document.getElementById("vZip").innerHTML=data[5];
						document.getElementById("vCC").innerHTML=data[6];
						document.getElementById("vEmail").innerHTML=data[7];
					});
					
					$.post("scripts/UserResrvQueries.php",
					{
						username:document.getElementById("user").innerHTML
					},
					function(data,status){
						data = data.split("~");
						for(i = 0; i < data.length; i++)
						{
							cols = data[i].split("|");
							if(new Date(cols[4])>=new Date())
								table=document.getElementById("currResr");
							else
								table=document.getElementById("pastResr");
							row=document.createElement("tr");
							table.appendChild(row);
							for(j = 0; j < cols.length; j++)
							{
								ele=document.createElement("td");
								ele.innerHTML=cols[j];
								row.appendChild(ele);
							}
						}
					});
				});
			});
		</script>
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
					<li><a onclick="changePage('index', 0);">Book Flight</a></li>
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
							<li><a id="viewTab" onclick="changePage('viewProf', 1)">View Profile</a></li>
							<li class="divider"></li>
							<li><!--<a id="customizeTab" onclick="changePage('customize', 2)">-->
								<a href="pages/customizeProfile.php">Customize Profile</a></li>
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
		<div id="header">
			<h1 id="companyName">Search Flights</h1>
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
							<input type="radio" name="flightType" value="OneWay" checked>One Way
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
						<p> Name: <span id="vName">armpit invader</span></p>
						<p> Address: <span id="vAddr">1234 Main Street</span>
							<div id="addr">
								<span id = "vCity"> idontcare</span>,
								<span id = "vState"> ny </span>	
								<span id = "vZip">54321</span> 
							</div>
						</p>
						<p> Email: <span id="vEmail">bopit@gmail.com</span></p>
						<p> Credit Card: <span id="vCC">123456789100</span></p>
						<!-- ---------CURRENT RESERVATION----------- -->
						<div class="reservations">
							<table class="table" id="currResr">
								<tr>
									<td colspan="8" class="header">Current Reservations</td>
								</tr>
								<tr>
									<td>Reservation Number</td>
									<td>Airline</td>
									<td>Flight Number</td>
									<td>Departure Airport</td>
									<td>Departure Time</td>
									<td>Arrival Airport</td>
									<td>Arrival Time</td>
									<td>Price</td>
								</tr>
							</table>
						</div>
						<br />
						<!-- --------PAST RESERVATIONS------------ -->
						<div class="reservations">
							<table class="table" id="pastResr">
								<tr>
									<td colspan="8" class="header">Previous Flights</td>
								</tr>
								<tr>
									<td>Reservation Number</td>
									<td>Airline</td>
									<td>Flight Number</td>
									<td>Departure Airport</td>
									<td>Departure Time</td>
									<td>Arrival Airport</td>
									<td>Arrival Time</td>
									<td>Price</td>
								</tr>
							</table>
						</div>
						<br />
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
		<?php 
			//startPage();
			setUsername();
		?>
	</body>
</html>
