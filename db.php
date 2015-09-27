<?php
	$DB_USERNAME = "root";
	$DB_PASSWORD = "";
	$DB_NAME = "ASR";
	$DB_HOST = "localhost";

	$db = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD,$DB_NAME) or die('DB ERROR: Cannot connect');
?>