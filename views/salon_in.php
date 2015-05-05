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
?>

          <p><img class="wallimg big" src="salon.jpg" alt="Salon im Institut für Wertewirtschaft"></p>
          
          <p>Unser <i>Salon</i> erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition. N&uuml;tzen Sie die Gelegenheit, das Institut und dessen au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Dabei beginnen Rahim Taghizadegan und Eugen Maria Schulak ein kritisches Gespr&auml;ch, das bei einem Buffet in angenehmer Atmosph&auml;re fortgesetzt wird.</p>
          
          <h5>Termine:</h5>        

          <p><table>
           <tr>
            <td class="bottomline">01.10.2014</td>
            <td class="bottomline"><b>Freihandel und Globalisierung</b></td>
           </tr> 
           <tr>
            <td><b>Mi</b>, 19:00</td>
            <td class="bottomline">Anl&auml;sslich des TTIP-Abkommens ist der Freihandel wieder in Verdacht geraten, nur den Interessen von Politik und Gro&szlig;konzernen zu dienen. Was bringen solche Abkommen, wem schaden sie? Brauchen wir mehr oder weniger Freihandel? Welche Ph&auml;nomene sind mit der Globalisierung verbunden, gibt es Alternativen dazu? Befinden wir uns in einer Phase zunehmender oder abnehmender Globalisierung? Was erkl&auml;rt die starken Vorbehalte und &Auml;ngste? Was sind die &ouml;konomischen und philosophischen Aspekte globaler Mobilit&auml;t von G&uuml;tern, Ideen und Menschen, aber auch von Pflanzen, Tieren und Viren?
             <b><a href="http://www.amiando.com/salon-freihandel">&rarr;Anmeldung</a></b>
             </td>
           </tr>
           <tr>
            <td class="bottomline">26.11.2014</td>
            <td class="bottomline"><b>Kooperation statt Konkurrenz?</b></td>
           </tr> 
           <tr>
            <td><b>Mi</b>, 19:00</td>
            <td class="bottomline">Der Konkurrenzdruck scheint zuzunehmen, viele empfinden sich als rastlos Getriebene der Wirtschaftsentwicklung. Auch an Schulen und Universit&aumten wird vielfach der Konkurrenzdruck beklagt, und an vielen Arbeitspl&aumtzen scheint eine Ellenbogenmentalit&aumt zu herrschen. Bringt das Konkurrenzsystem einer Marktwirtschaft das Schlechteste im Menschen an die Oberfl&aumche? W&aumre mehr Kooperation tats&aumchlich wünschenswert? Was steht &oumkonomisch und philosophisch hinter der Konkurrenz und den Vorbehalten und &Aumngsten vor dem Wettbewerb? Ist ein Wirtschaftssystem denkbar, das in gr&oumßerem Ausmaß auf Kooperation beruht? M&uumssen Konkurrenz und Kooperation überhaupt ein Widerspruch sein? Gibt es auch Schattenseiten der Kooperation? Welche Rolle spielen Konkurrenz und Kooperation in Unternehmen, und welche sollten sie spielen?
               <br>Quantity: <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="add" value="1052" />
                  <select name="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>        
                  </select> 
                <input type="submit" value="Add to Basket"></form></td>
           </tr>
           <tr>
            <td></td>
            <td>&nbsp;</td>
           </tr>
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

<!--        
        <p><b>Weitere Einblicke</b></p>
        
          <div id="galerie">
            <table width="570px" class="galerie">
           <tr>
             
          <td class="thumbcell"><a href="img/iww_01.jpg" rel="lightbox[galerie]" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft"><img src="img/iww_01.jpg" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft" alt="R&auml;me des Instituts f&uuml;r Wertewirtschaft" /></a></td>

          <td class="thumbcell"><a href="img/iww_02.jpg" rel="lightbox[galerie]" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft"><img src="img/iww_02.jpg" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft" alt="R&auml;me des Instituts f&uuml;r Wertewirtschaft" /></a></td>

          <td class="thumbcell"><a href="img/iww_03.jpg" rel="lightbox[galerie]" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft"><img src="img/iww_03.jpg" title="R&auml;ume des Instituts f&uuml;r Wertewirtschaft" alt="R&auml;me des Instituts f&uuml;r Wertewirtschaft" /></a></td>
       
             </tr>
            </table>
          </div>
-->
                   
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "_side_in.php"; ?>
        </div>
<? include "_footer.php"; ?>