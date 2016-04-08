<?php
	## Variables that need to be passed through the process
	$event_id = $_SESSION['product']['event_id'];
	$passed_from = $_SESSION['passed_from'];
	$quantity = $_SESSION['product']['quantity'];
	$level = $_SESSION['profile']['level'];
		
	###############################
	###      Personal Info      ###
	###############################
	
	//if($_SESSION['payment_page'] == 'user_info') {
	if($_GET['q'] == 'user_info') {
		$title="Zahlung - Pers&ouml;nliche Informationen";
	
		include('_header_not_in.php');
	
		echo '<div class="content">';
		echo '<div class="content-area">';
		echo '<div class="h1 centered">Pers&ouml;nliche Informationen</div>';
		echo '</div>';
		
		$pass_to = 'payment_submit';
		$action = htmlspecialchars('index.php?q=summary');
		// payment_submit
		
		#include the form
		include('../tools/form.php');
	
		echo '</div>';
		
	}
		
	###############################
	###       Confirmation      ###
	###############################
	
	//if($_SESSION['payment_page] == 'show_summary') {
	if($_GET['q'] == 'summary') {
		
		$title="Zahlung - &Uuml;bersicht";
	
		include('_header_not_in.php');
		
		/*
		$event_id = 666670;
		$passed_from = 'seminar';
		$quantity = 2;
		$_SESSION['anrede'] = 'Herr';
		$_SESSION['name'] = 'Ulrich';
		$_SESSION['surname'] = 'Moller';
		$_SESSION['email'] = 'bartholos@web.de';
		$_SESSION['street'] = 'Jenzschstrasse 13';
		$_SESSION['plz'] = '99867';
		$_SESSION['city'] = 'Gotha';
		$_SESSION['country'] = 'Deutschland';
		$_SESSION['payment_option'] = 'sofort';
		*/
		
		# event info 
		$product_info = $general->getProduct($event_id);
		$event_date = $general->getDate($product_info->start, $product_info->end);

		if ($passed_from === 'seminar') 
		{
			$total = $quantity*$product_info->price;
			$membership = 'Teilnehmer';
			$level = 3;

		}

		if ($passed_from === 'projekt' || $passed_from === 'upgrade') {
			switch($level) 
			{
				case 3: $total = 150; $membership ='Teilnehmer'; break;
				case 4: $total = 300; $membership ='Scholar'; break;
				case 5: $total = 600; $membership ='Partner'; break;
				case 6: $total = 1200; $membership ='Beirat'; break;
				case 7: $total = 2400; $membership ='Patron'; break;
				default: $total = 75; $membership ='Gast'; break;
			}

		}

		#set total and level values to session vars
		$_SESSION['product']['payment_total'] = $total;
		
		$now = date('d.m.Y', time());
			
		#membership ends one year (31536000 sec) from today 
	    $membership_end = date('d.m.Y', time()+31536000);
?>
		<div class="content">
			<div class="content-area">
				<div class="row-group">
					<div class="row row__body">
						<div class="col-8">
							<p class="h1">&Uuml;bersicht Ihrer Bestellung</p>
							<p class="h1__sub">Bitte &uuml;berpr&uuml;fen Sie Ihre Angaben</p>
						</div>
					</div>
				</div>
				<div class="row-group">
					<p class="h3">Produkt</p>
<?php
					if ($passed_from === 'seminar') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1"><?=$quantity?></div>
						<div class="col-5">
							<div class="col__content">
								<?=$product_info->title?><br>
								<?=$event_date?>
							</div>
						</div>
						<div class="col-1"><?=$product_info->price?></div>
						<div class="col-1"><?=$total?></div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5">Einj&auml;hrige Mitgliedschaft <i><?=$membership?></i> (<?=$now?> - <?=$membership_end?>)</div>
						<div class="col-1">0</div>
						<div class="col-1">0</div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><?=$total?></div>
					</div>					
<?php					
					}
					if ($passed_from === 'projekt') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1"><?=$total?></div>
						<div class="col-5">
							<div class="col__content">
								<?=ucfirst($product_info->type)?> <?=$product_info->title?>
							</div>
						</div>
						<div class="col-1">1</div>
						<div class="col-1"><?=$total?></div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5">Einj&auml;hrige Mitgliedschaft <i><?=$membership?></i> (<?=$now?> - <?=$membership_end?>)</div>
						<div class="col-1">0</div>
						<div class="col-1">0</div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><?=$total?></div>
					</div>

