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
			$id = $fname = $lname = $addr = $city = $state = $zip = $credit = $email = $uname = $pword = "";
			
			if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$fname = $_POST["fname"];
				$lname = $_POST["lname"];
				$addr = $_POST["addr"];
				$city = $_POST["city"];
				$state = $_POST["state"];
				$zip = $_POST["zip"];
				$uname = $_POST["uname"];
				$pword = $_POST["pword"];
				$email = $_POST["email"];		
				$credit = $_POST["cc"];
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
				
				if($_SERVER["REQUEST_METHOD"] == "POST" && $fnameErr == "" && $lnameErr == "" && $addrErr == "" && $cityErr == "" && $stateErr == "" && $zipErr == "" && $unameErr == "" && $pwordErr == "")
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
				global $id;
				if(canRegister())
				{
					connectToDB();
					$id = generateId();
					insertPerson();
					insertCustomer();
					mysqli_close($con);
					header("Location: ../index.html");
				}
			}
			
			function insertPerson()
			{
				global $con, $fname, $lname, $addr, $city, $state, $zip, $id;
				$query = "INSERT INTO Person(ID, FirstName, LastName, Address, City, State, ZipCode) VALUES(".$id.", '".$fname."', '".$lname."', '".$addr."', '".$city."', '".$state."', ".$zip.");";
				mysqli_query($con, $query);
				return $query;
			}
			
			function insertCustomer()
			{
				global $con, $id, $credit, $email;
				$query = "INSERT INTO Customer(AccountNo, ID, CreditCardNo, Email, CreationDate, Rating)
							VALUES(".generateAccountNo().", ".$id.", ";
				if($credit=="")
					$query = $query."NULL, ";
				else
					$query = $query.$credit.", ";
				if($email=="")
					$query = $query."NULL";
				else
					$query = $query."'".$email."'";
				$query = $query.", '".date("Y-m-d h:i:s")."', NULL);";
				mysqli_query($con, $query);
				return $query;
			}
			
			function generateID()
			{
				global $con;
				$result = mysqli_query($con,"SELECT MAX(ID) FROM Person;");
				if (!$result) 
				{
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				$row = $result->fetch_row();
				return $row[0]+1;
			}
			
			function generateAccountNo()
			{
				global $con;
				$result = mysqli_query($con,"SELECT MAX(AccountNo) FROM Customer;");
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
		<?php register(); ?>
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