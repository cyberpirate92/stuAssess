<?php
	// constants 
	define("TEST_ID_RANGE_START",0);
	define("TEST_ID_RANGE_END",100000);

	class CodeQuestion
	{
		public $question,$input1,$input2,$input3,$output1,$output2,$output3;
		public function getInsertSQL($tableName)
		{
			$sql = "INSERT INTO $tableName(question,input1,input2,input3,output1,output2,output3) VALUES ('".$this->question."' , '".$this->input1."' , '".$this->input2."' , '".$this->input3."' , '".$this->output1."' , '".$this->output2."' , '".$this->output3."' )";
			return $sql;
		}
		public function setData($q,$i1,$i2,$i3,$o1,$o2,$o3)
		{
			$this->question = $q;
			$this->input1 = $i1;
			$this->input2 = $i2;
			$this->input3 = $i3;
			$this->output1 = $o1;
			$this->output2 = $o2;
			$this->output3 = $o3;
		}
	}	

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
	function test_id_exists($number) // returns TRUE if a table exists with that ID
	{
		require('db.php');
		$query = "SELECT * FROM tests WHERE test_id=$number";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0)
			return true;
		else
			return false;
	}
	function createNewMCQTestTable($username,$random,$test_name) // creates a new MCQ test table 
	{
		require('db.php');
		$table_name = "test_mcq_".$random;
		//this should be done only if test is created succesfully.
		/*mysqli_query($db,"INSERT INTO tests(faculty_id,test_id,test_name) VALUES($username,$random,'$test_name')");*/
		$query = "CREATE TABLE $table_name(questionID INT PRIMARY KEY AUTO_INCREMENT,question TEXT NOT NULL,option1 VARCHAR(250) NOT NULL,option2 VARCHAR(250) NOT NULL,option3 VARCHAR(250) NOT NULL,option4 VARCHAR(250) NOT NULL,correct_option INT NOT NULL) ENGINE=MYISAM;";
		mysqli_query($db,$query);
	}
	function createNewCodeTestTable($username,$random,$test_name) // creates a new Code Test Table 
	{
		require('db.php');
		$table_name = "test_code_".$random;
		$query = "CREATE TABLE $table_name(question TEXT NOT NULL, input1 TEXT NOT NULL, input2 TEXT NOT NULL, input3 TEXT NOT NULL,output1 TEXT NOT NULL,output2 TEXT NOT NULL,output3 TEXT NOT NULL, id INT PRIMARY KEY AUTO_INCREMENT ) ENGINE=MYISAM";
		mysqli_query($db,$query);
	}
	function isValidVariable($var) // basic validation - returns false if variable is empty or null
	{
		$var = trim($var);
		return (isset($var) && !empty($var));
	}
?>