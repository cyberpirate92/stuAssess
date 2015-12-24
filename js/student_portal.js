function viewTests() 
{
	$('#option-test').css('color','red');
	$('#option-result').css('color','black');
	
	$('#tests').css('display','block');
	$('#results').css('display','none');
}
function viewResults() 
{
	$('#option-test').css('color','black');
	$('#option-result').css('color','red');

	$('#tests').css('display','none');
	$('#results').css('display','block');
}