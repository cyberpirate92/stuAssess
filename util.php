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
			// use of mysqli_real_escape_string escapes special characters so that they dont lead to SQL injections
			require("db.php");
			$this->question = mysqli_real_escape_string($db,$q);
			$this->input1 = mysqli_real_escape_string($db,$i1);
			$this->input2 = mysqli_real_escape_string($db,$i2);
			$this->input3 = mysqli_real_escape_string($db,$i3);
			$this->output1 = mysqli_real_escape_string($db,$o1);
			$this->output2 = mysqli_real_escape_string($db,$o2);
			$this->output3 = mysqli_real_escape_string($db,$o3);
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
	function convertDateFormat($dateString) // convert date format from dd-mm-yyyy to yyyy-mm-dd
	{
		if(preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateString)) // is the string matching the dd-mm-yyyy pattern ?
		{
			$dateString = trim($dateString);
			$tokens = explode("-", $dateString);
			return $tokens[2]."-".$tokens[1]."-".$tokens[0];
		}
		else // ERROR: the string dies not follow the pattern
		{
			return null;
		}
	}
	function getCourseCodeAndSlot($groupID,$facultyID) // returns the CourseCode+Slot string, for the provided groupID from the groups table
	{
		require("db.php");
		$query = "SELECT CourseCode, CourseSlot FROM groups WHERE groupID=$groupID AND facultyID=$facultyID";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			$return_value = $row['CourseCode']." (".$row['CourseSlot'].")";
			mysqli_close($db);
			return $return_value;
		}
		else
		{
			mysql_close($db);
			return null;
		}
	}
	function getCourseCode($groupID) // for use in student_portal
	{
		require("db.php");
		$query = "SELECT CourseCode FROM groups WHERE groupID=$groupID";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			mysqli_close($db);
			return $row['CourseCode'];
		}
		else
		{
			mysql_close($db);
			return null;
		}
	}
	function getTimeString($time_in_mins) // returns a string of the format n hours, x minutes when given the number of minutes.
	{
		if($time_in_mins > 0)
		{
			$time_string = "";
			$hours = (int)($time_in_mins/60);
			if($hours != 0)
			{
				if($hours == 1)
					$time_string = $hours." hour";
				else
					$time_string = $hours." hours";
			}
			$mins = $time_in_mins-(60*$hours);
			if($mins != 0)
				$time_string .= " ".$mins." mins";
			return $time_string;
		}
		else
			return "0 mins";
	}
	function deleteTable($table_name) // function to delete a given table
	{
		$table_name = trim($table_name);
		if(!empty($table_name))
		{
			require('db.php');
			$table_name = mysqli_real_escape_string($db,$table_name); // to prevent SQL injection attacks, (not likely to happen, but still..)
			$query = "DROP TABLE ".$table_name;
			echo "<script>console.log('".addslashes($query)."')</script>"; // FOR DEBUGGING... remove this afterwards
			mysqli_query($db,$query);
			mysqli_close($db);
		}
	}
	// returns the test type (Code,MCQ) of the given testID,
	// NOTE: the test must have been completely created, this function wont work while test creation is in process
	function getTestType($testID)
	{
		require('db.php');
		$query = "SELECT test_type FROM tests WHERE test_id=$testID";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_array($result);
			$type = $row['test_type'];
			return $type;
		}
		else
		{
			return null;
		}
	}
	function getTableName($testID) // returns the respective table name provided the test id.
	{
		$table_name = null;
		$test_type = getTestType($testID);
		if($test_type == "CODE")
		{
			$table_name = "test_code_".$testID;
		}
		else if($test_type == "MCQ")
		{	
			$table_name = "test_mcq_".$testID;
		}
		return $table_name;
	}
?>