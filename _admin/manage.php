<?php
	require_once('../util.php');
	$username = adminLoginCheck();
	if($username)
	{
		echo "admin logged in";
		echo "<a href='../logout.php'> Logout </a>";
	}
	else
	{
		print_r($_SESSION);
		secure_session_destroy();
		displayError("You must be logged in to view this page, please <a href='login.php'>login</a>");
		exit();
	}
?>