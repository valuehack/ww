<?php 
session_start();

echo "Data from paypal is set to a session var:<br>";

// $_SESSION[ipn_post_data] = "test";

// $_POST['text'] = 'another value';

$_SESSION[ipn_post_data] = $_POST;

?>