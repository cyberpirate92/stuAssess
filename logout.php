<?php
	require_once('util.php');
	secure_session_destroy();
	redirectTo('login.php');
?>