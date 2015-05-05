<? 
include "_werte_db.php";
$title="Videoaufnahmen";
include "_header.php";
?>
<!--Content-->
<div id="center">
        <div id="content">
	  <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Mitgliederbereich &raquo;</a> <a class="content" href="#">Videoaufnahmen</a>
	  <div id="tabs-wrapper-lower"></div>
          <h3>Videoaufnahmen</h3>

          <p><!--<img class="wallimg big" src="../style/gfx/platzhalter.png" alt="Platzhalter" title="Platzhalter">-->&nbsp;</p>

<?
         $limit=10;
         $n=0;
         $sql="SELECT * from video";
         if ($id) $sql=$sql." WHERE id='$id'";
          elseif ($tag) $sql=$sql." WHERE tags LIKE '%$tag%'";
        $sql=$sql." order by time desc";
        if ($offset||$limit) $sql=$sql." limit ";
        if ($offset) $sql=$sql.$offset.",";
        if ($limit) $sql=$sql."$limit";
        $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
        while($entry = mysql_fetch_array($result))
        {
         if (!preg_match('/ 0000 /',$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
         else $date=strftime("%d.%m.%Y", strtotime($entry[time_input]));
		 
         echo "<a name=\"$entry[titel]\"></a>
            <div align=\"center\" class=\"videoentry\"><h1>$entry[titel]</h1>
            <div class=\"autor\">$entry[autor], $date</div>
          	<p>$entry[text]</p>
          	<div class=\"videofile\">
            <iframe width=\"500\" height=\"281\" src=\"$entry[url]\" frameborder=\"0\" allowfullscreen></iframe>
            </div>
          </div>";
	   $n++;
	   }
       if ($n==$limit)
	   {
	   	?>
          <br><br>
          <div align="right"><i><a href="?offset=<?=($offset+$limit)?>">Weitere Videos</a></i></div>
       <?
        }
       ?>  
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "_side_in.php"; ?>
        </div>
<? include "_footer.php"; ?>