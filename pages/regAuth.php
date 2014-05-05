<!DOCTYPE html>
	<head>
		<?php
			global $con;
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
			
			function isUniqueUsername()
			{				
				global $con;
				$cmd="SELECT * FROM login 
					  WHERE username='".$_POST["uname"]."';";
								
				$result = mysqli_query($con,$cmd);
				$numRows = mysqli_num_rows($result);
				return numRows == 0;
			}
			
			function generateID()
			{
				global $con;
				$result = mysqli_query($con,"SELECT COUNT(*) FROM Person");
				$row = $result->fetch_row();
				return $row[0]+1;
			}
			
			function exampleQuery()
			{
				global $con;
				$result = mysqli_query($con,"SELECT * FROM Person");
				//For Error Checking
				if (!$result) 
				{
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				while($row = mysqli_fetch_array($result)) 
				{
					echo $row['FirstName'] . " " . $row['LastName'];
					echo "<br>";
				}
			}
		?>
	</head>
	<body>
		<?php
			$email=$_POST["email"];
		?>
		<?php
			connectToDB();
			echo "FIRST NAME: ".$_POST["fname"];
			echo "<br />";
			echo "LAST NAME: ".$_POST["lname"];
			echo "<br />";
			echo "ADDR :".$_POST["addr"]."\n".$_POST["city"].", ".$_POST["state"]." ".$_POST["zip"];
			echo "<br />";
			echo "CREDIT CARD :".$_POST["cc"];
			echo "<br />";
			echo "EMAIL :".$_POST["email"];
			echo "<br />";
			echo "USERNAME: ".$_POST["uname"];
			echo "<br />";
			echo "PASSWORD :".$_POST["pword"];
			echo "<br />";
			echo generateID();
		?>
	</body>
</html>