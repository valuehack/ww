<?
	require_once (dirname(__DIR__)."/config/header1.inc.php");
	$title="Projekte";
	include "../page/header2.inc.php";
?>
		<div id="content">
			
			<div class="container index-link"><p><a href="../index.php">mises.at</a> / Projekte</p></div>
  		<div class="container">
  			<h1>Projekte</h1>
  			<p>Hier finden Sie eine &Uuml;bersicht unserer aktuellen Projekte.</p>
  		</div>
			
			<div class="container h-centered style-space--bottom ">
				<div class="flex_container">
				<!--div class="row"-->
			
			<?
				$result_projekte = $general->getItemList("projekte", "n", "asc");
				$i = 1;
				
				//echo "<div class='row'>";
				
			for($n=0;$n<=1;$n++){
				foreach($result_projekte as $projekt){
					$titel = $projekt["titel"];
					$autor = $projekt["autor"];
					$desc = $projekt["beschreibung"];
					$spenden = $projekt["spenden"];
					$ziel = $projekt["ziel"];
					$autor_id = $projekt["autor_id"];
					$prozent = ($spenden/$ziel)*100;
					
					
					
			?>
			
			
				<!--div class="one-third column"-->
					<div class="card projectcard">
				<div class="card-content">
						<div class="list-itm h-extra-space__top">
							<h5> <a class="title" href="#"><?=$titel?></a></h5>
							<a class="link" href="../denker/?denker=<?=$autor_id?>"><p class="text--raleway"><?=$autor?></p></a>
							<p><?=$general->addlinks($desc);?></p>
						</div>
						
						<!--div class="list-itm h-white h-centered">
							<a href=#><img class="list-itm_img--big" src="" alt="."></a>
						</div-->
					
				
				<div>
					<progress value="<?=$prozent?>" max="100"></progress>
						<table class="progresstable">
							<tr class="">
								<td class="">
						<p class=""><b><?=$prozent?>%</b> finanziert</p></td><td class=""><p> <b><?=$spenden?>€</b> beigetragen</p></td>
							</tr>
						</table>
					<? if($prozent==100){echo "<br>";} else {?>
					
					<a class="btn-link h-block button-text h-centered" href="mailto:&#105;nf&#111;&#064;&#109;&#105;se&#115;.&#97;&#116;">Kontakt</a><br><br><br><br>
					
					<?}?>
				</div>
			</div>
		</div>
		<!--/div>
		</div-->
		
			
		<?
		/*if((($i%3) == 0)){
			echo "</div><div class='row'>";
		}*/
		$i++;
	}} //echo "</div>";
		?>
	</div>
</div>
    </div>
<?
  include "../page/footer.inc.php"; 
?>
