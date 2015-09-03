<?php

//please use config file entries - can be access with ftp client
@$con=mysql_connect("","","") or die ("cannot connect to MySQL");
mysql_select_db("");

// test

$sql = "SELECT id,Scholien from Mitglieder3 order by id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  $id=$entry[id];
  $sql2 = "SELECT Scholien from Mitglieder WHERE id='$id'";
  $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. mysql_error());
  $entry2 = mysql_fetch_array($result2);
  if ($entry[Scholien]<>$entry2[Scholien])
    {
      $sql3 = "UPDATE Mitglieder SET Scholien='$entry[Scholien]' WHERE id='$id'";
      $result3 = mysql_query($sql3) or die("Failed Query of " . $sql3. mysql_error());
      echo $sql3."<br>";
    }
  }

?>
