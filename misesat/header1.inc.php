<?
@$con=mysql_connect("") or die ("cannot connect to MySQL");
mysql_select_db("");
header('Content-Type: text/html; charset=ISO-8859-1');
if (!$id) $id=$HTTP_GET_VARS['id'];
if (!$id) $id=$_GET['id'];
if (!$offset) $offset=$HTTP_GET_VARS['offset'];
if (!$offset) $offset=$_GET['offset'];
?>