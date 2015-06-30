<?php 
$title="Passwort zur&uuml;cksetzen";
include('_header_not_in.php'); ?>

<div class="content">
	<div class="password">
<?php if ($login->passwordResetLinkIsValid() == true) { ?>
		<h1>Neues Passwort</h1>
		<form class="passwort" method="post" action="/" name="new_password_form">
    		<input type='hidden' name='user_email' value='<?php echo $_GET['user_email']; ?>' />
    		<input type='hidden' name='user_password_reset_hash' value='<?php echo $_GET['verification_code']; ?>' />
    		
    		<!--<label class="passwort_label" for="user_password_new">Neues Passwort eingeben</label><br>-->
    		<input id="user_password_new" class="password_inputfield" type="password" name="user_password_new" placeholder="Neues Passwort eingeben" pattern=".{6,}" required autocomplete="off"><br>
    		
    		<!--<label class="passwort_label" for="user_password_repeat"><?php echo WORDING_NEW_PASSWORD_REPEAT; ?></label><br>-->
   			<input id="user_password_repeat" class="password_inputfield" type="password" name="user_password_repeat" placeholder="Passwort wiederholen" pattern=".{6,}" required autocomplete="off"><br>
    		<input type="submit" class="password_inputbutton" name="submit_new_password" value="<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?>" />
		</form>
		
<!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
<?php } else { ?>
		<h1>Passwort zur&uuml;cksetzen</h1>
		<form  method="post" action="/password_reset.php" name="password_reset_form">
    		<label  for="user_email"><?php echo WORDING_REQUEST_PASSWORD_RESET; ?></label><br>
    		<input id="user_email" class="password_inputfield" type="text" name="user_email" placeholder="E-Mail" required />
    		<input type="submit" class="password_inputbutton" name="request_password_reset" value="<?php echo WORDING_RESET_PASSWORD; ?>" />
		</form>
<?php } ?>

		<div class="medien_anmeldung"><a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a></div>
	</div>
</div>

<?php include('_footer.php'); ?>