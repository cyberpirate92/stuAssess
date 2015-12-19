<!-- Refer for documentation [jquery-timepicker-addon] : http://trentrichardson.com/examples/timepicker/ -->
<?php
	require_once('faculty_login_check.php');
	require_once('util.php');
	if(!empty($_GET))
	{
		require_once("db.php");
		$ID = $_GET['id'];

		// checking if the groupID indeed belongs to this faculty
		$result = mysqli_query($db,"SELECT facultyID FROM groups WHERE groupID='$ID'");
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			if($row['facultyID'] != $username)
			{
				// the groupID does not belong to this faculty!
				session_destroy();
				redirectTo('logout.php');
				die('');
			}
			else
			{
				// groupID belongs to this faculty, safe to continue here
				// TODO:
			}
		}
		else
		{
			// groupID does not exist in the Database ! (might not happen, but still...)
			session_destroy();
			redirectTo('logout.php');
			die('');
		}
	}
	else
	{
		require_once('util.php');
		redirectTo('faculty_portal.php');
	}
?>
<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script type='text/javascript' src='js/jquery-2.1.4.min.js'></script>
		<script></script>
		<link rel='stylesheet' href='js/jquery-ui-1.11.4/jquery-ui.min.css'>
		<link rel='stylesheet' href='css/jquery.jquery-ui-timepicker-addon.min.css'>
		<script type='text/javascript' src='js/jquery-ui-1.11.4/jquery-ui.min.js'></script>
		<script type='text/javascript' src='js/jquery-ui-timepicker-addon.min.js'></script>
		<script type='text/javascript'>
			$(function(){
				var x = document.createElement("input");
				x.setAttribute("type","date");
				if(x.type != "date")
				{
					$("#startDate").datepicker({minDate:+0,maxDate:+30});
					$("#endDate").datepicker({minDate:+0,maxDate:+30});
				}

				x = document.createElement("input");
				x.setAttribute("type","time");
				if(x.type != "time")
				{
					$("#startTime").timepicker({disableTextInput:true});
					$("#endTime").timepicker();
				}
			});

			function debug()
			{
				var startDate = convertToString($("#startDate").datepicker("getDate"));
				var endDate = convertToString($("#endDate").datepicker("getDate"));
				alert(startDate+" to "+endDate);
			}

			function convertToString(dateObj)
			{
				return dateObj.getDate()+"/"+(dateObj.getMonth()+1)+"/"+dateObj.getFullYear();
			}

			function setMinEndDate(obj)
			{
				var _MAX = 30;  // maximum number of days which a test could be active
				var startDate = $(obj).datepicker("getDate");
				var endDate = $(obj).datepicker("getDate");

				endDate.setDate(startDate.getDate() + _MAX);

				$("#endDate").datepicker("destroy");
				$("#endDate").datepicker({minDate:startDate,maxDate:endDate});
			}
		</script>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					<!-- TODO: get input for number of questions and other data (time, date etc..) and display question number boxes -->
					<!-- ALSO: don't forget to add questions via excel file for more flexibility -->
					<form action='createMCQTest.php' method='POST'>
						<div id='preQuestion'>
							<div class='datetime'>
								<p class='block-title'> Test Start </p>
								<input type='date' name='startDate' placeholder='Date' id='startDate' onchange="setMinEndDate(this)" />
								<input type='time' name='startTime' placeholder='Time' id='startTime' />
							</div>
							<div class='datetime'>
								<p class='block-title'> Test End </p>
								<input type='date' name='endDate' placeholder='Date' id='endDate' />
								<input type='time' name='endTime' placeholder='Time' id='endTime' />
							</div>
							<div>
								Number of Questions : <input type='number' min='1' step='1' max='50' name='nQuestions'>
							</div>
							<div>
								<input type='button' onclick="debug()" value='debug'>
								<input type='submit' value='Go'>
							</div>
						</div>
					</form>
				</div>
				<div id='content-main'>
					<!-- TODO: Questions can be added here after providing input for number of questions and other required info-->
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>