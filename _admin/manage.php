<?php
	require_once('../util.php');
	$username = adminLoginCheck();
	if($username)
	{
		echo "admin logged in";
	}
	else
	{
		print_r($_SESSION);
		secure_session_destroy();
		displayError("You must be logged in to view this page, please <a href='login.php'>login</a>");
		exit();
	}
?>