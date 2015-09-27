<?php
	echo __DIR__.'/../db.php'."<br>";
	echo basename(__DIR__)."<br>";
	echo $_SERVER['DOCUMENT_ROOT'];
	echo $_SERVER['DOCUMENT_ROOT']."AntiSkillRack\stuAssess\db.php"."<br>";
	require_once($_SERVER['DOCUMENT_ROOT']."AntiSkillRack\stuAssess\db.php");
	mysqli_query($db,"SELECT * FROM groups");
	echo dirname(__DIR__)."/db.php"."<br>";
	echo file_exists(dirname(__DIR__)."/db.php");
?>