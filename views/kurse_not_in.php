<?php 

// require_once('../classes/Registration.php');
// require_once('../classes/Login.php');
$title="Seminare";
include('_header_not_in.php'); 


    	//check, if there is a image in the salon folder
	$img = 'http://www.scholarium.at/seminare/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://www.scholarium.at/seminare/default.jpg";
	}
?>

<div class="content">

<?php 
/* moved to zahlungen_not_in
if (isset($_POST["registrationform"])) {
  
  $profile = $_POST['profile'];
  $user_email = $profile[user_email];
  $id = $_POST['event_id'];
  $title = $_POST['title'];

  echo "<div style='text-align:center'><hr><i>Ein Platz in \"".ucfirst($title).'" wurde für Sie reserviert.<i/><hr></div>';

  $user_query = "SELECT * from mitgliederExt WHERE `user_email` LIKE '$user_email' ";
  $user_result = mysql_query($user_query) or die("Failed Query of " . $user_query. mysql_error());

  $userArray = mysql_fetch_array($user_result);
  $user_id = $userArray[user_id];

  $registration_query = "INSERT INTO registration (event_id, user_id, quantity, reg_datetime) VALUES ('$id', '$user_id', '1', NOW())";
  mysql_query($registration_query);

  $credits_left = 25;

  $left_credits_query = "UPDATE mitgliederExt SET credits_left='$credits_left' WHERE `user_id` LIKE '$user_id'";
  mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

  $space_query = "UPDATE produkte SET spots_sold = spots_sold + 1 WHERE `n` LIKE '$key'";
  mysql_query($space_query);
               
  //TO DO: email versenden 
}
*/

