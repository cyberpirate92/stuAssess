<?php
	function displayJSAlert($msg)
	{
		echo "<script type='text/javascript'> alert('$msg') </script>";
	}
	function redirectTo($location)
	{
		header("Location: $location");
	}
	function renameSpreadsheet($fieldName) // $fieldName is the name given in the form for the file upload field.
	{
		
	}
	function table_exists($table_name)
	{
		require("db.php");
		$result = mysqli_query($db,"SHOW TABLES LIKE '$table_name'");
		if(mysqli_num_rows($result) > 0)
			return (bool)TRUE;
		else
			return (bool)FALSE;
	}
	function test_id_exists($number)
	{
		require('db.php');
		$query = "SELECT * FROM tests WHERE test_id=$number";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0)
			return true;
		else
			return false;
	}
	function createNewTestTable($username,$random,$test_name)
	{
		require('db.php');
		$table_name = "test_".$random;
		mysqli_query($db,"INSERT INTO tests(faculty_id,test_id,test_name) VALUES($username,$random,'$test_name')");
		$query = "CREATE TABLE $table_name(questionID INT PRIMARY KEY AUTO_INCREMENT,question TEXT NOT NULL,option1 VARCHAR(250) NOT NULL,option2 VARCHAR(250) NOT NULL,option3 VARCHAR(250) NOT NULL,option4 VARCHAR(250) NOT NULL,correct_option INT NOT NULL) ENGINE=MYISAM;";
		mysqli_query($db,$query);
	}
?>