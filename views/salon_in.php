<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>


<?
require_once('../classes/Login.php');
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
                          <!-- Button trigger modal -->
                          <input type="button" value="Add to Basket" data-toggle="modal" data-target="#myModal">  
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Unterstützen</h2>
      </div>
      <div class="modal-body">
        <p>Das Institut f&uuml;r Wertewirtschaft ist eine gemeinn&uuml;tzige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabh&auml;ngigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Geb&uuml;hren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterst&uuml;tzung k&ouml;nnen wir unsere Arbeit aufrecht erhalten oder ausweiten.</p>

<p><b>Warum in das Institut f&uuml;r Wertewirtschaft investieren?</b></p>

<p> Wo gibt es sonst noch vollkommen unabh&auml;ngige Universalgelehrte, die im Wahnsinn der Gegenwart den &Uuml;berblick bewahren und den Verlockungen von Macht und Geld widerstehen? Einst hatten Universit&auml;ten diese Aufgabe, doch sind diese l&auml;ngst durch die Politik korrumpiert und im Kern zerst&ouml;rt.  Jeder rationale Anleger sollte ebenso in die Institutionen investieren, die f&uuml;r eine freie und wohlhabende Gesellschaft unverzichtbar sind. Ohne Menschen, die ihr Leben der Erkenntnis widmen, sind den Illusionen, die zu Unfreiheit und Versklavung f&uuml;hren, keine Grenzen gesetzt.  Das Institut f&uuml;r Wertewirtschaft ist, obwohl wir wenig pragmatisch sind, wohl eines der effizientesten Institute weltweit. Wir leisten mehr als Einrichtungen, die das Hundertfache unseres Budgets aufweisen. Durch gro&szlig;en pers&ouml;nlichen Einsatz , &auml;u&szlig;erst sparsames Management und unternehmerische Einstellung k&ouml;nnen wir auch mit geringen Betr&auml;gen gro&szlig;en Mehrwert schaffen.  Eine Gesellschaft, in der nahezu die gesamte Bildung und Forschung in staatlicher Hand liegt, befindet sich auf direktem Weg in den Totalitarismus. Sagen Sie nachher nicht, wir h&auml;tten Sie nicht gewarnt.  Warnung: Wir k&ouml;nnen nat&uuml;rlich auch keine Wunder vollbringen (wiewohl wir uns oft wundern, was uns alles trotz unser knappen Mittel gelingt). Wir sind keinesfalls geneigt, uns in irgendeiner Form f&uuml;r Geldmittel zu verbiegen. Wenn Sie in unsere Arbeit investieren, dann tun Sie das, weil Sie unsere Selbst&auml;ndigkeit und Unkorrumpierbarkeit sch&auml;tzen. Finanzmittel sind nur eine Zutat, und keinesfalls die Wichtigste. Wir bitten Sie darum, weil materielle Unabh&auml;ngigkeit die Voraussetzung unserer Arbeit ist - und diese Unabh&auml;ngigkeit k&ouml;nnen wir nur durch eine Vielfalt an Stiftern erreichen.</p>

<p><b>Ihre Vorteile:</b></p>

<p> Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)  Erm&auml;&szlig;igter Eintritt zu unseren Salon-Veranstaltungen (Video&uuml;bertragung f&uuml;r ausw&auml;rtige Mitglieder)  Abonnement der Scholien inkludiert  Wachsende Zahl exklusiver Inhalte (Audio/Video)  Nutzung der Bibliothek, B&uuml;cherleihe  F&ouml;rderer:  F&ouml;rderer leisten einen regelm&auml;&szlig;igen Beitrag, der &uuml;ber die Kosten hinausgeht, um uns bei unserer Arbeit zu ermutigen und zu unterst&uuml;tzen. Daf&uuml;r sind sie etwas mehr in unser Institut eingebunden und erhalten zus&auml;tzlich zu den Mitgliedschaftsvorteilen:  Hintergrundinformationen zu unserer Arbeit  Einladung zu exklusiven Veranstaltungen  Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen  ab 300 &euro; Beitrag: Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Jetzt upgraden</button></a>
      </div>
    </div>
  </div>
</div>

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