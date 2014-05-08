<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/login.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<script type="text/javascript">
			function setInfos(data){
				data = data.split("~");
				
				document.getElementById("vName").innerHTML=data[0]+" "+data[1];
				document.getElementById("vAddr").innerHTML=data[2];
				document.getElementById("vCity").innerHTML=data[3];
				document.getElementById("vState").innerHTML=data[4];
				document.getElementById("vZip").innerHTML=data[5];
				document.getElementById("vCC").innerHTML=data[6];
				document.getElementById("vEmail").innerHTML=data[7];
			}
			
			function setTables(data)
			{
				data = data.split("~");
				for(i = 1; i < data.length; i++)
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
			}
		</script>
		<?php
			$con = null;
			$user = $id = $accNo = null;
			function startPage()
			{
				connectToDB();
				setUserName();
				setID();
				setAccNo();
				getInfoFields();
				getResvInfos();
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
			
			function setUserName()
			{
				global $user;
				if(isset($_COOKIE["user"]))
				{
					$user = $_COOKIE["user"];
					resetPage();
				}
				else
					header("location:login.php");
			}
			
			function setID()
			{
				global $con, $id, $user;
				$query = "select id from logins where username = '".$user."';";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$id = $row['id'];
			}
			
			function setAccNo()
			{
				global $con, $id, $accNo;
				$query = "select accountno from customer where id=".$id.";";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$accNo = $row['accountno'];
			}
			
			function getResvInfos()
			{
				global $accNo, $con;
				$query = "SELECT resrno, airlineid, flightno, depairportid, deptime, arrairportid, arrtime, totalfare
							FROM reservation
								NATURAL JOIN includes
								NATURAL JOIN leg
							where accountno=".$accNo."
							order by deptime;";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['resrno']."|".$row['airlineid']."|".$row['flightno']."|".$row['depairportid']."|".$row['deptime']."|".$row['arrairportid']."|".$row['arrtime']."|".$row['totalfare'];
				}
				echo("<script type='text/javascript'>
						setTables('".$dataStr."');
					  </script>");
			}
			
			function getInfoFields()
			{
				global $id, $con;
				//gets all data from person table
				$query = "select * from person where id=".$id.";";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$fname = $row['FirstName'];
				$lname = $row['LastName'];
				$addr = $row['Address'];
				$city = $row['City'];
				$state = $row['State'];
				$zip = $row['ZipCode'];
				$dataString = $fname."~".$lname."~".$addr."~".$city."~".$state."~".$zip;
				
				//gets all data from customer table
				$query = "select * from customer where id=".$id.";";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$cc = $row['CreditCardNo'];
				$email = $row['Email'];
				$rating = $row['Rating'];
				$dataString .= "~".$cc."~".$email."~".$rating;
				
				echo("<script type='text/javascript'>
						setInfos(\"".$dataString."\");
					  </script>");
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
			<h1 id="companyName">View Profile</h1>
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<div>
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
		<?php 
			startPage();
		?>
	</body>
</html>