if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type='lehrgang' or type='seminar' or type='kurs') AND id='$id' AND (status > 0)";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $title=$entry3[title];
  $spots_total=$entry3[spots];
  $spots_sold=$entry3[spots_sold];
  $spots_available=$spots_total-$spots_sold;
  $n=$entry3[n];
  $event_price = $entry3[price];
  $status = $entry3[status];
  
    if ($title == "craftprobe" || $title == "%coaching%") {
    	$event_price = $entry3[price]-25;
    }
    
    if ($status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
  }
  else {
?>
  
  	<div class="salon_head">
  		<h1><?=ucfirst($entry3[type])." ".$entry3[title]?></h1>
  		<p class="salon_date">
  			  <? $date = $general->getDate($entry3[start],$entry3[end]);
			  echo $date;?>
  		</p>
  		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">-->
		<div class="centered">
			<div class="salon_reservation">
				<?
				if ($spots_available == 0){
    	echo '<p class="salon_reservation_span_d">Die Veranstaltung ist leider ausgebucht.</p>';
	}
	else {    
    	echo '<p class="salon_reservation_span_d">'.($event_price+25).' &euro; pro Teilnehmer</p>';
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
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";
?>
		<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Seminaren</a></div>
	</div>

	<div class="salon_subscribe">
		<p>Sie k&ouml;nnen zu diesem Termin leider nicht teilnehmen, interessieren sich aber f&uuml;r unser weiteres Angebot? Kein Problem. Tragen Sie hier Ihre E-Mail-Adresse ein, dann k&ouml;nnen wir Sie &uuml;ber unsere weiteren Veranstaltungen und Angebote informieren.</p>
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input type="hidden" name="first_reg" value="seminare">
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
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
			$static_info = $general->getStaticInfo('seminare');
			echo $static_info->info	
		?>
  	</div>
  	<div class="salon_seperator">
    	<h1>Termine</h1>
    </div>
	<div class="salon_content">
  <?
  
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from produkte WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and (type='lehrgang' or type='seminar' or type='kurs') and status=1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<h1>";
    echo "<a href='?q=$id'>";
    echo $entry[title]."</a></h1>";
     
    echo "<div class='salon_dates'>";
	$date = $general->getDate($entry[start],$entry[end]);
	echo $date;
    
    echo "</div>";
    echo "<p>";
    //echo "<img src='$img_url' alt='$id'>";
    echo $entry[text];
    //echo "<div class='salon_anmeldung'><a href='?q=$id'>zur Anmeldung</a></div>";
	echo "<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>";
  } 
?>
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
    	<!-- <form method="post" action="../spende/zahlung.php" name="user_create_profile_form"> -->
      
      	<div class="profil payment_width">
      	<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="user_create_profile_form">
      
        	<input type="hidden" name="seminar_profile[event_id]" value="<?=$n?>">
        	<input type="hidden" name="seminar_profile[title]" value="<?=$title?>">
            <input type="hidden" name="seminar_profile[credits]" value="25">
				
			<label for="user_email">E-Mail</label>
        	<input id="ajax_email_exists" type="email" class="profil_inputfield" name="seminar_profile[user_email]" required><br>
        	<div id="ajax_email_exists_error"></div><br><br>
        	
        	<label for="user_anrede">Anrede</label> 
        	<select id="user_anrede" name="seminar_profile[user_anrede]" required>
        		<option value="Herr">Herr</option>
        		<option value="Frau">Frau</option>
        	</select>
        	<label for="user_first_name">Vorname</label>		
        	<input class="profil_inputfield" id="user_first_name" type="text" name="seminar_profile[user_first_name]" required><br>
        	<label for="user_surname">Nachname</label>
        	<input class="profil_inputfield" id="user_surname" type="text" name="seminar_profile[user_surname]" required><br>
        	<label for="user_telefon">Telefon</label>
        	<input class="profil_inputfield" id="user_telefon" type="tel"  name="seminar_profile[user_telefon]"><br>
        	<label for="user_company">(ggf. Firma)</label>
            <input class="profil_inputfield" id="user_company" type="text" name="seminar_profile[user_company]"><br>
        	<label for="user_street">Stra&szlig;e</label>
        	<input class="profil_inputfield" id="user_street" type="text" name="seminar_profile[user_street]" required><br>
        	<label for="user_plz">PLZ</label> 
        	<input class="profil_inputfield" id="user_plz" type="text" name="seminar_profile[user_plz]" required><br>
        	<label for="user_city">Ort</label>
        	<input class="profil_inputfield" id="user_city" type="text" name="seminar_profile[user_city]" required><br>

			<label for="user_country">Land</label>
        	<select id="user_country" name="seminar_profile[user_country]" required>
        			<option value="&Ouml;sterreich">&Ouml;sterreich</option>
        			<option value="Deutschland">Deutschland</option>
        			<option value="Schweiz">Schweiz</option>
        			<option value="Liechtenstein">Liechtenstein</option>
        			<option value="divider" disabled>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
        			<option value="Afghanistan">Afghanistan</option>
        			<option value="&Auml;gypten">&Auml;gypten</option>
        			<option value="Aland">Aland</option>
        			<option value="Albanien">Albanien</option>
        			<option value="Algerien">Algerien</option>
        			<option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option>
        			<option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option>
        			<option value="Andorra">Andorra</option>
    					<option value="Angola">Angola</option>
    					<option value="Anguilla">Anguilla</option>
    					<option value="Antarktis">Antarktis</option>
    					<option value="Antigua und Barbuda">Antigua und Barbuda</option> 					
              <option value="&Auml;quatorialguinea">&Auml;quatorialguinea</option>
              <option value="Argentinien">Argentinien</option>
              <option value="Armenien">Armenien</option>                    
              <option value="Aruba">Aruba</option>
              <option value="Ascension">Ascension</option>
              <option value="Aserbaidschan">Aserbaidschan</option>
              <option value="&Auml;thiopien">&Auml;thiopien</option>
              <option value="Australien">Australien</option>
              <option value="Bahamas">Bahamas</option>
              <option value="Bahrain">Bahrain</option>
              <option value="Bangladesch">Bangladesch</option>
              <option value="Barbados">Barbados</option>
              <option value="Belgien">Belgien</option>
              <option value="Belize">Belize</option>
              <option value="Benin">Benin</option>
              <option value="Bermuda">Bermuda</option>
              <option value="Bhutan">Bhutan</option>
              <option value="Bolivien">Bolivien</option>
              <option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option>
              <option value="Botswana">Botswana</option>
              <option value="Bouvetinsel">Bouvetinsel</option>
              <option value="Brasilien">Brasilien</option>
              <option value="Brunei">Brunei</option>
              <option value="Bulgarien">Bulgarien</option>
              <option value="Burkina Faso">Burkina Faso</option>
              <option value="Burundi">Burundi</option>
              <option value="Chile">Chile</option>
              <option value="China">China</option>
              <option value="Cookinseln">Cookinseln</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Cote d'Ivoire">Cote d'Ivoire</option>
              <option value="D&auml;nemark">D&auml;nemark</option>
              <option value="Diego Garcia">Diego Garcia</option>
              <option value="Dominica">Dominica</option>
              <option value="Dominikanische Republik">Dominikanische Republik</option>
              <option value="Dschibuti">Dschibuti</option>
              <option value="Ecuador">Ecuador</option>
              <option value="El Salvador">El Salvador</option>
              <option value="Eritrea">Eritrea</option>
              <option value="Estland">Estland</option>
              <option value="Europ&auml;ische Union">Europ&auml;ische Union</option>
              <option value="Falklandinseln">Falklandinseln</option>
              <option value="F&auml;r&ouml;er">F&auml;r&ouml;er</option>
              <option value="Fidschi">Fidschi</option>
              <option value="Finnland">Finnland</option>
              <option value="Frankreich">Frankreich</option>
              <option value="Franz&ouml;sisch-Guayana">Franz&ouml;sisch-Guayana</option>
              <option value="Franz&ouml;sisch-Polynesien">Franz&ouml;sisch-Polynesien</option>
              <option value="Gabun">Gabun</option>
              <option value="Gambia">Gambia</option>
              <option value="Georgien">Georgien</option>
              <option value="Ghana">Ghana</option>
              <option value="Gibraltar">Gibraltar</option>
              <option value="Grenada">Grenada</option>
              <option value="Griechenland">Griechenland</option>
              <option value="Gr&ouml;nland">Gr&ouml;nland</option>
              <option value="Gro&szlig;britannien">Gro&szlig;britannien</option>
              <option value="Guadeloupe">Guadeloupe</option>
              <option value="Guam">Guam</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Guernsey">Guernsey</option>
              <option value="Guinea">Guinea</option>
              <option value="Guinea-Bissau">Guinea-Bissau</option>
              <option value="Guyana">Guyana</option>
              <option value="Haiti">Haiti</option>
              <option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option>
              <option value="Honduras">Honduras</option>
              <option value="Hongkong">Hongkong</option>
              <option value="Indien">Indien</option>
              <option value="Indonesien">Indonesien</option>
              <option value="Irak">Irak</option>
              <option value="Iran">Iran</option>
              <option value="Irland">Irland</option>
              <option value="Island">Island</option>
              <option value="Israel">Israel</option>
              <option value="Italien">Italien</option>
              <option value="Jamaika">Jamaika</option>
              <option value="Japan">Japan</option>
              <option value="Jemen">Jemen</option>
              <option value="Jersey">Jersey</option>
              <option value="Jordanien">Jordanien</option>
              <option value="Kaimaninseln">Kaimaninseln</option>
              <option value="Kambodscha">Kambodscha</option>
              <option value="Kamerun">Kamerun</option>
              <option value="Kanada">Kanada</option>
              <option value="Kanarische Inseln">Kanarische Inseln</option>
              <option value="Kap Verde">Kap Verde</option>
              <option value="Kasachstan">Kasachstan</option>
              <option value="Katar">Katar</option>
              <option value="Kenia">Kenia</option>
              <option value="Kirgisistan">Kirgisistan</option>
              <option value="Kiribati">Kiribati</option>
              <option value="Kokosinseln">Kokosinseln</option>
              <option value="Kolumbien">Kolumbien</option>
              <option value="Komoren">Komoren</option>
              <option value="Kongo">Kongo</option>
              <option value="Kroatien">Kroatien</option>
              <option value="Kuba">Kuba</option>
              <option value="Kuwait">Kuwait</option>
              <option value="Laos">Laos</option>
              <option value="Lesotho">Lesotho</option>
              <option value="Lettland">Lettland</option>
              <option value="Libanon">Libanon</option>
              <option value="Liberia">Liberia</option>
              <option value="Libyen">Libyen</option>
              <option value="Litauen">Litauen</option>
              <option value="Luxemburg">Luxemburg</option>
              <option value="Macao">Macao</option>
              <option value="Madagaskar">Madagaskar</option>
              <option value="Malawi">Malawi</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Malediven">Malediven</option>
              <option value="Mali">Mali</option>
              <option value="Malta">Malta</option>
              <option value="Marokko">Marokko</option>
              <option value="Marshallinseln">Marshallinseln</option>
              <option value="Martinique">Martinique</option>
              <option value="Mauretanien">Mauretanien</option>
              <option value="Mauritius">Mauritius</option>
              <option value="Mayotte">Mayotte</option>
              <option value="Mazedonien">Mazedonien</option>
              <option value="Mexiko">Mexiko</option>
              <option value="Mikronesien">Mikronesien</option>
              <option value="Moldawien">Moldawien</option>
              <option value="Monaco">Monaco</option>
              <option value="Mongolei">Mongolei</option>
              <option value="Montserrat">Montserrat</option>
              <option value="Mosambik">Mosambik</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Namibia">Namibia</option>
              <option value="Nauru">Nauru</option>
              <option value="Nepal">Nepal</option>
              <option value="Neukaledonien">Neukaledonien</option>
              <option value="Neuseeland">Neuseeland</option>
              <option value="Neutrale Zone">Neutrale Zone</option>
              <option value="Nicaragua">Nicaragua</option>
              <option value="Niederlande">Niederlande</option>
              <option value="Niederl&auml;ndische Antillen">Niederl&auml;ndische Antillen</option>
              <option value="Niger">Niger</option>
              <option value="Nigeria">Nigeria</option>
              <option value="Niue">Niue</option>
              <option value="Nordkorea">Nordkorea</option>
              <option value="N&ouml;rdliche Marianen">N&ouml;rdliche Marianen</option>
              <option value="Norfolkinsel">Norfolkinsel</option>
              <option value="Norwegen">Norwegen</option>
              <option value="Oman">Oman</option>
              <option value="Pakistan">Pakistan</option>
              <option value="Pal&auml;stina">Pal&auml;stina</option>
              <option value="Palau">Palau</option>
              <option value="Panama">Panama</option>
              <option value="Papua-Neuguinea">Papua-Neuguinea</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Peru">Peru</option>
              <option value="Philippinen">Philippinen</option>
              <option value="Pitcairninseln">Pitcairninseln</option>
              <option value="Polen">Polen</option>
              <option value="Portugal">Portugal</option>
              <option value="Puerto Rico">Puerto Rico</option>
              <option value="Réunion">Réunion</option>
              <option value="Ruanda">Ruanda</option>
              <option value="Rum&auml;nien">Rum&auml;nien</option>
              <option value="Russische F&ouml;deration">Russische F&ouml;deration</option>
              <option value="Salomonen">Salomonen</option>
              <option value="Sambia">Sambia</option>
              <option value="Samoa">Samoa</option>
              <option value="San Marino">San Marino</option>
              <option value="São Tomé und Príncipe">São Tomé und Príncipe</option>
              <option value="Saudi-Arabien">Saudi-Arabien</option>
              <option value="Schweden">Schweden</option>
              <option value="Senegal">Senegal</option>
              <option value="Serbien und Montenegro">Serbien und Montenegro</option>
              <option value="Seychellen">Seychellen</option>
              <option value="Sierra Leone">Sierra Leone</option>
              <option value="Simbabwe">Simbabwe</option>
              <option value="Singapur">Singapur</option>
              <option value="Slowakei">Slowakei</option>
              <option value="Slowenien">Slowenien</option>
              <option value="Somalia">Somalia</option>
              <option value="Spanien">Spanien</option>
              <option value="Sri Lanka">Sri Lanka</option>
              <option value="St. Helena">St. Helena</option>
              <option value="St. Kitts und Nevis">St. Kitts und Nevis</option>
              <option value="St. Lucia">St. Lucia</option>
              <option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option>
              <option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option>
              <option value="S&uuml;dafrika, Republik">S&uuml;dafrika, Republik</option>
              <option value="Sudan">Sudan</option>
              <option value="S&uuml;dkorea">S&uuml;dkorea</option>
              <option value="Suriname">Suriname</option>
              <option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option>
              <option value="Swasiland">Swasiland</option>
              <option value="Syrien">Syrien</option>
              <option value="Tadschikistan">Tadschikistan</option>
              <option value="Taiwan">Taiwan</option>
              <option value="Tansania">Tansania</option>
              <option value="Thailand">Thailand</option>
              <option value="Timor-Leste">Timor-Leste</option>
              <option value="Togo">Togo</option>
              <option value="Tokelau">Tokelau</option>
              <option value="Tonga">Tonga</option>
              <option value="Trinidad und Tobago">Trinidad und Tobago</option>
              <option value="Tristan da Cunha">Tristan da Cunha</option>
              <option value="Tschad">Tschad</option>
              <option value="Tschechische Republik">Tschechische Republik</option>
              <option value="Tunesien">Tunesien</option>
              <option value="T&uuml;rkei">T&uuml;rkei</option>
              <option value="Turkmenistan">Turkmenistan</option>
              <option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option>
              <option value="Tuvalu">Tuvalu</option>
              <option value="Uganda">Uganda</option>
              <option value="Ukraine">Ukraine</option>
              <option value="Ungarn">Ungarn</option>
              <option value="Uruguay">Uruguay</option>
              <option value="Usbekistan">Usbekistan</option>
              <option value="Vanuatu">Vanuatu</option>
              <option value="Vatikanstadt">Vatikanstadt</option>
              <option value="Venezuela">Venezuela</option>
              <option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option>
              <option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Wallis und Futuna">Wallis und Futuna</option>
              <option value="Weihnachtsinsel">Weihnachtsinsel</option>
              <option value="Wei&szlig;russland">Wei&szlig;russland</option>
              <option value="Westsahara">Westsahara</option>
              <option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option>
              <option value="Zypern">Zypern</option></select>
                    
            <p>Bitte w&auml;hlen Sie Ihre gew&uuml;nschte Zahlungsmethode:</p> 
                
			<input type="hidden" name="ok" value="1">
    		<input type="hidden" name="seminar_profile[betrag]" value="<?php echo $event_price+25; ?>">
    		<input type="hidden" name="level" value="<?=$level?>">

    		<input type="radio" class="profil_radio" name="seminar_profile[zahlung]" value="bank" required>&Uuml;berweisung<br>
    		<input type="radio" class="profil_radio" name="seminar_profile[zahlung]" value="kredit">Paypal<br>
    		<input type="radio" class="profil_radio" name="seminar_profile[zahlung]" value="bar">Bar<br>
			
    	    <input type="submit" class="profil_inputbutton" name="register_seminar_from_outside_submit" value="Anmelden">
    </form>
    </div>
        
    </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>
