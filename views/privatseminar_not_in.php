<?
require_once('../classes/Login.php');
$title="Privatseminar";
include "_header_not_in.php"; 
?>
	<div class="content">

	<div class="salon_info">
		<h1>Privatseminar</h1>
		
		<?php
			$static_info = $general->getStaticInfo('privatseminar');
			echo $static_info->info	
		?>
		<p class="content-elm">Wir freuen uns, dass Sie Interesse an einer Teilnahme haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten einer Teilnahme zu erfahren (falls Sie sich schon einmal eingetragen haben, bitte um Login &uuml;ber den Link &quot;Anmelden&quot; oben rechts auf der Seite):</p>
				<div class="centered">
					<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
						<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  						<input type="hidden" name="first_reg" value="privatseminar">
  						<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
					</form>
				</div>
    </div>
<? include "_footer.php"; ?>