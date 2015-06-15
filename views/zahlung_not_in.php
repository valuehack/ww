<?php 

require_once('../classes/Login.php');

$title="Zahlung";

include('_header_not_in.php'); 

?>

<div class="content">
	<div class="payment">
		<h1>Zahlung</h1>
		
<?php
//payments coming from kurse_not_in
if (isset($_POST["registrationform"])) {
    $level = "Kursteilnehmer";
    $betrag = 150;
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $profile = $_POST['profile'];
    $user_email = $profile[user_email];

?>		
		<p>Bitte w&auml;hlen Sie Ihre gew&uuml;nschte Zahlungsmethode:</p>
		
		<div class="payment_form">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upgrade_user_account" accept-charset="UTF-8">
                
    			<input type="hidden" name="ok" value="2">
    			<input type="hidden" name="betrag" value="<?php echo $betrag; ?>">
    			<input type="hidden" name="level" value="<?php echo $level; ?>">
    			<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
    			<input type="hidden" name="title" value="<?php echo $title; ?>">
    			<input type="hidden" name="email" value="<?php echo $user_email; ?>">
    			<input type="hidden" name="profile" value="<?php echo $profile; ?>">

    			<input type="radio" class="payment_form_radio" name="zahlung" value="bank" required>&Uuml;berweisung<br>
    			<input type="radio" class="payment_form_radio" name="zahlung" value="kredit">Paypal<br>
    			<input type="radio" class="payment_form_radio" name="zahlung" value="bar">Bar<br>

    			<input type="submit" class="inputbutton" name="upgrade_user_account" value="Weiter">
			</form>
		</div>
<?php

}

