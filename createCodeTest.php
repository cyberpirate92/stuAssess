<?php
	require_once('faculty_login_check.php');
	if(!empty($_GET))
	{
		require_once("db.php");
		$ID = $_GET['id'];

		// checking if the groupID indeed belongs to this faculty
		$result = mysqli_query($db,"SELECT facultyID FROM groups WHERE groupID='$ID'");
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			if($row['facultyID'] != $username)
			{
				// the groupID does not belong to this faculty!
				session_destroy();
				redirectTo('logout.php');
				die('');
			}
			else
			{
				// groupID belongs to this faculty, safe to continue here
				// TODO:
			}
		}
		else
		{
			// groupID does not exist in the Database ! (might not happen, but still...)
			session_destroy();
			redirectTo('logout.php');
			die('');
		}
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
					<!-- TODO: get input for number of questions and other data (time, date etc..) and display question number boxes -->
				</div>
				<div id='content-main'>
					<!-- TODO: Questions can be added here after providing input for number of questions and other required info-->
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>