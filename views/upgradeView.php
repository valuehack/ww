
<?php 
include ("_header.php");
$title="Willkommen!";
 
?>


<div id="center">  
<div id="content">
<!-- clean separation of HTML and PHP -->

<?php 
$ok = $_POST['ok'];
$zahlung = $_POST['payment_type'];
$abo = $_POST['payment_amount'];

$betrag = $abo;
$user_id = $_SESSION['user_id'];

if (!isset($ok))
{
?>
   
            <h2><?php echo $_SESSION['user_name']; ?> <?php echo WORDING_EDIT_YOUR_CREDENTIALS; ?></h2>
            <br>

            <?php 
            echo "This is going to be upgrade view.";

            $result_row = $login->getUserData(trim($_SESSION['user_email']));

            $disableButton = "disabled";

            if ( isset($result_row->Vorname) and trim($result_row->Vorname) and 
                 isset($result_row->Nachname) and trim($result_row->Nachname) and
                 isset($result_row->Land) and trim($result_row->Land) and
                 isset($result_row->Ort) and trim($result_row->Ort) and
                 isset($result_row->Strasse) and trim($result_row->Strasse) )
                {

                $disableButton = "";

                }

            ?>


            <form method="post" action="/upgrade.php" name="upgrade_user_account">
                
                <input type="hidden" name="ok" value="1">

                <!-- <label for="user_password_old"><?php #echo WORDING_OLD_PASSWORD; ?></label> -->
                <input type="radio" name="payment_amount" value="90" required/>Standard<br>
                <input type="radio" name="payment_amount" value="150"/>Middle<br>
                <input type="radio" name="payment_amount" value="300"/>TheBestOne<br>
            <hr>
                <input type="radio" name="payment_type" value="bank" required/>Bank<br>
                <input type="radio" name="payment_type" value="kredit"/>Paypal<br>
                <input type="radio" name="payment_type" value="bar"/>BAR<br>
            <hr>


            <?php if ($disableButton == "disabled") 
                    {
                       echo "To be able to register please fill in account information:<br>" ; 
                       echo "<a href='/edit.php'>Edit your data:</a><br>";
                    }?>


                <input type="submit" name="upgrade_user_account" value="Upgrade" <?php echo $disableButton; ?>/>
            </form>
            <hr/>

    <?php 
}
else 
{ 
?>
            <p><b>Vielen Dank f&uuml;r Ihre Mitgliedschaft!</b></p>

            <p><b>Laufzeit und K&uuml;ndigung:</b></p>

            <p>Die Mitgliedschaft l&auml;uft ein Jahr und verl&auml;ngernt sich automatisch um ein weiteres Jahr wenn Sie nicht zwei Wochen vor Ablauf k&uuml;ndigen. Eine K&uuml;ndigung ist jederzeit m&ouml;glich, E-Mail oder Fax gen&uuml;gt.</p>

            <? if ($abo || $analysen || $pdf2009 || $pdf2011|| $wwv || $wienerschule || $systemtrottel || $endewut || $philosophicum || $praxis)  {
            echo "<p>Sie haben
            <ul>";

            if ($abo==90){echo "<li>Standardmitgliedschaft</li>";}
            if ($abo==150){echo "<li>F&ouml;rdermitgliedschaft (150 &euro;)</li>";}
            if ($abo==300){echo "<li>F&ouml;rdermitgliedschaft (300 &euro;)</li>";}
            //if ($abo==50){echo "<li>reduzierte Mitgliedschaft</li>";}
            if ($analysen) {echo "<li>die gesammelten Analysen</li>";}
            if ($pdf2009) {echo "<li>den Jahrgang 2009 der Scholien als PDF";}
            if ($pdf2010) {echo "<li>den Jahrgang 2010 der Scholien als PDF";}
            if ($pdf2011) {echo "<li>den Jahrgang 2011 der Scholien als PDF";}
            if ($wwv) {echo "<li>Wirtschaft wirklich verstehen</li>";}
            if ($wienerschule) {echo "<li>Die Wiener Schule der National&ouml;konomie</li>";}
            if ($systemtrottel) {echo "<li>Vom Systemtrottel zum Wutb&uuml;rger</li>";}
            if ($endewut) {echo "<li>Das Ende der Wut</li>";}
            if ($philosophicum) {echo "<li>$philosophicum Gutschein(e) f&uuml;r das Philosophicum</li>";}
            if ($praxis) {echo "<li>$praxis Gutschein(e) f&uuml;r die Philosophische Praxis</li>";}

            echo "</ul>bestellt."; }
            if ($spende) {echo "<br><br>Vielen Dank f&uuml; Ihre gro&szlig;&uuml;gige Spende!";}
            if ($gold and $freie_verwendung!=1) {echo "<p><b>Willkommen im ausgew&auml;hlten Kreis unserer M&auml;zene!</b> Wir freuen uns, dass Sie uns bei der Verwirklichung eines konkretes Projektes unterst&uuml;tzen m&ouml;chten!\n\nSie haben sich daf&uuml;r entschieden, unseren Stipendienfonds, unser &Uuml;bersetzungsprojekt und/oder unser Filmprojekt mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!</p>";}
            if ($gold and $freie_verwendung) {echo "<p><b>Willkommen im ausgew&auml;hlten Kreis unserer M&auml;zene!</b> Wir freuen uns, dass Sie sich entschieden haben, unsere Arbeit so gro&szlig;z&uml;gig mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!</p>";}

            ?>


            <? if ($zahlung=="bank")
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
            <INPUT TYPE="hidden" NAME="address1" VALUE="<?php echo $result_row->Strasse?>">
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








<!-- edit form for username / this form uses HTML5 attributes, like "required" and type="email" -->
<!-- <form method="post" action="edit.php" name="user_edit_form_name">
    <label for="user_name"><?php #echo WORDING_NEW_USERNAME; ?></label><br><br>
    <input id="user_name" type="text" name="user_name" pattern="[a-zA-Z0-9]{2,64}" required /> (<?php #echo WORDING_CURRENTLY; ?>: <?php #echo $_SESSION['user_name']; ?>)
    <br><br><input type="submit" name="user_edit_submit_name" value="<?php #echo WORDING_CHANGE_USERNAME; ?>" />
</form><hr/>
<br> -->

<!-- edit form for user email / this form uses HTML5 attributes, like "required" and type="email" -->
<!-- <form method="post" action="edit.php" name="user_edit_form_email">
    <label for="user_email"><?php #echo WORDING_NEW_EMAIL; ?></label><br>
    <input id="user_email" type="email" name="user_email" required /> (<?php #echo WORDING_CURRENTLY; ?>: <?php #echo $_SESSION['user_email']; ?>)
    <br><br><input type="submit" name="user_edit_submit_email" value="<?php #echo WORDING_CHANGE_EMAIL; ?>" />
</form><hr/>
<br> -->
<!-- edit form for user's password / this form uses the HTML5 attribute "required" -->
<!-- <form method="post" action="edit.php" name="user_edit_form_password">
    <label for="user_password_old"><?php #echo WORDING_OLD_PASSWORD; ?></label>
    <input id="user_password_old" type="password" name="user_password_old" autocomplete="off" />
<br>
    <label for="user_password_new"><?php #echo WORDING_NEW_PASSWORD; ?></label>
    <input id="user_password_new" type="password" name="user_password_new" autocomplete="off" />
<br>
    <label for="user_password_repeat"><?php #echo WORDING_NEW_PASSWORD_REPEAT; ?></label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" autocomplete="off" />
<br>
    <input type="submit" name="user_edit_submit_password" value="<?php #echo WORDING_CHANGE_PASSWORD; ?>" />
</form><hr/> -->

<!-- backlink -->



<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>
</div>
<?php 
include ("_side_in.php");
?>
</div>


<?php include('_footer.php'); ?>
