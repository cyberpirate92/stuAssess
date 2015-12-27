<?php
	if(!empty($_POST))
	{
		require_once('util.php');
		$username = strtoupper($_POST['username']);
		$password = $_POST['password'];
		$loginType = isFacultyOrStudent($username);
		if(isValidLogin($loginType,$username,$password))
		{
			secure_session_destroy();
			secure_session_start();
			$_SESSION['username'] = $username;
			$_SESSION['type'] = $loginType;
			$redirectPage = "";
			if($loginType == "faculty")
				$redirectPage = "faculty_portal.php";
			else
				$redirectPage = "student_portal.php";
			redirectTo($redirectPage);
		}
		else
		{
			displayError1("Invalid Login");
		}
	}
?>
<html>
	<head>
		<title> Login </title>
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