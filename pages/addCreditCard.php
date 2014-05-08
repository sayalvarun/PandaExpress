<?php
	
	if(isset($_POST["cardInfo"])){
		$card = $_POST["cardInfo"];
	}
	if(isset($_COOKIE["user"])){
		$username = $_COOKIE["user"];
	}
	

	
	$con = mysqli_connect("localhost", "root", "", "PandaExpress"); 
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$cmd = "select C.AccountNo from customer C, logins L
				where C.id = L.id AND L.username = '".$username."';";
				
		$data = mysqli_query($con,$cmd);
		
		
		while($row = mysqli_fetch_array($data)) {
			$accountNo = (int) $row["AccountNo"];
		}
		
		
		$cmd = "UPDATE customer
		SET CreditCardNo = '".$card."'
		WHERE AccountNo = ".$accountNo.";";
		$parameters = "CreditCardNo";
	
		$data = mysqli_query($con,$cmd);
		
		header("location: reservationBooker.php");

?>