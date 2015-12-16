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
  $spots_total = $entry3[spots];
  $spots_available=$entry3[spots]-$entry3[spots_sold];
  $status = $entry3[status];
  $n = $entry3[n];
    	//check, if there is a image in the salon folder
	$img = 'http://scholarium.at/salon/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://scholarium.at/salon/default.jpg";
	}
  if ($status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
  }
  else {
?>
	<div class="salon_head">
  		<h1><?echo $entry3[title]?></h1>
  		<p class="salon_date"><?
      if ($entry3[start] != NULL && $entry3[end] != NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry3[start]));
        if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
          {
          echo " Uhr &ndash; ";
          $tag=date("w",strtotime($entry3[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry3[end]));
      }
      elseif ($entry3[start]!= NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
    </p>
  		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">-->
		<div class="centered">
			<div class="salon_reservation">
				<?
				if ($spots_available == 0){
  					echo '<span class="salon_reservation_span_a">Diese Veranstaltung ist leider ausgebucht.</span><br>';
  				}
				if ($spots_total > 59){
					echo '<span class="salon_reservation_span_a">Unser Offener Salon steht allen offen die uns pers&ouml;nlich kennenlernen m&ouml;chten. Der Kostenbeitrag betr&auml;gt <b>5&euro;</b> und kann nur vor Ort in bar gezahlt werden.</span><br><br>';
				}
				?>  
    			<!--Button trigger modal-->
    			<input class="salon_reservation_inputbutton" type="button" value="Reservieren" data-toggle="modal" data-target="#myModal" <?if($spots_available == 0){echo 'disabled';}?>>
 
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
  
			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];			
			?>
			<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Salons</a></div>
    	</div>
	</div>
<?php
	}
}
         
else { 
?>
	<div class="salon_info">
		<h1>Salon</h1>
		
		<?php
			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];	
		?>
				<div class="centered">
					<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
						<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  						<input type=hidden name="first_reg" value="salon">
  						<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
					</form>
				</div>
    </div>
<?php
}
?> 

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-login modal-form-width">
    <div class="modal-content-login">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Reservierung</h2>
      </div>
      <div class="modal-body">
      	<?php
        	if ($spots_total > 59){
        		$pass_to = 'register_open_salon_from_outside'; //Register from level 0
        		$submit = 'register_open_salon_from_outside'; //Register from level 0
        		include ('../tools/open_salon_form.php');
        	}  
			else {
		?>
        <p>Wir freuen uns, dass Sie Interesse an einer Teilnahme haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten einer Teilnahme zu erfahren (falls Sie sich schon einmal eingetragen haben, bitte um Login &uuml;ber den Link &quot;Anmelden&quot; oben rechts auf der Seite):</p>
        <div class="subscribe">
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input type="hidden" name="first_reg" value="salon">
            <input class="inputbutton" id="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
          </form>
        </div>
        <?php
		  }
		?>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>