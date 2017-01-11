<?php
require_once('config/config.php');

date_default_timezone_set('Europe/Vienna');

try {
	$db = new PDO('mysql:host='. DB_WERTE_HOST .';dbname='. DB_WERTE_NAME . ';charset=utf8', DB_WERTE_USER, DB_WERTE_PASS);
	$db2 = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
} catch(PDOException $e) {
	echo 'Connection failed: '.$e->getMessage();
}

header('Content-Type: text/html; charset=UTF-8');

?>
