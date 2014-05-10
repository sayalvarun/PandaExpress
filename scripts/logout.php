<?php
	unset($_COOKIE["user"]);
	setcookie("user", "", -1,"/");
	header("location:../index.php");
?>