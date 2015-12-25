<?php
	include('util.php');
	if(!empty($_POST))
	{
		require_once('db.php');
		require_once('util.php');
		$username = mysqli_real_escape_string($db,strtoupper(trim($_POST['username'])));
		$password = mysqli_real_escape_string($db,$_POST['password']);

		if(strlen($username) == 0 || strlen($password) == 0)
		{
			displayError1('Invalid Username/Password');
		}
		else
		{
			$password = md5($password);
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
				displayError1('Invalid username/password.');
			}
		}
	}
?>
<html>
	<head>
		<title> Template </title>
		<link href='css/alternate.css' rel='stylesheet'>
		<style type='text/css'>
			div#content
			{
				background:rgba(0,0,0,0);
				padding:5%;
			}
		</style>
	</head>
	<body>
		<div id='wrapper'>
			<div id='content'>
				<center>
					<div id='loginBlock' class='whiteText'>
						<center>
							<img src='images/logo.png' width='190' height='70'>
							<hr>
							<h2> Login </h2>
							<form action='<?php echo $_SERVER['PHP_SELF'];?>' method='POST'>
								<input type='text' name='username' placeholder='username' id='username'>
								<input type='password' name='password' placeholder='password' id='password'><br>
								<input type='submit' value='login'>
							</form>
						</center>
					</div>
				</center>
			</div>
		</div>
	</body>
</html>