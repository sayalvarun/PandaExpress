 <html>
	<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		


			<?php 
 				// Connects to your Database 
				global $con, $cmd, $data, $row;	

				function connectAndQuery($cmd, $paramString){
					//The paramters are delimited by commas
					$con = mysqli_connect("localhost", "root", "root", "PandaExpress"); 
					if (mysqli_connect_errno()) {
				  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}

					
 					$data = mysqli_query($con,$cmd);
					$parameters = explode(",", $paramString);

					if(count($data)>0){
						Print "<table border cellpadding=3>";
 						while($row = mysqli_fetch_array($data)) 
						{
							Print "<tr>";
							//echo $row['Id'] . " " . $row['Name'];
							//echo "<br>";
							foreach($parameters as &$value){
								
								Print "<th>".$value.":</th> <td>".$row[$value] . "</td> "; 
							}
							Print "<tr>";
						}
						Print "</table>";
					}
				}
			?>
	</head>

	<body>
		<?php 
			/*
			connectAndQuery("select * from Airline","Id,Name"); //Get all airline's

			connectAndQuery("select * from Reservation","ResrNo,AccountNo");
			
			//Customer level transactions
			connectAndQuery("SELECT * FROM Reservation R 
			      	        WHERE EXISTS ( 
 					SELECT * FROM Includes I, Leg L 
 					WHERE R.ResrNo = I.ResrNo AND I.AirlineID = L.AirlineID 
 					AND I.FlightNo = L.FlightNo AND L.DepTime >= NOW()) 
					AND R.AccountNo = 1008;", "ResrNo,TotalFare,AccountNo"); //Get all current reservations (!Contains a hard parameter)

			connectAndQuery("SELECT DISTINCT I.ResrNo, I.AirlineID, I.FlightNo, 
 			  		DA.Name AS Departing, AA.Name AS Arriving, 
 					L.DepTime, L.ArrTime 
					FROM Includes I, Leg L, Airport DA, Airport AA 
					WHERE I.AirlineID = L.AirlineID AND I.FlightNo = L.FlightNo 
 					AND L.DepAirportID = DA.Id AND L.ArrAirportID = AA.Id 
 					AND I.ResrNo = 111", "ResrNo,AirlineId,FlightNo,Departing,Arriving"); //Get a travel itinerary for a given reservation

			connectAndQuery("SELECT * FROM Auctions 
					WHERE AccountNo = 1008 AND AirlineID = 'AA' AND FlightNo = 111 AND Class = 
					'Economy' ORDER BY `Date` DESC LIMIT 0,1", "AccountNo,AirlineID,FlightNo,Class,Date,NYOP,Accepted"); 
					//Get a customers current auctions (!Contains a hard parameter)

			connectAndQuery("SELECT * FROM Reservation WHERE AccountNo = 1008", 
					"ResrNo,ResrDate,BookingFee,TotalFare,RespSSN,AccountNo"); //History of reservations made by a customer(!hard parameter)

			connectAndQuery("SELECT * FROM FlightReservation ORDER BY ResrCount DESC;","AirlineID,FlightNo,ResrCount"); //Best Seller list of life

			connectAndQuery("SELECT * FROM FlightReservation FR 
					WHERE NOT EXISTS ( 
 					SELECT * FROM Reservation R, Includes I 
 					WHERE R.ResrNo = I.ResrNo AND FR.AirlineID = I.AirlineID 
 					AND FR.FlightNo = I.FlightNo AND R.AccountNo = 1008) 
					ORDER BY FR.ResrCount DESC;", "AirlineID,FlightNo,ResrCount"); //Personalized flight suggestion list
			*/
			//connectAndQuery("INSERT INTO Includes VALUES (555, 'AA', 111, 1, '2014-04-10');","");
			connectAndQuery("INSERT INTO Reservation VALUES (555, '2014-04-01 16:50:45', 100, 1000, NULL, 1008);","")  
			//connectAndQuery("INSERT INTO ReservationPassenger VALUES(555, 1, 1008, '10B', 'First', 'Steak');",""); 
					//Add a 1 way reservation
					//(!contains hardcoded parameters)

			connectAndQuery("select * from Reservation","ResrNo,AccountNo");
			connectAndQuery("select * from ReservationPassenger","");
			connectAndQuery("select * from Includes","");

			/*
			//Customer representative level transactions
			connectAndQuery("CREATE VIEW FlightReservation(AirlineID, FlightNo, ResrCount) AS 
					SELECT I.AirlineID, I.FlightNo, COUNT(DISTINCT I.ResrNo) AS ResrCount 
					FROM Includes I 
					GROUP BY I.AirlineID, I.FlightNo;", "AirlineID,FlightNo,ResrCount"); //List of flight suggestions based on past

			connectAndQuery("SELECT * FROM FlightReservation FR 
					WHERE NOT EXISTS ( SELECT * FROM Reservation R, Includes I 
 					WHERE R.ResrNo = I.ResrNo AND FR.AirlineID = I.AirlineID 
 					AND FR.FlightNo = I.FlightNo AND R.AccountNo = 1008) 
					ORDER BY FR.ResrCount DESC", "AirlineID,FlightNo,ResrCount"); //List of flight suggestions based on past (!Contains a hard parameter)
		 	*/
		?>
	</body> 






















