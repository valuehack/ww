<?php

	//create curl resource
	$ch = curl_init();

	//TODO - hide the api key in the config
	//set header
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: Bearer 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'));

	//set url
	curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$body = "This is working with godaddy!";

	$post_data = array(
/*		'api_user' => 'daneas', 
		'api_key' => 'bmbClat1!',*/
		'to' => 'dzainius@gmail.com',
		'toname' => 'Dainius',
		'subject' => 'testestest',
		'html' => $body,
		'from' => 'dzainius@gmail.com'
		);

	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

	curl_setopt($ch, CURLOPT_VERBOSE, true);

	// $output contains the output string
	$response = curl_exec($ch);

	// close curl resource to free up system resources
	$response = curl_exec($ch);

	if(empty($response))die("Error: No response.");
	else
	{
		
	    $json = json_decode($response);
	    // print_r($json->access_token);
	    print_r($response);
	}

	curl_close($ch);

?>
