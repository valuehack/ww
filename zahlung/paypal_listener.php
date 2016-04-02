<?php 

	#response from paypal
	$ipn_post_data = $_POST;


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
	$ipn_post_data_serialized = serialize($_POST);

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

	// $paypal_data_query->bindValue(':wrt_txn_id', $ipn_post_data[custom], PDO::PARAM_STR);
	$paypal_data_query->bindValue(':wrt_txn_id', "0LbHNzBN6j24", PDO::PARAM_STR);
	$paypal_data_query->execute();

	$result_row = $paypal_data_query->fetchObject();
	$txn_data = unserialize($result_row->data);

	$profile = $txn_data['profile'];
	$product = $txn_data['product'];

	#register user
	$registration->addNewUser($profile, $product);
	$registration->addPersonalDataGeneric($profile);