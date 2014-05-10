<html>
<head lang="en">
		<title> Welcome to Panda Express! </title>
		<meta charset="utf-8">		
		
		<link rel="stylesheet" type="text/css" href="styles/index.css">
		<link rel="stylesheet" type="text/css" href="styles/login.css">
		<link rel="stylesheet" type="text/css" href="styles/search.css">
		<link rel="stylesheet" type="text/css" href="styles/logoutTab.css">
		<link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">  
		<style type="text/css">
			h1 {color: #FFFFFF;}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="scripts/js/bootstrap.js"></script>
		<script src="scripts/logoutTab.js"></script>
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
					<a id="logo" class="navbar-brand" href="index.php">PandaExpress</a>
				</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="pages/search.php">Book Flight</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="pages/help.php">Help</a></li>
						<li id="loginButton"><a href="pages/login.php">Login</a></li>
						<li class="dropdown" id="userDropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user">-insert Username here-</span><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="pages/viewProfile.php">View Profile</a></li>
								<li class="divider"></li>
								<li><a href="pages/customizeProfile.php">Customize Profile</a></li>
								<li class="divider"></li>
								<li><a href="pages/auctions.php">Auctions</a></li>
								<li class="divider"></li>
								<li><a href="pages/cancelReservation.php">Cancel Reservation</a></li>
								<li class="divider"></li>
								<li><a href="pages/managerial.php">Manage</a></li>
								<li class="divider"></li>
								<li><a href="scripts/logout.php">Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1" class=""></li>
				<li data-target="#myCarousel" data-slide-to="2" class=""></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<img src="styles/images/pandaBanner.jpg" />
					<div class="container">
						<div class="carousel-caption">
							<!--<p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p> -->
						</div>
					</div>
				</div>
				<div class="item">
					<img src="styles/images/NZ.jpg" />
					<div class="container">
						<div class="carousel-caption">
							<h1>New Zealand</h1>
							<!--<p><a class="btn btn-lg btn-primary" href="http://getbootstrap.com/examples/carousel/#" role="button">Learn more</a></p> -->
						</div>
					</div>
				</div>
				<div class="item">
					<img src="styles/images/beach.jpg" />
					<div class="container">
						<div class="carousel-caption">
						<h1>Let us suggest a vacation!</h1>
						<p>View our list of suggested and popular flights!<p>
						<!--<p><a class="btn btn-lg btn-primary" href="index.html" role="button">View List</a></p>-->
						</div>
					</div>
				</div>
			</div>
		  
			<a class="left carousel-control" href="http://getbootstrap.com/examples/carousel/#myCarousel" data-slide="prev"></a>
			<a class="right carousel-control" href="http://getbootstrap.com/examples/carousel/#myCarousel" data-slide="next"></a> 
		</div><!-- /.carousel -->
		
		<?php
			// Create connection
			$con=mysqli_connect("localhost","root","","pandaexpress");

			// Check connection
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			if(isset($_COOKIE["user"]))
			{
				$user = $_COOKIE["user"];
				echo("<script type='text/javascript'>
						resetPage('".$user."');
					  </script>");
			}
		?>
	</body>
</html>