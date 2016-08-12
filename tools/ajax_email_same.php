<?php
	#php side of the ajax request to check email if email exists in the database
	
	header('content-type: text/json');
	
	#data sent from ajax 
	$user_email = $_POST['user_email'];
	$user_email2 = $_POST['user_email2'];
	
	if ($user_email !== $user_email2) 
	{
		echo json_encode(array('notsame' => true));
	}
	else
	{
		echo 0;
	}

?>	   
