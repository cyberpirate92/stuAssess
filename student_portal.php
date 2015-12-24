<?php
	require_once('student_login_check.php');
?>
<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
		<script type='text/javascript' src='js/student_portal.js'></script>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-sidebar'>
					<ul>
						<li id='option-test' onclick="viewTests()"> Tests </li>
						<li id='option-result' onclick="viewResults()"> Results </li>
					</ul>
				</div>
				<div id='content-main'>
					<div id='tests'>
						<h3> Tests </h3>
						<?php  
							require_once('db.php');
							require_once('util.php');
							$temp_count = 0;
							$result = mysqli_query($db,"SELECT groupID FROM student_group WHERE username='$username'");
							$groups = array(); // stores the groups the student belongs to...
							while($row = mysqli_fetch_array($result))
							{
								array_push($groups, $row['groupID']);
							}
							echo "<table class='standardTable left10 top5' width='75%' cellspacing='0px'>";
							echo "<tr>";
							echo "<th> S.No </th>";
							echo "<th> Test Name </th>";
							echo "<th> Subject </th>";
							echo "<th> Test Date </th>";
							echo "<th> Start Time </th>";
							echo "<th> Test Duration </th>";
							echo "<th> Test Type </th>";
							echo "</tr>";	
							foreach($groups as $group)	
							{
								$result = mysqli_query($db,"SELECT * FROM tests WHERE group_id=$group");
								while($row=mysqli_fetch_array($result))
								{
									$temp_count++;
									$start = new DateTime($row['start_time']);
									$end = new DateTime($row['end_time']);
									$duration = $end->diff($start);
									$subject = getCourseCode($row['group_id']);
									echo "<tr>";
									echo "<td>".$temp_count."</td>";
									echo "<td>".$row['test_name']."</td>";
									echo "<td>".$subject."</td>";
									echo "<td>".$start->format('d M Y')."</td>";
									echo "<td>".$start->format('H:m')."</td>";
									//echo "<td>".$duration->days." Days,".$duration->h." hours</td>";
									echo "<td>".getTimeString($row['test_duration'])."</td>";
									echo "<td>".$row['test_type']."</td>";
									echo "</tr>";
								}
							}
							if($temp_count <= 0)
							{
								echo "<td colspan='7'> No Tests Yet </td>";
							}
							echo "</table>";
						?>
					</div>
					<div id='results'>
						
					</div>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University, Chennai
			</div>
		</div>
	</body>
</html>