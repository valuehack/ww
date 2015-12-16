      <?php
      	//$passed_from = Where was the form included?
      	//$pass_to = To what function should the form be send?
      	  	
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
          	<p>Die Zahlung von 5&euro; pro Teilnehmer erfolgt in bar im Scholarium am Abend des Offenen Salons.</p> 
         	<input type="hidden" name="zahlung" value="bar">

		  	<label for="quantity">Tickets</label>
		  	<select id="quantity" name="product[quantity]">
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
		  <!-- quantity -->
		  <?php
		  
		  #quantity for projekte
		  if ($passed_from == 'projekt'){
		  ?>
		  <div class="projekte_investment">
              <input type="radio" class="projekte_investment_radio" name="product[quantity]" value="150" required>
              150&euro;: Sie erhalten Zugriff auf die Scholien und andere Inhalte.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[quantity]" value="300">
              300&euro;: Ab diesem Beitrag haben Sie als Scholar vollen Zugang zu allen unseren Inhalten und Veranstaltungen.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[quantity]" value="600">
              600&euro;: Ab diesem Beitrag werden Sie Partner, wir f&uuml;hren Sie (au&szlig;er anders gew&uuml;nscht) pers&ouml;nlich mit Link auf unserer Seite an und laden Sie zu einem exklusiven Abendessen ein (oder Sie erhalten einen Geschenkkorb)<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[quantity]" value="1200">
              1200&euro;: Ab diesem Beitrag nehmen wir Sie als Beirat auf und laden Sie zu unserer Strategieklausur ein.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[quantity]" value="2400">
              2400&euro;: Ab diesem Beitrag werden Sie Ehrenpr&auml;sident und bestimmen bis zu zweimal im Jahr ein Thema f&uuml;r das <i>scholarium</i>.<br>  
          </div>
          <?php
          }

		  #quantity for seminare
		  if ($passed_from == 'seminar'){
		  ?>
		  <label for="quantity">Tickets</label>
		  <select id="quantity" name="product[quantity]">
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
		  
		  #quantity for upgrade
		  if ($passed_from == 'upgrade'){
		  ?>
		  <p>Sie haben das Beitragslevel &quot;<?=$level?>&quot; mit einem Jahresbeitrag von <?=$betrag?> gew&auml;hlt.</p>
		  <?php
		  }
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
          <input type="hidden" name="product[event_id]" value="<?=$n?>">
      	  <input type="hidden" name="product[betrag]" value="<?=$event_price?>">
      	  <input type="hidden" name="product[title]" value="<?=$title?>">
      	        		
      	  <?php
      	  #hidden fields for open salon
      	  if ($passed_from == 'open_salon') {
      	  ?>
      	  <!--o_salon + echo $n is used at verification to register to an event-->
      	  <!--<input type="hidden" name="profile[first_reg]" value="<?=$n?>">-->	
      	  ?>
      	  <?php
		  }
      	  #hidden field for seminare
      	  if ($passed_from == 'seminar') {
      	  ?>
          <input type="hidden" name="profile[credits]" value="25">
          <input type="hidden" name="profile[first_reg]" value="seminar_<?=$n?>">
          <?php
		  }
		  
		  #hidden fields for upgrade
		  if ($passed_from == 'upgrade') {
      	  ?>
    	  <input type="hidden" name="profile[level]" value="<?=$level?>">
          <input type="hidden" name="profile[first_reg]" value="upgrade_buerger">
      	  <?php
		  }
		  
		  #hidden fields for projekte
		  if ($passed_from == 'projekt') {
      	  ?>
      	  <input type="hidden" name="profile[first_reg]" value="projekt_<?=$n?>">
      	  <?php
		  }
		  ?>
          
		  <p>Mit dem Klick auf <i>Anmelden</i> best&auml;tigen Sie, dass Sie unsere AGB gelesen haben und anerkennen. <a href="../agb/agb.html" onclick="openpopup(this.href); return false">Unsere AGB finden Sie hier.</a></p>
			
    	  <input type="submit" class="profil_inputbutton" name="<?=$pass_to?>" value="Anmelden" <?if ($spots_available == 0){echo 'disabled';}?>>
      </form>
      </div>