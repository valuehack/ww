<?php 
require_once('../classes/Login.php');
$title="Schriften";
include('_header_in.php'); 

?>

<script>
function changeView(price, price_book) {
    var x = document.getElementById("change").value;

    if (x == 4) {    
      document.getElementById("quantity").innerHTML = '<input type="number" name="quantity" onchange="changePrice(this.value,' + price_book + ')" value="1" min="1" max="100">';
      document.getElementById("price").innerHTML = "<span id='total'>" + price_book + " </span>";
    }
    else {
      document.getElementById("quantity").innerHTML = '<input type="hidden" name="quantity" value="1"><input type="number" name="quantity2" value="1" disabled>';
      document.getElementById("price").innerHTML = price;
    }
}

function changePrice(totalQuantity, price_book){
    document.getElementById("total").innerHTML = (totalQuantity * price_book);
}

function changeprice_book(totalQuantity, price_book){
    document.getElementById("total2").innerHTML = (totalQuantity * price_book);
}
</script>

<div class="content">


<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

	$add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_format = $_POST['format'];
  $add_code = $add_id . $add_format;
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";

 	echo "<div class='basket_message'><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>&raquo; zum Korb</a></div>";

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
  $sql="SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
  $type=$entry3[type];
  $title=$entry3[title];
  
          	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
?>
  	<div class="medien_head">
  		<h1><?echo $entry3[title]?></h1>
  		<div>
  		<div class="schriften_img">
			<img src="<?echo $img;?>" alt="<?echo $id;?>">
		</div>
		<div class="schriften_bestellen">
			<?php
			  echo '<span class="schriften_type">'.ucfirst($entry3[type]).'</span>';
			  if ($_SESSION['Mitgliedschaft'] == 1) {
			  	  
   					 //Button trigger modal
    				echo '<input type="button" value="Bestellen und Herunterladen" class="inputbutton" data-toggle="modal" data-target="#myModal">';  
  			  }
  			  else {
    				$pdf = substr($entry3[format],0,1);
    				$epub = substr($entry3[format],1,1);
    				$kindle = substr($entry3[format],2,1);
    				$druck = substr($entry3[format],3,1);

    				$price = $entry3[price];
    				$price_book = $entry3[price_book];
    			?>
    		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      			<input type="hidden" name="add" value="<?php echo $n; ?>" />
     
    		<?php
    			if ($entry3[format] == '0001') {
    				echo '<span class="coin"><img src="../style/gfx/coin.png"></span><span id="total2" class="schriften_price">'.$entry3[price].' </span>';
					echo '<input type="submit" class="inputbutton" value="Ausw&auml;hlen"><br>';
				}
				else {
					echo '<span class="coin"><img src="../style/gfx/coin.png"></span><span id="price" class="schriften_price">' .$entry3[price].' </span>';
					echo '<input type="submit" class="inputbutton" value="Ausw&auml;hlen"><br>';
				}
				echo '<span class="schriften_format">Format: <select name="format"';
				
					if ($entry3[format] == '0001') {
						echo '>';
						echo '<option value="4">Druck</option>';
					}
					else {
						echo ' id="change" onchange="changeView('.$price.','.$price_book.')">';
							if ($pdf == 1) echo '<option value="1">PDF</option>';
        					if ($epub == 1) echo '<option value="2">ePub</option>';
        					if ($kindle == 1) echo '<option value="3">Kindle</option>';
        					if ($druck == 1) echo '<option value="4">Druck</option>'; 
						}					
				echo '</select></span>';
				
        echo '<span class="schriften_quantity">Anzahl: ';
        if ($entry3[format] == '0001') {
				echo '<input type="number" name="quantity" onchange="changeprice_book(this.value,'.$price_book.')" value="1" min="1" max="100">';
					}
        else {
						echo '<span id="quantity"><input type="hidden" name="quantity" value="1"><input type="number" name="quantity2" value="1" disabled></span>';
					}
				echo '</span>';
      		} ?>
    		</form>
		</div>
		</div>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo $entry3[text];
  if ($entry3[text2]) echo $entry3[text2];

?>
    	<div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Schriften</a></div>
    </div>
   </div>
<?php 
}
  
else {

  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>	
    	<p>Unsere Schriften umfassen derzeit:<br>
      		<ul>
        		<li><b>B&uuml;cher</b> &ndash; teilweise eigene, eher f&uuml;r ein breiteres Publikum, teilweise &Uuml;bersetzungen, meist schwierigere Texte</li>
        		<li><b>Analysen</b> &ndash; besonders effiziente und lesbare Texte f&uuml;r einen schnellen, aber profunden &Uuml;berblick zu einem Thema</li>
        		<li>Restexemplare der gedruckten <b>Scholien</b> bis 2014</li>
        		<li>neue Druckausgaben der <b>Scholien</b></li>
     	  </ul>
		</p>  
  </div>
  <div class="medien_seperator">
    <h1>Schriften</h1>
  </div> 
  <?
  } ?>

	<div class="medien_content">
<?php

//Pagination Script found at http://www.phpeasystep.com/phptu/29.html
  $tbl_name="produkte";   //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  
  /* 
     First get total number of rows in data table. 
     If you have a WHERE clause in your query, make sure you mirror it here.
  */
  $query = "SELECT COUNT(*) as num FROM $tbl_name WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0";
  $total_pages = mysql_fetch_array(mysql_query($query));
  $total_pages = $total_pages[num];
  
  /* Setup vars for query. */
  $targetpage = "index.php";  //your file name  (the name of this file)
  $limit = 10;                //how many items to show per page
  $page = $_GET['page'];
  if($page) 
    $start = ($page - 1) * $limit;      //first item to display on this page
  else
    $start = 0;               //if no page var is given, set start to 0
  
  /* Get data. */
  $sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by title asc, n asc LIMIT $start, $limit";
  
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  

    /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1
  
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
    if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
    { 
      for ($counter = 1; $counter <= $lastpage; $counter++)
      {
        if ($counter == $page)
          $pagination.= "<span class=\"current\">$counter</span>";
        else
          $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         
      }
    }
    elseif($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
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

//$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by title asc, n asc";
//$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	echo "<table class='schriften_table'>";

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
      				<? if (strlen($entry[text]) > 500) {
							echo substr ($entry[text], 0, 500);
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
?>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Bestellen und Herunterladen - Upgrade</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eine unserer Schriften bestellen m&ouml;chten. Allerdings sind einige Schriften nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt, andere sind im Buchhandel zu erwerben,&nbsp;da ein Vertrieb und Versand f&uuml;r uns nicht wirtschaftlich&nbsp;ist. Unser Webshop, &uuml;ber den alle Schriften entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Schriften:&nbsp;</p>
      </div>
      <div class="modal-footer">
        <a href="../abo/upgrade.php"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>