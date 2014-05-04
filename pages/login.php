<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="../styles/index.css">
		<link rel="stylesheet" type="text/css" href="../styles/login.css">
		<!--<link rel="stylesheet" type="text/css" href="styles/search.css">-->
		<style type="text/css">
			#container{margin-left:auto;margin-right:auto;}
		</style>
		<script src="../scripts/logoutTab.js"></script>
		
	</head>
	<body>
		<!--<div class= "topBar">
		</div>-->
		<div id="header">
			<h1 id="companyName"> Panda Express </h1>
		</div>
		<br />
		<div class = "searchAreaBorder">
			<div class = "searchArea">
				<div id="container">  
					<div id="containerHead"><h3>Login</h3></div>     
					<form id="loginForm" method="post" action="../index.php">
						<label for="username">Username:</label>
						<input type="text" id="username" name="username">
						<label for="password">Password:</label>
						<input type="password" id="password" name="password">
						<div id="lower">
							<input type="checkbox"><label for="checkbox">Keep me logged in</label>
							<input type="submit" value="Login">
							<br />
							<span> Don't have an account? <a href = "registration.php">Sign Up</a></span>
							<br />
						</div><!--/ lower-->
					</form>
				</div>
			</div>
		</div>
	</body>
</html>