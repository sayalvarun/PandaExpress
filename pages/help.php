<link rel="stylesheet" type="text/css" href="../styles/reservationBooker.css">
		<link rel="stylesheet" type="text/css" href="../styles/profile.css">
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">  
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="../scripts/js/bootstrap.js"></script>
		<script src="../scripts/logoutTab.js"></script>
		<link rel="stylesheet" type="text/css" href="../styles/logoutTab.css">
		
		<?php
			$con = null;
			$user = null;
			
			function setUserName()
			{
				global $user;
				if(isset($_COOKIE["user"]))
				{
					$user = $_COOKIE["user"];
					resetPage();
				}	
			}
			function resetPage()
			{
				global $user;
				echo("<script type='text/javascript'>
						resetPage('".$user."');
					  </script>");
			}
		?>
	</head>

	<body>
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<span id="logo" class="navbar-brand">PandaExpress</span>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../index.php">Book Flight</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="help.php">Help</a></li>
					<li id="loginButton"><a href="login.php">Login</a></li>
					<li class="dropdown" id="userDropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user">-insert Username here-</span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="viewProfile.php">View Profile</a></li>
							<li class="divider"></li>
							<li><a href="customizeProfile.php">Customize Profile</a></li>
							<li class="divider"></li>
							<li><a href="auctions.html">Auctions</a></li>
							<li class="divider"></li>
							<li><a href="cancelReservation.php">Cancel Reservation</a></li>
							<li class="divider"></li>
							<li><a href="managerial.php">Manage</a></li>
							<li class="divider"></li>
							<li><a href="../scripts/logout.php">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div id="header">
			<h1 id="companyName"> FAQ </h1>
		</div>
		<div class = "searchAreaBorder">
			<div class = "searchArea">		
					<h2>What is a reverse auction?</h2>
						<p> A reverse auction is a different way of reserving flights! It allows the customer to 'Name Your Own Price' 
						allowing users to bid an amount they are willing to pay for a flight. If you bid higher than the hidden fee
						for a flight (the cheapest price allowable for a ticket), it is yours!</p>
						
				<h2>Do I need a credit card on file to purchase tickets?</h2>
						<p> We do require customers list they're preferred credit card before purchasing their ticket. This facilitates
							quicker reservation processing and allows us to better serve the customer.</p>
							
				<h2>Do I need a credit card on file to create an account?</h2>
						<p> We do require customers list they're preferred credit card before purchasing their ticket. This facilitates
							quicker reservation processing and allows us to better serve the customer.</p>
				<h2>How can I see the list of flights I've been on?</h2>
						<p>Clicking on your username will show a drop down menu. Click on "View Profile". This will show a table of listing
						all your previous reservations and a table listing all of your current reservations.</p>
				<h2>The email address  you have on file is wrong so I'm not getting any promotional deals. How do I fix this?</h2>
						<p>Clicking on your username will show a drop down menu. Click on "Customize Profile". This will allow you to change
						your email address as well as other personal informations.</p>
				<h2>Your FAQ didn't answer any of my questions. Who should I contact?</h2>
						<p>Call our hotline at 1-(631)-PANDA-EX for more direct help.</p> 
			</div>
		</div>	
		<?php setUserName(); ?>
	</body>
</html>
