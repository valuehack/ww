<?php 

#error log settings
ini_set("log_errors" , "1");
#php_listener_errors is a filename where errors are logged
ini_set("error_log" , "./log/php_listener_errors");
ini_set("display_errors" , "0");

#response from paypal
$ipn_post_data = $_POST;

#log received post
error_log( "POST FROM PAYPAL. TXN_ID: ".$ipn_post_data['txn_id'] ." WRT_TXN_ID: ".$ipn_post_data['custom']);

require_once('../config/config.php');
require_once('../classes/Registration.php');

$registration = new Registration();

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
$paypal_data_query = $db_connection->prepare(
"SELECT * FROM paypal_data_storage 
WHERE wrt_txn_id = :wrt_txn_id
");

$paypal_data_query->bindValue(':wrt_txn_id', $ipn_post_data['custom'], PDO::PARAM_STR);
$paypal_data_query->execute();


if ($paypal_data_query->rowCount() == 0) 
{
	#wrt_txn_id was not found in the transactional db.
	error_log( "CRITICAL: No entry in db for:  ".$ipn_post_data['custom']);

}
else
{
	$result_row = $paypal_data_query->fetchObject();

	#session data in db is stored serialized
	$txn_data = unserialize($result_row->data);

	$profile = $txn_data['profile'];
	$product = $txn_data['product'];


#if email exists in mitglieder, query database, function in registration 
	#then 
		#add credits to the db 
	#else 
		#create new user

	#register user
	$registration->addNewUser($profile, $product);
	$registration->addPersonalDataGeneric($profile);
}

#how to check if the user is a member already???


