<?php 
  // Stop page from being loaded directly. 
if (preg_match("/functions.php/i", $_SERVER['PHP_SELF'])){
echo "Please do not load this page directly. Thanks!";
exit;
}  

include_once("functions.php");
dbconnect();
if(isset($_GET['securl']) && $_GET['securl']!=""){
	 $client_ip = getip();
	 $current_url = $_GET['currenturl'];
	 $dcodearray = explode('=', $_GET['securl']);
	 $dcode = trim($dcodearray[count($dcodearray)-1]);
	 $current_url = mysql_escape_string($current_url);
	 
	 $query = "update ipmap set refer = '{$current_url}' where ipaddress = '{$client_ip}' and dccode='{$dcode}' limit 1";
	 mysql_query($query) or die(mysql_error());
}

?>