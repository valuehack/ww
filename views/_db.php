<?php

// @$con=mysql_connect("wertewirtschaft1.db.6152056.hostedresource.com","wertewirtschaft1","Werte333wirte") or die ("cannot connect to MySQL");
// mysql_select_db("wertewirtschaft1");

    @$con=mysql_connect("newBig.db.6152056.hostedresource.com","newBig","bmbClat1!") or die ("cannot connect to MySQL");
    mysql_select_db("newBig");


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