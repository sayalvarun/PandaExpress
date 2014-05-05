<?php
	// Create connection
	//$con=mysqli_connect("localhost","root","","pandaexpress");

	// Check connection
	//if (mysqli_connect_errno()) {
	//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	//}
	$cars=array("Volvo","BMW","Toyota");
	$username = $_POST["username"];
	for($i=0; $i<count($cars); $i++)
		echo($cars[$i]);
?>