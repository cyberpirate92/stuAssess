<?php
	require_once('faculty_login_check.php');
	if(!empty($_POST))
	{
		require_once('util.php');
		$nQuestions = $_POST['nQuestions'];
		$test_name = $_POST['testName'];
		do
		{
			$random = rand(100,999999);
		}while(table_exists($random));

		createNewTestTable($username,$random,$test_name);

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
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					
				</div>
				<div id='content-main'>
					<!-- Content goes here -->
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University, Chennai
			</div>
		</div>
	</body>
</html>