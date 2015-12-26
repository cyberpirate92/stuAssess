<?php
	if(!empty($_POST))
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			require_once("../db.php");
			$errors = null;
			$username = mysqli_real_escape_string($db,$_POST['username']);
			$password = md5(mysqli_real_escape_string($db,$_POST['password']));
			$query = "SELECT * FROM admin_login WHERE username='$username' AND password='$password'";
			$result = mysqli_query($db,$query);
			if(mysqli_num_rows($result) > 0)
			{
				require_once('../util.php');
				if(session_status() == PHP_SESSION_ACTIVE) // invalidate previous session (if any)
				{
					session_unset();
				}
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['access_level'] = "admin";
				mysqli_close($db);
				redirectTo('manage.php');
			}
			else
			{
				$errors = "Invalid Login";
			}
			mysqli_close($db);
		}
	}
?>
<html>
	<head>
		<title> Admin Login </title>
		<link href='../css/alternate.css' rel='stylesheet'>
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
						<img src='../images/logo.png' width='190' height='70'>
						<hr>
						<h2> Login </h2>
						<form action='login.php' method='POST'>
							<input type='text' name='username' placeholder='username'>
							<input type='password' name='password' placeholder='password'><br>
							<input type='submit' value='login'>
						</form>
					</center>
				</div>
				</center>
			</div>
			<?php
				if(!empty($errors))
				{
					require_once('../util.php');
					displayError($errors);
				}
			?>
		</div>
	</body>
</html>