<?php
	require_once('util.php');
	session_start();
	$_SESSION['username'] = "";
	$_SESSION['type'] = "";
	session_destroy();
	redirectTo('login.php');
?>