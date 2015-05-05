<? 
include "_werte_db.php";
$title="Tonaufnahmen";
include "_header.php";



?>
<!--Content-->
<div id="center">
        <div id="content">
	  <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Mitgliederbereich &raquo;</a> <a class="content" href="#">Tonaufnahmen</a>
	  <div id="tabs-wrapper-lower"></div>
          <h3>Tonaufnahmen</h3>
          
          <p><!--<img class="wallimg big" src="../style/gfx/platzhalter.png" alt="Platzhalter" title="Platzhalter">-->&nbsp;</p>
<?
         $limit=10;
         $n=0;
         $sql="SELECT * from audio";
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
            <div align=\"center\" class=\"audioentry\"><h1>$entry[titel]</h1>
            <div class=\"autor\">$entry[autor], $date</div>
          	<p>$entry[text]</p>
            <div align=\"center\" class=\"audiofile\"><audio controls preload=\"none\">
              <source src=\"$entry[url_mp3]\" type=\"audio/mpeg\">
              <source src=\"$entry[url_mp4]\" type=\"audio/aac\">
              <source src=\"$entry[url_ogg]\" type=\"audio/ogg\">
               Das Audioformat wird von Ihrem Browser leider nicht unterst&uuml;tzt. Installieren Sie bitte eine aktuelle Version Ihres Browsers.
            </audio>
            </div>
            <p><a href=\"$entry[url_mp3]\">Download</a></p>
          </div>";
	   $n++;
	   }
       if ($n==$limit)
	   {
	   	?>
          <br><br>
          <div align="right"><i><a href="?offset=<?=($offset+$limit)?>">Weitere Tonaufnahmen</a></i></div>
       <?
        }
       ?>          
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "_side_in.php"; ?>
        </div>
<? include "_footer.php"; ?>