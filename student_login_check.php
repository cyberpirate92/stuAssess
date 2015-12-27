<?php
	require_once('util.php');
	secure_session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['type']) && $_SESSION['type'] == 'student')
	{
		$username = $_SESSION['username'];
	}
	else
	{
		secure_session_destroy();
		displayError1("You must be logged in to view this page, please <a href='login.php'>login</a>");
		exit();
	}
?>