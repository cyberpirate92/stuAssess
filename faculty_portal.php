<html>
<?php
	require_once('faculty_login_check.php');
	require_once('util.php');
	if(!empty($_POST))
	{
		if(isset($_POST['classInfoUpload'])) // file upload form is submitted.
		{
			require_once('parse.php');
			$upload_dir = "faculty_uploads/";

			// generating name in following format : facultyID_courseCode_courseSlot
			$newFileName = getNameFromSpreadSheet($_FILES["classInfo"]["tmp_name"],$_SESSION['username']);
			if($newFileName != null)
			{
				$newFileName = $newFileName.".xls";
				$target_file = $upload_dir.$newFileName;			
				if (move_uploaded_file($_FILES["classInfo"]["tmp_name"], $target_file))
				{
	        		displayJSAlert($_FILES["classInfo"]["name"]." is uploaded succesfully.");
	        		storeInDB($target_file);
				}
	    		else
	    		{ 
	        		displayJSAlert("Sorry, there was an error uploading your file.\n Please try again.");
	        	}
	        }
	        else
	        {
	        	displayJSAlert("Sorry, the file uploaded is invalid, please try again");
	        }
		}
	}
?>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
		<script type='text/javascript' src='js/faculty_portal.js'></script>
		<style type='text/css'>
			input[type='file']
			{
				border:1px solid black;
			}
		</style>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					<ul>
						<li id='option-test' onclick="viewTests()"> Create Test </li>
						<li id='option-result' onclick="viewResults()"> Test Reports </li>
						<li id='option-upload' onclick="viewUpload()"> Add New class </li>
					</ul>
				</div>
				<div id='content-main'>
					<div id='tests'>
						
						<div class='block'>
							<h3> Upload MCQ Test </h3>
							<form action='#' method='POST'>
								File: <input type="file" name='mcq_test_file'>
								<input type='submit' value='Upload MCQ Test'>
							</form>
						</div>

						<div class='block'>
							<h3> Create Code Test online </h3>
							<form action='createCodeTest.php' method='POST'>
								Questions: <input type='text' name='nQuestions'><br>
								Test Name: <input type='text' name='testName'>
								Test Duration : <input type='text' name='testDuration'>
								<input type='submit' value='Go'>
							</form>
						</div>

						<div class='block'>
							<h3> Tests Created </h3>
							<?php
								require("db.php");
								require_once("util.php");
								$query = "SELECT test_id,test_name,test_type,test_duration FROM tests WHERE faculty_id=$username";
								$result = mysqli_query($db,$query);
								if(mysqli_num_rows($result) > 0)
								{
									$count = 1;
									echo "<table class='standardTable left10 top5' width='50%' cellspacing='0px'>";
									echo "<tr>";
									echo "<th> S.NO </th>";
									echo "<th> Test Name </th> ";
									echo "<th> Test ID </th>";
									echo "<th> Test Type </th>";
									echo "<th> Test Duration </th>";
									echo "</tr>";
									while($row=mysqli_fetch_array($result))
									{
										$testID = $row['test_id']; // for viewing a particular test.
										echo "<tr>";
										echo "<td>".($count++)."</td>";
										echo "<td> <a href='viewTest.php?id=$testID'> ".$row['test_name']." </a> </td>";
										echo "<td>".$row['test_id']."</td>";
										echo "<td>".$row['test_type']."</td>";
										echo "<td>".getTimeString($row['test_duration'])."</td>";
										echo "</tr>";
									}
									echo "</table>";
								}
								else
								{
									echo "<p>  The tests you create will appear here. </p>";
								}
								mysqli_close($db);
							?>
						</div>

						<div class='block'>
							<h3> Tests Assigned </h3>
							<?php
								require("db.php");
								$query = "SELECT * FROM tests WHERE faculty_id=$username AND group_id!=''";
								$result = mysqli_query($db,$query);
								if(mysqli_num_rows($result) > 0)
								{
									$count = 1;
									echo "<table class='standardTable left10 top5' width='75%' cellspacing='0px'>";
									echo "<tr>";
									echo "<th> S.NO </th>";
									echo "<th> Test Name </th> ";
									echo "<th> Test ID </th>";
									echo "<th> Test Type </th>";
									echo "<th> Class Assigned </th>";
									echo "<th> Test Start Date </th>";
									echo "<th> Test End Date </th>";
									echo "</tr>";

									while($row=mysqli_fetch_array($result))
									{
										$testID = $row['test_id']; // for viewing a particular test.
										$class_assigned = getCourseCodeAndSlot($row['group_id'],$username); // function def in util.php
										$start_time = new DateTime($row['start_time']);
										$end_time = new DateTime($row['end_time']);
										echo "<tr>";
										echo "<td>".($count++)."</td>";
										echo "<td> ".$row['test_name']."</td>";
										echo "<td>".$row['test_id']."</td>";
										echo "<td>".$row['test_type']."</td>";
										echo "<td>".$class_assigned."</td>";
										echo "<td>".$start_time->format("d/M/Y H:m")."</td>";
										echo "<td>".$end_time->format("d/M/Y H:m")."</td>";
										echo "</tr>";
									}
									echo "</table>";
								}
								else
								{
									echo "<p> You have not assigned any tests yet </p>";
								}
								mysqli_close($db);
							?>
						</div>
					</div>
					<div id='results'>
						Results
					</div>
					<div id='upload'>
						<p> Please upload class info here </p>
						<form action='faculty_portal.php' method='POST' enctype='multipart/form-data' onsubmit="return validate_upload()">
							<input type='file' name='classInfo' id='uploadFile'>
							<input type='submit' name='classInfoUpload' value='upload'>
						</form>
					</div>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University, Chennai
			</div>
		</div>
	</body>
</html>