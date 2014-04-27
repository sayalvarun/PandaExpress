<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/search.css">
		<style type="text/css">
			label{color:#FFFFFF;}
			input[type=submit]{float:left; margin-left:50px;}
			.error{color:red;}
		</style>
		<?php
			// define variables and set to empty values
			$con;
			$fnameErr = $lnameErr = $addrErr = $cityErr = $stateErr = $zipErr = $unameErr = $pwordErr = "";
			$fname = $lname = $addr = $city = $state = $zip = $credit = $email = $uname = $pword = NULL;
			if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$fname = $_POST["fname"];
				$lname = $_POST["lname"];
				$addr = $_POST["addr"];
				$city = $_POST["city"];
				$state = $_POST["state"];
				$zip = $_POST["zip"];
				$credit = $_POST["cc"];
				$email = $_POST["email"];
				$uname = $_POST["uname"];
				$pword = $_POST["pword"];
			}
			
			function checkForEmptyFields()
			{
				global $fnameErr, $lnameErr, $addrErr, $cityErr, $stateErr, $zipErr, $unameErr, $pwordErr;
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					if (empty($_POST["fname"]))
						$fnameErr = "First name is required.";
					if (empty($_POST["lname"]))
						$lnameErr = "Last name is required.";						
					if (empty($_POST["addr"]))
						$addrErr = "Address is required.";
					if (empty($_POST["city"]))
						$cityErr = "City is required.";
					if (empty($_POST["state"]))
						$stateErr = "State is required.";
					if (empty($_POST["zip"]))
						$zipErr = "Zipcode is required.";
					if (empty($_POST["uname"]))
						$unameErr = "Username is required.";				  
					if (empty($_POST["pword"]))
						$pwordErr = "Password is required.";
				}
			}
			
			function canRegister()
			{
				global $fnameErr, $lnameErr, $addrErr, $cityErr, $stateErr, $zipErr, $unameErr, $pwordErr;
				if($fnameErr == "" && $lnameErr == "" && $addrErr == "" && $cityErr == "" && $stateErr == "" && $zipErr == "" && $unameErr == "" && $pwordErr == "")
					return true;
				return false;
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
			
			function register()
			{
				if(canRegister())
				{
					connectToDB();
					return insertPerson();
					//insertCustomer();
				}
			}
			
			function insertPerson()
			{
				global $con, $fname, $lname, $addr, $city, $state, $zip;
				$query = "INSERT INTO Person (ID, FirstName, LastName, Address, City, State, ZipCode) VALUES (".generateID().", '".$fname."', '".$lname."', '".$addr."', '".$city."', '".$state."', ".$zip.");";
				//$query = "INSERT INTO PERSON (".generateID().", \"".$fname."\", \"".$lname."\", \"".$addr."\", \"".$city."\", \"".$state."\", ".$zip.");";
				mysqli_query($con, $query);
				mysqli_close($con);

				return $query;
			}
			
			function generateID()
			{
				global $con;
				$result = mysqli_query($con,"SELECT COUNT(*) FROM Person;");
				if (!$result) 
				{
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				$row = $result->fetch_row();
				return $row[0]+1;
			}
		?>
		
	</head>
	<body>
		<!--<div class= "topBar"></div>-->
		<div id="header">
			<h1>Registration Page</h1>
		</div>
		<?php echo register(); ?>
		<div class="searchArea">
			<?php checkForEmptyFields(); ?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!-- FIELDS REQURED FOR PERSON TABLE -->
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
				<br />
				<label>*Username <input type="text" name="uname" value="<?php echo $uname; ?>" /></label>
				<br />
				<span class="error"><?php echo $unameErr;?></span>
				<br />
				<label>*Password <input type="password" name="pword" /></label>
				<br />
				<span class="error"><?php echo $pwordErr;?></span>
				<br />
				<input type="submit" />
				<br />
				<br />
				<br />
				<span> Fields begining with an asterisk (*) must be filled out. </span>
				<br />
				<br />
			</form>
		</div>
	</body>
</html>