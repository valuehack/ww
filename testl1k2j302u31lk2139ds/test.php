<?php 
session_start();

echo "Here is some data for from Paypal:<br>";

// $_SESSION[ipn_post_data] = "test";

$_SESSION[ipn_post_data] = $_POST;

print_r($_SESSION[ipn_post_data]);

?>