<?php 

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
#switch off error display on the screen
ini_set("display_errors" , "0");

#response from paypal
$ipn_post_data = $_POST;

# check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once('../libraries/password_compatibility_library.php');
}

error_log('this is a session id in paypal-listener '.session_id());

#log received post
error_log( "POST FROM PAYPAL. TXN_ID: ".$ipn_post_data['txn_id'] ." WRT_TXN_ID: ".$ipn_post_data['custom']);

require_once('../config/config.php');
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
$paypal_data_query = $db_connection->prepare(
"SELECT * FROM transactions 
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
	$txn_data = unserialize($result_row->session_data);

	error_log($txn_data['profile']['user_email']);

	$profile = $txn_data['profile'];
	$product = $txn_data['product'];
	$donation = $txn_data['donation'];

	error_log('email from paypal listener'.$profile['user_email']);

	$registration->processPayment($profile, $product, $donation);
}
