<?php
	// Create connection
	$con=mysqli_connect("localhost","root","","pandaexpress");
	
	$username = $_POST["username"];
	
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	//get person id
	$query = "select id from logins where username = '".$username."';";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$id = $row['id'];
	
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
	echo($fname."~".$lname."~".$addr."~".$city."~".$state."~".$zip);
	
	//gets all data from customer table
	$query = "select * from customer where id=".$id.";";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$cc = $row['CreditCardNo'];
	$email = $row['Email'];
	$rating = $row['Rating'];
	echo("~".$cc."~".$email."~".$rating);
?>