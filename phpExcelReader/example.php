<?php

require_once 'Excel/reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read('Book1.xls');

error_reporting(E_ALL ^ E_NOTICE);

$facultyID  = trim($data->sheets[0]['cells'][1][2]);
$courseCode = trim($data->sheets[0]['cells'][2][2]);
$courseSlot = trim($data->sheets[0]['cells'][3][2]);
$nStudents  = trim($data->sheets[0]['cells'][4][2]);

echo "Faculty ID : $facultyID <br>";
echo "courseCode : $courseCode <br>";
echo "courseSlot : $courseSlot <br>";
echo "nStudents : $nStudents <br>";

$studentList = array();

for($i=0;$i<$nStudents;$i++)
{
	$regno = trim($data->sheets[0]['cells'][7+$i][1]);
	if(strlen($regno) == 0)
	{
		// error;
		echo "Empty cell detected.";
	}
	array_push($studentList, $regno);
}

foreach($studentList as $regno)
	echo "$regno <br>";

?>
