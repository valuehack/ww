<?
require_once('../config/config.php');

@$con=mysql_connect(DB_WERTE_HOST,DB_WERTE_USER,DB_WERTE_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_WERTE_NAME);

@$con2=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_NAME);

header('Content-Type: text/html; charset=ISO-8859-1');
?>


