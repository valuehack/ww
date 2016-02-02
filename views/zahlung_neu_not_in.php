<?php
	## Variables that need to be passed through the process
	$event_id = $_POST['product[event_id]'];
	$passed_from = $_POST['passed_from'];
	$quantity = $_POST['product[quantity]'];
	$level = $_POST['profile[level]'];
	
	###############################
	###      Personal Info      ###
	###############################
	
	if($_GET['q'] == 'userinfo') {
		
		$title="Zahlung - Pers&ouml;nliche Informationen";
	
		include('_header_not_in.php');
	
		echo '<div class="content">';
		echo '<div class="profil">';
		echo '<h1>Pers&ouml;nliche Informationen</h1>';
		echo '</div>';
		
		$action = htmlspecialchars('zahlung_neu.php?q=summary');
		
		include('../tools/form.php');
	
		echo '</div>';
		
	}
		
	###############################
	###       Confirmation      ###
	###############################
	
	if($_GET['q'] == 'summary') {
		
		$title="Zahlung - &Uml;bersicht";
	
		include('_header_not_in.php');
	
		echo '<div class="content">';
		echo '<div class="profil">';
		## Maybe HTML should be moved to seperate include file
		echo '<h1>&Uuml;bersicht Ihrer Bestellung</h1>';
		echo '</div>';
		
		echo '</div>';
	}
		
	include('_footer.php');
?>