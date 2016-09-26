<? 
	ini_set("log_errors" , "1");
	ini_set("error_log" , "../classes/error.log");
	ini_set("display_errors" , "0");

	include "../config/header1.inc.php";

	$title="Willkommen!";

	include "header2.inc.php";
?>
	<!-- Begin Landing Content -->
    <div id="">
		<div class="section">
			<div class="main-title">
				<div class="row">
					<div class="one-half column h-centered">
						<img src="../verlag/cover/neuen-intellektuellen.jpg">
					</div>
					<div class="one-half column">
						<h2>Wer werden die neuen Intellektuellen sein?</h2>
						<p>&bdquo;Jeder Mann und jede Frau, der oder die willens ist, zu denken. All jene, die wissen, dass das Leben des Menschen von der Vernunft geleitet werden muss; jene, die ihr eigenes Leben wertsch&auml;tzen und nicht willens sind, es dem Kult der Verzweiflung im heutigen Dschungel zynischer Ohnmacht auszuliefern, so wie sie nicht willens sind, die Welt den Dunklen Zeitaltern und der Herrschaft der Unmenschen zu &uuml;berlassen.&ldquo;</p>
						<div>
							<a class="btn-link" href="../verlag/">Jetzt lesen</a>
						</div>
					</div>
				</div>
			</div>			
		</div>
		<div class="section">
			<div class="row " style="padding:3em 0;">
				<div class="container">
					<div class="one-half column">
						<?php $denker = $general->getRandomInfo('denker');?>
						<div class="card small horizontal">
      						<div class="card-head">      							
      							<? if ($denker->img != '') echo '<img src="'.$denker->img.'" alt="'.$denker->name.'">';?>							
     						</div>
      						<div class="card-stacked">
								<div class="card-content">
									<span class="card-title"><?=$denker->name?></span>
									<p><?=$general->substrCloseTags($denker->bio,200)?></p>
								</div>
								<div class="card-link h-right">
									<a href="?denker=<?=$denker->id?>">Zum Denker</a>
								</div>
							</div>
						</div>						
					</div>
					<div class="one-half column">
						<?php $orte = $general->getRandomInfo('orte');?>
						<div class="card small horizontal">
      						<div class="card-head">      							
      							<? if ($orte->img != '') echo '<img src="'.$orte->img.'" alt="'.$orte->name.'">';?>			
      						</div>
      						<div class="card-stacked">
      							<div class="card-content">
      								<span class="card-title"><?=$orte->name?></span>
									<p><?=$general->substrCloseTags($orte->text,200)?></p>
								</div>
								<div class="card-link h-right">
									<a href="?denker=<?=$orte->id?>">Zum Ort</a>
								</div>
      						</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		
		<div class="section">
			<div class="row">
				<div class="one-half column full-text">
					<h2>Lorem ipsum dolor</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consequat tortor lorem, sit amet fringilla nibh sodales vel. In ullamcorper quam sed laoreet fringilla. Praesent fermentum tortor sit amet lorem tincidunt vehicula. Nullam eleifend nisi eget elit vestibulum, nec dictum sapien semper. Praesent gravida congue elementum. Nunc cursus volutpat metus. Mauris consequat massa non nunc bibendum, non accumsan eros sodales. Donec maximus congue ornare. Vivamus non lorem vel ipsum ultrices dignissim. Nulla id mi ut purus lacinia iaculis in at tellus. Pellentesque tempus vulputate neque at luctus. Etiam molestie nulla et ligula euismod, a tempus orci accumsan. Vestibulum fermentum rhoncus diam ac dapibus. Maecenas eget metus interdum neque vehicula blandit volutpat posuere diam. Nulla facilisis ipsum non leo euismod ultrices. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>

					<p>Ut sit amet ante eu velit ullamcorper commodo. Donec non imperdiet ex. Mauris posuere justo eu libero sollicitudin convallis. Etiam gravida, sem vel laoreet lobortis, ex leo pretium libero, sed viverra massa libero a nisi. Pellentesque posuere, justo non semper pellentesque, eros ex tincidunt neque, non cursus lacus ipsum et justo. Morbi ornare lorem elit, a rhoncus lectus gravida in. Proin at vehicula felis, quis auctor metus. Phasellus eget sapien enim. Pellentesque malesuada id turpis cursus rhoncus. Vivamus consectetur consectetur massa, vel vulputate purus condimentum nec. Suspendisse ex mauris, efficitur a sollicitudin mattis, finibus fermentum sapien. In dapibus sit amet eros eu fermentum.</p>
				</div>
				<div class="one-half column clear-fright">
					<div class="full-img">
						<img src="../style/mises_young.png" alt="Ein Porträit des jungen Ludwig von Mises">
					</div>
				</div>
			</div>

		</div>
    </div>    
	<!-- End Landing Content -->
<?php include "footer.inc.php"?>