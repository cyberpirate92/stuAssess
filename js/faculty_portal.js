// NOTE:requires jquery to be referenced before using this script
function viewTests() 
{
	$('#option-test').css('color','red');
	$('#option-result').css('color','black');
	$('#option-upload').css('color','black');

	$('#tests').css('display','block');
	$('#results').css('display','none');
	$('#upload').css('display','none');
}
function viewResults() 
{
	$('#option-test').css('color','black');
	$('#option-result').css('color','red');
	$('#option-upload').css('color','black');

	$('#tests').css('display','none');
	$('#results').css('display','block');
	$('#upload').css('display','none');
}
function viewUpload() 
{
	$('#option-test').css('color','black');
	$('#option-result').css('color','black');
	$('#option-upload').css('color','red');

	$('#tests').css('display','none');
	$('#results').css('display','none');
	$('#upload').css('display','block');
}
function validate_upload()
{
	var fileName = document.getElementById('uploadFile').value;
	
	if(fileName.length == 0 ) 
	{
		alert("You haven't selected a file for upload.\nPlease select a file and then click upload.");
		return false; 
	} 
    
    var file_extension = fileName.split('.').pop();
    if(file_extension.toLowerCase() == "xls" )
    	return true;
    else if(file_extension.toLowerCase() == "xlsx")
    {
    	alert("You have selected a '.XLSX' file, only '.XLS' files are supported, please save the file as xls and try again.");
    }
    else
    {
    	alert("Please choose a Excel file (.xls) ");
    }
    return false;
}