<?php			
					}
					if ($passed_from === 'upgrade') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5">
							<div class="col__content">
								Abo: Mitgliedschaftslevel <i><?=$membership?></i> (<?=$now?> - <?$membership_end?>)
							</div>
						</div>
						<div class="col-1"><?=$total?></div>
						<div class="col-1"><?=$total?></div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><?=$total?></div>
					</div>
						
<?php					
					}				
?>				
				</div>
				<div class="row-group">
					<div class="row row__body">
						<div class="col-4">
							<p class="h3">Pers&ouml;nliche Informationen</p>
						</div>
						<div class="col-4">
							<p class="h3">Zahlung</p>
						</div> 
					</div>
					<div class="row row__body">
						<div class="col-4">
							<div class="col__content">
								<?=$_SESSION['profile']['user_anrede']?> <?=$_SESSION['profile']['user_first_name']?> <?=$_SESSION['profile']['user_surname']?><br>
								<?=$_SESSION['profile']['user_email']?><br>
								<?=$_SESSION['profile']['user_street']?><br>
								<?=$_SESSION['profile']['user_plz']?> <?=$_SESSION['profile']['user_city']?><br>
								<?=$_SESSION['profile']['user_country']?><br>
							</div>
						</div>
						<div class="col-4">								
								<?if ($_SESSION['profile']['payment_option'] == 'paypal') echo 'PayPal'?>
								<?if ($_SESSION['profile']['payment_option'] == 'sofort') echo 'SOFORT'?>
						</div>
					</div>
				</div>
				<div class="row-group">
					<div class="row row__body">
						<div class="col-8">
							<div class="col__content">
								
								<form method="post" action="<?=htmlentities('index.php')?>">
									<input type="submit" class="profil_inputbutton" name="change_info_submit" value="Angaben &auml;ndern">
    	 							<input type="submit" class="profil_inputbutton" name="confirmed_submit" value="Verbindlich bestellen">
								</form>
							</div>
						</div>				
					</div>
				</div>
			</div>		
		</div>

