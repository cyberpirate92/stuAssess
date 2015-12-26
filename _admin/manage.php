<?php
	if(session_status() != PHP_SESSION_ACTIVE)
	{
		session_start();
	}
	if(isset($_SESSION['username']) && isset($_SESSION['type']))
	{
		// this is faculty account, not a admin login, so don't allow
		session_unset();
		session_destroy();
		require_once('util.php');
		displayError("You must be logged in to view this page, please <a href='login.php'>login</a>");
		die('');
	}
	else if(isset($_SESSION['username']) && isset($_SESSION['access_level']) && $_SESSION['access_level'] == "admin" )
	{
		//login success!
		// TODO: Implement secure session management.		
	}
	else
	{
		require_once('util.php');
		session_destroy();
		displayError("You must be logged in to view this page, please <a href='login.php'>login</a>");
		die('');
	}
?>