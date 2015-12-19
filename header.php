<?php
	if(session_status() != PHP_SESSION_ACTIVE)
	{
		session_start();
	}
	$loggedIn = false;
	$greet = "";
	if(isset($_SESSION['username']))
	{
		$greet = "Welcome ".$_SESSION['username'];
		$loggedIn = true;
	}
?>


<div id='header'>
	<div id='header-title'>
		<span id='header-title'> <b> DIRECTORATE OF ACADEMICS  </b> </span>
		<span id='header-title'> Student Assessment (Chennai Campus) </span>
	</div>
	<div id='header-logo'>
		<img src='images/vit_logo.jpg'>
	</div>
	<div id='black-div'>
		<table>
			<tr>
				<!-- For displaying the profile name, -->
				<td width='20%' align='left'> <?php echo $greet; ?> </td>
				<!-- For displaying logout button if logged in -->
				<td align='center'> <?php if($loggedIn) { echo "<a href='logout.php' class='logout-link'>Logout</a>"; } ?> </td>
				<!-- For displaying the current date and time, -->
				<td width='20%' align='right'> <?php echo date('l, F d, Y');?> </td>
			</tr>
		</table>
	</div>
</div>