<?php
	if(!empty($_POST))
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			require_once('../util.php');
			if(isValidLogin("admin",$_POST['username'],$_POST['password']))
			{
				secure_session_destroy();
				secure_session_start();
				$_SESSION['username'] = trim($_POST['username']);
				$_SESSION['access_level'] = "admin";
				redirectTo('manage.php');
			}
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