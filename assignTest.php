<!--
	===EXTERNAL LIBRARIES USED===
	The following open source libraries are used...
		1) Pikaday (https://github.com/dbushell/Pikaday) - Lightweight date picker library
		2) MomentJS (https://github.com/moment/moment/)  - A JS Library for formatting native JS Date objects

	===JAVASCRIPT===
	While setting date for test start and end,
		1) The start date should not be before the current day.
		2) The end date must not be less than the start date.
		3) The start time must not be less than the current time.
		4) The end time must not be less than the start time
		5) The difference between end date-time and start date-time must be ATLEAST 2 minutes
	
	===PHP===
	In the PHP Part, In addition to all the above checks,
		1) The date and time are seperate, they should be combined into a single entity for inserting into the database table which is of DATETIME datatype
		2) Make sure while inserting that the test start date,time has not crossed the current date,time.
-->
<?php
	require_once('faculty_login_check.php');
	if(!empty($_GET) && isset($_GET['id']))
	{
		$testID = $_GET['id'];
		if(session_status() != PHP_SESSION_ACTIVE)
			session_start();
		$_SESSION['_test_id'] = $testID; // this is used later...
	}
	else if(!empty($_POST))
	{
		// handle the form here ... (Validate, Update tests table with provided data)
		require_once('util.php');
		$errors = array();
		if(!isValidVariable($_POST['group']))
		{
			array_push($errors, "Class cannot be empty");
		}
		if(!isValidVariable($_POST['startdate']))
		{
			array_push($errors, "Start Date cannot be empty");
		}	
		if(!isValidVariable($_POST['starttime_hours']) || !isValidVariable($_POST['starttime_mins']))
		{
			array_push($errors, "Start Time is invalid");
		}	
		if(!isValidVariable($_POST['enddate']))
		{
			array_push($errors, "End date cannot be empty");
		}
		if(!isValidVariable($_POST['endtime_hours']) || !isValidVariable($_POST['endtime_mins']))
		{
			array_push($errors, "End time cannot is invalid");
		}
		if(empty($errors))
		{
			$groupID = $_POST['group'];
			$startDate = $_POST['startdate'];
			$startTime_hours = $_POST['starttime_hours'];
			$startTime_mins = $_POST['starttime_mins'];
			$endDate = $_POST['enddate'];
			$endTime_hours = $_POST['endtime_hours'];
			$endTime_mins = $_POST['endtime_mins'];

			/* for debugging....
			var_dump($groupID);
			var_dump($startDate);
			var_dump($startTime_hours);
			var_dump($startTime_mins);
			var_dump($endDate);
			var_dump($endTime_hours);
			var_dump($endTime_mins);
			*/

			$Start_DateTime = new DateTime(convertDateFormat($startDate)." ".$startTime_hours.":".$startTime_mins.":0");
			$End_DateTime   = new DateTime(convertDateFormat($endDate)." ".$endTime_hours.":".$endTime_mins.":0");
			if($Start_DateTime >= $End_DateTime)
			{
				var_dump($Start_DateTime);
				var_dump($End_DateTime);
				array_push($errors,"Start Date must be before end date");
			}
			else
			{
				if(isset($_SESSION['_test_id']))
				{
					// write to tests table...
					$Start_DateTime = $Start_DateTime->format("Y-m-d H:i:s");
					$End_DateTime = $End_DateTime->format("Y-m-d H:i:s");
					require("db.php");
					$testID = $_SESSION['_test_id'];
					$query = "UPDATE tests SET group_id=$groupID,start_time='$Start_DateTime',end_time='$End_DateTime' WHERE test_id=$testID AND faculty_id=$username";
					echo "<script>console.log('".addslashes($query)."');</script>";
					echo "<script>console.log('$testID')</script>";
					echo "<script>console.log('".$_SESSION['_test_id']."')</script>";
					mysqli_query($db,$query);
					echo "<script>alert('Test Assigned succesfully.');window.location='faculty_portal.php';</script>";
				}
				else
				{
					// login again and try,... something went wrong, no session variable
				}
			}
		}
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
		<link rel='stylesheet' href='Pikaday/css/pikaday.css'>
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
						// dislay errors if any...
						if(!empty($errors))
						{
							echo "<ul id='errors'>";
							foreach($errors as $error)
							{
								echo "<li>".$error."</li>";
							}
							echo "</ul>";
						}
					?>
					<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' onsubmit='confirmDates()'>
						<h2> Assign Test </h2>
						<p> 
							Select class to assign : 
							<select name='group' id='selected_class'>
								<?php
									require("db.php");
									$query = "SELECT groupID,CourseCode,CourseSlot from groups WHERE facultyID=$username";
									$result = mysqli_query($db,$query);
									while($row=mysqli_fetch_array($result))
										echo "<option value='".$row['groupID']."'>".$row['CourseCode']." ( ".$row['CourseSlot'].") </option>";
								?>
							</select><br>
							Start Date : <input type='text' name='startdate' id='start_date_picker' onchange="adjust()"><br>
							Start Time : 
							<select name='starttime_hours' id='starttime_hours'> <?php for($i=0;$i<24;$i++) { echo "<option value='$i'>$i</option>"; } ?> </select>
							<select name='starttime_mins' id='starttime_mins'> <?php for($i=0;$i<60;$i+=5) { echo "<option value='$i'>$i</option>"; } ?> </select>
							<br>
							End Date : <input type='text' name='enddate' id='end_date_picker' disabled><br>
							End Time : 
							<select name='endtime_hours' id='endtime_hours'> <?php for($i=0;$i<24;$i++) { echo "<option value='$i'>$i</option>"; } ?> </select>
							<select name='endtime_mins' id='endtime_mins'> <?php for($i=0;$i<60;$i+=5) { echo "<option value='$i'>$i</option>"; } ?> </select>
							<br>
							<input type='submit' value='assign'> 
						</p>
					</form>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>

		<script src='js/moment.min.js' type='text/javascript'></script>
		<script src='Pikaday/pikaday.js' type='text/javascript'></script>
		<script type='text/javascript'>
			var currentDate = new Date();
		    var start_date_picker = new Pikaday(
		    {
		        field: document.getElementById('start_date_picker'),
		        firstDay: 1,
		        minDate: currentDate,
		        format:'D-MM-YYYY',
		        maxDate: new Date(currentDate.getFullYear(), 12, 31),
		        yearRange: [currentDate.getFullYear(),currentDate.getFullYear()+1]
		    });

			var end_date_picker = new Pikaday(
		    {
		        field: document.getElementById('end_date_picker'),
		        firstDay: 1,
		        minDate: currentDate,
		        format:'D-MM-YYYY',
		        maxDate: new Date(currentDate.getFullYear(), 12, 31),
		        yearRange: [currentDate.getFullYear(),currentDate.getFullYear()+1]
		    });

		    function adjust()
		    {
		    	if(start_date_picker.getDate() != null)
		    	{
		    		end_date_picker.setDate(start_date_picker.getDate());
		    		end_date_picker.setMinDate(start_date_picker.getDate());
		    		document.getElementById("end_date_picker").disabled = false;
		    	}
		    	else
		    	{
		    		if(end_date_picker.getDate() == null || end_date_picker.getDate() - start_date_picker.getDate() < 0 )
		    		{
		    			end_date_picker.setDate(start_date_picker.getDate());
		    		}
		    	}
		    }		    
		    function confirmDates()
		    {
		    	var selectedClass = document.getElementById("selected_class").value;
		    	var StartDate = start_date_picker.getDate();
		    	var StartHours = document.getElementById("starttime_hours").value;
		    	var StartMins = document.getElementById("starttime_mins").value;
		    	var EndDate = end_date_picker.getDate();
		    	var EndHours = document.getElementById("endtime_hours").value;
		    	var EndMins = document.getElementById("endtime_mins").value;
		    	
		    	StartDate.setHours(StartHours);
		    	StartDate.setMinutes(StartMins);
		    	EndDate.setHours(EndHours);
		    	EndDate.setMinutes(EndMins);

		    	var StartDateString = StartDate.getDate() + "/" + StartDate.getMonth() + "/" + StartDate.getFullYear() + ", "+ StartDate.getHours() + ":"+StartDate.getMinutes();
		    	var EndDateString = EndDate.getDate() + "/" + EndDate.getMonth() + "/" + EndDate.getFullYear() + ", "+ EndDate.getHours() + ":"+EndDate.getMinutes();

		    	var str = "Selected Class : "+selectedClass;
		    	str+="\n Test Start Date :"+StartDateString;
		    	str+="\n Test End Date : "+EndDateString;
		    	str+="\n Press yes to assign the test or no to modify the information.";

		    	return confirm(str);
		    }
		</script>
	</body>
</html>