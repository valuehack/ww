<?php

    @$con=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
	mysql_set_charset('utf8', @$con);
    mysql_select_db(DB_NAME);

if (!$id) $id=$HTTP_GET_VARS['id'];
if (!$id) $id=$_GET['id'];
if (!$offset) $offset=$HTTP_GET_VARS['offset'];
if (!$offset) $offset=$_GET['offset'];
$category=$_GET['category'];


function Phrase($n)
	{
  if ($n=="day1") $o="Montag";
  if ($n=="day2") $o="Dienstag";
  if ($n=="day3") $o="Mittwoch";
  if ($n=="day4") $o="Donnerstag";
  if ($n=="day5") $o="Freitag";
  if ($n=="day6") $o="Samstag";
  if ($n=="day7") $o="Sonntag";
  return $o;
	}
?>