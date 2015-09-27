<?php
	require_once('student_login_check.php');
?>
<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
		<script type='text/javascript'>
			function viewTests() {
				$('#option-test').css('color','red');
				$('#option-result').css('color','black');
				
				$('#tests').css('display','block');
				$('#results').css('display','none');
			}
			function viewResults() {
				$('#option-test').css('color','black');
				$('#option-result').css('color','red');

				$('#tests').css('display','none');
				$('#results').css('display','block');
			}
		</script>
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
						<?php  

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