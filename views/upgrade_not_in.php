<?php 

require_once('../classes/Login.php');
$title="Upgrades";
include('_header_not_in.php'); 


?>
<script>
$(document).ready(function(){
    // event hover add / remove open class
    $("#selected").on("mouseenter", function(e){
        $(e.currentTaget).addClass('selected');
    }).on("mouseleave", function(){
        $(e.currentTaget).removeClass('selected');
    });
});
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
    
            <div class="pay_option_box pay_option_box1">
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
            </div>

            
            <div class="pay_option_box pay_option_box2">
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
                            <li>Zugang zu allen Seminaren.</li>
                            <li>Kostenlose Teilnahme an einem Seminar pro Jahr (oder alternativ Fernkurse/ Aufzeichnungen/Schriften im selben Gegenwert).</li>
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
        </div>
        
        <div id="selected" class="pay_option_box pay_option_box3">
            <table>
                <tr><th th rowspan="3">
                    <h1>Scholar</h1>
                    <h2>25&euro;/ Monat</h2>
                </th>
                <td class="pay_option_box_td_top">           
                    <p>Sie sind nicht zuf&auml;llig hier, sondern empfinden so wie wir. Wenn es das scholarium nicht g&auml;be, w&uuml;rden Sie sie vermissen. Sie wollen wie wir die Realit&auml;t erkennen, Werte schaffen und Sinn finden. Sie leben Eigenverantwortung und leisten als B&uuml;rger einen Beitrag, um dieses Zentrum verantwortlichen Unternehmertums, unabh&auml;ngiger Forschung und zivilgesellschaftlichen Engagements abseits der subventionierten Anstalten zu erm&ouml;glichen. Wenn es Sie nicht g&auml;be, g&auml;be es auch kein scholarium.
                    </p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast und Teilnehmer</li>
                        <li>Teilnahme an Seminaren und Salon, sowie Bezug von B&uuml;chern und Medien  je nach Belieben in entsprechend gr&ouml;&szlig;erem Ausma&szlig;.</li>
                        <li>Nutzung der digitalen Bibliothek.</li>
                        <li>Exklusive Informationen.</li>
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
        </div>
        
        <div class="pay_option_box pay_option_box4">
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
                        <li>Einladung zu einem regelm&auml;&szlig;igen exklusiven Abendessen zum pers&ouml;nlichen Austausch, bei dem Sie Hintergrundinformationen zu unserer Arbeit erhalten.</li>
                        <li>Alternativ, wenn Sie nicht zuf&auml;llig vor Ort sind oder anreisen wollen: Geschenkkorb mit wertvollen Produkten.</li>
                        <li>Auf Wunsch: Visitenkarten, Verlinkung des eigenen Unternehmens.</li>
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
        </div>


        </div>

<?php include('_footer.php'); ?>