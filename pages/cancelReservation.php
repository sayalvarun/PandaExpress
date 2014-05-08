<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css"> 
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<script type="text/javascript">			
			function setTables(data)
			{
				data = data.split("~");
				for(i = 1; i < data.length; i++)
				{
					cols = data[i].split("|");
					//if(new Date(cols[4])>=new Date())
					//{
						table=document.getElementById("currResr");
						row=document.createElement("tr");
						table.appendChild(row);
						
						ele = document.createElement("td");
						row.appendChild(ele);
						
						check = document.createElement("input");
						check.setAttribute("type", "checkbox");
						check.setAttribute("name", "resrs[]");
						check.setAttribute("value", cols[0]);
						ele.appendChild(check);
						for(j = 0; j < cols.length; j++)
						{
							ele=document.createElement("td");
							ele.innerHTML=cols[j];
							row.appendChild(ele);
						}
					//}
				}
			}
		</script>
		<?php
			$con = null;
			$user = $id = $accNo= null;
			function startPage()
			{
				connectToDB();
				setUserName();
				setID();
				setAccNo();
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					if(!empty($_POST["resrs"]))
					{
						foreach($_POST["resrs"] as $resr) {
							deleteRes($resr);
						}
					}
					header("Location:cancelReservation.php");
				}
				else
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
					header("location: login.php");
			}
			
			function resetPage()
			{
				global $user;
				echo("<script type='text/javascript'>
						resetPage('".$user."');
					  </script>");
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
				echo($dataStr);
				echo("<script type='text/javascript'>
						setTables('".$dataStr."');
					  </script>");
			}
			
			function deleteRes($res)
			{
				global $con;
				$query = "DELETE FROM Includes WHERE ResrNo = ".$res.";";
				mysqli_query($con, $query);
				
				$query = "DELETE FROM ReservationPassenger WHERE ResrNo = ".$res.";";
				mysqli_query($con, $query);
				
				$query = "DELETE FROM Reservation WHERE ResrNo = ".$res.";";
				mysqli_query($con, $query);
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
					<li><a href="../index.php">Book Flight</a></li>
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
							<li><a href="viewProfile.php">View Profile</a></li>
							<li class="divider"></li>
							<li><a href="customizeProfile.php">Customize Profile</a></li>
							<li class="divider"></li>
							<li><a href="auctions.html">Auctions</a></li>
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
			<h1 id="companyName">Search Flights</h1>
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<div class="reservations">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<table class="table" id = "currResr">
							<tr>
								<td colspan="9" class="header">Current Reservations</td>
							</tr>
							<tr>
								<td>Delete</td>
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
						<input type="submit" value="delete" />
					</form>
				</div>
			</div>
		</div>
		<?php 
			startPage();
			//setUsername();
		?>
	</body>
</html>
