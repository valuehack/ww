<?php

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
ini_set("display_errors" , "0");

#if session does not exist, start a session
if(session_id() == '') session_start();
error_log('this is a session id in sofort-listener '.session_id());

# check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once('../libraries/password_compatibility_library.php');
}

require_once('../config/config.php');
require_once('../translations/de.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

$registration = new Registration();
$login = new Login();

try 
{
	$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} 
catch (PDOException $e) 
{
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}


#get data from transactional db 
$sofort_data_query = $db_connection->prepare(
"SELECT * FROM transactions 
WHERE wrt_txn_id = :wrt_txn_id
");

$sofort_data_query->bindValue(':wrt_txn_id', $_GET["g"], PDO::PARAM_STR);
$sofort_data_query->execute();

if ($sofort_data_query->rowCount() == 0) 
{
	#wrt_txn_id was not found in the transactional db.
	error_log( "CRITICAL: No entry in db for:  ".$_GET["g"]);

}
else
{
	$result_row = $sofort_data_query->fetchObject();

	#session data in db is stored serialized
	$txn_data = unserialize($result_row->session_data);

	$profile = $txn_data['profile'];
	$product = $txn_data['product'];
	$donation = $txn_data['donation'];

	$registration->processPayment($profile, $product, $donation);
}