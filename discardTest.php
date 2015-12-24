<?php
	require_once('faculty_login_check.php');
	require_once('util.php');
	if(isset($_SESSION['_test_id']))
	{
		$testID = $_SESSION["_test_id"];
		$testType = $_SESSION['_test_type'];
		$tableName = null;
		
		if($testType == "CODE")
			$tableName = "test_code_".$testID;
		else if($testType == "MCQ")
			$tableName = "test_mcq_".$testID;

		deleteTable($tableName);
		redirectTo("faculty_portal.php");
	}
	else
	{
		session_unset();
		redirectTo('login.php');
	}
?>