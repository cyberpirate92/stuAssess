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
?>