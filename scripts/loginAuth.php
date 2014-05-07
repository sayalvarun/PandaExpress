<?php
	global $con;
	// Create connection
	$con=mysqli_connect("localhost","root","","pandaexpress");

	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	if(empty($_POST["username"]) || empty($_POST["password"]))
		header("Location:pages/login.php");
	else
	{
		$cmd="SELECT * FROM Logins 
			  WHERE username='".$_POST["username"]."' 
			  AND password='".$_POST["password"]."'";
		
		$result=mysqli_query($con,$cmd);
		if(!$result || mysqli_num_rows($result)!=1)
			header("Location:pages/login.php");
		else
		{
			$expire=time()+60;
			$user = $_POST["username"];
			setcookie("user", $user, $expire, ".localhost/PandaExpress/");
			echo($user);
			//print_r($_COOKIE);
			//echo($_COOKIE["user"]);
			header("Location:../index.php");
		}
	}
?>