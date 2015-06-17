<?php 
require_once('../classes/Login.php');
$title="Projekte";
include ("_header_not_in.php"); 
?>

<div class="content">

<?php
if ($id = $_GET["q"])
{
  $sql="SELECT * from produkte WHERE `type` LIKE 'projekt' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
  $avail=$entry[spots]-$entry[spots_sold];
  $text=$entry[text];
?>
	<div class="medien_head">
  		<h1><?echo $title?></h1>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">
<?php
 	if ($entry[img]) echo $entry[img];

  	if ($entry[text]) echo $entry[text];
 	if ($entry[text2]) echo $entry[text2];
?>
   		<!-- Button trigger modal -->
   		<div class="centered">
    		<input type="button" value="Investieren" class="medien_inputbutton" data-toggle="modal" data-target="#myModal"> 
    	</div>
    	<div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Projekten</a></div>
	</div>

<?php
}

else {
?>
	<div class="medien_info">
		<h1>Projekte</h1>  

		<p>In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Je nach H&ouml;he Ihrer Investition profitieren Sie als Anerkennung Ihres Beitrages von den Angeboten der Wertewirtschaft.</p>
	</div>
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
  echo $pagination;
    ?>

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
        <form method="post" action="../abo/zahlung.php" name="user_create_profile_form">
            <input type="hidden" name="event_id" value="<?php echo $n ?>" />
            <input type="hidden" name="title" value="<?php echo $title ?>" />
        
        <div class="centered">
        <div class="salon_input">
              <input class="salon_inputfield" id="user_email" type="email" name="profile[user_email]" placeholder=" eMail" required><br> 
              <input class="salon_inputfield" id="user_first_name" type="text" name="profile[user_first_name]" placeholder=" Vorname" required><br>
              <input class="salon_inputfield" id="user_surname" type="text" name="profile[user_surname]" placeholder=" Nachname" required><br>
              <input class="salon_inputfield" id="user_street" type="text" name="profile[user_street]" placeholder=" Stra&szlig;e und Hausnummer" required><br> 
              <input class="salon_inputfield" id="user_plz" type="text" name="profile[user_plz]" placeholder=" Postleitzahl" required><br>
              <input class="salon_inputfield" id="user_city" type="text" name="profile[user_city]" placeholder=" Stadt" required><br>
              <select class="salon_inputfield_select" id="user_country" name="profile[user_country]" placeholder=" Land" required><option value="<?php echo $result_row->Land; ?>"><?php if ($result_row->Land) echo $result_row->Land; ?></option><option value="&Ouml;sterreich" selected>&Ouml;sterreich</option><option value="Deutschland">Deutschland</option><option value="Schweiz">Schweiz</option><option value="Liechtenstein">Liechtenstein</option><option value="Afghanistan">Afghanistan</option><option value="&Auml;gypten">&Auml;gypten</option><option value="Aland">Aland</option><option value="Albanien">Albanien</option><option value="Algerien">Algerien</option><option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option><option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarktis">Antarktis</option><option value="Antigua und Barbuda">Antigua und Barbuda</option><option value="&Auml;quatorialguinea">&Auml;quatorialguinea</option><option value="Argentinien">Argentinien</option><option value="Armenien">Armenien</option><option value="Aruba">Aruba</option><option value="Ascension">Ascension</option><option value="Aserbaidschan">Aserbaidschan</option><option value="&Auml;thiopien">&Auml;thiopien</option><option value="Australien">Australien</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesch">Bangladesch</option><option value="Barbados">Barbados</option><option value="Belgien">Belgien</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivien">Bolivien</option><option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option><option value="Botswana">Botswana</option><option value="Bouvetinsel">Bouvetinsel</option><option value="Brasilien">Brasilien</option><option value="Brunei">Brunei</option><option value="Bulgarien">Bulgarien</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Chile">Chile</option><option value="China">China</option><option value="Cookinseln">Cookinseln</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="D&auml;nemark">D&auml;nemark</option><option value="Diego Garcia">Diego Garcia</option><option value="Dominica">Dominica</option><option value="Dominikanische Republik">Dominikanische Republik</option><option value="Dschibuti">Dschibuti</option><option value="Ecuador">Ecuador</option><option value="El Salvador">El Salvador</option><option value="Eritrea">Eritrea</option><option value="Estland">Estland</option><option value="Europ&auml;ische Union">Europ&auml;ische Union</option><option value="Falklandinseln">Falklandinseln</option><option value="F&auml;r&ouml;er">F&auml;r&ouml;er</option><option value="Fidschi">Fidschi</option><option value="Finnland">Finnland</option><option value="Frankreich">Frankreich</option><option value="Franz&ouml;sisch-Guayana">Franz&ouml;sisch-Guayana</option><option value="Franz&ouml;sisch-Polynesien">Franz&ouml;sisch-Polynesien</option><option value="Gabun">Gabun</option><option value="Gambia">Gambia</option><option value="Georgien">Georgien</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Grenada">Grenada</option><option value="Griechenland">Griechenland</option><option value="Gr&ouml;nland">Gr&ouml;nland</option><option value="Gro&szlig;britannien">Gro&szlig;britannien</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option><option value="Honduras">Honduras</option><option value="Hongkong">Hongkong</option><option value="Indien">Indien</option><option value="Indonesien">Indonesien</option><option value="Irak">Irak</option><option value="Iran">Iran</option><option value="Irland">Irland</option><option value="Island">Island</option><option value="Israel">Israel</option><option value="Italien">Italien</option><option value="Jamaika">Jamaika</option><option value="Japan">Japan</option><option value="Jemen">Jemen</option><option value="Jersey">Jersey</option><option value="Jordanien">Jordanien</option><option value="Kaimaninseln">Kaimaninseln</option><option value="Kambodscha">Kambodscha</option><option value="Kamerun">Kamerun</option><option value="Kanada">Kanada</option><option value="Kanarische Inseln">Kanarische Inseln</option><option value="Kap Verde">Kap Verde</option><option value="Kasachstan">Kasachstan</option><option value="Katar">Katar</option><option value="Kenia">Kenia</option><option value="Kirgisistan">Kirgisistan</option><option value="Kiribati">Kiribati</option><option value="Kokosinseln">Kokosinseln</option><option value="Kolumbien">Kolumbien</option><option value="Komoren">Komoren</option><option value="Kongo">Kongo</option><option value="Kroatien">Kroatien</option><option value="Kuba">Kuba</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Lettland">Lettland</option><option value="Libanon">Libanon</option><option value="Liberia">Liberia</option><option value="Libyen">Libyen</option><option value="Litauen">Litauen</option><option value="Luxemburg">Luxemburg</option><option value="Macao">Macao</option><option value="Madagaskar">Madagaskar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Malediven">Malediven</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marokko">Marokko</option><option value="Marshallinseln">Marshallinseln</option><option value="Martinique">Martinique</option><option value="Mauretanien">Mauretanien</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mazedonien">Mazedonien</option><option value="Mexiko">Mexiko</option><option value="Mikronesien">Mikronesien</option><option value="Moldawien">Moldawien</option><option value="Monaco">Monaco</option><option value="Mongolei">Mongolei</option><option value="Montserrat">Montserrat</option><option value="Mosambik">Mosambik</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Neukaledonien">Neukaledonien</option><option value="Neuseeland">Neuseeland</option><option value="Neutrale Zone">Neutrale Zone</option><option value="Nicaragua">Nicaragua</option><option value="Niederlande">Niederlande</option><option value="Niederl&auml;ndische Antillen">Niederl&auml;ndische Antillen</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Nordkorea">Nordkorea</option><option value="N&ouml;rdliche Marianen">N&ouml;rdliche Marianen</option><option value="Norfolkinsel">Norfolkinsel</option><option value="Norwegen">Norwegen</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Pal&auml;stina">Pal&auml;stina</option><option value="Palau">Palau</option><option value="Panama">Panama</option><option value="Papua-Neuguinea">Papua-Neuguinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippinen">Philippinen</option><option value="Pitcairninseln">Pitcairninseln</option><option value="Polen">Polen</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Réunion">Réunion</option><option value="Ruanda">Ruanda</option><option value="Rum&auml;nien">Rum&auml;nien</option><option value="Russische F&ouml;deration">Russische F&ouml;deration</option><option value="Salomonen">Salomonen</option><option value="Sambia">Sambia</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="São Tomé und Príncipe">São Tomé und Príncipe</option><option value="Saudi-Arabien">Saudi-Arabien</option><option value="Schweden">Schweden</option><option value="Senegal">Senegal</option><option value="Serbien und Montenegro">Serbien und Montenegro</option><option value="Seychellen">Seychellen</option><option value="Sierra Leone">Sierra Leone</option><option value="Simbabwe">Simbabwe</option><option value="Singapur">Singapur</option><option value="Slowakei">Slowakei</option><option value="Slowenien">Slowenien</option><option value="Somalia">Somalia</option><option value="Spanien">Spanien</option><option value="Sri Lanka">Sri Lanka</option><option value="St. Helena">St. Helena</option><option value="St. Kitts und Nevis">St. Kitts und Nevis</option><option value="St. Lucia">St. Lucia</option><option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option><option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option><option value="S&uuml;dafrika, Republik">S&uuml;dafrika, Republik</option><option value="Sudan">Sudan</option><option value="S&uuml;dkorea">S&uuml;dkorea</option><option value="Suriname">Suriname</option><option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option><option value="Swasiland">Swasiland</option><option value="Syrien">Syrien</option><option value="Tadschikistan">Tadschikistan</option><option value="Taiwan">Taiwan</option><option value="Tansania">Tansania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad und Tobago">Trinidad und Tobago</option><option value="Tristan da Cunha">Tristan da Cunha</option><option value="Tschad">Tschad</option><option value="Tschechische Republik">Tschechische Republik</option><option value="Tunesien">Tunesien</option><option value="T&uuml;rkei">T&uuml;rkei</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="Ungarn">Ungarn</option><option value="Uruguay">Uruguay</option><option value="Usbekistan">Usbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatikanstadt">Vatikanstadt</option><option value="Venezuela">Venezuela</option><option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option><option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option><option value="Vietnam">Vietnam</option><option value="Wallis und Futuna">Wallis und Futuna</option><option value="Weihnachtsinsel">Weihnachtsinsel</option><option value="Wei&szlig;russland">Wei&szlig;russland</option><option value="Westsahara">Westsahara</option><option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option><option value="Zypern">Zypern</option></select><br> 
			</div>
			</div>
              <div class="projekte_investment">
              <input type="radio" class="projekte_investment_radio" name="betrag" value="150" required>150&euro;: Sie erhalten Zugriff auf die Scholien.<br><br>
              <input type="radio" class="projekte_investment_radio" name="betrag" value="300">300&euro;: Ab diesem Beitrag erhalten Sie Zugriff auf digitale Inhalte in unserer Bibliothek.<br><br>
              <input type="radio" class="projekte_investment_radio" name="betrag" value="600">600&euro;: Ab diesem Beitrag werden Sie Partner, wir f&uuml;hren Sie (au&szlig;er anders gew&uuml;nscht) pers&ouml;nlich mit Link auf unserer Seite an und laden Sie zu einem exklusiven Abendessen ein (oder Sie erhalten einen Geschenkkorb)<br><br>
              <input type="radio" class="projekte_investment_radio" name="betrag" value="1200">1200&euro;: Ab diesem Beitrag nehmen wir Sie als Beirat auf und laden Sie zu unserer Strategieklausur ein.<br><br>
              <input type="radio" class="projekte_investment_radio" name="betrag" value="2400">2400&euro;: Ab diesem Beitrag werden Sie Ehrenpr&auml;sident und wir laden Sie zu einer privaten Campusf&uuml;hrung mit einem exklusiven Mittagessen ein.<br>
        	</div>

        <div class="centered">
          <input type="submit" class="inputbutton_login" name="donationform" value="Investieren"/>
        </div>
    </form>
    <!--TO DO: Create account when registering for the event -->
        </div>
    </div>
  </div>
</div>

<?php 
include "_footer.php"; 
?>