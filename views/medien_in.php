<?
require_once('../classes/Login.php');
$title="Medien";
include "_header_in.php";

?>

<div class="content">

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = 1;
  $add_code = $add_id . "0";
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";
  echo "<div style='text-align:center'><hr><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>Zum Korb</a><hr><br></div>";

  if (isset($_SESSION['basket'][$add_code])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}


if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'media' or type LIKE 'audio' or type LIKE 'video') AND id = '$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
  
  				//Change button-value according to media type
   if ($entry3[type] == 'media') { $btn_value = "Herunterladen";} 
  if ($entry3[type] == 'audio') { $btn_value = "Herunterladen";} 
    if ($entry3[type] == 'video') { $btn_value = "Ansehen";}

            	//check, if there is a image in the medien folder
	$img = 'http://test.wertewirtschaft.net/medien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/medien/default.jpg";
	}
	
?>
  	<div class="medien_head">
  		<h1><?=$entry3[title];?></h1>	
		<div>
  		<div class="schriften_img">
			<img src="<?echo $img;?>" alt="<?echo $id;?>">
		</div>
		<div class="schriften_bestellen">
			<?
			if ($_SESSION['Mitgliedschaft'] == 1) {
				echo '<input type="button" value="Herunterladen" class="inputbutton" data-toggle="modal" data-target="#myModal">';
			}
			else { ?>
				<span class="schriften_price"><?php echo $entry3[price]; ?> Credits</span>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      				<input type="hidden" name="add" value="<?php echo $n; ?>" />
     				<!--<select name="quantity">
        				<option value="1">1</option>
        				<option value="2">2</option>
        				<option value="3">3</option>
        				<option value="4">4</option>
        				<option value="5">5</option>        
      				</select> -->
      				<input type="submit" class="inputbutton" value="<?echo $btn_value;?>">
    			</form>
    		<?
			}
			?>
		</div>
		</div>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo "<p>".$entry3[text]."</p>";
  if ($entry3[text2]) echo "<p>".$entry3[text2]."</p>";
?>
  	<div class="medien_anmeldung"><a href='<?echo $_SERVER['PHP_SELF'];?>'>zur&uuml;ck zu den Medien</a></div>
	</div>
<?php
}
     
else {
	
  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>
      <p>Da die meisten unserer G&auml;ste nicht in Wien zuhause sind und unsere Arbeit ein Publikum im gesamten deutschsprachigen Raum anspricht (hinter der Wertewirtschaft stehen deutsche, &ouml;sterreichische, Schweizer und Liechtensteiner Unternehmer), bieten wir selbstverst&auml;ndlich digitale Medien an, die es erlauben, an unseren Erkenntnissen auch aus der Ferne teilzuhaben. Wir geben uns dabei viel M&uuml;he, den Fernzugang so angenehm wie m&ouml;glich zu halten. Sie k&ouml;nnen also nicht nur bequem nachlesen, sondern meist auch nachh&ouml;ren, was sich in der Wertewirtschaft tut.</p>
   </div>
  <?
  } ?>
  
	<div class="medien_seperator">
    	<h1>Audio und Video</h1>
    </div>
	<div class="medien_content">

<?php
$sql = "SELECT * from produkte WHERE (type LIKE 'media' or type LIKE 'audio' or type LIKE 'video') AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
						//Change button-value according to media type
	if ($entry[type] == 'media') { $btn_value = "Herunterladen";} 
  if ($entry[type] == 'audio') { $btn_value = "Herunterladen";} 
    if ($entry[type] == 'video') { $btn_value = "Ansehen";}
	
  $id = $entry[id];
  $n = $entry[n];
            
?>    
	 <a class="medien_title_list" href='?q=<?echo $id;?>'><?echo $entry[title];?></a>
     <p><?echo $entry[text];?></p>
     
     <?
			if ($_SESSION['Mitgliedschaft'] == 1) {
				echo '<div class="centered"><input type="button" value="Herunterladen" class="inputbutton" data-toggle="modal" data-target="#myModal"></div>';
			}
			else { ?>
				<div class='centered'>			
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<span class="medien_price"><?php echo $entry[price]; ?> Credits</span>
      				<input type="hidden" name="add" value="<?php echo $n; ?>">
     				<!--<select name="quantity">
        				<option value="1">1</option>
        				<option value="2">2</option>
        				<option value="3">3</option>
        				<option value="4">4</option>
        				<option value="5">5</option>        
      				</select> -->
      				<input type="submit" class="inputbutton" value="<?echo $btn_value;?>">
    			</form>
    			</div>
    		<?
			}
			?>
     
	 <div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>
	
<?php
	} 
	echo "</div>";
}
?>

<!--	<div class="medien_seperator">
    	<h1>Video</h1>
    </div>
	<div class="medien_content"> -->
<?php
/*
$sql = "SELECT * from produkte WHERE type LIKE 'video' AND status > 0 order by title asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
  $video_id = $entry[id];
 
          echo "<a class='medien_title_list' href='?q=$video_id'>".$entry[title];"</a>"; 
	}

?>
	</div>
<?
}
*/
?>

<!-- </div> -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Herunterladen</h2>
      </div>
      <div class="modal-body">
          <p>Wir freuen uns, dass Sie eine unserer Aufzeichnungen herunterladen m&ouml;chten. Allerdings sind einige Aufnahmen nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt &ndash; wir und unsere G&auml;ste m&uuml;ssten uns ein allzu gro&szlig;es Blatt vor den Mund nehmen, wenn jeder mith&ouml;ren k&ouml;nnte. Das Herunterladen von Medien steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r die meisten Medien kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf alle unsere Medien:</p>
        <div class="subscribe">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail Adresse" name="user_email" required>
          	<input class="inputbutton"  type="submit" name="submit" value="Eintragen" />
          </form>  
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="inputbutton_white" data-dismiss="modal">Schlie&szlig;en</button>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>