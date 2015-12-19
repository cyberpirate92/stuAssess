<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
		<script type='text/javascript' src='js/faculty_portal.js'></script> <!-- NOTE: may change in case of student portal. -->
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					<li id='option-test' onclick="viewTests()"> Create Test </li>
					<li id='option-result' onclick="viewResults()"> Test Reports </li>
					<li id='option-upload' onclick="viewUpload()"> Add New class </li>
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