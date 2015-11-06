<?php
	#done by dainius
	#php side of the ajax request to check email if email exists in the database
	
	header('content-type: text/json');

	#uses the current config file to connect to the database
	require_once("../config/config.php");
	
	#data sent from ajax 
	$user_email = $_POST['user_email'];

	#use pdo 
	//MAIN SCRIPT
	try {
	    // Generate a database connection, using the PDO connector
	    // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
	    // Also important: We include the charset, as leaving it out seems to be a security issue:
	    // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
	    // "Adding the charset to the DSN is very important for security reasons,
	    // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
	    $db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	// If an error is catched, database connection failed
	} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
	        exit;
	}

	//setting up correct timezones for php and mysql
	date_default_timezone_set('Europe/Vienna');
	$query_time_zone = $db_connection->prepare("SET time_zone = 'Europe/Vienna'");
	$query_time_zone->execute();

	$email_exists_query = $db_connection->prepare('SELECT user_email FROM mitgliederExt WHERE user_email LIKE :user_email LIMIT 1');
	$email_exists_query->bindValue(':user_email', $user_email, PDO::PARAM_STR);
	$email_exists_query->execute();

	if ($email_exists_query->rowCount() > 0) 
	{
		echo json_encode(array('exists' => true));
	}else
	{
		echo 0;
	}

?>	   