<?php  
#testing
print_r($_SESSION);
?>
<?php
	}
		
	###############################
	###           Edit          ###
	###############################
	
	//if($_SESSION['payment_page'] == 'edit_info') {
	if($_GET['q'] == 'edit') {
		
		$title="Zahlung - &Auml;nderung";
	
		include('_header_not_in.php');
		
		/*
		$event_id = 666671;
		$passed_from = 'upgrade';
		$quantity = 2;
		$level = 4;
		$_SESSION['anrede'] = 'Herr';
		$_SESSION['name'] = 'Ulrich';
		$_SESSION['surname'] = 'Moller';
		$_SESSION['email'] = 'bartholos@web.de';
		$_SESSION['street'] = 'Jenzschstrasse 13';
		$_SESSION['plz'] = '99867';
		$_SESSION['city'] = 'Gotha';
		$_SESSION['country'] = 'Deutschland';
		$_SESSION['payment_option'] = 'sofort';
		*/
		
		# event info 
		$product_info = $general->getProduct($event_id);
		$event_date = $general->getDate($product_info->start, $product_info->end);

		$spots_available = $product_info->spots-$product_info->spots_sold;

		if ($passed_from === 'seminar') {
			$total = $quantity*$product_info->price;
			$membership = 'Teilnehmer';
		}
		if ($passed_from === 'projekt' || $passed_from === 'upgrade') {
			switch($level) {
				case 3: $total = 150; $membership ='Teilnehmer'; break;
				case 4: $total = 300; $membership ='Scholar'; break;
				case 5: $total = 600; $membership ='Partner'; break;
				case 6: $total = 1200; $membership ='Beirat'; break;
				case 7: $total = 2400; $membership ='Patron'; break;
				default: $total = 75; $membership ='Gast'; break;
			}
		}
?>
		<div class="content">
			<div class="content-area">
				<div class="row-group">
					<div class="row row__body">
						<div class="col-8">
							<p class="h1">&Auml;nderung Ihrer Bestellung</p>
							<p class="h1__sub">Bitte &uuml;berpr&uuml;fen Sie Ihre Angaben</p>
						</div>
					</div>
				</div>
				<div class="row-group">
					<p class="h3">Produkt</p>
					
					<form method="post" action="<?=htmlentities('index.php?q=summary')?>">
<?php
					if ($passed_from === 'seminar') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1">
							<select id="quantity" name="product[quantity]" onchange="changePrice(this.value,'<?=$product_info->price?>')">
		  						<?php
								if($quantity == 1) $selected1 = ' selected';
								if($quantity == 2) $selected2 = ' selected';
								if($quantity == 3) $selected3 = ' selected';
								if($quantity == 4) $selected4 = ' selected';
								if($quantity == 5) $selected5 = ' selected';
								
		  						if ($spots_available == 0){echo '<option value="0" disabled>0</option>';}
		  						if ($spots_available >= 1){echo '<option value="1"'.$selected1.'>1</option>';}
		  						if ($spots_available >= 2){echo '<option value="2"'.$selected2.'>2</option>';}
		  						if ($spots_available >= 3){echo '<option value="3"'.$selected3.'>3</option>';}
		  						if ($spots_available >= 4){echo '<option value="4"'.$selected4.'>4</option>';}
		  						if ($spots_available >= 5){echo '<option value="5"'.$selected5.'>5</option>';}
		  						?>
		  					</select>
		  				</div>
						<div class="col-5">
							<div class="col__content">
								<?=$product_info->title?><br>
								<?=$event_date?>
							</div>
						</div>
						<div class="col-1"><?=$product_info->price?></div>
						<div class="col-1"><span id="change"><?=$total?></span>&euro;</div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5"><?=$membership?></div>
						<div class="col-1">0</div>
						<div class="col-1">0</div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><span id="change"><?=$total?></span>&euro;</div>
					</div>					
<?php					
					}
					if ($passed_from === 'projekt') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1">
							<select id="quantity" name="product[total]" onchange="changePrice(this.value,'1')">
		  						<?php
								if($total == 75) $selected75 = ' selected';
								if($total == 150) $selected150 = ' selected';
								if($total == 300) $selected300 = ' selected';
								if($total == 600) $selected600 = ' selected';
								if($total == 1200) $selected1200 = ' selected';
								if($total == 2400) $selected2400 = ' selected';
								
		  						if ($spots_available == 0){echo '<option value="0" disabled>0</option>';}
		  						if ($spots_available >= 150){echo '<option value="150"'.$selected150.'>150</option>';}
		  						if ($spots_available >= 300){echo '<option value="300"'.$selected300.'>300</option>';}
		  						if ($spots_available >= 600){echo '<option value="600"'.$selected600.'>600</option>';}
		  						if ($spots_available >= 1200){echo '<option value="1200"'.$selected1200.'>1200</option>';}
		  						if ($spots_available >= 2400){echo '<option value="2400"'.$selected2400.'>2400</option>';}
		  						?>
		  					</select></div>
						<div class="col-5">
							<div class="col__content">
								<?=ucfirst($product_info->type)?> <?=$product_info->title?>
							</div>
						</div>
						<div class="col-1">1</div>
						<div class="col-1"><span id="change"><?=$total?></span>&euro;</div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5"><?=$membership?></div>
						<div class="col-1">0</div>
						<div class="col-1">0</div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><span id="change"><?=$total?></span>&euro;</div>
					</div>