//payments coming from upgrade_not_in
if(isset($_POST['pay'])) {
    $level = $_POST['level'];
    $betrag = $_POST['betrag'];

?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upgrade_user_account" accept-charset="UTF-8">

		<p>Bitte geben Sie Ihre Daten ein:</p>

			<input class="inputfield" id="user_email" type="email" name="profile[user_email]" placeholder=" eMail" required><br> 
			<input class="inputfield" id="user_first_name" type="text" name="profile[user_first_name]" placeholder=" Vorname" required><br>
			<input class="inputfield" id="user_surname" type="text" name="profile[user_surname]" placeholder=" Nachname" required><br>
			<input class="inputfield" id="user_street" type="text" name="profile[user_street]" placeholder=" Stra&szlig;e und Hausnummer" required><br> 
			<input class="inputfield" id="user_plz" type="text" name="profile[user_plz]" placeholder=" Postleitzahl" required><br>
			<input class="inputfield" id="user_city" type="text" name="profile[user_city]" placeholder=" Stadt" required><br>
			<select class="inputfield" id="user_country" name="profile[user_country]" placeholder=" Land" required><option value="<?php echo $result_row->Land; ?>"><?php if ($result_row->Land) echo $result_row->Land; ?></option><option value="Österreich">Österreich</option><option value="Deutschland">Deutschland</option><option value="Schweiz">Schweiz</option><option value="Liechtenstein">Liechtenstein</option><option value="Afghanistan">Afghanistan</option><option value="Ägypten">Ägypten</option><option value="Aland">Aland</option><option value="Albanien">Albanien</option><option value="Algerien">Algerien</option><option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option><option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarktis">Antarktis</option><option value="Antigua und Barbuda">Antigua und Barbuda</option><option value="Äquatorialguinea">Äquatorialguinea</option><option value="Argentinien">Argentinien</option><option value="Armenien">Armenien</option><option value="Aruba">Aruba</option><option value="Ascension">Ascension</option><option value="Aserbaidschan">Aserbaidschan</option><option value="Äthiopien">Äthiopien</option><option value="Australien">Australien</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesch">Bangladesch</option><option value="Barbados">Barbados</option><option value="Belgien">Belgien</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivien">Bolivien</option><option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option><option value="Botswana">Botswana</option><option value="Bouvetinsel">Bouvetinsel</option><option value="Brasilien">Brasilien</option><option value="Brunei">Brunei</option><option value="Bulgarien">Bulgarien</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Chile">Chile</option><option value="China">China</option><option value="Cookinseln">Cookinseln</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="Dänemark">Dänemark</option><option value="Diego Garcia">Diego Garcia</option><option value="Dominica">Dominica</option><option value="Dominikanische Republik">Dominikanische Republik</option><option value="Dschibuti">Dschibuti</option><option value="Ecuador">Ecuador</option><option value="El Salvador">El Salvador</option><option value="Eritrea">Eritrea</option><option value="Estland">Estland</option><option value="Europäische Union">Europäische Union</option><option value="Falklandinseln">Falklandinseln</option><option value="Färöer">Färöer</option><option value="Fidschi">Fidschi</option><option value="Finnland">Finnland</option><option value="Frankreich">Frankreich</option><option value="Französisch-Guayana">Französisch-Guayana</option><option value="Französisch-Polynesien">Französisch-Polynesien</option><option value="Gabun">Gabun</option><option value="Gambia">Gambia</option><option value="Georgien">Georgien</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Grenada">Grenada</option><option value="Griechenland">Griechenland</option><option value="Grönland">Grönland</option><option value="Großbritannien">Großbritannien</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option><option value="Honduras">Honduras</option><option value="Hongkong">Hongkong</option><option value="Indien">Indien</option><option value="Indonesien">Indonesien</option><option value="Irak">Irak</option><option value="Iran">Iran</option><option value="Irland">Irland</option><option value="Island">Island</option><option value="Israel">Israel</option><option value="Italien">Italien</option><option value="Jamaika">Jamaika</option><option value="Japan">Japan</option><option value="Jemen">Jemen</option><option value="Jersey">Jersey</option><option value="Jordanien">Jordanien</option><option value="Kaimaninseln">Kaimaninseln</option><option value="Kambodscha">Kambodscha</option><option value="Kamerun">Kamerun</option><option value="Kanada">Kanada</option><option value="Kanarische Inseln">Kanarische Inseln</option><option value="Kap Verde">Kap Verde</option><option value="Kasachstan">Kasachstan</option><option value="Katar">Katar</option><option value="Kenia">Kenia</option><option value="Kirgisistan">Kirgisistan</option><option value="Kiribati">Kiribati</option><option value="Kokosinseln">Kokosinseln</option><option value="Kolumbien">Kolumbien</option><option value="Komoren">Komoren</option><option value="Kongo">Kongo</option><option value="Kroatien">Kroatien</option><option value="Kuba">Kuba</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Lettland">Lettland</option><option value="Libanon">Libanon</option><option value="Liberia">Liberia</option><option value="Libyen">Libyen</option><option value="Litauen">Litauen</option><option value="Luxemburg">Luxemburg</option><option value="Macao">Macao</option><option value="Madagaskar">Madagaskar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Malediven">Malediven</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marokko">Marokko</option><option value="Marshallinseln">Marshallinseln</option><option value="Martinique">Martinique</option><option value="Mauretanien">Mauretanien</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mazedonien">Mazedonien</option><option value="Mexiko">Mexiko</option><option value="Mikronesien">Mikronesien</option><option value="Moldawien">Moldawien</option><option value="Monaco">Monaco</option><option value="Mongolei">Mongolei</option><option value="Montserrat">Montserrat</option><option value="Mosambik">Mosambik</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Neukaledonien">Neukaledonien</option><option value="Neuseeland">Neuseeland</option><option value="Neutrale Zone">Neutrale Zone</option><option value="Nicaragua">Nicaragua</option><option value="Niederlande">Niederlande</option><option value="Niederländische Antillen">Niederländische Antillen</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Nordkorea">Nordkorea</option><option value="Nördliche Marianen">Nördliche Marianen</option><option value="Norfolkinsel">Norfolkinsel</option><option value="Norwegen">Norwegen</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palästina">Palästina</option><option value="Palau">Palau</option><option value="Panama">Panama</option><option value="Papua-Neuguinea">Papua-Neuguinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippinen">Philippinen</option><option value="Pitcairninseln">Pitcairninseln</option><option value="Polen">Polen</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Réunion">Réunion</option><option value="Ruanda">Ruanda</option><option value="Rumänien">Rumänien</option><option value="Russische Föderation">Russische Föderation</option><option value="Salomonen">Salomonen</option><option value="Sambia">Sambia</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="São Tomé und Príncipe">São Tomé und Príncipe</option><option value="Saudi-Arabien">Saudi-Arabien</option><option value="Schweden">Schweden</option><option value="Senegal">Senegal</option><option value="Serbien und Montenegro">Serbien und Montenegro</option><option value="Seychellen">Seychellen</option><option value="Sierra Leone">Sierra Leone</option><option value="Simbabwe">Simbabwe</option><option value="Singapur">Singapur</option><option value="Slowakei">Slowakei</option><option value="Slowenien">Slowenien</option><option value="Somalia">Somalia</option><option value="Spanien">Spanien</option><option value="Sri Lanka">Sri Lanka</option><option value="St. Helena">St. Helena</option><option value="St. Kitts und Nevis">St. Kitts und Nevis</option><option value="St. Lucia">St. Lucia</option><option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option><option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option><option value="Südafrika, Republik">Südafrika, Republik</option><option value="Sudan">Sudan</option><option value="Südkorea">Südkorea</option><option value="Suriname">Suriname</option><option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option><option value="Swasiland">Swasiland</option><option value="Syrien">Syrien</option><option value="Tadschikistan">Tadschikistan</option><option value="Taiwan">Taiwan</option><option value="Tansania">Tansania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad und Tobago">Trinidad und Tobago</option><option value="Tristan da Cunha">Tristan da Cunha</option><option value="Tschad">Tschad</option><option value="Tschechische Republik">Tschechische Republik</option><option value="Tunesien">Tunesien</option><option value="Türkei">Türkei</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="Ungarn">Ungarn</option><option value="Uruguay">Uruguay</option><option value="Usbekistan">Usbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatikanstadt">Vatikanstadt</option><option value="Venezuela">Venezuela</option><option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option><option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option><option value="Vietnam">Vietnam</option><option value="Wallis und Futuna">Wallis und Futuna</option><option value="Weihnachtsinsel">Weihnachtsinsel</option><option value="Weißrussland">Weißrussland</option><option value="Westsahara">Westsahara</option><option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option><option value="Zypern">Zypern</option></select>

			<p>Bitte w&auml;hlen Sie Ihre gew&uuml;nschte Zahlungsmethode:</p>
                
    		<input type="hidden" name="ok" value="1">
    		<input type="hidden" name="betrag" value="<?php echo $betrag; ?>">
    		<input type="hidden" name="level" value="<?php echo $level; ?>">

    		<input type="radio" class="payment_form_radio" name="zahlung" value="bank" required>&Uuml;berweisung<br>
    		<input type="radio" class="payment_form_radio" name="zahlung" value="kredit">Paypal<br>
    		<input type="radio" class="payment_form_radio" name="zahlung" value="bar">Bar<br>

    		<input type="submit" class="inputbutton" name="upgrade_user_account" value="Weiter">
		</form>

<?php
}

