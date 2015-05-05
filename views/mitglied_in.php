<?
// include "_db.php";
$title="Mitgliederbereich";
// include "../views/header2.inc.php";
include "_werte_db.php";
include "_header.php";



?>
<!--Content-->
<div id="center">
        <div id="content">
          <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="#">Mitgliederbereich</a>
	    <div id="tabs-wrapper"></div>
          <h3>Mitgliederbereich</h3>

            <p><!--<img class="wallimg big" src="../style/gfx/platzhalter.png" alt="Platzhalter" title="Platzhalter">--></p>

            <p class="intern"><a href="audio.php" alt="">Tonaufnahmen</a> - <a href="video.php" alt="">Videoaufnahmen</a> - <a href="scholienarchiv.php" alt="">Scholienarchiv</a></p>

            <p></p>
            
            <a href="audio.php"><h5>Audio</h5></a>
            
<?
         $limit=2;
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

         //ereg() not used anymore in PHP5.3 and up 
         // if (!ereg("0000",$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
         if (!preg_match('/ 0000 /',$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
         else $date=strftime("%d.%m.%Y", strtotime($entry[time_input]));
		          
            echo "<div class=\"audioentry\">
            <div><b>$entry[titel]</b></div>
            <div class=\"autor\">$entry[autor], $date</div>
          	<p>$entry[text]</p>
            <p><a href=\"audio.php#$entry[titel]\"><b>Anh&ouml;ren</b></a></p>
          </div>";
	   $n++;
	   }
       if ($n==$limit)
	   {
	   	?>
          <div class="weitere"><i><a href="audio.php">Weitere Tonaufnahmen</a></i></div>
       <?
        }
       ?>          
            
            
            <a href="video.php"><h5>Video</h5></a>
<?
         $limit2=2;
         $n2=0;
         $sql2="SELECT * from video";
         if ($id2) $sql2=$sql2." WHERE id='$id2'";
          elseif ($tag2) $sql2=$sql2." WHERE tags LIKE '%$tag2%'";
        $sql2=$sql2." order by time desc";
        if ($offset2||$limit2) $sql2=$sql2." limit ";
        if ($offset2) $sql2=$sql2.$offset2.",";
        if ($limit2) $sql2=$sql2."$limit2";
        $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. " - ". mysql_error());
        while($entry2 = mysql_fetch_array($result2))
        {
         // if (!ereg("0000",$entry2[time])) $date2=strftime("%d.%m.%Y", strtotime($entry2[time]));
         if (!preg_match('/ 0000 /',$entry2[time])) $date2=strftime("%d.%m.%Y", strtotime($entry2[time]));
         else $date2=strftime("%d.%m.%Y", strtotime($entry2[time_input]));
		          
            echo "<div class=\"videoentry\">
            <div><b>$entry2[titel]</b></div>
            <div class=\"autor\">$entry2[autor], $date2</div>
          	<p>$entry2[text]</p>
            <p><a href=\"video.php#$entry2[titel]\"><b>Ansehen</b></a></p>
          </div>";
	   $n2++;
	   }
       if ($n2==$limit2)
	   {
	   	?>
          <div class="weitere"><i><a href="video.php">Weitere Videoaufnahmen</a></i></div>
       <?
        }
       ?>          
          <a href="scholienarchiv.php"><h5>Scholienarchiv</h5></a>
          <p>Hier finden Sie alle unsere bisher erschienenen <a href="../scholien/" alt="">Scholien</a> als PDF zum Download.</p>
          
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "_side_in.php"; ?>
        </div>
<? include "_footer.php"; ?>