<?php			
					}
					if ($passed_from === 'upgrade') {
?>
					<div class="row row__head">
						<div class="col-1">Menge</div>
						<div class="col-5">&nbsp;</div>
						<div class="col-1">Einzelpreis</div>
						<div class="col-1">Gesamtpreis</div>
					</div>
					<div class="row row__body">
						<div class="col-1">1</div>
						<div class="col-5">
							<div class="col__content">
								Abo: Mitgliedschaftslevel
								<select id="quantity" name="product[total]" onchange="changePrice(this.value,'1')">
		  						<?php
								if($total == 75) $selected75 = ' selected';
								if($total == 150) $selected150 = ' selected';
								if($total == 300) $selected300 = ' selected';
								if($total == 600) $selected600 = ' selected';
								if($total == 1200) $selected1200 = ' selected';
								if($total == 2400) $selected2400 = ' selected';
								?>
		  						<option value="75" <?=$selected75?>>Gast (6,25&euro;/Monat)</option>
		  						<option value="150" <?=$selected150?>>Teilnehmer (12,50&euro;/Monat)</option>
		  						<option value="300" <?=$selected300?>>Scholar (25&euro;/Monat)</option>
		  						<option value="600" <?=$selected600?>>Partner (50&euro;/Monat)</option>
		  						<option value="1200" <?=$selected1200?>>Beirat (100&euro;/Monat)</option>
		  						<option value="2400" <?=$selected2400?>>Patron (200&euro;/Monat)</option>
		  						
		  					</select>
							</div>
						</div>
						<div class="col-1"><span id="change"><?=$total?></span></div>
						<div class="col-1"><span id="change"><?=$total?></span></div>
					</div>
					<div class="row row__foot">
						<div class="col-6">&nbsp;</div>
						<div class="col-1">Gesamt:</div>
						<div class="col-1"><span id="change"><?=$total?></span></div>
					</div>
						
<?php					
					}				
?>				
				</div>
				<div class="row-group">
					<div class="row row__body">
						<div class="col-4">
							<p class="h3">Pers&ouml;nliche Informationen</p>
						</div>
						<div class="col-4">
							<p class="h3">Zahlung</p>
						</div> 
					<div class="row row__body">
						<div class="col-4">
							<div class="col__content">
								<select class="profil_select" name="profile[anrede]">
									<option value="Herr"<?if($_SESSION['profile']['user_anrede'] == 'Herr') echo 'selected'?>>Herr</option>
									<option value="Frau"<?if($_SESSION['profile']['user_anrede'] == 'Frau') echo 'selected'?>>Frau</option>
								</select><br>
								<input type="email" class="profil_inputfield" name="profile['user_first_name']" value="<?=$_SESSION['profile']['user_first_name']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_surname']" value="<?=$_SESSION['profile']['user_surname']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_email']" value="<?=$_SESSION['profile']['user_email']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_street']" value="<?=$_SESSION['profile']['user_street']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_plz']" value="<?=$_SESSION['profile']['user_plz']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_city']" value="<?=$_SESSION['profile']['user_city']?>"><br> 
								<input type="text" class="profil_inputfield" name="profile['user_country']" value="<?=$_SESSION['profile']['user_country']?>"><br> 
							</div>
						</div>
						<div class="col-4">
							<input type="radio" name="profile['payment_option']" value="paypal" <?if($_SESSION['profile']['payment_option'] == 'paypal') echo 'checked'?> required>PayPal<br>
							<input type="radio" name="profile['payment_option']" value="sofort" <?if($_SESSION['profile']['payment_option'] == 'sofort') echo 'checked'?>>SOFORT		
						</div>
					</div>
				</div>
				<div class="row-group">
					<div class="row row__body">
						<div class="col-8">
							<div class="col__content">
								
    	 							<input type="submit" class="profil_inputbutton" name="confirmed_submit" value="Verbindlich bestellen" disabled>
								</form>
							</div>
						</div>				
					</div>
				</div>
			</div>		
		</div>
<?php
	}

	include('_footer.php');
?>
<script>
function changePrice(totalQuantity, price){
    	document.getElementById("change").innerHTML = (totalQuantity * price);
}
</script>