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
  $salon_info = $general->getProduct($id);
  
  $event_id = $salon_info->n;
  $title = $salon_info->title;
  $price = $salon_info->price;
  $price2 = $salon_info->price_book;
  $spots_total = $salon_info->spots;
  $spots_available = $spots_total - $salon_info->spots_sold;
  $livestream = $salon_info->livestream;
  $status = $salon_info->status;
    
  $date = $general->getDate($salon_info->start, $salon_info->end);
	
  if ($status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
  }
  else {
?>
	<div class="salon_head">
  		<h1><?=$title?></h1>
  		<p class="salon_date"><?=$date?></p>
	</div>

	<div class="salon_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	
	<div class="salon_content">
	
  <?php
  if ($salon_info->text) echo "<p>$salon_info->text</p>";
  if ($salon_info->text2) echo "<p>$salon_info->text2</p>";
  
			$static_info = $general->getStaticInfo('salon');
			echo $static_info->info		
			?>
			<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Salons</a></div>
			
			<div class="centered">
				<div class="salon_reservation">
				<?
				if ($spots_available == 0){
  					echo '<span class="salon_reservation_span_a">Diese Veranstaltung ist leider ausgebucht.</span><br>';
  				}
				if ($spots_total > 59){
					echo '<span class="salon_reservation_span_a">Unser Offener Salon steht allen offen, die uns pers&ouml;nlich kennenlernen m&ouml;chten. Der Kostenbeitrag betr&auml;gt <b>5&euro;</b> und kann nur vor Ort in bar gezahlt werden.</span><br><br>';
				}
				?>  
    			<!--Button trigger modal-->
    			<input class="salon_reservation_inputbutton" type="button" value="Reservieren" data-toggle="modal" data-target="#myModal" <?if($spots_available == 0){echo 'disabled';}?>>
 
    			</div>
    		</div>
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
			$static_info = $general->getStaticInfo('salon');
			echo $static_info->info	
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