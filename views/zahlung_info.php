 <?php  ?>
 <?php 

## this page only displays the extra information 
session_start();
include('../views/_header_not_in.php');         
require_once('../config/config.php');
include('../views/_db.php');

?>

<div class="content">
<div class="payment">
<div class="payment_success>"<p><b>Vielen Dank f&uuml;r Ihre Unterst&uuml;tzung!</b></p>
 
 <?php

if (isset($_SESSION["projekte_profile"]))
{
    $profile = $_SESSION["projekte_profile"];
}
else if (isset($_SESSION["seminar_profile"]))
{
    $profile = $_SESSION["seminar_profile"];
}

$user_email = $profile[user_email];
$zahlung = $profile[zahlung];

#replace with case and functions
#fuck if
    if ($zahlung=="bank") {
        #$result_row = $login->getUserData(trim($_SESSION['user_email']));
    
    ?>
    <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <b><?php echo $profile[betrag] ?></b> an:</p>
      <li>scholarium</li>
      <li>Erste Bank, Wien/&Ouml;sterreich</li>
      <li>IBAN: AT81 2011 1827 1589 8501</li>
      <li>BIC: GIBAATWW</li>
      </ul></p>

      <p><b>Bitte verwenden Sie als Zahlungsreferenz/Betreff unbedingt &quot;<?php echo strtr($profile[user_email], array("@" => "[at]")) ?>&quot;</b></p>
    
    <?php
    }

    if ($zahlung=="kredit")
    {
    
    #used to populate paypal 
    #$result_row = $login->getUserData(trim($_SESSION['user_email']));

    ?>
    <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <b><?php echo $profile[betrag] ?></b> per Paypal: Einfach auf das Symbol unterhalb klicken, Ihre Kreditkartennummer eingeben, fertig. Unser Partner PayPal garantiert eine schnelle, einfache und sichere Zahlung (an Geb&uuml;hren fallen 2-3% vom Betrag an). Sie m&uuml;ssen kein eigenes Konto bei PayPal einrichten, die Eingabe Ihrer Kreditkartendaten reicht.</p>

    <div class="centered">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" name="paypal">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="info@scholarium.at">
            <input type="hidden" name="item_name" value="Mitglied Nr.<?php echo $profile[user_email]?>">
            <input type="hidden" name="amount" value="<?php echo $profile[betrag] ?>">
            <input type="hidden" name="shipping" value="0">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="tax" value="0">

            <!-- prepopulate paypal -->
<!--             <INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo $result_row->Vorname ?>">
            <INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo $result_row->Nachname ?>">
            <INPUT TYPE="hidden" NAME="address1" VALUE="<?php echo $result_row->Strasse ?>">
            <INPUT TYPE="hidden" NAME="city" VALUE="<?php echo $result_row->Ort ?>">
            <INPUT TYPE="hidden" NAME="zip" VALUE="<?php echo "" ?>">
            <INPUT TYPE="hidden" NAME="lc" VALUE="AT"> -->

            <input type="hidden" name="bn" value="PP-BuyNowBF">
            <input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but6.gif" border="0" name="submit" alt="" style="border:none">
            <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>


    <?
    }

    elseif ($zahlung=="bar")
    {
      echo "<p>Bitte schicken Sie uns den gew&auml;hlten Betrag von ".$profile[betrag]. " &euro; in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an das scholarium, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.</p>";
    }

echo "</div></div></div>";

include('_footer.php');
?>

