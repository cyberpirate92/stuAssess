<html>
	<head>
		<title> Template </title>
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
		</div>
	</body>
</html>