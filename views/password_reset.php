<?php include('_header.php'); ?>

<div class="content">
	<div class="password">
<?php if ($login->passwordResetLinkIsValid() == true) { ?>

<form class="passwort" method="post" action="/" name="new_password_form">
    <input type='hidden' name='user_email' value='<?php echo $_GET['user_email']; ?>' />
    <input type='hidden' name='user_password_reset_hash' value='<?php echo $_GET['verification_code']; ?>' />
<br>
    <label class="passwort_label" for="user_password_new">Neues Passwort</label>
    <br>
    <input id="user_password_new" class="inputfield" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
<br>
    <label class="passwort_label" for="user_password_repeat"><?php echo WORDING_NEW_PASSWORD_REPEAT; ?></label>
    <br>
    <input id="user_password_repeat" class="inputfield" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
<br>
    <input type="submit" class="inputbutton" name="submit_new_password" value="<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?>" />
<br>
</form>
<!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
<?php } else { ?>
		<h2>Passwort zur&uuml;cksetzen</h2>
		<form  method="post" action="/password_reset.php" name="password_reset_form">
    		<label  for="user_email"><?php echo WORDING_REQUEST_PASSWORD_RESET; ?></label><br>
    		<input id="user_email" class="inputfield" type="text" name="user_email" required />
    		<input type="submit" class="inputbutton" name="request_password_reset" value="<?php echo WORDING_RESET_PASSWORD; ?>" />
		</form>
<?php } ?>

		<div class="medien_anmeldung"><a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a></div>
	</div>
</div>

<?php include('_footer.php'); ?>