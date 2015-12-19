<?php
	include('util.php');
	if(!empty($_POST))
	{
		$username = strtoupper(trim($_POST['username']));
		$password = $_POST['password'];

		if(strlen($username) == 0 || strlen($password) == 0)
		{
			displayJSAlert('Invalid username/password');
		}
		else
		{
			$password = md5($password);
			require_once('db.php');
			if(preg_match('/^[0-9]*$/',$username)) // checking if username belongs to a faculty (all numbers)
			{
				$table_name = "faculty_login";
				$page_name = "faculty_portal.php";
				$type = 'faculty';
			}
			else
			{
				$table_name = "student_login";
				$page_name = "student_portal.php";
				$type='student';
			}
			var_dump($table_name);
			var_dump($page_name);
			$result = mysqli_query($db,"SELECT * FROM $table_name WHERE username='$username' AND password='$password'");
			if(mysqli_num_rows($result) > 0)
			{
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['type'] = $type;
				redirectTo($page_name);
			}
			else
			{
				displayJSAlert('Invalid username/password.');
			}
		}
	}
?>
<html>
	<head>
		<title> Student Assessment </title>
		<link rel='stylesheet' href='css/base.css'>
		<style type='text/css'>
			#content-login
			{
				margin-top:7%;
				margin-left:40%;
				background:#5A768D;
				border:3px solid #CC9900;
				width:315px;
				font-family: tahoma;
				padding-top: 35px;
			}
			div.row
			{
				border:1px solid white;
				padding-left: 5px;
				padding-top: 5px;
				height:30px;
				background:#E1ECF2;
				text-align: center;
			}
			span.label
			{
				color: 5A768D;
				font-weight: bold;
				font-size: 12px;
			}
			div.form-input
			{
				float:left;
				margin-left:33%;
				background:#E1ECF2;
				width:65%;
				margin-left: 50%;
				width:50%;
			}
			div.buttons
			{
				padding:5px;
				text-align:center;
			}
		</style>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-login'>
					<form action='login.php' method='POST'>
						<div class='row'>
							<span class='label'> Username </span> &nbsp; <input type='text' name='username'>
						</div>
						<div class='row'>
							<span class='label'> Password </span> &nbsp; <input type='password' name='password'>
						</div>
						<div class='buttons'>
							<input type='submit' value='login'>
						</div>
					</form>
				</div>
			</div>
			<div id='footer'>
				&copy; &nbsp; VIT University, Chennai
			</div>
		</div>
	</body>
</html>