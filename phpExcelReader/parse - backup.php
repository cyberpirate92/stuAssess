<?php

require_once 'Excel/reader.php';
//require_once dirname(__DIR__)."/db.php";
require_once $_SERVER['DOCUMENT_ROOT']."AntiSkillRack\stuAssess\db.php";
function getNameFromSpreadSheet($filename,$username)
{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($filename);

	error_reporting(E_ALL ^ E_NOTICE);

	$facultyID  = trim($data->sheets[0]['cells'][1][2]);
	$courseCode = trim($data->sheets[0]['cells'][2][2]);
	$courseSlot = trim($data->sheets[0]['cells'][3][2]);
	$nStudents  = trim($data->sheets[0]['cells'][4][2]);
	$studentList= array();

	for($i=0;$i<$nStudents;$i++)
	{
		$regno = trim($data->sheets[0]['cells'][7+$i][1]);
		if(strlen($regno) != 0)
			array_push($studentList, $regno);
	}

	if($facultyID != $username)
	{
		require_once('util.php');
		displayJSAlert('ERROR (002): Faculty ID provided in excel sheet does not match your Faculty ID.');
		return null;	
	}

	// checking if no of students provided in the excel sheet matches with the parsed data..
	if($nStudents != count($studentList))
	{
		require_once('util.php');
		displayJSAlert('ERROR (003): Number of students provided in Excel sheet does not match.\nCheck the instructions for more details');
		return null;
	}

	if(strlen($facultyID) == 0 || strlen($courseCode) == 0 || strlen($courseSlot) == 0)
	{
		require_once('util.php');
		displayJSAlert('ERROR (004): Some required fields in the excel file are empty, Please try again.\nCheck the instructions for more details');
		return null;
	}

	return $facultyID . "_" . $courseCode . "_" . $courseSlot;
}

function storeInDB($excelFileName)
{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excelFileName);

	error_reporting(E_ALL ^ E_NOTICE);

	$facultyID  = trim($data->sheets[0]['cells'][1][2]);
	$courseCode = trim($data->sheets[0]['cells'][2][2]);
	$courseSlot = trim($data->sheets[0]['cells'][3][2]);
	$nStudents  = trim($data->sheets[0]['cells'][4][2]);

	$studentList= array();

	for($i=0;$i<$nStudents;$i++)
	{
		$regno = trim($data->sheets[0]['cells'][7+$i][1]);
		if(strlen($regno) != 0)
			array_push($studentList, $regno);
	}

	displayJSAlert(count($studentList));

	$db = mysqli_connect("127.0.0.1","root","","ASR");

	$result = mysqli_query($db,"SELECT * FROM groups WHERE facultyID=$facultyID AND CourseCode='$courseCode' AND CourseSlot='$courseSlot'");
	if(mysqli_num_rows($result) == 0)
	{
		mysqli_query($db,"INSERT INTO groups(facultyID,CourseCode,CourseSlot) VALUES($facultyID,'$courseCode','$courseSlot')");
		$groupID = mysqli_insert_id($db);
	}
	else
	{
		$row = mysqli_fetch_array($result);
		$groupID = $row['groupID'];
	}      

	foreach($studentList as $student)
	{
		$result = mysqli_query($db,"SELECT id FROM student_group WHERE username='$student' AND CourseSlot='$courseSlot'");
		if(mysqli_num_rows($result) == 0)
		{
			mysqli_query($db,"INSERT INTO student_group(username,groupID,CourseSlot) VALUES ('$student',$groupID,'$courseSlot')");
		}
		else
		{
			$row = mysqli_fetch_array($result);
			$id = $row['id'];
			mysqli_query($db,"UPDATE student_group SET groupID=$groupID WHERE id=$id");
		}
	}
}

?>
