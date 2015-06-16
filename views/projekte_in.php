<?php 
require_once('../classes/Login.php');
$title="Projekte";
include ("_header_in.php"); 

?>

<div class="content">

<?php 
if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";
  echo "<div style='text-align:center'><hr><i>".$add_quantity." Credits f&uuml;r das ausgew&auml;hlte Projekt ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>Zum Korb</a><hr><br></div>";

  if (isset($_SESSION['basket'][$add_code])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}


if ($id = $_GET["q"])
{
  $sql="SELECT * from produkte WHERE `type` LIKE 'projekt' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
  $avail=$entry[spots]-$entry[spots_sold];
  $text=$entry[text];
  $n = $entry[n];
?>
	<div class="medien_head">
 		<h1><?echo $title?></h1>
 	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">

<?php		
  	echo $text;

  if ($_SESSION['Mitgliedschaft'] == 1) { 
    ?>
    <div class="centered">
      	<!-- Button trigger modal -->
     	<input type="button" class="medien_inputbutton" value="Investieren" data-toggle="modal" data-target="#myModal"> 
    </div>
    <?php
    }
    else {
		echo "<div class='projekte_invest'>
		<p>Interessierte Mitglieder haben bereits <span class='projekte_credits_sold'>".$entry[spots_sold]."</span> von <span class='projekte_credits_sold'>".$entry[spots]."</span> n&ouml;tigen Credits investiert.</p>"; ?>
      	<form class="projekte_invest_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        	<input type="hidden" name="add" value="<?php echo $n ?>" />
        	<span class="projekte_invest_span">Ich m&ouml;chte mit </span>
        	<input class="projekte_invest_select" type="number" name="quantity" value="1" min="1" max="<?php echo $avail;?>">
        	<span class="projekte_invest_span">Credit(s) zu diesem Projekt beitragen.</span><br>
        	<input type="hidden" name="projekt" value="1" />
          <input type="submit" class="medien_inputbutton" value="Jetzt beitragen">
      	</form>
      </div>
      <div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Projekten</a></div>
    <?php
    }
	echo "</div>";
}

else {
  if ($_SESSION['Mitgliedschaft'] == 1) { 
    echo "<div class='medien_info'>";
    echo "<p>In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Je nach H&ouml;he Ihrer Investition profitieren Sie als Anerkennung Ihres Beitrages von den Angeboten der Wertewirtschaft.</p>";
    echo "</div>";
  }

  else {

  echo "<div class='medien_info'>";
  echo '<p>Wir bieten Ihnen durch unsere zahlreichen Angebote stets vollen Gegenwert f&uuml;r Ihre Unterst&uuml;tzung an. Eine wirkliche Unterst&uuml;tzung, die eine Ausweitung unserer T&auml;tigkeit erlaubt, wird es aber freilich erst, wenn Sie &ndash; so wie wir &ndash; einen gewissen Idealismus an den Tag legen und zumindest einen Teil Ihres Beitrages f&uuml;r Angebote widmen, die Ihnen nicht sofort, direkt und exklusiv zugute kommen, sondern Bausteine mit langfristiger Wirkung sind. In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Wenn Sie selbst einen gr&ouml;&szlig;eren Beitrag als en Restbetrag Ihres regelm&auml;&szlig;igen Guthabens investieren k&ouml;nnen und Projektvorschl&auml;ge haben, freuen wir uns &uuml;ber <a href="mailto:info@wertewirtschaft.org">Ihre Nachricht</a>. Ab einer Investition von 25.000&euro; k&ouml;nnen Sie Gesellschafter und damit Miteigent&uuml;mer unseres Unternehmens werden.</p>';
  echo '</div>';
  }
?>
	<div class="medien_seperator">
		<h1>Offene Projekte</h1>
	</div>
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
  $query = "SELECT COUNT(*) as num FROM $tbl_name WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0";
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
  $sql = "SELECT * from produkte WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0 order by n asc LIMIT $start, $limit";
  
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


//$sql = "SELECT * from produkte WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0 order by n asc";
//$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
   ?>
	<div class="projekte">
		<h1><a href='?q=<?php echo $id;?>'><?php echo $entry[title];?></h1></a>
		<?php echo $entry[text]; ?>
		<div class="medien_anmeldung"><a href="?q=<?php echo $id;?>">weitere Informationen</a></div>
		<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>
 	</div>    
    <?php
    }
    ?>
</table>
</div>


<?php 
} 
?>
</div>

<!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title" id="myModalLabel">Investieren</h2>
          </div>
          <div class="modal-body">
            Spendenformular

            </div>
          <div class="modal-footer">
            <button type="button" class="inputbutton_white" data-dismiss="modal">Schlie&szlig;en</button>
          </div>
        </div>
      </div>
    </div>

<?php 
include "_footer.php"; 
?>