<?php
	require_once('util.php');
	if(session_status() != PHP_SESSION_ACTIVE)
	{
		session_start();
	}
	$_SESSION['username'] = "";
	$_SESSION['type'] = "";
	session_destroy();
	redirectTo('login.php');
?>