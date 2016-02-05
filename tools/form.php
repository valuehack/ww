      <?php
      	//$passed_from = Where was the form included?
      	//$pass_to = To what function should the form be send?
        # $pass_to - name of the form submit value
      	# working example in /test/
      	
      	//profile[] = personal information, name, e-mail, adress
      	//product[] = product information, betrag, quantity
      	  	
      	if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
      		$result_row = $login->getUserData(trim($_SESSION['user_email']));

			$anrede = trim($result_row->Anrede);
       		$vorname = trim($result_row->Vorname);
        	$nachname = trim($result_row->Nachname);
        	$land = trim($result_row->Land);
        	$ort = trim($result_row->Ort);
        	$strasse = trim($result_row->Strasse);
        	$plz = trim($result_row->PLZ);
		}
      ?>
      <div class="profil payment_width">
      <form method="post" action="<?=$action?>" name="<?=$pass_to?>">

		  <!-- user profile -->
          <!-- ajax_email_exists checks if user email is already registered -->
			<label for="user_email">E-Mail</label>
        	<input id="ajax_email_exists" type="email" class="profil_inputfield" name="profile[user_email]" value="<?php echo $_SESSION['user_email']; ?>" required><br>
        	<div id="ajax_email_exists_error"></div><br><br>
        	
        	<label for="user_anrede">Anrede</label> 
        	<select id="user_anrede" name="profile[user_anrede]" required>
        		<option value="Herr" <?if ($anrede=='Herr'){echo "selected";}?>>Herr</option>
        		<option value="Frau" <?if ($anrede=='Frau'){echo "selected";}?>>Frau</option>
        	</select><br>
        	<label for="user_first_name">Vorname</label>		
        	<input class="profil_inputfield" id="user_first_name" type="text" name="profile[user_first_name]" value="<?=$vorname?>" required><br>
        	<label for="user_surname">Nachname</label>
        	<input class="profil_inputfield" id="user_surname" type="text" name="profile[user_surname]" value="<?=$nachname?>" required><br>
        	<label for="user_telefon">Telefon</label>
        	<input class="profil_inputfield" id="user_telefon" type="tel"  name="profile[user_telefon]" value="<?=$telefon?>"><br>
        	<label for="user_street">Stra&szlig;e</label>
        	<input class="profil_inputfield" id="user_street" type="text" name="profile[user_street]" value="<?=$strasse?>" required><br>
        	<label for="user_plz">PLZ</label> 
        	<input class="profil_inputfield" id="user_plz" type="text" name="profile[user_plz]" value="<?=$plz?>" required><br>
        	<label for="user_city">Ort</label>
        	<input class="profil_inputfield" id="user_city" type="text" name="profile[user_city]" value="<?=$ort?>" required><br>

			<label for="user_country">Land</label>
        	<select id="user_country" name="profile[user_country]" required>        		
            <!-- List of countries -->
            <?php include("_country_list.html") ?>
         	</select><br>
            <!-- end of user profile -->
          
          <!-- payment methods  -->
                   				  
		  <input type="radio" class="profil_radio" name="profile[payment_option]" value="sofort" required><span class="profil_radio_label">SOFORT</span><br>
      	  <input type="radio" class="profil_radio" name="profile[payment_option]" value="paypal"><span class="profil_radio_label">PayPal</span><br>	  

		  <!-- end payment options -->

		  <!-- hidden fields -->
		  <input type="hidden" name="amount" value="20">

          <!-- general -->
      	        	  
      	  <?php
      	  #swich first_reg
      	  switch ($passed_from){
		  	case 'open_salon':
		  		$first_reg = 'opensalon_'.$event_id;
				break;
			case 'seminar':
				$first_reg = 'seminar_'.$event_id;
				break;
			case 'projekt':
				$first_reg = 'projekt_'.$event_id;
				break;
			case 'upgrade':
				$first_reg = 'upgrade_buerger';
				echo '<input type="hidden" name="profile[level]" value="'.$level['level'].'">';
				break;
			default:
				$first_reg = 'unbekannt';
      	  }
  		 ?>
  		 
  		 <input type="hidden" name="profile[first_reg]" value="<?=$first_reg?>">
          
<?php	
		 if (isset($passed_from)) {
?>
         <input type="hidden" name="passed_from" value="<?=$passed_from?>">
		 <input type="hidden" name="product[event_id]" value="<?=$_SESSION['product']['event_id']?>">
		 <input type="hidden" name="product[quantity]" value="<?=$_SESSION['product']['quantity']?>">
		 <input type="hidden" name="profile[level]" value="<?=$level?>">
<?php
		 }
?>
		 <p>Mit dem Klick auf <i>Anmelden</i> best&auml;tigen Sie, dass Sie unsere AGB gelesen haben und anerkennen. <a href="../agb/agb.html" onclick="openpopup(this.href); return false">Unsere AGB finden Sie hier.</a></p>
			
    	 <input type="submit" class="profil_inputbutton" name="<?=$pass_to?>" value="Anmelden" <?//if ($spots_available == 0){echo 'disabled';}?>>
      </form>
      </div>

<script>
function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
}
</script>