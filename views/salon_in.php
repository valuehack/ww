<script>
var ALERT_TITLE = "Oops!";
var ALERT_BUTTON_TEXT = "Ok";

if(document.getElementById) {
    window.alert = function(txt) {
        createCustomAlert(txt);
    }
}

function createCustomAlert(txt) {
    d = document;

    if(d.getElementById("modalContainer")) return;

    mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    mObj.id = "modalContainer";
    mObj.style.height = d.documentElement.scrollHeight + "px";

    alertObj = mObj.appendChild(d.createElement("div"));
    alertObj.id = "alertBox";
    if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
    alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
    alertObj.style.visiblity="visible";

    h1 = alertObj.appendChild(d.createElement("h1"));
    h1.appendChild(d.createTextNode(ALERT_TITLE));

    msg = alertObj.appendChild(d.createElement("p"));
    //msg.appendChild(d.createTextNode(txt));
    msg.innerHTML = txt;

    btn = alertObj.appendChild(d.createElement("a"));
    btn.id = "closeBtn";
    btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
    btn.href = "#";
    btn.focus();
    btn.onclick = function() { removeCustomAlert();return false; }

    alertObj.style.display = "block";

}

function removeCustomAlert() {
    document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}

function windowMessage() {
    alert("Das Institut für Wertewirtschaft ist eine gemeinnützige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabhängigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Gebühren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterstützung können wir unsere Arbeit aufrecht erhalten oder ausweiten. <br> Klicken Sie <a href='../edit.php'>hier</a>, um zahlendes Mitglied zu werden");
}
</script>

<?
include "_db.php";
$title="Salon";
include "_header.php"; 
?>
<!--Content-->
<div id="center">
        <div id="content">
          <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="#">Salon</a>
      <div id="tabs-wrapper"></div>
          <h3>Salon</h3>
<?php 
//Inserted from catalog.php
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){
  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  //array_push($_SESSION[basket],$add_id);
  echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../basket.php'>Go to Basket</a><hr><br></div>";

  $_SESSION['basket'][$add_id] = $add_quantity; 
}

//für Interessenten (Mitgliedschaft 1) Erklärungstext oben
if ($_SESSION['Mitgliedschaft'] == 1) {
    echo "<p><img class='wallimg big' src='salon.jpg' alt='Salon im Institut für Wertewirtschaft'></p>";
    echo "<p>Unser <i>Salon</i> erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition. N&uuml;tzen Sie die Gelegenheit, das Institut und dessen au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Dabei beginnen Rahim Taghizadegan und Eugen Maria Schulak ein kritisches Gespr&auml;ch, das bei einem Buffet in angenehmer Atmosph&auml;re fortgesetzt wird.</p>";
  }
?>       
             
          <h5>Termine:</h5>        

          <p><table>
       
          <?php
          $sql = "SELECT * from termine WHERE type LIKE 'salon' AND end > NOW() order by start asc, id asc";
          $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

          while($entry = mysql_fetch_array($result))
          {
            $event_id = $entry[id];
              ?>
              <tr>
                  <td class="bottomline"><?php echo date("d.m.Y",strtotime($entry[start])); ?></td>
                  <td class="bottomline"><?php echo "<i>".$event_id."</i> <b>".$entry[title]; ?></b></td>
               </tr> 
               <tr>
                <td><?php echo date("H:i",strtotime($entry[start])); ?></td>
                <td class="bottomline"><?php echo $entry[text]; ?>
                  <?php 
                    
                    if ($_SESSION['Mitgliedschaft'] == 1) {
                      ?>
                      <form>
                        <select name="quantity">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>        
                        </select> 
                        <input type="button" value="Add to Basket" onclick="alert('Alert this pages');">
                      </form>
                        
                  <?php
                    } 

                    else {
                      ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="add" value="<?php echo $event_id; ?>" />
                        <select name="quantity">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>        
                        </select> 
                        <input type="submit" value="Add to Basket">
                      </form>
                  <?php
                    } 
                  ?>

                  </td>
               </tr>
               <tr><td>&nbsp;</td><td></td></tr>
          <?php
          }
          ?>

          </table></p>


       <h5>Unser Angebot</h5>

       <p>Wir organisieren und gestalten philosophische Caf&eacute;s, Salons und Seminare f&uuml;r Ihre Mitarbeiter, Ihren Ort, Ihren Freundeskreis. Sch&ouml;pfen Sie Kraft, abseits vom Wahnsinn des Alltags die Mu&szlig;e zu finden, einmal tiefgehend nachzudenken. Wir regen kontroversiellen aber konstruktiven Gedankenaustausch an. Immer mehr Unternehmen ziehen solche Anl&auml;sse mit tieferem Sinn oberfl&auml;chlichen Schulungen und Teambuildings vor. Hier k&ouml;nnen unter fachlicher Anleitung die Hintergr&uuml;nde realer Probleme beleuchtet werden, k&ouml;nnen Gedanken und Beobachtung ausgedr&uuml;ckt werden, die in einer kurzlebigen Zeit sonst niemals an die Oberfl&auml;che kommen. G&ouml;nnen Sie Ihren Mitarbeitern und G&auml;sten den Luxus der Mu&szlig;e, um tief Luft zu holen f&uuml;r neue Aufgaben. Anfragen an: <a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a>.</p>


       <h5>Informationen</h5>
       
       <p><b>Veranstaltungsort:</b></p>
       
       <p><table width="570px"><tr><td width="50%" valign="top">
       <ul>
        <li class="ort"><b>Institut f&uuml;r Wertewirtschaft</b></li>
        <li class="ort">Schl&ouml;sselgasse 19/2/18</li>
        <li class="ort">A 1080 Wien</li>
        <li class="ort">&Ouml;sterreich</li>
        <li class="ort">&nbsp;</li>
        <li class="ort">Fax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+43 1 2533033 4733</li>
        <li class="ort">E-Mail: &nbsp;<a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a></li>
       </ul>
       
       <p><b>Teilnahme:</b></p> <p>10 Euro (5 Euro f&uuml;r <a href="../institut/mitglied.php">Mitglieder</a>). Inkludiert sind Buffet und Getr&auml;nke. Eine Anmeldung ist n&ouml;tig, da beschr&auml;nkte Platzzahl. Aufpreis an der Abendkassa (f&uuml;r unangemeldete Teilnehmer, falls noch Pl&auml;tze frei) 5 Euro, Platzgarantie nur f&uuml;r <a href="../institut/mitglied.php">M&auml;zene</a>. Video&uuml;bertragung f&uuml;r <a href="../institut/mitglied.php">Mitglieder</a>.</p></td> 
       <td><iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095&amp;output=embed"></iframe><br /><small><a href="https://maps.google.de/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095"></iframe>
       </td></tr>
       </table></p>

          
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "_side_in.php"; ?>
        </div>
<? include "_footer.php"; ?>