<?php 

	require_once('../config/config.php');

	// mc_gross=1.00&protection_eligibility=Eligible&address_status=unconfirmed&payer_id=3RX2RTNJ5ZFCJ&tax=0.00&address_street=Weingartenweg 1 Rafing&payment_date=02:48:42 Jan 21, 2016 PST&payment_status=Completed&charset=windows-1252&address_zip=3741&first_name=test&mc_fee=0.38&address_country_code=AT&address_name=test buyer&notify_version=3.8&custom=&payer_status=verified&business=dainius.tol-facilitator@gmail.com&address_country=Austria&address_city=PULKAU&quantity=1&verify_sign=ApBHX6qbpxJW-Ll3oP22LSbo0WeuAQHBaWa7VW2tLYttvuemnGFuzh5d&payer_email=dainius.tol-buyer@gmail.com&txn_id=1VM04871B73394130&payment_type=instant&last_name=buyer&address_state=&receiver_email=dainius.tol-facilitator@gmail.com&payment_fee=&receiver_id=4S3ADK9KYT2T4&txn_type=web_accept&item_name=Test Item&mc_currency=EUR&item_number=tst1&residence_country=AT&test_ipn=1&handling_amount=0.00&transaction_subject=&payment_gross=&shipping=0.00&ipn_track_id=e103b218a7bce


	// txn_id=1VM04871B73394130


	$ipn_post_data = $_POST;

	// $ipn_post_data['txn_id'];


	try 
	{
    	$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	} 
	catch (PDOException $e) 
	{
	    echo 'Connection failed: ' . $e->getMessage();
        exit;
	}



    $txn_id_test_query = $this->db_connection->prepare(
    "UPDATE grey_user   
        SET Notiz = :txn_id
      WHERE user_email = :user_email"
    );

    $txn_id_test_query->bindValue(':txn_id', $ipn_post_data['txn_id'], PDO::PARAM_STR);
    $txn_id_test_query->bindValue(':user_email', 'dzainius@gmail.com', PDO::PARAM_STR);

    $txn_id_test_query->execute();


?>