elseif (isset($_POST['ok']))
{
	$level = $_POST['level'];
    $betrag = $_POST['betrag'];
    $zahlung = $_POST['zahlung'];
    
    //after user is created, SESSION variables should be set in Login.php
    $user_id = $_SESSION['user_id'];

    //register for the event
    if ($_POST['ok'] == 2) { 
    
      $user_email = $_POST['email'];
      $id = $_POST['event_id'];
      $title = $_POST['title'];

      echo "<div class='payment_sucess'><p>Vielen Dank, ein Platz in \"".ucfirst($title).'" wurde für Sie reserviert. Außerdem haben wir für Sie die einj&auml;hrige Mitgliedschaft &quot;Kursteilnehmer&quot; freigeschalten und Ihrem Konto 25 Credits hinzugef&uuml;gt.</p></div>';

      $user_query = "SELECT * from mitgliederExt WHERE `user_email` LIKE '$user_email' ";
      $user_result = mysql_query($user_query) or die("Failed Query of " . $user_query. mysql_error());

      $userArray = mysql_fetch_array($user_result);
      $user_id = $userArray[user_id];

      $registration_query = "INSERT INTO registration (id, user_id, quantity, reg_datetime) VALUES ('$id', '$user_id', '1', NOW())";
      mysql_query($registration_query);

      $credits_left = 25;

      $left_credits_query = "UPDATE mitgliederExt SET credits_left='$credits_left' WHERE `user_id` LIKE '$user_id'";
      mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

      $space_query = "UPDATE produkte SET spots_sold = spots_sold + 1 WHERE `n` LIKE '$id'";
      mysql_query($space_query);
                   
      //TO DO: send email, create user first 
    }

    else {
      echo '<div class="payment_sucess>"<p><b>Vielen Dank f&uuml;r Ihre Mitgliedschaft!</b></p>';

      echo '<p><b>Laufzeit und K&uuml;ndigung:</b></p>';

      echo '<p>Die Mitgliedschaft l&auml;uft ein Jahr und verl&auml;ngernt sich automatisch um ein weiteres Jahr wenn Sie nicht zwei Wochen vor Ablauf k&uuml;ndigen. Eine K&uuml;ndigung ist jederzeit m&ouml;glich, E-Mail oder Fax gen&uuml;gt.</p>';

      echo "<p>Sie haben das Abo ".$level." bestellt.</p></div>";

    }




   
    if ($zahlung=="bank")
    {
    ?>
    <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <?php echo $betrag?> an:</p>
    <p><i>International</i>
    <ul>
    <li>Institut f&uuml;r Wertewirtschaft</li>
    <li>Erste Bank, Wien/&Ouml;sterreich</li>
    <li>Kontonummer: 28824799900</li>
    <li>Bankleitzahl: 20111</li>
    <li>IBAN: AT332011128824799900</li>
    <li>BIC: GIBAATWW</li>
    </ul></p>
    
    <p>Alternativ k&ouml;nnen Sie den Gegenwert in Schweizer Franken auf folgendes Konto &uuml;berweisen:</p>

    <p>
    <ul>
    <li>Institut f&uuml;r Wertewirtschaft</li>
    <li>Liechtensteinische Landesbank</li>
    <li>Kontonummer: 23103297</li>
    <li>Bankleitzahl: 08800</li>
    <li>IBAN: LI6308800000023103297</li>
    <li>BIC: LILALI2X</li>
    </ul>
    </p>

    <p><b>Bitte verwenden Sie als Sie als Zahlungsreferenz/Betreff unbedingt &quot;Mitglied Nr. <?php echo $user_id ?>&quot;</b></p>
    
    <?php
    }
    if ($zahlung=="kredit")
    {
    
    #used to populate paypal 
    $result_row = $login->getUserData(trim($_SESSION['user_email']));

    ?>
    <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <?=$betrag?> per Paypal: Einfach auf das Symbol unterhalb klicken, Ihre Kreditkartennummer eingeben, fertig. Unser Partner PayPal garantiert eine schnelle, einfache und sichere Zahlung (an Geb&uuml;hren fallen 2-3% vom Betrag an). Sie m&uuml;ssen kein eigenes Konto bei PayPal einrichten, die Eingabe Ihrer Kreditkartendaten reicht.</p><br>

    <div align="center">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" name="paypal">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="info@wertewirtschaft.org">
    <input type="hidden" name="item_name" value="Mitglied Nr.<?php echo $user_id ?>">
    <input type="hidden" name="amount" value="<?=$betrag?>">
    <input type="hidden" name="shipping" value="0">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="tax" value="0">

    <!-- prepopulate paypal -->
    <INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo $result_row->Vorname ?>">
    <INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo $result_row->Nachname ?>">
    <INPUT TYPE="hidden" NAME="address1" VALUE="<?php echo $result_row->Strasse ?>">
    <INPUT TYPE="hidden" NAME="city" VALUE="<?php echo $result_row->Ort ?>">
    <INPUT TYPE="hidden" NAME="zip" VALUE="<?php echo "" ?>">
    <INPUT TYPE="hidden" NAME="lc" VALUE="AT">

    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but6.gif" border="0" name="submit" alt="" style="border:none">
    <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
    </div>


    <?
    }

    elseif ($zahlung=="bar")
    {
    echo "<p>Bitte schicken Sie uns den gew&auml;hlten Betrag von $betrag &euro; in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an das Institut f&uuml;r Wertewirtschaft, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich im Institut (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.</p>";
    }

}
?>

	</div>
</div>

<?php
include('_footer.php');
?>