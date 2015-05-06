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

<p><img class='wallimg big' src='salon.jpg' alt='Salon im Institut für Wertewirtschaft'></p>
<p>Unser <i>Salon</i> erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition. N&uuml;tzen Sie die Gelegenheit, das Institut und dessen au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Dabei beginnen Rahim Taghizadegan und Eugen Maria Schulak ein kritisches Gespr&auml;ch, das bei einem Buffet in angenehmer Atmosph&auml;re fortgesetzt wird.</p>
         
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
        <h2 class="modal-title" id="myModalLabel">email eintragen</h2>
      </div>
      <div class="modal-body">
        <i>Wenn Sie unseren Salon besuchen, tragen Sie sich hier völlig unverbindlich ein:</i><br><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
          <input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
          <input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
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
         <? include "_side_not_in.php"; ?>
        </div>
<? include "_footer.php"; ?>