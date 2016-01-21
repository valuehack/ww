<?php 
session_start();

echo "here is the session from paypal:<br>";

print_r($_SESSION[ipn_post_data]);

?>