<?php 

require_once('../classes/Login.php');
$title="Unterst&uuml;tzen";
include('_header_in.php'); 

?>

<script type="text/javascript">
  function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) {
      item.className=(item.className=='hidden')?'unhidden':'hidden';
    }
  }
</script> 

<div class="payment">
           <div class="payment_info">
           	<?php  
				$sql = "SELECT * from static_content WHERE (page LIKE 'upgrade')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];			
			?>
           </div>
<?php    
        $op1 = $op1.'<div id="op1" class="pay_option_box pay_option_box1">
                <table>
                    <tr><th rowspan="3">
                        <h1>Gast</h1>
                        <h2>6,25&euro;/Monat</h2>
                    </th>
                    <td>
                        <p>Sie sind interessierter B&uuml;rger mit beschr&auml;nkten Mitteln, der nur einmal neugierig hineinschnuppern m&ouml;chte, ob es das scholarium auch wert ist.</p>
                    </td>
                    </tr><tr>
                    <td>
                        <ul>
                            <li>Kostenloser Zugang zu allen Scholien inkl. Archiv</li>
                            <li>Zugang zum Salon, kostenlose Teilnahmem&ouml;glichkeit inkl. Konsumation</li>
                            <li>Zugriff auf Schriften und Medien</li>
                            <li>Nutzung der Bibliothek (auch Fernleihe)</li>
                        </ul>
                   </td>
                   </tr><tr>
                       <td class="pay_option_form" colspan="2">
                            <form method="post" action="zahlung.php">
                                <input type="hidden" name="betrag" value="75">
                                <input type="hidden" name="level" value="Gast">
                                <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Gast">
                            </form>   
                       </td>
                   </tr>                   
                </table>             
            </div>';

            
            $op2 = $op2.'<div id="op2" class="pay_option_box pay_option_box2">
               <table>
                    <tr><th rowspan="3">
                        <h1>Teilnehmer</h1>
                        <h2>12,50&euro;/ Monat</h2>
                    </th>
                    <td>
                        <p>Sie sind an tiefer gehender Erkenntnis und Inspiration interessiert. Sie vertrauen dem scholarium bereits, dass sich hier wirklich etwas lernen l&auml;sst. Manchmal w&uuml;rde Sie auch die Teilnahme an intensiven Seminaren reizen.</p>
                    </td>
                    </tr><tr>
                    <td>
                        <ul>
                            <li>Vorteile von Gast</li>
                            <li>Zugang zu allen Seminaren</li>
                            <li>Kostenlose Teilnahme an einem Seminar pro Jahr (oder alternativ Fernkurse/ Aufzeichnungen/Schriften im selben Gegenwert)</li>
                        </ul>
                    </td>
                    </tr><tr>
                    <td class="pay_option_form" colspan="2">
                        <form method="post" action="zahlung.php">
                            <input type="hidden" name="betrag" value="150">
                            <input type="hidden" name="level" value="Kursteilnehmer">
                            <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Teilnehmer">
                        </form>   
                    </td>
                    </tr>
                </table>
        </div>';
        
        $op3 = $op3.'<div id="op3" class="pay_option_box pay_option_box3">
            <table>
                <tr><th th rowspan="3">
                    <h1>Scholar</h1>
                    <h2>25&euro;/Monat</h2>
                </th>
                <td class="pay_option_box_td_top">           
                    <p>Sie sind nicht zuf&auml;llig hier, sondern empfinden so wie wir. Wenn es das scholarium nicht g&auml;be, w&uuml;rden Sie es vermissen. Sie wollen wie wir die Realit&auml;t erkennen, Werte schaffen und Sinn finden. Sie leben Eigenverantwortung und leisten als B&uuml;rger einen Beitrag, um dieses Zentrum verantwortlichen Unternehmertums, unabh&auml;ngiger Forschung und zivilgesellschaftlichen Engagements abseits der subventionierten Anstalten zu erm&ouml;glichen. Wenn es Sie nicht g&auml;be, g&auml;be es auch kein scholarium.
                    </p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast und Teilnehmer</li>
                        <li>Teilnahme an Seminaren und Salon, sowie Bezug von B&uuml;chern und Medien  je nach Belieben in entsprechend gr&ouml;&szlig;erem Ausma&szlig;</li>
                        <li>Nutzung der digitalen Bibliothek</li>
                        <li>Exklusive Informationen</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="300">
                        <input type="hidden" name="level" value="Scholar">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Scholar">
                    </form>   
                </td>
                </tr>
            </table>
        </div>';
        
        $op4 = $op4.'<div id="op4" class="pay_option_box pay_option_box4">
            <table>
                <tr><th rowspan="3">
                    <h1>Partner</h1>
                    <h2>50&euro;/Monat</h2>
                </th>
                <td>
                    <p>Sie k&ouml;nnen sich einen gr&ouml;&szlig;eren Beitrag leisten und wollen nicht nur unser Angebot nutzen, sondern uns auch helfen, dieses noch auszubauen. Sie begleiten uns auf unserem Weg und werden Teil des engeren Kerns unserer Unterst&uuml;tzer: allesamt wirklich beeindruckende Pers&ouml;nlichkeiten, ohne die Europa schon l&auml;ngst zusperren k&ouml;nnte.</p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast, Teilnehmer und Scholar</li>
                        <li>Einladung zu einem regelm&auml;&szlig;igen exklusiven Abendessen zum pers&ouml;nlichen Austausch, bei dem Sie Hintergrundinformationen zu unserer Arbeit erhalten</li>
                        <li>Alternativ, wenn Sie nicht zuf&auml;llig vor Ort sind oder anreisen wollen: Geschenkkorb mit wertvollen Produkten</li>
                        <li>Auf Wunsch: Visitenkarten, Verlinkung des eigenen Unternehmens</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="600">
                        <input type="hidden" name="level" value="Partner">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Partner">
                    </form>   
                </td>
                </tr>
            </table>
        </div>';

        $op5 = $op5.'<div id="op5" class="pay_option_box pay_option_box5">
            <table>
                <tr><th rowspan="3">
                    <h1>Beirat</h1>
                    <h2>100&euro;/Monat</h2>
                </th>
                <td>
                    <p>Sie wollen und k&ouml;nnen einen wirklich ernsthaften Beitrag leisten, weil Sie ein Interesse an der strategischen Entwicklung des scholarium haben. Wir nehmen Sie als Beirat auf und Sie gestalten mit uns die Zukunft. Nat&uuml;rlich gehen wir mit Ihrer Zeit pfleglich um: Einmal im Jahr reflektieren wir mit unseren Beir&auml;ten die Erkenntnisse des vergangenen Jahres und blicken in das kommende.</p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast, Teilnehmer, Scholar und Partner</li>
                        <li>Einladung zu unserer j&auml;hrlichen Klausur an einem historischen Ort in wundersch&ouml;ner Landschaft</li>
                        <li>Alternativ, wenn Sie zum Termin verhindert sind:  Aufzeichnungen/Nachlesen</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="1200">
                        <input type="hidden" name="level" value="Beirat">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Beirat">
                    </form>   
                </td>
                </tr>
            </table>
        </div>';

        $op6 = $op6.'<div id="op6" class="pay_option_box pay_option_box6">
            <table>
                <tr><th rowspan="3">
                    <h1>Ehrenpr&auml;sident</h1>
                    <h2>200&euro;/Monat</h2>
                </th>
                <td class="pay_option_box_td_m">
                    <p>Vielleicht w&auml;re das ja eine Aufgabe f&uuml;r Sie? Als Ehrenpr&auml;sident leisten Sie einen Beitrag, der das nachhaltige Bestehen des scholarium sichert. Ehrenpr&auml;sidenten sind unsere VIPs: Keine falsche Elite mit Anspr&uuml;chen, sondern eine wahre mit &uuml;berdurchschnittlicher Leistungs- und Verantwortungsbereitschaft.</p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast, Teilnehmer, Scholar, Partner und Beirat</li>
                        <li>Zus&auml;tzlich bestimmen Sie bis zu zweimal pro Jahr ein Thema f&uuml;r das <i>scholarium</i>, das gemeinsam mit den Studenten bearbeitet wird. Die Ergebnisse besprechen Sie bei einem exklusiven Mittagessen mit dem Rektor. Sie w&auml;hlen ein Thema, zu dem Sie selbst Inputs suchen, oder eines, das Sie f&uuml;r junge Menschen f&uuml;r besonders wichtig halten.</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="2400">
                        <input type="hidden" name="level" value="Ehrenpr&auml;sident">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Ehrenpr&auml;sident">
                    </form>   
                </td>
                </tr>
            </table>
        </div>';
				
		if ($mitgliedschaft == 1) {
			echo $op1;
			echo $op2;
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
		if ($mitgliedschaft == 2) {
			echo $op2;
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
		if ($mitgliedschaft == 3) {
			echo $op2;
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
		if ($mitgliedschaft == 4) {
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
		if ($mitgliedschaft == 5) {
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
		if ($mitgliedschaft == 6) {
			echo $op3;
			echo $op4;
			echo $op5;
			echo $op6;
		}
?>		
        </div>

<?php include('_footer.php'); ?>