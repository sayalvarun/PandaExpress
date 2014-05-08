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
			function setFields(data)
			{
				data = data.split("~");
				fields = document.getElementsByClassName("cProf");
				for(i = 0; i < data.length; i++)
					fields[i].value = data[i];
			}
		</script>
		<?php
			$con = null;
			$user = $id = null;
			$prevPage = "Home";
			$rate = $fname = $lname = $addr = $city = $state = $zip = $email = $credit = null;
			$fnameErr = $lnameErr = $addrErr = $cityErr = $stateErr = $zipErr = $emailErr = null;
			
			function startPage()
			{
				connectToDB();
				setUserName();
				setID();
				if ($_SERVER["REQUEST_METHOD"] == "POST")
					customize();
				else
					setDataFields();
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
			
			function setID()
			{
				global $con, $id, $user;
				$query = "select id from logins where username = '".$user."';";
				$result = mysqli_query($con, $query);
				$row = mysqli_fetch_array($result);
				$id = $row['id'];
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
			
			function customize()
			{
				global $id;
				//echo($user);
				
				if(!empty($_POST["fname"]))
					runUpdates("person", "firstname", $_POST["fname"]);
				if(!empty($_POST["lname"]))
					runUpdates("person", "lastname", $_POST["lname"]);
				if(!empty($_POST["addr"]))
					runUpdates("person", "address", $_POST["addr"]);
				if(!empty($_POST["city"]))
					runUpdates("person", "city", $_POST["city"]);
				if(!empty($_POST["state"]))
					runUpdates("person", "state", $_POST["state"]);
				if(!empty($_POST["zip"]))
					runUpdates("person", "zipcode", $_POST["zip"]);
				
				if(!empty($_POST["cc"]))
					runUpdates("customer", "creditcardno", $_POST["cc"]);
				if(!empty($_POST["email"]))
					runUpdates("customer", "email", $_POST["email"]);
				if(!empty($_POST["rate"]))
					runUpdates("customer", "rating", $_POST["rate"]);
				header("location:viewProfile.php");
			}
			
			function runUpdates($table, $attr, $value)
			{
				global $con, $id;
				$query = "update ".$table." set ".$attr."='".$value."' where id=".$id.";";
				mysqli_query($con, $query);
			}
			
			function setDataFields()
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
						setFields(\"".$dataString."\");
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
			<h1 id="companyName">Customize Profile</h1>
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<div>
					<div class = "container">
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<label>First Name <input class="cProf" type="text" name="fname" value="<?php echo $fname; ?>" /></label>
							<br />
							<span class="error"><?php echo $fnameErr; ?></span>
							<br />
							<label>Last Name <input class="cProf" type="text" name="lname" value="<?php echo $lname; ?>" /></label>
							<br />
							<span class="error"><?php echo $lnameErr; ?></span>
							<br />
							<label>Address <input class="cProf" type="text" name="addr" value="<?php echo $addr; ?>" /></label>
							<br />
							<span class="error"><?php echo $addrErr; ?></span>
							<br />
							<label>City <input class="cProf" type="text" name="city" value="<?php echo $city; ?>" /></label>
							<br />
							<span class="error"><?php echo $cityErr; ?></span>
							<br />
							<label>State <input class="cProf" type="text" name="state" value="<?php echo $state; ?>" /></label>
							<br />
							<span class="error"><?php echo $stateErr;?></span>
							<br />
							<label>Zip Code <input class="cProf" type="number" name ="zip" value="<?php echo $zip; ?>" min="0" max="99999" /></label>
							<br />
							<span class="error"><?php echo $zipErr; ?></span>
							<br />
							<br />
						<!-- FIELDS REQUIRED FOR CUSTOMER TABLE -->	
							<label>Credit Card <input class="cProf" type="number" name="cc" value="<?php echo $credit; ?>" min="0" max="999999999999" /></label>
							<br />
							<label>Email <input class="cProf" type="email" name="email" value="<?php echo $email; ?>" /></label>
							<br />
							<label>Rating<input class="cProf" type="number" name="rate" value="<?php echo $rate; ?>" /></label>
							<br />
							
							<input type="submit" value="Update">
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php 
			startPage();
			setUsername();
		?>
	</body>
</html>
