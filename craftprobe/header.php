<?
require_once('config/config.php');

@$con2=mysql_connect(DB_WERTE_HOST,DB_WERTE_USER,DB_WERTE_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_WERTE_NAME);

$pdocon->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
return true;

$db = new PDO('mysql:host='. DB_WERTE_HOST .';dbname='. DB_WERTE_NAME . ';charset=utf8', DB_WERTE_USER, DB_WERTE_PASS);
return true;
?>
