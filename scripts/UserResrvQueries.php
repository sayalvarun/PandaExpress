<?php
	//create connection
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
	
	//get customer account no
	$query = "select accountno from customer where id=".$id.";";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$accNo = $row['accountno'];
	//echo($accNo);
	
	//get reservation infos
	$query = "SELECT resrno, airlineid, flightno, depairportid, deptime, arrairportid, arrtime, totalfare
				FROM reservation
					NATURAL JOIN includes
					NATURAL JOIN leg
				where accountno=".$accNo."
				order by deptime;";
	$result = mysqli_query($con, $query);
	
	while($row = mysqli_fetch_array($result))
	{
		echo("~".$row['resrno']."|".$row['airlineid']."|".$row['flightno']."|".$row['depairportid']."|".$row['deptime']."|".$row['arrairportid']."|".$row['arrtime'])."|".$row['totalfare'];
	}
?>