<html>
	<head>
		<title> Template </title>
		<link rel='stylesheet' href='../css/alternate1.css'>
	</head>
	<body>
		<div id='wrapper'>
			<div id='header'>
				<div id='logo'>
					<img src='../images/logo.png' width='190' height='70'>
				</div>
				<div id='navbar-options'>
					<ul>
						<li><a href='template_new.php' class='current_page'>Home</a></li>
						<li><a href='#'>About</a></li>
						<li><a href='#'>Tests</a></li>
						<li><a href='#'>Faculty</a></li>
						<li><a href='#'>Students</a></li>
						<li><a href='../logout.php'>Logout</a></li>
					</ul>
				</div>
			</div>
			<div id='content'>
				<h3> Student Data </h3>
				<p>
					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
				</p>
				<center>
					<table cellpadding="3px" border="0" cellspacing="0px">
						<tr>
							<th>Number</th>
							<th>First Name</th>
							<th>Last Name</th>		
							<th>Points</th>
						</tr>
						<tr>
							<td>1</td>
							<td>Eve</td>
							<td>Jackson</td>		
							<td>94</td>
						</tr>
						<tr>
							<td>2</td>
							<td>John</td>
							<td>Doe</td>		
							<td>80</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Adam</td>
							<td>Johnson</td>		
							<td>67</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Jill</td>
							<td>Smith</td>		
							<td>50</td>
						</tr>
					</table>
					<br>
				</center>
				<div id='input_form'>
					<form action='#' method='POST'>
						<h2> A sample form </h2>
						<hr>
						Username: <input type='text' name='sampleText'><br>
						Password: <input type='password' name='samplePassword'><br>
						<input type='radio'> Male
						<input type='radio'> Female<br>
						<input type='submit' name='submit'>
						<hr>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>