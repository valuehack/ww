<?php 

	$ipn_post_data = $_POST;

	require_once('../config/config.php');


		try 
		{
	    	$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} 
		catch (PDOException $e) 
		{
		    echo 'Connection failed: ' . $e->getMessage();
	        exit;
		}

	    $txn_id_test_query = $db_connection->prepare(
	    "UPDATE mitgliederExt   
	        SET Notiz = :txn_id
	      WHERE user_email = :user_email"
	    );	

	    $txn_id_test_query->bindValue(':txn_id', $ipn_post_data[txn_id], PDO::PARAM_STR);
	    $txn_id_test_query->bindValue(':user_email', 'dzainius@gmail.com', PDO::PARAM_STR);

	    $txn_id_test_query->execute();


	// if(array_key_exists('test_ipn', $ipn_post_data) && 1 === (int) $ipn_post_data['test_ipn'])
	//     $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	// else
	//     $url = 'https://www.paypal.com/cgi-bin/webscr';



	$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';



	// Set up request to PayPal
	$request = curl_init();
	curl_setopt_array($request, array
	(
	    CURLOPT_URL => $url,
	    CURLOPT_POST => TRUE,
	    CURLOPT_POSTFIELDS => http_build_query(array('cmd' => '_notify-validate') + $ipn_post_data),
	    CURLOPT_RETURNTRANSFER => TRUE,
	    CURLOPT_HEADER => FALSE,
	    CURLOPT_SSLVERSION => 3,
	    CURLOPT_SSL_VERIFYPEER => TRUE, // Verify peers
    	CURLOPT_CAINFO => './cacert.pem' // Path to file with certificates
	));

	// Execute request and get response and status code
	$response = curl_exec($request);
	$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);
	$curl_error = curl_errno($request);


	if($status == 200 && $response == 'VERIFIED')
	{
	    // All good! Proceed...

	    $txn_id_test_query = $db_connection->prepare(
	    "UPDATE mitgliederExt   
	        SET Notiz = :txn_id
	      WHERE user_email = :user_email"
	    );

	    $txn_id_test_query->bindValue(':txn_id', 'bloody thing is working!', PDO::PARAM_STR);
	    $txn_id_test_query->bindValue(':user_email', 'dzainius@gmail.com', PDO::PARAM_STR);

	    $txn_id_test_query->execute();

	}
	else
	{
	    // Not good. Ignore, or log for investigation...

	    $txn_id_test_query = $db_connection->prepare(
	    "UPDATE mitgliederExt   
	        SET Notiz = :txn_id
	      WHERE user_email = :user_email"
	    );	

	    $txn_id_test_query->bindValue(':txn_id', $curl_error, PDO::PARAM_STR);
	    $txn_id_test_query->bindValue(':user_email', 'dzainius@gmail.com', PDO::PARAM_STR);

	    $txn_id_test_query->execute();

	}

	// Close connection
	curl_close($request);



?>