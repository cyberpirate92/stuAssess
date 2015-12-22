<?php
	require_once('faculty_login_check.php');
	if(!empty($_GET) && isset($_GET['id']))
	{
		$testID = $_GET['id'];
	}
	else if(!empty($_POST))
	{
		// handle the form here ... (Update tests table with provided data)
	}
	else
	{
		require_once('util.php');
		redirectTo("faculty_portal.php");
	}
?>
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
					<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
						<h2> Assign Test </h2>
						<p> 
							Select class to assign : 
							<select name='group'>
								<?php
									require("db.php");
									$query = "SELECT groupID,CourseCode,CourseSlot from groups WHERE facultyID=$username";
									$result = mysqli_query($db,$query);
									while($row=mysqli_fetch_array($result))
										echo "<option value='".$row['groupID']."'>".$row['CourseCode']." ( ".$row['CourseSlot'].") </option>";
								?>
							</select><br>
							Start Date : <input type='text' name='startdate'><br>
							Start Time : <input type='text' name='starttime'><br>
							End Date : <input type='text' name='enddate'><br>
							End Time : <input type='text' name='endtime'><br>
							<input type='submit' value='assign'> 
						</p>
					</form>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>