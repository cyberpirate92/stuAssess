<html>
<?php
	require_once('faculty_login_check.php');
	require_once('util.php');
	if(!empty($_POST))
	{
		if(isset($_POST['classInfoUpload'])) // file upload form is submitted.
		{
			require_once('phpExcelReader/parse.php');
			$upload_dir = "faculty_uploads/";

			// generating name in following format : facultyID_courseCode_courseSlot
			$newFileName = getNameFromSpreadSheet($_FILES["classInfo"]["tmp_name"]);
			if($newFileName != null)
			{
				$newFileName = $newFileName.".xls";
				$target_file = $upload_dir.$newFileName;			
				if (move_uploaded_file($_FILES["classInfo"]["tmp_name"], $target_file))
				{
	        		displayJSAlert($_FILES["classInfo"]["name"]." is uploaded succesfully.");
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
		<script type='text/javascript'>
			function viewTests() {
				$('#option-test').css('color','red');
				$('#option-result').css('color','black');
				$('#option-upload').css('color','black');

				$('#tests').css('display','block');
				$('#results').css('display','none');
				$('#upload').css('display','none');
			}
			function viewResults() {
				$('#option-test').css('color','black');
				$('#option-result').css('color','red');
				$('#option-upload').css('color','black');

				$('#tests').css('display','none');
				$('#results').css('display','block');
				$('#upload').css('display','none');
			}
			function viewUpload() {
				$('#option-test').css('color','black');
				$('#option-result').css('color','black');
				$('#option-upload').css('color','red');

				$('#tests').css('display','none');
				$('#results').css('display','none');
				$('#upload').css('display','block');
			}
			function validate_upload()
			{
				var fileName = document.getElementById('uploadFile').value;
				
				if(fileName.length == 0 ) 
				{
					alert("You haven't selected a file for upload.\nPlease select a file and then click upload.");
					return false; 
				} 
			    
			    var file_extension = fileName.split('.').pop();
			    if(file_extension.toLowerCase() == "xls" )
			    	return true;
			    else if(file_extension.toLowerCase() == "xlsx")
			    {
			    	alert("You have selected a '.XLSX' file, only '.XLS' files are supported, please save the file as xls and try again.");
			    }
			    else
			    {
			    	alert("Please choose a Excel file (.xls) ");
			    }
			    return false;
			}
		</script>
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
						Tests
						<?php  
							require_once('db.php');
							
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