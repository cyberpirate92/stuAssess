<?php
	if(session_status() != PHP_SESSION_ACTIVE)
	{
		session_start();
	}
	if(isset($_SESSION['username']) && isset($_SESSION['type']) && $_SESSION['type'] == 'faculty')
	{

	}
	else
	{
		require_once('util.php');
		session_destroy();
		displayJSAlert('You must be logged in to view this page, please login');
		redirectTo('login.php');
		die('');
	}
?>