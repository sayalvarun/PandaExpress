<html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		<style type="text/css">
			table{display:none;}
			form{display:none;}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<script type="text/javascript">

			function setTable(data, tName)
			{
				data = data.split("~");
				for(i = 1; i < data.length; i++)
				{
					cols = data[i].split("|");
					table=document.getElementById(tName);
					row=document.createElement("tr");
					table.appendChild(row);
					for(j = 0; j < cols.length; j++)
					{
						ele=document.createElement("td");
						ele.innerHTML=cols[j];
						row.appendChild(ele);
					}
				}
				viewTable(tName);
			}

			prevTable = "";
			function viewTable(table)
			{
				document.getElementById(table).style.display="inline";
				if(prevTable != "")
					document.getElementById(prevTable).style.display="none";
				prevTable = table;
			}
			
			function viewForm(id)
			{
				document.getElementById(id).style.display="block";
			}
		</script>
		<?php
			$con = null;
			$user = null;
			$formData = null;
			$table = null;
			function startPage()
			{
				global $table, $formData;
				connectToDB();
				setUserName();
				
				$table = "flLate";
				getLateFlights();
				$table = "flOT";
				getOnTimeFlights();
				$table = "activeFl";
				getMostActiveFlights();
				$table = "tRevCust";
				getCustWithMostRevenue();
				$table = "revCR";
				getRevenueFromCustRep();
				$table = "flights";
				getFlightsList();
				$table = "sales";
				getSalesReport();
				
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					$table = $_POST["table"];
					if($table == "resrCust")
					{
						$formData = array("first"=>$_POST['cFirst'],"last"=>$_POST['cLast']);
						getResvFromCustomer();
					}
					if($table == 'resrFlights')
					{
						$formData = array("airID"=>$_POST['airID'],"flightNo"=>$_POST['flightNo']);
						getResvFromFlights();
					}
					if($table == 'revFl')
					{
						$formData = array("airID"=>$_POST['airID'],"flightNo"=>$_POST['flightNo']);
						getRevenueFromFlight();
					}
					if($table == 'revCity')
					{
						$formData = array("city"=>$_POST['city']);
						getRevenueFromCity();
					}
					if($table == 'revCust')
					{
						$formData = array("accNo"=>$_POST['accNo']);
						getRevenueFromCustomer();
					}
					if($table == 'custSeats')
					{
						$formData = array("airID"=>$_POST['airID'],"flightNo"=>$_POST['flightNo']);
						getCustomersOnFlight();
					}
					if($table == 'flAir')
					{
						$formData = array("airport"=>$_POST['airport']);
						getFlightsAtAirport();
					}
					//if($table == "sales")
					//	getSalesReport();
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
					header("Location:login.php");
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
			
			function resetPage()
			{
				global $user;
				echo("<script type='text/javascript'>
						resetPage('".$user."');
					  </script>");
			}
			
			function getSalesReport()
			{
				global $con;
				/*$query = "SELECT R.ResrNo, R.ResrDate, R.TotalFare, R.BookingFee, R.RepSSN, P.FirstName, P.LastName
							FROM Reservation R, Customer C, Person P
							WHERE R.ResrDate > '2010-12-31' AND R.ResrDate < '2011-02-01'
								AND R.AccountNo = C.AccountNo AND C.Id = P.Id
							ORDER BY R.ResrDate;";
				*/
				$query = "SELECT R.ResrNo, R.ResrDate, R.TotalFare, R.BookingFee, R.RepSSN, P.FirstName, P.LastName
							FROM Reservation R, Customer C, Person P
							WHERE R.AccountNo = C.AccountNo AND C.Id = P.Id
							ORDER BY R.ResrDate;";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|".$row['ResrDate']."|$".$row['TotalFare']."|$".$row['BookingFee']."|".$row['RepSSN']."|".$row['FirstName']." ".$row['LastName'];
				}
				showTable($dataStr);
			}
			
			function getFlightsList()
			{
				global $con;
				$query = "SELECT * FROM flight";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AirlineID']."|".$row['FlightNo']."|".$row['NoOfSeats']."|".$row['DaysOperating']."|".$row['MinLengthOfStay']."|".$row['MaxLengthOfStay'];
				}
				showTable($dataStr);
			}
			
			function getResvFromFlights()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT R.ResrNo, R.ResrDate, R.TotalFare, R.BookingFee, R.RepSSN, P.FirstName, P.LastName
							FROM Reservation R, Customer C, Person P, Includes I
							WHERE R.AccountNo = C.AccountNo AND C.Id = P.Id
							AND I.ResrNo = R.ResrNo AND I.AirlineID = '".$formData['airID']."' AND I.FlightNo = ".$formData['flightNo'].";";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|".$row['ResrDate']."|$".$row['TotalFare']."|$".$row['BookingFee']."|".$row['RepSSN']."|".$row['FirstName']." ".$row['LastName'];
				}
				showTable($dataStr);
			}
			
			function getResvFromCustomer()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT R.ResrNo, R.ResrDate, R.TotalFare, R.BookingFee, R.RepSSN, P.FirstName, P.LastName
							FROM Reservation R, Customer C, Person P
							WHERE R.AccountNo = C.AccountNo AND C.Id = P.Id
							AND P.FirstName = '".$formData['first']."' AND P.LastName = '".$formData['last']."';";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|".$row['ResrDate']."|$".$row['TotalFare']."|$".$row['BookingFee']."|".$row['RepSSN']."|".$row['FirstName']." ".$row['LastName'];
				}
				showTable($dataStr);
			}
			
			function getRevenueFromFlight()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT R.ResrNo, R.TotalFare * 0.1 AS Revenue
							FROM Reservation R, Includes I 
							WHERE I.ResrNo = R.ResrNo 
							AND I.AirlineID = '".$formData['airID']."' AND I.FlightNo = '".$formData['flightNo']."';";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|$".$row['Revenue'];
				}
				showTable($dataStr);
			}
			
			function getRevenueFromCity()
			{
				global $con, $formData;
				$query = "CREATE VIEW ResrFlightLastLeg(ResrNo, AirlineID, FlightNo, LegNo)
							AS
							SELECT I.ResrNo, I.AirlineID, I.FlightNo, MAX(I.LegNo)
							FROM Includes I
							GROUP BY I.ResrNo, I.AirlineID, I.FlightNo;";
				$result = mysqli_query($con, $query);
				
				$query = "SELECT DISTINCT R.ResrNo, R.TotalFare * 0.1 AS Revenue
							FROM Reservation R, Leg L, ResrFlightLastLeg LL, Airport A
							WHERE L.FlightNo = LL.FlightNo AND L.LegNo = LL.LegNo
							AND L.ArrAirportID = A.ID AND A.City = '".$formData['city']."';";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|$".$row['Revenue'];
				}
				showTable($dataStr);
			}
			
			function getRevenueFromCustomer()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT R.ResrNo, R.TotalFare * 0.1 AS Revenue
							FROM Reservation R
							WHERE R.AccountNo = ".$formData['accNo'].";";
				$result = mysqli_query($con, $query);
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['ResrNo']."|$".$row['Revenue'];
				}
				showTable($dataStr);
			}
			
			function getRevenueFromCustRep()
			{
				global $con;
				$query = "CREATE VIEW CRRevenue(SSN, TotalRevenue)
							AS
							SELECT RepSSN, SUM(TotalFare * 0.1)
							FROM Reservation
							GROUP BY RepSSN;";
				$result = mysqli_query($con, $query);
				
				$query = "SELECT SSN FROM CRRevenue
							WHERE TotalRevenue >= (SELECT MAX(TotalRevenue) FROM CRRevenue);";
				$result = mysqli_query($con, $query);
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['SSN'];
				}
				showTable($dataStr);
			}
			
			function getCustWithMostRevenue()
			{
				global $con;
				$query = "CREATE VIEW CustomerRevenue(AccountNo, TotalRevenue)
							AS
							SELECT AccountNo, SUM(TotalFare * 0.1)
							FROM Reservation
							GROUP BY AccountNo;";
				$result = mysqli_query($con, $query);
				
				$query = "SELECT CR.AccountNo, P.FirstName, P.LastName
							FROM CustomerRevenue CR, Customer C, Person P
							WHERE CR.AccountNo = C.AccountNo AND C.Id = P.Id
							AND CR.TotalRevenue >= (SELECT MAX(TotalRevenue) FROM CustomerRevenue);";
				$result = mysqli_query($con, $query);
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AccountNo']."|".$row['FirstName']." ".$row['LastName'];
				}
				showTable($dataStr);
			}
			
			function getMostActiveFlights()
			{
				global $con;
				$query = "CREATE VIEW FlightReservation(AirlineID, FlightNo, ResrCount)
							AS
							SELECT I.AirlineID, I.FlightNo, COUNT(DISTINCT I.ResrNo)
							FROM Includes I
							GROUP BY I.AirlineID, I.FlightNo;";
				$result = mysqli_query($con, $query);
				
				$query = "SELECT * FROM FlightReservation
							WHERE ResrCount >= (SELECT MAX(ResrCount) FROM FlightReservation);";
				$result = mysqli_query($con, $query);
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AirlineID']."|".$row['FlightNo']."|".$row['ResrCount'];
				}
				showTable($dataStr);
			}
			
			function getCustomersOnFlight()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT P.Id, P.FirstName, P.LastName
							FROM Reservation R, Includes I, ReservationPassenger RP, Person P
							WHERE I.ResrNo = R.ResrNo AND R.ResrNo = RP.ResrNo AND RP.Id = P.Id
							AND I.AirlineID = '".$formData['airID']."' AND I.FlightNo = '".$formData['flightNo']."';";
				$result = mysqli_query($con, $query);
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['Id']."|".$row['FirstName']." ".$row['LastName'];
				}
				showTable($dataStr);
			}
			
			function getFlightsAtAirport()
			{
				global $con, $formData;
				$query = "SELECT DISTINCT F.* 
							FROM Flight F, Leg L, Airport A
							WHERE F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo
							AND (L.DepAirportId = A.Id OR L.ArrAirportId = A.Id)
							AND A.Name = '".$formData['airport']."';";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AirlineID']."|".$row['FlightNo']."|".$row['NoOfSeats']."|".$row['DaysOperating']."|".$row['MinLengthOfStay']."|".$row['MaxLengthOfStay'];
				}
				showTable($dataStr);
			}
			
			function getOnTimeFlights()
			{
				global $con;
				$query = "SELECT * FROM Flight F 
							WHERE NOT EXISTS(
								SELECT * FROM Leg L
								WHERE F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo
									AND(ActualArrTime > ArrTime OR ActualDepTime > DepTime));";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AirlineID']."|".$row['FlightNo']."|".$row['NoOfSeats']."|".$row['DaysOperating']."|".$row['MinLengthOfStay']."|".$row['MaxLengthOfStay'];
				}
				showTable($dataStr);
			}
			
			function getLateFlights()
			{
				global $con;
				$query = "SELECT * FROM Flight F 
							WHERE EXISTS(
								SELECT * FROM Leg L
								WHERE F.AirlineID = L.AirlineID AND F.FlightNo = L.FlightNo
									AND(ActualArrTime > ArrTime OR ActualDepTime > DepTime));";
				$result = mysqli_query($con, $query);
				
				$dataStr = "";
				while($row = mysqli_fetch_array($result))
				{
					$dataStr .= "~".$row['AirlineID']."|".$row['FlightNo']."|".$row['NoOfSeats']."|".$row['DaysOperating']."|".$row['MinLengthOfStay']."|".$row['MaxLengthOfStay'];
				}
				showTable($dataStr);
			}
			
			function showTable($dataStr)
			{
				global $table;
				echo("<script type='text/javascript'>
						setTable('".$dataStr."', '".$table."');
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
				<a id="logo" class="navbar-brand" href="../index.php">PandaExpress</a>
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
			<h1 id="companyName">Customize Profile</h1>
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<div>
					<div class = "container">
						<button onclick = "viewTable('sales');"> View Sales Report </button>
						<br />
						<br />
						<table class = "table" id = "sales">
							<tr>
								<td colspan="6" class="header">Sales Report</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Reservation Date</td>
								<td>Total Fare</td>
								<td>Booking Fee</td>
								<td>Employee Rep</td>
								<td>Customer Name</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('flights');"> View List of Flights </button>
						<br />
						<br />
						<table class = "table" id = "flights">
							<tr>
								<td colspan="6" class="header">List of Flights</td>
							</tr>
							<tr>
								<td>Airline Id</td>
								<td>Flight Number</td>
								<td>Number of Seats</td>
								<td>Days Operating</td>
								<td>Minimum Length of Stay</td>
								<td>Maximum Length of Stay</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('rfForm');"> View Reservations by Flight </button>
						<form id="rfForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>Airline ID <input type = "text" name="airID" /></label>
							<label>Flight Number <input type = "number" name="flightNo" /></label>
							<input type = "hidden" name="table" value="resrFlights" ></label>
							<input type="submit" />
						</form>
						<br />
						<br />
						<table class = "table" id = "resrFlights">
							<tr>
								<td colspan="6" class="header">Reservations</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Reservation Date</td>
								<td>Total Fare</td>
								<td>Booking Fee</td>
								<td>Employee Rep</td>
								<td>Customer Name</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('rcForm');"> View Reservations by Customer </button>
						<form id = "rcForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>First Name <input type = "text" name="cFirst" /></label>
							<label>Last Name <input type = "text" name="cLast" /></label>
							<input type = "hidden" name="table" value="resrCust" ></label>
							<input type="submit" />
						</form>
						<br />
						<br/>
						<table class = "table" id = "resrCust">
							<tr>
								<td colspan="6" class="header">Reservations</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Reservation Date</td>
								<td>Total Fare</td>
								<td>Booking Fee</td>
								<td>Employee Rep</td>
								<td>Customer Name</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('revFlForm');"> View Revenue Generated By Flight </button>
						<form id = "revFlForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>Airline ID <input type = "text" name="airID" /></label>
							<label>Flight Number <input type = "number" name="flightNo" /></label>
							<input type = "hidden" name="table" value="revFl" ></label>
							<input type="submit" />
						</form>
						<br />
						<br/>
						<table class = "table" id = "revFl">
							<tr>
								<td colspan="2" class="header">Revenue Generated By Flight</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Revenue</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('revCForm');"> View Revenue Generated By City </button>
						<form id = "revCForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>City <input type = "text" name="city" /></label>
							<input type = "hidden" name="table" value="revCity" ></label>
							<input type="submit" />
						</form>
						<br />
						<br/>
						<table class = "table" id = "revCity">
							<tr>
								<td colspan="2" class="header">Revenue Generated By City</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Revenue</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('revCustForm');"> View Revenue Generated By Customer </button>
						<form id = "revCustForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>Account Number <input type = "number" name="accNo" /></label>
							<input type = "hidden" name="table" value="revCust" ></label>
							<input type="submit" />
						</form>
						<br />
						<br/>
						<table class = "table" id = "revCust">
							<tr>
								<td colspan="2" class="header">Revenue Generated By Customer</td>
							</tr>
							<tr>
								<td>Reservation</td>
								<td>Revenue</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('revCR');"> View Customer Representative Generating Most Revenue</button>
						<br />
						<br/>
						<table class = "table" id = "revCR">
							<tr>
								<td class="header">Customer Representative Generating Most Total Revenue</td>
							</tr>
							<tr>
								<td>Customer Representative</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('tRevCust');"> View Customer Generating Most Revenue</button>
						<br />
						<br/>
						<table class = "table" id = "tRevCust">
							<tr>
								<td colspan="2"class="header">Customer Generating Most Total Revenue</td>
							</tr>
							<tr>
								<td>Account Number</td>
								<td>Name</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('activeFl');"> View Most Active Flights</button>
						<br />
						<br/>
						<table class = "table" id = "activeFl">
							<tr>
								<td colspan="3"class="header">Most Active Flights</td>
							</tr>
							<tr>
								<td>Airline ID</td>
								<td>Flight Number</td>
								<td>Number of Reservations</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('cSeatsForm');"> View Customers on a Flight</button>
						<br />
						<br/>
						<form id = "cSeatsForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>Airline ID <input type = "text" name="airID" /></label>
							<label>Flight Number <input type = "number" name="flightNo" /></label>
							<input type = "hidden" name="table" value="custSeats" ></label>
							<input type="submit" />
						</form>
						<table class = "table" id = "custSeats">
							<tr>
								<td colspan="2"class="header">Customers on Flight</td>
							</tr>
							<tr>
								<td>Person</td>
								<td>Name</td>
							</tr>
						</table>
						
						<button onclick = "viewForm('flAirForm');"> View Flights in Airport</button>
						<br />
						<br/>
						<form id = "flAirForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>Airport Name <input type = "text" name="airport" /></label>
							<input type = "hidden" name="table" value="flAir" ></label>
							<input type="submit" />
						</form>
						<table class = "table" id = "flAir">
							<tr>
								<td colspan="6"class="header">Flights in an Airport</td>
							</tr>
							<tr>
								<td>Airline Id</td>
								<td>Flight Number</td>
								<td>Number of Seats</td>
								<td>Days Operating</td>
								<td>Minimum Length of Stay</td>
								<td>Maximum Length of Stay</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('flOT');"> View On Time Flights</button>
						<br />
						<br/>
						<table class = "table" id = "flOT">
							<tr>
								<td colspan="6"class="header">On Time Flights</td>
							</tr>
							<tr>
								<td>Airline Id</td>
								<td>Flight Number</td>
								<td>Number of Seats</td>
								<td>Days Operating</td>
								<td>Minimum Length of Stay</td>
								<td>Maximum Length of Stay</td>
							</tr>
						</table>
						
						<button onclick = "viewTable('flLate');"> View Late Flights</button>
						<br />
						<br/>
						<table class = "table" id = "flLate">
							<tr>
								<td colspan="6"class="header">Late Flights</td>
							</tr>
							<tr>
								<td>Airline Id</td>
								<td>Flight Number</td>
								<td>Number of Seats</td>
								<td>Days Operating</td>
								<td>Minimum Length of Stay</td>
								<td>Maximum Length of Stay</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php 
			startPage();
		?>
	</body>
</html>
