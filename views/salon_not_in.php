<?
require_once('../classes/Login.php');
$title="Salon";
include "_header_not_in.php"; 
?>
	<div class="content">
<?
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE type LIKE 'salon' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  
    	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/salon/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/salon/default.jpg";
	}
?>
	<div class="salon_head">
  		<h1><?echo $entry3[title]?></h1>
  		<p class="salon_date"><?echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));?></p>
  		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">-->
		<div class="centered">
			<div class="salon_reservation">
  				<!-- Button trigger modal -->
  				<input type="button" class="salon_reservation_inputbutton" value="Reservieren" data-toggle="modal" data-target="#myModal">  
    		</div>
    	</div>
    </div>
	<div class="salon_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="salon_content">
	
  <?php
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */  
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";
?>

  <p>Unser Salon erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition.</p>

  <p>N&uuml;tzen Sie die Gelegenheit, die Wertewirtschaft und deren au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Ein spannender und tiefgehender Input bringt Ihren Geist auf Hochtouren, worauf dann eine intensive Diskussion in intimer Atmosph&auml;re folgt. Dabei kommt auch das leibliche Wohl nicht zu kurz: Selbst zu bereitete Gaumenfreuden und gute Tropfen machen den Abend auch zu einem kulinarischen Erlebnis.</p>

    	</div>
	</div>
<?php
}
         
else { 
?>
	<div class="salon_info">
		<h1>Salon</h1>
  		<p>Unser Salon erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition.</p>

  		<p>N&uuml;tzen Sie die Gelegenheit, die Wertewirtschaft und deren au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Ein spannender und tiefgehender Input bringt Ihren Geist auf Hochtouren, worauf dann eine intensive Diskussion in intimer Atmosph&auml;re folgt. Dabei kommt auch das leibliche Wohl nicht zu kurz: Selbst zu bereitete Gaumenfreuden und gute Tropfen machen den Abend auch zu einem kulinarischen Erlebnis.</p>
    </div>
    <div class="salon_seperator">
    	<h1>Termine</h1>
    </div>
    <div class="salon_content">
  

  <?php
  $sql = "SELECT * from produkte WHERE type LIKE 'salon' AND start > NOW() AND spots > spots_sold AND status = 1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	
  $sql = "SELECT * from produkte WHERE type LIKE 'salon' AND start > NOW() AND spots > spots_sold AND status = 1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
      ?>
      
<?php echo "<h1><a href='?q=$id'><i>".$event_id."</i>".$entry[title]; ?></a></h1>
		<div class="salon_dates"><?php echo date("d.m.Y",strtotime($entry[start])); ?> &ndash; 
						 	 <?php echo date("H:i",strtotime($entry[start])); ?> Uhr
		</div>
		<?php echo $entry[text]; ?> 
			<div class="salon_anmeldung"><a href="<? echo "?q=$id";?>">zur Anmeldung</a></div>
			<div class="centered"><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>	
  <?php
  }
  ?>
			</div>
	</div>
  <!--<div class="location_box">  
   		<table>
   			<tr>
   				<td>
   					<h1>Wertewirtschaft</h1>
   					<ul>
    					<li>Schl&ouml;sselgasse 19/2/18</li>
    					<li>A 1080 Wien</li>
    					<li>&Ouml;sterreich</li>
    					<li>&nbsp;</li>
    					<li>Fax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+43 1 2533033 4733</li>
    					<li>E-Mail: &nbsp;<a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a></li>
   					</ul>
   				</td> 
   				<td>
   					<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095&amp;output=embed"></iframe><br /><small><a href="https://maps.google.de/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095"></iframe>
   				</td>
   			</tr>
   		</table>
   </div>-->

<?php
}
?> 

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Reservierung</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie Interesse an einer Teilnahme haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten einer Teilnahme zu erfahren:</p>
        <div class="subscribe">
<!--           
  Commented out, because of the clashes between forms
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
          <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required />
          <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" style="display:none"  />
          <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
          </form>  -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>