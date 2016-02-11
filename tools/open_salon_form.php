      <?php
      	//$pass_to = 'user_create_profile_form'; //Register from Outside
      	//$submit = 'register_o_salon_from_outside_submit';//Register from Outside 
      	
      	//TODO change the submit name      	
      	if (isset($_SESSION['user_id'])) {
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
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="<?=$pass_to?>">

		  <!-- user profile -->
          <!-- ajax_email_exists checks if user email is already registered -->
			<label for="user_email">E-Mail</label>
        	<input id="ajax_email_exists" type="email" class="profil_inputfield" name="profile[user_email]" value="<?php echo $_SESSION['user_email']; ?>" required><br>
        	<div id="ajax_email_exists_error"></div><br><br>
        	
        	<label for="user_anrede">Anrede</label> 
        	<select id="user_anrede" name="profile[user_anrede]" required>
        		<option value="Herr" <?if ($anrede=='Herr'){echo "selected";}?>>Herr</option>
        		<option value="Frau" <?if ($anrede=='Frau'){echo "selected";}?>>Frau</option>
        	</select>
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
            <!-- this content is static and just takes too much space -->
            <?php include("_country_list.html") ?>
          </select>
          <!-- end of user profile -->
          
          <!-- payment methods  -->
                    
          <!-- payment for open salon -->
          <?php
          if ($spots_total > 59){
          ?>
          	<p>Die Zahlung von 5&euro; pro Teilnehmer erfolgt in bar im scholarium am Abend des Offenen Salons.</p> 
         	<input type="hidden" name="profile[zahlung]" value="bar">

		  	<label for="quantity">Tickets</label>
		  	<select id="quantity" name="profile[quantity]">
		  		<?php
		  		if ($spots_available == 0){echo '<option value="0" disabled>0</option>';}
		  		if ($spots_available >= 1){echo '<option value="1" selected>1</option>';}
		  		if ($spots_available >= 2){echo '<option value="2">2</option>';}
		  		if ($spots_available >= 3){echo '<option value="3">3</option>';}
		  		if ($spots_available >= 4){echo '<option value="4">4</option>';}
		  		if ($spots_available >= 5){echo '<option value="5">5</option>';}
		  		?>
		  	</select>
		  <?php
		  }
		  else {
		  ?>
		  <!-- payment general -->
		  <input type="radio" class="profil_radio" name="zahlung" value="bank" required><span class="profil_radio_label">&Uuml;berweisung</span><br>
      	  <input type="radio" class="profil_radio" name="zahlung" value="kredit"><span class="profil_radio_label">Paypal</span><br>
      	  <input type="radio" class="profil_radio" name="zahlung" value="bar"><span class="profil_radio_label">Bar</span><br>
      	  <?php
		  }
		  ?>
		  <!-- end payment methods -->
		  
          <!-- hidden fields -->
          <!-- general -->
          <input type="hidden" name="profile[event_id]" value="<?=$event_id?>">
      	  <input type="hidden" name="profile[betrag]" value="<?=$event_price?>">
      	  
      	  <!-- Open Salon -->
          <?php #o_salon + echo $n is used at verification to register to an event?>
          <!--<input type="hidden" name="profile[first_reg]" value="<?=$n?>">-->
      		
      	  <!-- Seminar -->
      	  <!-- Projekte -->
      	  <!-- Salon -->
      	  <!-- Upgrade -->
          
          <!-- <input type="hidden" name="profile[title]" value="<?php echo $title ?>"> -->
          <!-- <input type="hidden" name="profile[credits]" value="25"> -->

		  <p>Mit dem Klick auf <i>Anmelden</i> best&auml;tigen Sie, dass Sie unsere AGB gelesen haben und anerkennen. <a href="../agb/agb.html" onclick="openpopup(this.href); return false">Unsere AGB finden Sie hier.</a></p>
			
    	  <input type="submit" class="profil_inputbutton" name="<?=$submit?>" value="Anmelden" <?if ($spots_available == 0){echo 'disabled';}?>>
      </form>
      </div>