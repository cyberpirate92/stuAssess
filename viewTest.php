<!-- This page is used to view a particular test (faculty)-->
<?php
	require_once('faculty_login_check.php');
	if(!empty($_GET) && isset($_GET['id']))
	{
		$testID = $_GET['id'];
		$table_html = false;
		// test id should be numeric, must not contain alphabets or other chars
		if(preg_match('/^\d+$/',$_GET['id']))
		{
			require("db.php");
			// first, checking if the test ID is a valid ID by looking at the tests table.
			$query = "SELECT test_type FROM tests WHERE faculty_id=$username AND test_id=$testID";
			echo "<script>console.log('$query')</script>";
			$result = mysqli_query($db,$query);
			if(mysqli_num_rows($result) > 0)
			{
				while($row=mysqli_fetch_array($result))
				{
					$testType = $row['test_type'];
					if(empty($testType))
					{
						require_once("util.php");
						redirectTo("login.php");
					}
					else
					{
						$prefix = ($testType == "CODE") ? "test_code_" : "test_mcq_";
						$table_name = $prefix.$testID;

						// now check if the table exists in the database
						$query = "SELECT table_name FROM information_schema.tables WHERE table_schema='ASR' AND table_name='$table_name'";
						$r = mysqli_query($db,$query);
						if(mysqli_num_rows($r) > 0)
						{
							// table exists, now display the questions and testcases
							/* TODO: display questions and testcases here */
							unset($r);
							$query = "SELECT * FROM $table_name";
							$r = mysqli_query($db,$query);
							if(mysqli_num_rows($r) > 0)
							{
								$table_html = "<table class='standardTable left20 top5' width='75%' cellspacing='0px'>";
								$table_html.= "<tr>";
								$table_html.= "<th>S.No</th>";
								$table_html.= "<th>Question </th>";
								$table_html.= "<th colspan='2'>Testcase 1</th>";
								$table_html.= "<th colspan='2'>Testcase 2</th>";
								$table_html.= "<th colspan='2'>Testcase 3</th>";
								$table_html.= "</tr>";
								$table_html.= "<tr>";
								$table_html.= "<td>&nbsp;</td>";
								$table_html.= "<td>&nbsp;</td>";
								for($i=0;$i<3;$i++)
								{
									$table_html.= "<th>Input</th>";
									$table_html.= "<th>Output</th>";
								}
								$table_html.= "</tr>";
								while($table_row = mysqli_fetch_array($r))
								{
									$table_html.= "<tr>";
									$table_html.= "<td>".$table_row['id']."</td>";
									$table_html.= "<td>".$table_row['question']."</td>";
									$table_html.= "<td>".$table_row['input1']."</td>";
									$table_html.= "<td>".$table_row['output1']."</td>";
									$table_html.= "<td>".$table_row['input2']."</td>";
									$table_html.= "<td>".$table_row['output2']."</td>";
									$table_html.= "<td>".$table_row['input3']."</td>";
									$table_html.= "<td>".$table_row['output3']."</td>";
									$table_html.= "</tr>";
								}
								$table_html.= "</table>";
							}
							else
							{
								$table_html = "<p> No questions </p> ";
							}
						}
						else
						{
							require_once('util.php');
							// table doesn't exist, delete the entry from tests table and redirect back to the portal page
							$query = "DELETE FROM tests WHERE test_id=$testID AND faculty_id=$username";
							mysqli_query($db,$query);
							redirectTo("faculty_portal.php");
						}
					}
				}
			}
			else
			{
				require_once("util.php");
				echo "<script> console.log('so dumb'); </script>";
				//redirectTo("login.php");
			}
		}
		else
		{
			// invalid test ID, redirect to login page
			require_once('util.php');
			redirectTo("login.php");
		}
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
					<?php
						if(!empty($table_html))
							echo $table_html;
					?>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>