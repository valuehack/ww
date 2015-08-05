<table class='schriften_table'>
<?php
	
while($entry = mysql_fetch_array($result))
{
	$id = $entry[id];
	
		      	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
	
?>
		<tr>
			<td class="schriften_table_a">
				<a href="<? echo "?q=$id";?>"><img src="<?echo $img_url;?>" alt="Cover <?echo $id;?>"></a>
			</td>			
			<td class="schriften_table_b">
				<span><? echo ucfirst($entry[type]);?></span><br>
      			<? echo "<a href='?q=$id'>".$entry[title]." </a>"; ?>
      			<p>
      				<? if (strlen($entry[text]) > 300) {
							echo substr ($entry[text], 0, 300);
              echo '...';
						}
						else {
							echo $entry[text];
						}
					?>
				</p>
			</td>
			<!--<td class="schriften_table_c">	
				<input type="button" class="inputbutton" value="Bestellen / Herunterladen" data-toggle="modal" data-target="#myModal">
			</td>-->
		</tr>

    <tr><td colspan="3"> <div class="centered"><p class='linie'><img style='height: 35px' src='../style/gfx/linie.png' alt=''></p></div></td></tr>


<?php
	}
	echo "</table>";