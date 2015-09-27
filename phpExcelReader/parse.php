<?php

require_once 'Excel/reader.php';

function getNameFromSpreadSheet($filename)
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

?>
