<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<!--<link rel="stylesheet" type="text/css" href="../styles/index.css">-->
		<style type="text/css">
			label{color:#FFFFFF;}
			input[type=submit] {
				margin-right: 20px;
				margin-top: 20px;
				width: 80px;
				height: 30px;
				
				font-size: 14px;
				font-weight: bold;
				color: #fff;
				background-color: #acd6ef; /*IE fallback*/
				background-image: -webkit-gradient(linear, left top, left bottom, from(#acd6ef), to(#6ec2e8));
				background-image: -moz-linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
				background-image: linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
				border-radius: 30px;
				border: 1px solid #66add6;
				box-shadow: 0 1px 2px rgba(0, 0, 0, .3), inset 0 1px 0 rgba(255, 255, 255, .5);
				cursor: pointer;
			}			
		</style>
		<?php
			$fname = $lname = $addr = $city = $state = $zip = $email = $credit = null;
			$fnameErr = $lnameErr = $addrErr = $cityErr = $stateErr = $zipErr = $emailErr = null;
		?>
		<script src="../scripts/logoutTab.js"></script>
	</head>
	<body>
		<!--<div class= "topBar">
		</div>-->
		<div id="header">
			<h1 id="companyName"> Customize Profile </h1>
			<ul class="logoutTab">
				<li id="username">Username <span onclick="clickedUsername();" id="triangle"> &#9660 </span></li>
				<ul id ="tabOps">
					<li><a href="pages/userProfile.html">View Profile</a>
					<li><a>Customize Profile</a></li>
					<li><a href="../index.html">Log Out</a></li>
				</ul>
			</ul>
		</div>
		<div class = "orange">
			<div class = "info">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
					<input type="submit" />
					<br />
					<br />
				</form>
			</div>
		</div>
	</body>
</html>