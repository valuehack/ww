<?php 

$title="Salon";
include('_header_not_in.php'); 

#TODO - check for the right image
//check, if there is an image in the salon folder
$img = 'http://www.scholarium.at/seminare/'.$id.'.jpg';

if (@getimagesize($img)) 
{
    $img_url = $img;
} 
else 
{
    $img_url = "http://www.scholarium.at/seminare/default.jpg";
}

?>

<div class="content">

<?php 

if(isset($_GET['q']))
{
  $id = $_GET['q'];

  #TODO rewrite to PDO
  #id is actually a slug
  #real id is n 

#set a connection
#TODO - think how to move this to a controler, use OOP
$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

#query sets timezone for the database
$query_time_zone = $db_connection->prepare("SET time_zone = 'Europe/Vienna'");
$query_time_zone->execute();

$offenen_salon_query = $db_connection->prepare('SELECT * FROM produkte WHERE type = :event_type AND id = :event_id AND status = :status LIMIT 1');

$offenen_salon_query->bindValue(':event_type', 'offenen-salon', PDO::PARAM_STR);
$offenen_salon_query->bindValue(':event_id', $id, PDO::PARAM_INT);
$offenen_salon_query->bindValue(':status', 1, PDO::PARAM_INT);
$offenen_salon_query->execute();

#fetches results to an associated array
$offenen_salon = $offenen_salon_query->fetch(PDO::FETCH_ASSOC);

  $title=$offenen_salon[title];
  $spots_total=$offenen_salon[spots];
  $spots_sold=$offenen_salon[spots_sold];
  $spots_available=$spots_total-$spots_sold;
  $n=$offenen_salon[n];
  $event_price = $offenen_salon[price];
  $status = $offenen_salon[status];
  
  if ($status == 0) 
  {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
  }
  else 
  {
?>
  
  	<div class="salon_head">
  		<h1><?=ucfirst($offenen_salon[type])." ".$offenen_salon[title]?></h1>
  		<p class="salon_date">
  	
    <? 
    if ($offenen_salon[start] != NULL && $offenen_salon[end] != NULL)
        {
        $tag=date("w",strtotime($offenen_salon[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($offenen_salon[start]));
        if (strftime("%d.%m.%Y", strtotime($offenen_salon[start]))!=strftime("%d.%m.%Y", strtotime($offenen_salon[end])))
          {
          echo " Uhr &ndash; ";
          $tag=date("w",strtotime($offenen_salon[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($offenen_salon[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($offenen_salon[end]));
      }
      elseif ($offenen_salon[start]!= NULL)
        {
        $tag=date("w",strtotime($offenen_salon[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($offenen_salon[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
  		</p>

		<div class="centered">
			<div class="salon_reservation">
				<?
				if ($spots_available == 0){
    	echo '<p class="salon_reservation_span_d">Die Veranstaltung ist leider ausgebucht.</p>';
	}
	else {    
    	echo '<p class="salon_reservation_span_d">'.$offenen_salon[price].' &euro; pro Teilnehmer</p>';
	}
	?>
  				<!-- Button trigger modal -->
  				<input type="button" class="salon_reservation_inputbutton" value="Anmelden" data-toggle="modal" data-target="#myModal" <?if($spots_available == 0){echo 'disabled';}?>>
  				<p class="salon_reservation_span_c">Melden Sie sich heute noch an (beschr&auml;nkte Pl&auml;tze) &ndash; Sie erhalten nicht nur eine Eintrittskarte f&uuml;r das Seminar, sondern auch Zugang zu unserem weiteren Angebot (u.a. Scholien, unserem Salon, Schriften, Medien).</p>
    		</div>
    	</div>
    </div>
	<div class="salon_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="salon_content">
<?  
  #if not really neccessary as it would output nothing - it would output the <p> and then we have an empty space thats not supposed to be there
  if ($offenen_salon[text]) echo "<p>$offenen_salon[text]</p>";
  if ($offenen_salon[text2]) echo "<p>$offenen_salon[text2]</p>";

?>
		<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Seminaren</a></div>
	</div>

	<div class="salon_subscribe">
		<p>Sie k&ouml;nnen zu diesem Termin leider nicht teilnehmen, interessieren sich aber f&uuml;r unser weiteres Angebot? Kein Problem. Tragen Sie hier Ihre E-Mail-Adresse ein, dann k&ouml;nnen wir Sie &uuml;ber unsere weiteren Veranstaltungen und Angebote informieren.</p>
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
          </form> 
  </div>
<?php
	}
}

else {
  ?>
	<div class="salon_info">
  		<h1>Seminare</h1>
  		
  		<?php  
      #what does it do?
			$sql = "SELECT * from static_content WHERE (page LIKE 'seminare')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
			echo $entry4[info];			
			?>

				<div class="centered">
					<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
						<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  						<input type=hidden name="first_reg" value="o_salon">
  						<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
					</form>
				</div>
    </div>
<?
}
?>
	</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog-login modal-form-width">
  <div class="modal-content-login">
 
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title" id="myModalLabel">Anmeldung</h2>
  </div>
  
  <div class="modal-body">
  <div class="profil payment_width">

      <!-- <form method="post" action="../spende/zahlung.php" name="user_create_profile_form"> -->
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="user_create_profile_form">

          <!-- ajax_email_exists checks if user email is already registered -->
			<label for="user_email">E-Mail</label>
        	<input id="ajax_email_exists" type="email" class="profil_inputfield" name="profile[user_email]" required><br>
        	<div id="ajax_email_exists_error"></div><br><br>
        	
        	<label for="user_anrede">Anrede</label> 
        	<select id="user_anrede" name="profile[user_anrede]" required>
        		<option value="Herr">Herr</option>
        		<option value="Frau">Frau</option>
        	</select>
        	<label for="user_first_name">Vorname</label>		
        	<input class="profil_inputfield" id="user_first_name" type="text" name="profile[user_first_name]" required><br>
        	<label for="user_surname">Nachname</label>
        	<input class="profil_inputfield" id="user_surname" type="text" name="profile[user_surname]" required><br>
        	<label for="user_telefon">Telefon</label>
        	<input class="profil_inputfield" id="user_telefon" type="tel"  name="profile[user_telefon]"><br>
        	<label for="user_street">Stra&szlig;e</label>
        	<input class="profil_inputfield" id="user_street" type="text" name="profile[user_street]" required><br>
        	<label for="user_plz">PLZ</label> 
        	<input class="profil_inputfield" id="user_plz" type="text" name="profile[user_plz]" required><br>
        	<label for="user_city">Ort</label>
        	<input class="profil_inputfield" id="user_city" type="text" name="profile[user_city]" required><br>

			    <label for="user_country">Land</label>
        	<select id="user_country" name="profile[user_country]" required>        		
            <!-- this content is static and just takes too much space -->
            <?php include("_country_list.html") ?>
          </select>
          <!-- end of user profile -->
          
          <!-- payment methods  -->
          <p>Die Zahlung von 5&euro; erfolgt in bar im scholarium am Abend des Offenen Salons.</p> 
          <input type="hidden" name="profile[zahlung]" value="bar">

          <!-- additional hidden fields -->
      	  <input type="hidden" name="profile[betrag]" value="<?php echo $event_price; ?>">
          <?php #o_salon + echo $n is used at verification to register to an event?>
          <input type="hidden" name="profile[first_reg]" value="osalon_<?php echo $n; ?>">
      		
          <!-- <input type="hidden" name="profile[event_id]" value="<?php echo $n ?>"> -->
          <!-- <input type="hidden" name="profile[title]" value="<?php echo $title ?>"> -->
          <!-- <input type="hidden" name="profile[credits]" value="25"> -->
			
    	    <input type="submit" class="profil_inputbutton" name="register_o_salon_from_outside_submit" value="Anmelden">
          <!-- TODO change the submit name -->
      </form>

</div><!-- profil payment_width -->
</div><!-- modal-body -->
</div><!-- modal-content-login -->
</div><!-- modal-dialog-login modal-form-width -->
</div><!-- modal fade -->

<?php include('_footer.php'); ?>