<?php 

$title="Themenwahl";
include ("_header_not_in.php"); 
?>

<div class="content">

	<div class="medien_info">
		<h1>Themenwahl</h1>  

		<?php  
			$topic_static = $general->getStaticInfo('themenwahl');
				
			echo "<p>".$topic_static->info."</p>";
			
			$topic_info = $general->getTopic();
			foreach($topic_info as $row) {
    			$n = $row['n'];
    			$title = $row['title'];
				$amount = $row['amount'];
				$amount_barlength = min($amount, 3000); ?>
			
			<!-- show bar chart of topics -->
			<div>
				<dl>
					<dd class="barlength barlength-<?=$amount_barlength?>"><span class="topic_text">
						<?=$title?>: <?=$amount?></span></dd>
				</dl>				
			</div>
			<?php	} ?>
			

		<!--Button trigger modal-->
    		<input class="inputbutton themenwahl_btn" type="button" value="Abstimmen" data-toggle="modal" data-target="#myModal">

		<p>Sie k&ouml;nnen sich unten kostenlos eintragen, um &uuml;ber unsere Forschungsthemen auf dem Laufenden zu bleiben.</p>
		<div class="centered">
			<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
  				<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  				<input type=hidden name="first_reg" value="Themenwahl">
  				<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
			</form>
		</div>

	</div>	
	
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-login modal-form-width">
      <div class="modal-content-login">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">Themenwahl</h2>
        </div>
        <div class="modal-body">
        	<?php
			echo $topic_static->modal;
			?>
        </div>
        <div class="modal-footer">
			<a href="../spende/"><button type="button" class="inputbutton">Unterst&uuml;tzer werden</button></a>
        </div>
      </div>
    </div>
  </div>

<?php 
include "_footer.php"; 
?>