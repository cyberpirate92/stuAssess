<?php
	require_once('faculty_login_check.php');
	require_once('util.php');
	$currentQuestion=0;
	if(!empty($_POST))
	{
		if(isValidVariable($_POST['nQuestions']) && isValidVariable($_POST['testName']))
		{
			$nQuestions = $_POST['nQuestions'];
			$testName = $_POST['testName'];
			unset($_POST['nQuestions']);
			unset($_POST['testName']);

			$test_id = rand(constant("TEST_ID_RANGE_START"),constant("TEST_ID_RANGE_END"));
			while(test_id_exists($test_id))
			{
				$test_id = rand(constant("TEST_ID_RANGE_START"),constant("TEST_ID_RANGE_END"));
			}

			$_SESSION['_questionNumber'] = 0;
			$_SESSION['_totalQuestions'] = $nQuestions;
			$_SESSION['_test_id'] = $test_id;
			$_SESSION['_test_name'] = $testName;

			createNewCodeTestTable($username,$test_id,$testName);
		}
		else
		{
			if(!isset($_SESSION['_totalQuestions']) || !isset($_SESSION['_test_id']))
			{
				/* if the number of questions or test id has not been set, then redirect to the portal page */
				unset($_SESSION["_totalQuestions"]);
				unset($_SESSION["_questionNumber"]);
				unset($_SESSION["_test_id"]);
				unset($_SESSION["_test_name"]);
				redirectTo("faculty_portal.php");
				header('Location: faculty_portal.php');
				die('');
			}
			else
			{
				if(!isset($_SESSION['_questionNumber']))
				{
					$_SESSION['_questionNumber'] = 0;
				}
				else
				{
					$currentQuestion = $_SESSION['_questionNumber'];
				}
				$errors = array();
				if(!isValidVariable($_POST['question']))
				{
					array_push($errors, "Question cannot be empty");
				}
				if(!isValidVariable($_POST['input1']))
				{
					array_push($errors, "Testcase-1 input cannot be empty");
				}
				if(!isValidVariable($_POST['output1']))
				{
					array_push($errors, "Testcase-1 output cannot be empty");
				}
				if(!isValidVariable($_POST['input2']))
				{
					array_push($errors, "Testcase-2 input cannot be empty");
				}
				if(!isValidVariable($_POST['output2']))
				{
					array_push($errors, "Testcase-2 output cannot be empty");
				}
				if(!isValidVariable($_POST['input3']))
				{
					array_push($errors, "Testcase-3 input cannot be empty");
				}
				if(!isValidVariable($_POST['output3']))
				{
					array_push($errors, "Testcase-3 output cannot be empty");
				}
				if(empty($errors))
				{
					// database operations...
					require("db.php");
					$tableName = "test_code_".$_SESSION['_test_id'];
					$currentQuestion = $_SESSION['_questionNumber'];
					$question_obj = new CodeQuestion();
					$question_obj->setData($_POST['question'],$_POST['input1'],$_POST['input2'],$_POST['input3'],$_POST['output1'],$_POST['output2'],$_POST['output3']);
					$sql = $question_obj->getInsertSQL($tableName);
					mysqli_query($db,$sql);
					mysqli_close($db);
					$currentQuestion++;
					$_SESSION['_questionNumber'] = $currentQuestion;
					if($_SESSION['_questionNumber'] >= $_SESSION['_totalQuestions'])
					{
						// All questions have been created, now add the entry to the tests table and redirect to the portal page.
						require("db.php");
						$query = "INSERT INTO tests (faculty_id,test_id,test_name,test_type) VALUES($username,".$_SESSION['_test_id'].",'".$_SESSION['_test_name']."','CODE')";
						mysqli_query($db,$query);
						mysqli_close($db);
						echo "<script>alert('Test Added Successfully.'); window.location='faculty_portal.php'</script>";
					}
				}
				else
				{
					echo "<div class='error'>";
					echo "<h3> Please correct these errors before proceeding to the next question </h3>.<br>";
					echo "<ul class='error-list'>";
					foreach($errors as $error)
					{
						echo "<li>$error</li>";
					}
					echo "</ul>";
					echo "</div>";
				}
			}
		}
	}
	else
	{
		redirectTo('faculty_portal.php');
	}
?>
<html>
	<head>
		<title> Student Assesment </title>
		<link rel='stylesheet' href='css/base.css'>
		<script src='js/jquery-2.1.4.min.js' type='text/javascript'></script>
	</head>
	<body>
		<div id='wrapper'>
			<?php require_once('header.php'); ?>
			<div id='content'>
				<div id='content-main'>
					<h2> Question Number : <?php echo ($currentQuestion+1); ?> </h2>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
						<h2> Question: </h2>
						<textarea name='question' rows='10' cols='60'><?php /*TODO: if already entered, fill this*/ ?></textarea>
						
						<div class='testcase-block'>
							<h2> Testcase 1: </h2>
							<h3> Input: </h3>
							<textarea name='input1' rows='10' cols='25'><?php /*TODO: if already entered, fill this */?></textarea>
							Output:
							<textarea name='output1' rows='10' cols='25'><?php /*TODO: if already entered, fill this */?></textarea>
						</div>

						<div class='testcase-block'>
							<h2> Testcase 2: </h2>
							<h3> Input: </h3>
							<textarea name='input2' rows='10' cols='25'><?php //TODO: if already entered, fill this ?></textarea>
							Output:
							<textarea name='output2' rows='10' cols='25'><?php //TODO: if already entered, fill this ?></textarea>
						</div>

						<div class='testcase-block'>
							<h2> Testcase 3: </h2>
							<h3> Input: </h3>
							<textarea name='input3' rows='10' cols='25'><?php //TODO: if already entered, fill this ?></textarea>
							Output:
							<textarea name='output3' rows='10' cols='25'><?php //TODO: if already entered, fill this ?></textarea>
						</div>

						<input type='submit' value='Save &amp; Continue'>
					</form>
				</div>
			</div>
			<div id='footer'>
				&copy; VIT University Chennai
			</div>
		</div>
	</body>
</html>