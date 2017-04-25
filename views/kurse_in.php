<?php 
require_once('../classes/Login.php');
$title="Seminare";
include('_header_in.php'); 

?>

<script>
function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
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
  $add_code = $add_id . "0";
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";
  echo "<div class='basket_message'><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../spende/korb.php'>&raquo; zum Korb</a></div>";

  if (isset($_SESSION['basket'][$add_code])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}

   	//check, if there is an image in the seminare folder
	$img = 'http://www.scholarium.at/seminare/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://www.scholarium.at/seminare/default.jpg";
	}

if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type='lehrgang' or type='seminar' or type='kurs') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
  $price = $entry3[price];
  $title=$entry3[title];
  $spots_total=$entry3[spots];
  $spots_sold=$entry3[spots_sold];
  $spots_available=$spots_total-$spots_sold;
  $status = $entry3[status];
  $livestream = $entry3[livestream];
  
  $price_lv1 = $price + 25;
  if ($title == "craftprobe") {
      $price_lv1 = $price;
  }
  
  //Userdetails
  $user_items_query = "SELECT * from registration WHERE `user_id`=$user_id and event_id='$n'";
  $user_items_result = mysql_query($user_items_query) or die("Failed Query of " . $user_items_query. mysql_error());
  $userItemsArray = mysql_fetch_array($user_items_result);

  //$bought = $userItemsArray[quantity];
  
  if ($status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
  }
  else {
?>
  	<div class="salon_head">
 	 	<h1><?=ucfirst($entry3[type])." ".$entry3[title]?></h1>
  		<p class="salon_date">
  			       <? 
      if ($entry3[start] != NULL && $entry3[end] != NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry3[start]));
        if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
          {
          echo " Uhr &ndash; ";
          $tag=date("w",strtotime($entry3[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry3[end]));
      }
      elseif ($entry3[start]!= NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
  			</p>
<?php
	  if ($livestream != '' && $mitgliedschaft >= 2){
?>
	<div class="centered">
	<p class="salon_date salon_livestream">
		<a href="<?=$livestream?>">Sehen Sie dieses Seminar im Livestream</a>
	</p>
	</div>
<?php	  	
	  }
?> 
		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">-->
		
		<div class="centered">
			<div class="salon_reservation">
				<?	
  if ($_SESSION['Mitgliedschaft'] == 1) {
    if ($spots_available == 0){
    	echo '<p class="salon_reservation_span_d">Die Veranstaltung ist leider ausgebucht.</p>';
	}
	//elseif ($bought >= 1) {
		//echo '<p class="salon_reservation_span_a">Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.</p>';
	//}
	else { ?>
    	<p class="salon_reservation_span_d"><?=$price_lv1?>&euro; pro Teilnehmer</p>
<?php	
    }
	?>
    <form method="post" action="../spende/zahlung.php" name="user_create_profile_form">
      <input type="hidden" name="event_id" value="<?php echo $n ?>">
      <input type="hidden" name="title" value="<?php echo $title ?>">
      <input type="hidden" name="pay" value="2">
      <input type="hidden" name="betrag" value="<?php echo $price_lv1 ?>">
      <input class="inputbutton" type="submit" value="Anmelden" <?if($spots_available == 0 || $bought >= 1){echo 'disabled';}?>><br>
    </form>
    <p class="salon_reservation_span_c">Melden Sie sich heute noch an (beschr&auml;nkte Pl&auml;tze) &ndash; Sie erhalten nicht nur eine Eintrittskarte f&uuml;r das Seminar, sondern auch Zugang zu unserem weiteren Angebot (u.a. Scholien, unserem Salon, Schriften, Medien).</p>

    <?
    //echo '<input class="salon_reservation_inputbutton" type="button" value="Anmelden" data-toggle="modal" data-target="#myModal1">';
    }
  
  if ($_SESSION['Mitgliedschaft'] > 1) {
    ?>
    <!--<p class="salon_reservation_span_d"><?echo $entry3[price]?> Credits pro Teilnehmer</p>-->
<?php  
	if ($spots_available >= 5) {
		?>	
				
	<span class="salon_reservation_span_a">
		<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Anzahl gew&uuml;nschter Teilnehmer";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')" <? if($bought >= 1) echo "disabled"?>>
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($bought >= 1) echo "disabled"?>><br>     
    </form>
  <div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
  
 <?php
  	}

elseif ($spots_available == 4) {
	?>

	<span class="salon_reservation_span_a">
		<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Anzahl gew&uuml;nschter Teilnehmer";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')" <? if($bought >= 1) echo "disabled"?>>
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($bought >= 1) echo "disabled"?>><br>     
    </form>
  <div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>

<?php	
	}
 
 elseif ($spots_available == 3) {
	?>

	<span class="salon_reservation_span_a">
		<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Anzahl gew&uuml;nschter Teilnehmer";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')" <? if($bought >= 1) echo "disabled"?>>
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($bought >= 1) echo "disabled"?>><br>     
    </form>
  <div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
 
 <?php	
	}
 
 
 elseif ($spots_available == 2) {
	?>

	<span class="salon_reservation_span_a">
		<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Anzahl gew&uuml;nschter Teilnehmer";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')" <? if($bought >= 1) echo "disabled"?>>
      	<option value="1">1</option>
        <option value="2">2</option>       
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($bought >= 1) echo "disabled"?>><br>     
    </form>
  <div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
 
 <?php	
	}
 
 
 elseif ($spots_available == 1) {
	?>

<span class="salon_reservation_span_a">
			<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Anzahl gew&uuml;nschter Teilnehmer";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')" <? if($bought >= 1) echo "disabled"?>>
      	<option value="1">1</option>      
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($bought >= 1) echo "disabled"?>><br>     
    </form>
  <div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>

 <?php	
	}
 	elseif ($spots_avaibale == 0){
?>	
	<span class="salon_reservation_span_a">
	<? if($bought >= 1) {
			echo "Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.";
			}
		else {
			echo "Diese Veranstaltung ist leider ausgebucht.";
		}
		?>
		</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" disabled onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="0">0</option>     
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen" disabled><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
<?php
	}	
  }
?>
			</div>
		</div>		
	</div>
	<div class="salon_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="salon_content">
  <? 
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";
				
	$sql = "SELECT * from static_content WHERE (page LIKE 'seminare')";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];			
			?>

		<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Seminaren</a></div>
	</div>
	
<?php
	}
}
  else { 
  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>
    <div class="salon_info">
    	<h1>Seminare</h1>  
    	<?php  
			$static_info = $general->getStaticInfo('seminare');
			echo $static_info->info				
			?>
    </div>
    <div class="salon_seperator">
    	<h1>Termine</h1>
    </div>
	<?
  }
  ?>  
 	<div class="salon_content">
  <?
  
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from produkte WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and (type='lehrgang' or type='seminar' or type='kurs') and status=1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<h1>";
    echo "<a href='?q=$id'>";
    echo $entry[title]."</a></h1>";
     
    echo "<div class='salon_dates'>";

    if ($entry[start] != NULL && $entry[end] != NULL)
      {
      $tag=date("w",strtotime($entry[start]));
      $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
      echo $tage[$tag]." ";
      echo strftime("%d.%m.%Y %H:%M", strtotime($entry[start]));
      if (strftime("%d.%m.%Y", strtotime($entry[start]))!=strftime("%d.%m.%Y", strtotime($entry[end])))
        {
        echo " Uhr &ndash; ";
        $tag=date("w",strtotime($entry[end]));
        echo $tage[$tag];
        echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry[end]));
        }
      else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry[end]));
    }
    elseif ($entry[start]!= NULL)
      {
      $tag=date("w",strtotime($entry[start]));
      echo $tage[$tag]." ";
      echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry[start]));
    }
    else echo "Der Termin wird in K&uuml;rze bekannt gegeben.";
    echo "</div>";
    echo "<p>";
    //echo "<img src='$img_url' alt='$id'>";
    echo $entry[text];
    //echo "<div class='salon_anmeldung'><a href='?q=$id'>zur Anmeldung</a></div>";
	echo "<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>";
  } 
