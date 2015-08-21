<?
require_once('../classes/Login.php');
$title="Medien";
include('_header_not_in.php'); 

?>

<div class="content">
 
 <?php
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'paket' or type LIKE 'audio' or type LIKE 'video') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  
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
		<!--<img src="<?echo $img;?>" alt="<?echo $id;?>">-->
	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo "<p>".$entry3[text]."</p>";
  if ($entry3[text2]) echo "<p>".$entry3[text2]."</p>";
?>

  	<!-- Button trigger modal -->
  	<div class="centered">
  		<input type="button" class="inputbutton" value="Herunterladen" data-toggle="modal" data-target="#myModal">
  	</div>
  	<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Medien</a></div>  
  </div>
<?php
}
         
else { 
?>   
	<div class="medien_info">
		<h1>Medien</h1>

		<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'medien')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info];			
			?>
	</div>
	<div class="medien_seperator">
		<h1>Tonaufnahmen</h1>
	</div>
	<?
	  
	if(isset($_GET['type']))
	{
	$type2 =  $_GET['type'];	
	
	if ($type2 == 'oekonomik'){
		$type3 = 'scholie';
	}	
	elseif ($type2 == 'ethik'){
		$type3 = 'analyse';
	}	
	elseif ($type2 == 'politik'){
		$type3 = 'buch';
	}
	elseif ($type2 == 'audio'){
		$type3 = 'buch';
	}
	include('../medien/medien_data.php');
}
else {
  ?>
    <div class="salon_types">
    	<span><a class="salon_types_active" href="index.php">Alle</a></span>
    	<span><a href="?type=oekonomik">&Ouml;konomik</a></span>
    	<span><a href="?type=ethik">Ethik</a></span>
    	<span><a href="?type=politik">Politik</a></span>
    	<span><a href="?type=audio">Tonaufnahmen</a></span>
    </div> 
	<div class="medien_content">

<?php
	//Pagination Script found at http://www.phpeasystep.com/phptu/29.html
	$tbl_name="produkte";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 4;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE (type LIKE 'paket' or type LIKE 'audio') AND status > 0";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "index.php"; 	//your file name  (the name of this file)
	$limit = 8; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * from produkte WHERE (type LIKE 'paket' or type LIKE 'audio') AND status > 0 order by id asc, n asc LIMIT $start, $limit";
	
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	

		/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">&laquo; zur&uuml;ck</a>";
		else
			$pagination.= "<span class=\"disabled\">&laquo; zur&uuml;ck</span>";	
		
		//pages	
		if ($lastpage < 4 + ($adjacents * 2))	//not enough pages to bother breaking it up -7
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 2 + ($adjacents * 2))	//enough pages to hide some -5
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">vor &raquo;</a>";
		else
			$pagination.= "<span class=\"disabled\">vor &raquo;</span>";
		$pagination.= "</div>\n";		
	}
//$sql = "SELECT * from produkte WHERE (type LIKE 'paket' or type LIKE 'audio' or type LIKE 'video') AND status > 0 order by title asc, n asc";
//$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
  
  	//Change button-value according to media type
	if ($entry[type] == 'paket') { $btn_value = "Herunterladen";} 
    if ($entry[type] == 'audio') { $btn_value = "Herunterladen";} 
    if ($entry[type] == 'video') { $btn_value = "Ansehen";}
  
    //check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/medien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/medien/default.jpg";
	}
	
?>
		<tr>
			<td class="schriften_table_a">
				<a href="<? echo "?q=$id";?>"><img src="<?echo $img_url;?>" alt=""></a>
			</td>			
			<td class="schriften_table_b">
				<span><? echo ucfirst($entry[type]);?></span><br>
      			<? echo "<a href='?q=$id'>".$entry[title]." </a>"; ?>
      			<p>
      				<? 	$text1 = wordwrap($entry[text], 500, "\0");
						$short_text = preg_replace('/^(.*?)\0(.*)$/is', '$1', $text1);
      				
      					if (strlen($entry[text]) > 500) {
							echo $short_text;
              echo '...';
						}
						else {
							echo $entry[text];
						}?>
				</p>
			</td>
			<!--<td class="schriften_table_c">
				<?php
					/*if 	($_SESSION['Mitgliedschaft'] == 1) { 
						echo '<input type="button" class="inputbutton" value="Bestellen / Herunterladen" data-toggle="modal" data-target="#myModal">';
					}
					else {
						
						echo "<a href='?q=$id'><button class='inputbutton' type='button'>Bestellen</button></a>";
      					}     									
					*/?>
			</td>-->
		</tr>
      
    <tr><td colspan="3"> <div class="centered"><p class='linie'><img style='height: 35px' src='../style/gfx/linie.png' alt=''></p></div></td></tr>


<?php
	}
	echo "</table>";
	echo $pagination;
	}
}
?>

	</div>

	
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Herunterladen</h2>
      </div>
      <div class="modal-body">
         <p>Wir freuen uns, dass Sie Interesse an unseren Medien haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten der Bestellung oder des Herunterladens digitaler Dateien zu erfahren (diese k&ouml;nnen wir leider nicht offen zug&auml;nglich machen):
         </p>
        <div class="subscribe">
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail Adresse" name="user_email" required>
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
          </form> 
        </div>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>