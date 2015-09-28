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
						<?php  
							require_once('db.php');
							$rowCount = 1;
							$result = mysqli_query($db,"SELECT * FROM groups WHERE facultyID='$username'");
							echo "<table class='standardTable left10 top5' width='50%' cellspacing='0px'>";
							echo "<tr>";
							echo "<th> Sl.No</th>";
							echo "<th> Course Code </th>";
							echo "<th> Course Slots </th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "</tr>";
							while($row = mysqli_fetch_array($result))
							{
								$courseCode = $row['CourseCode'];
								$courseSlot = $row['CourseSlot'];
								$link = "createMCQTest.php?id=".$row['groupID'];
								$link1 = "createCodeTest.php?id=".$row['groupID'];
								echo "<tr><td> $rowCount </td><td> $courseCode </td> <td> $courseSlot </td> <td> <a href='$link'><button>Create MCQ Test</button><a></td> <td> <a href='$link1'><button>Create Code Test</button><a></td> </tr>";
								$rowCount++;
							}
							echo "</table>";
						?>
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