?>
		</div>
	</div>
<?
}
?>
<!-- Modal 1 - Mitgliedschaft == 1 
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Anmeldung</h2>
      </div>
      <div class="modal-body">
        <form method="post" action="../spende/zahlung.php" name="user_create_profile_form">
            <input type="hidden" name="event_id" value="<?php echo $n ?>" />
            <input type="hidden" name="title" value="<?php echo $title ?>" />
        
        <div class="salon_input">
              <input class="salon_inputfield" id="user_email" type="email" name="profile[user_email]" placeholder=" eMail" required><br> 
              <input class="salon_inputfield" id="user_first_name" type="text" name="profile[user_first_name]" placeholder=" Vorname" required><br>
              <input class="salon_inputfield" id="user_surname" type="text" name="profile[user_surname]" placeholder=" Nachname" required><br>
              <input class="salon_inputfield" id="user_street" type="text" name="profile[user_street]" placeholder=" Stra&szlig;e und Hausnummer" required><br> 
              <input class="salon_inputfield" id="user_plz" type="text" name="profile[user_plz]" placeholder=" Postleitzahl" required><br>
              <input class="salon_inputfield" id="user_city" type="text" name="profile[user_city]" placeholder=" Stadt" required><br>

              <select class="salon_inputfield_select" id="user_country" name="profile[user_country]" placeholder=" Land" required><option value="<?php echo $result_row->Land; ?>"><?php if ($result_row->Land) echo $result_row->Land; ?></option><option value="&Ouml;sterreich" selected>&Ouml;sterreich</option><option value="Deutschland">Deutschland</option><option value="Schweiz">Schweiz</option><option value="Liechtenstein">Liechtenstein</option><option value="Afghanistan">Afghanistan</option><option value="&Auml;gypten">&Auml;gypten</option><option value="Aland">Aland</option><option value="Albanien">Albanien</option><option value="Algerien">Algerien</option><option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option><option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarktis">Antarktis</option><option value="Antigua und Barbuda">Antigua und Barbuda</option><option value="&Auml;quatorialguinea">&Auml;quatorialguinea</option><option value="Argentinien">Argentinien</option><option value="Armenien">Armenien</option><option value="Aruba">Aruba</option><option value="Ascension">Ascension</option><option value="Aserbaidschan">Aserbaidschan</option><option value="&Auml;thiopien">&Auml;thiopien</option><option value="Australien">Australien</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesch">Bangladesch</option><option value="Barbados">Barbados</option><option value="Belgien">Belgien</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivien">Bolivien</option><option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option><option value="Botswana">Botswana</option><option value="Bouvetinsel">Bouvetinsel</option><option value="Brasilien">Brasilien</option><option value="Brunei">Brunei</option><option value="Bulgarien">Bulgarien</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Chile">Chile</option><option value="China">China</option><option value="Cookinseln">Cookinseln</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="D&auml;nemark">D&auml;nemark</option><option value="Diego Garcia">Diego Garcia</option><option value="Dominica">Dominica</option><option value="Dominikanische Republik">Dominikanische Republik</option><option value="Dschibuti">Dschibuti</option><option value="Ecuador">Ecuador</option><option value="El Salvador">El Salvador</option><option value="Eritrea">Eritrea</option><option value="Estland">Estland</option><option value="Europ&auml;ische Union">Europ&auml;ische Union</option><option value="Falklandinseln">Falklandinseln</option><option value="F&auml;r&ouml;er">F&auml;r&ouml;er</option><option value="Fidschi">Fidschi</option><option value="Finnland">Finnland</option><option value="Frankreich">Frankreich</option><option value="Franz&ouml;sisch-Guayana">Franz&ouml;sisch-Guayana</option><option value="Franz&ouml;sisch-Polynesien">Franz&ouml;sisch-Polynesien</option><option value="Gabun">Gabun</option><option value="Gambia">Gambia</option><option value="Georgien">Georgien</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Grenada">Grenada</option><option value="Griechenland">Griechenland</option><option value="Gr&ouml;nland">Gr&ouml;nland</option><option value="Gro&szlig;britannien">Gro&szlig;britannien</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option><option value="Honduras">Honduras</option><option value="Hongkong">Hongkong</option><option value="Indien">Indien</option><option value="Indonesien">Indonesien</option><option value="Irak">Irak</option><option value="Iran">Iran</option><option value="Irland">Irland</option><option value="Island">Island</option><option value="Israel">Israel</option><option value="Italien">Italien</option><option value="Jamaika">Jamaika</option><option value="Japan">Japan</option><option value="Jemen">Jemen</option><option value="Jersey">Jersey</option><option value="Jordanien">Jordanien</option><option value="Kaimaninseln">Kaimaninseln</option><option value="Kambodscha">Kambodscha</option><option value="Kamerun">Kamerun</option><option value="Kanada">Kanada</option><option value="Kanarische Inseln">Kanarische Inseln</option><option value="Kap Verde">Kap Verde</option><option value="Kasachstan">Kasachstan</option><option value="Katar">Katar</option><option value="Kenia">Kenia</option><option value="Kirgisistan">Kirgisistan</option><option value="Kiribati">Kiribati</option><option value="Kokosinseln">Kokosinseln</option><option value="Kolumbien">Kolumbien</option><option value="Komoren">Komoren</option><option value="Kongo">Kongo</option><option value="Kroatien">Kroatien</option><option value="Kuba">Kuba</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Lettland">Lettland</option><option value="Libanon">Libanon</option><option value="Liberia">Liberia</option><option value="Libyen">Libyen</option><option value="Litauen">Litauen</option><option value="Luxemburg">Luxemburg</option><option value="Macao">Macao</option><option value="Madagaskar">Madagaskar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Malediven">Malediven</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marokko">Marokko</option><option value="Marshallinseln">Marshallinseln</option><option value="Martinique">Martinique</option><option value="Mauretanien">Mauretanien</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mazedonien">Mazedonien</option><option value="Mexiko">Mexiko</option><option value="Mikronesien">Mikronesien</option><option value="Moldawien">Moldawien</option><option value="Monaco">Monaco</option><option value="Mongolei">Mongolei</option><option value="Montserrat">Montserrat</option><option value="Mosambik">Mosambik</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Neukaledonien">Neukaledonien</option><option value="Neuseeland">Neuseeland</option><option value="Neutrale Zone">Neutrale Zone</option><option value="Nicaragua">Nicaragua</option><option value="Niederlande">Niederlande</option><option value="Niederl&auml;ndische Antillen">Niederl&auml;ndische Antillen</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Nordkorea">Nordkorea</option><option value="N&ouml;rdliche Marianen">N&ouml;rdliche Marianen</option><option value="Norfolkinsel">Norfolkinsel</option><option value="Norwegen">Norwegen</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Pal&auml;stina">Pal&auml;stina</option><option value="Palau">Palau</option><option value="Panama">Panama</option><option value="Papua-Neuguinea">Papua-Neuguinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippinen">Philippinen</option><option value="Pitcairninseln">Pitcairninseln</option><option value="Polen">Polen</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Réunion">Réunion</option><option value="Ruanda">Ruanda</option><option value="Rum&auml;nien">Rum&auml;nien</option><option value="Russische F&ouml;deration">Russische F&ouml;deration</option><option value="Salomonen">Salomonen</option><option value="Sambia">Sambia</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="São Tomé und Príncipe">São Tomé und Príncipe</option><option value="Saudi-Arabien">Saudi-Arabien</option><option value="Schweden">Schweden</option><option value="Senegal">Senegal</option><option value="Serbien und Montenegro">Serbien und Montenegro</option><option value="Seychellen">Seychellen</option><option value="Sierra Leone">Sierra Leone</option><option value="Simbabwe">Simbabwe</option><option value="Singapur">Singapur</option><option value="Slowakei">Slowakei</option><option value="Slowenien">Slowenien</option><option value="Somalia">Somalia</option><option value="Spanien">Spanien</option><option value="Sri Lanka">Sri Lanka</option><option value="St. Helena">St. Helena</option><option value="St. Kitts und Nevis">St. Kitts und Nevis</option><option value="St. Lucia">St. Lucia</option><option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option><option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option><option value="S&uuml;dafrika, Republik">S&uuml;dafrika, Republik</option><option value="Sudan">Sudan</option><option value="S&uuml;dkorea">S&uuml;dkorea</option><option value="Suriname">Suriname</option><option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option><option value="Swasiland">Swasiland</option><option value="Syrien">Syrien</option><option value="Tadschikistan">Tadschikistan</option><option value="Taiwan">Taiwan</option><option value="Tansania">Tansania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad und Tobago">Trinidad und Tobago</option><option value="Tristan da Cunha">Tristan da Cunha</option><option value="Tschad">Tschad</option><option value="Tschechische Republik">Tschechische Republik</option><option value="Tunesien">Tunesien</option><option value="T&uuml;rkei">T&uuml;rkei</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="Ungarn">Ungarn</option><option value="Uruguay">Uruguay</option><option value="Usbekistan">Usbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatikanstadt">Vatikanstadt</option><option value="Venezuela">Venezuela</option><option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option><option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option><option value="Vietnam">Vietnam</option><option value="Wallis und Futuna">Wallis und Futuna</option><option value="Weihnachtsinsel">Weihnachtsinsel</option><option value="Wei&szlig;russland">Wei&szlig;russland</option><option value="Westsahara">Westsahara</option><option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option><option value="Zypern">Zypern</option></select><br> 
    </div>
      <input type="submit" class="inputbutton_login" name="registrationform" value="Anmelden">

    </form>
        
    
    </div>
  </div>
</div>
-->

<!-- Modal 2 - Mitgliedschaft == 2 
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Mitgliedschaft 150</h2>
      </div>
      <div class="modal-body">
        Erkl&auml;rung 
      </div>
      <div class="modal-footer">
        <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>
-->

<?php include('_footer.php'); ?>
