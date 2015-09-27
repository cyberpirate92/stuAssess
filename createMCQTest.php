<?php
	require_once('faculty_login_check.php');
	if(!empty($_GET))
	{
		$ID = $_GET['id'];

	}
	else
	{
		require_once('util.php');
		redirectTo('faculty_portal.php');
	}
?>
<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					
				</div>
				<div id='content-main'>

				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>