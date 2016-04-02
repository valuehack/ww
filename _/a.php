<?php 

#display all errors while developing
ini_set('display_errors',1);
error_reporting(E_ALL);


	#response from paypal
	$ipn_post_data =	array (
  'mc_gross' => '75.00',
  'protection_eligibility' => 'Eligible',
  'address_status' => 'unconfirmed',
  'payer_id' => '3RX2RTNJ5ZFCJ',
  'tax' => '0.00',
  'address_street' => 'Goodin Street 5',
  'payment_date' => '12:19:23 Apr 02, 2016 PDT',
  'payment_status' => 'Completed',
  'charset' => 'windows-1252',
  'address_zip' => '1050',
  'first_name' => 'test',
  'mc_fee' => '2.90',
  'address_country_code' => 'AT',
  'address_name' => 'Denis Stankus',
  'notify_version' => '3.8',
  'custom' => '0LbHNzBN6j24',
  'payer_status' => 'verified',
  'business' => 'dainius.tol-facilitator@gmail.com',
  'address_country' => 'Austria',
  'address_city' => 'Wien',
  'quantity' => '1',
  'verify_sign' => 'ARTWVaUGckuviK6HZ-Of6l88vDtdAp7tR3Z3DvH04O--EqHqaNYUffgn',
  'payer_email' => 'dainius.tol-buyer@gmail.com',
  'txn_id' => '8KR042673S837913N',
  'payment_type' => 'instant',
  'last_name' => 'buyer',
  'address_state' => '',
  'receiver_email' => 'dainius.tol-facilitator@gmail.com',
  'payment_fee' => '',
  'receiver_id' => '4S3ADK9KYT2T4',
  'txn_type' => 'web_accept',
  'item_name' => 'Gast',
  'mc_currency' => 'EUR',
  'item_number' => 'upgrade_2',
  'residence_country' => 'AT',
  'test_ipn' => '1',
  'handling_amount' => '0.00',
  'transaction_subject' => '',
  'payment_gross' => '',
  'shipping' => '0.00',
  'ipn_track_id' => '721520c5f1453',
);

	
	// define("LOG_FILE", "./listener.log");
	// error_log(date('[Y-m-d H:i e] '). "$ipn_post_data[test]". PHP_EOL, 3, LOG_FILE);

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


	#writes serialized paypal responce to db  
	#TESTING ONLY
	// $ipn_post_data_serialized = serialize($_POST);
	$ipn_post_data_serialized = serialize($ipn_post_data);

    $txn_id_test_query = $db_connection->prepare(
    "UPDATE mitgliederExt   
        SET Notiz = :txn_id
      WHERE user_email = :user_email"
    );

    $txn_id_test_query->bindValue(':txn_id', $ipn_post_data_serialized, PDO::PARAM_STR);
    $txn_id_test_query->bindValue(':user_email', 'dzainius@gmail.com', PDO::PARAM_STR);
    $txn_id_test_query->execute();



	#get data from db transactional db 
	$paypal_data_query = $db_connection->prepare(
	"SELECT * FROM paypal_data_storage 
	WHERE wrt_txn_id = :wrt_txn_id
	");

	$paypal_data_query->bindValue(':wrt_txn_id', $ipn_post_data['custom'], PDO::PARAM_STR);
	// $paypal_data_query->bindValue(':wrt_txn_id', "0LbHNzBN6j24", PDO::PARAM_STR);
	$paypal_data_query->execute();

	$result_row = $paypal_data_query->fetchObject();
	$txn_data = unserialize($result_row->data);

	$profile = $txn_data['profile'];
	$product = $txn_data['product'];

	#register user
	$registration->addNewUser($profile, $product);
	$registration->addPersonalDataGeneric($profile);

// #display all errors while developing
// ini_set('display_errors',1);
// error_reporting(E_ALL);

// header('Content-Type: text/html; charset=UTF-8');

// require_once('../config/config.php');

// 	require_once('../classes/Login.php');
// 	require_once('../classes/Registration.php');

// 	$registration = new Registration();
// 	$login = new Login();


// try 
// {
// 	$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// } 
// catch (PDOException $e) 
// {
//     echo 'Connection failed: ' . $e->getMessage();
//     exit;
// }


// #get data from db transactional db 
// $paypal_data_query = $db_connection->prepare(
// "SELECT * FROM paypal_data_storage 
// WHERE wrt_txn_id = :wrt_txn_id
// ");


// // $paypal_data_query->bindValue(':wrt_txn_id', $ipn_post_data['custom'], PDO::PARAM_STR);
// $paypal_data_query->bindValue(':wrt_txn_id', "0LbHNzBN6j24", PDO::PARAM_STR);
// $paypal_data_query->execute();

// $result_row = $paypal_data_query->fetchObject();
// $txn_data = unserialize($result_row->data);

// $profile = $txn_data['profile'];
// $product = $txn_data['product'];

// $registration->addNewUser($profile, $product);
// $registration->addPersonalDataGeneric($profile);