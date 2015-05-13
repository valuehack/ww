<?php

	#uses the current config file to connect to the database
	require_once("config/config.php");

	$conn = mysql_connect(DB_HOST,DB_USER,DB_PASS)or die(mysql_error());
         mysql_select_db(DB_NAME,$conn)or die(mysql_error());

	$db_table= "mitgliederExt";		// Table name
	$db_column = "user_email";	// Table column from which suggestions will get shown

	$keyword = $_POST['data'];
	$sql = "select user_email from ".$db_table." where ".$db_column." like '".$keyword."' limit 0,20";
	//$sql = "select name from ".$db_table."";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result))
	{
		echo '<ul class="list">';
		while($row = mysql_fetch_array($result))
		{
			$str = strtolower($row['user_email']);
			$start = strpos($str,$keyword); 
			$end   = similar_text($str,$keyword); 
			$last = substr($str,$end,strlen($str));
			$first = substr($str,$start,$end);
			
			$final = '<span class="bold">'.$first.'</span>'.$last;
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
?>	   
