<?php 

require_once('../classes/Login.php');
$title="Upgrades";
include('_header_not_in.php'); 


?>

<div class="payment">
           <div class="payment_info">
            <p>Gro&szlig;artig, dass Sie zu uns gefunden haben! Es gibt heute nur noch wenige, die bereit sind, Institutionen zivilgesellschaftlich zu tragen &ndash; die meisten verlassen sich auf Staat und Lobbies und &quot;engagieren&quot; sich allenfalls als Zuwendungsempf&auml;nger.<br><br>
            Die Wertewirtschaft wird ausschlie&szlig;lich privat von B&uuml;rgern wie Ihnen finanziert. Wir lehnen jede Subvention aus Prinzip ab, weil wir niemals mehr Werte aufbrauchen als sch&ouml;pfen wollen, Zwang verabscheuen und Unabh&auml;ngigkeit f&uuml;r einen hohen Wert halten. Wir sind ein gemeinn&uuml;tziges Unternehmen, das hei&szlig;t, alle Ertr&auml;ge flie&szlig;en direkt in die F&ouml;rderung unserer Zwecke, ohne Abzug von Dividenden, Zinsen oder Steuern.<br><br>
            Wir sind aber auch stolz darauf, ein Unternehmen zu sein, und eben keine Beh&ouml;rde, kein Komitee, keine Partei, kein Hobbyverein, keine ideologische Bewegung. Professionalit&auml;t, Effizienz, reale Wertsch&ouml;pfung und &ouml;konomische N&uuml;chternheit sind zentral f&uuml;r uns. Wir bieten Ihnen daher realen Gegenwert und nicht blo&szlig; allgemeine Versprechen.<br><br>
            Auch wenn Ihre finanziellen Mittel beschr&auml;nkt sind, k&ouml;nnen Sie schon mit einem kleinen Beitrag an unseren Erkenntnissen und Werten teilhaben, Teil eines au&szlig;ergew&ouml;hnlichen Netzwerkes von Wertewirten werden und eine gewichtige L&uuml;cke f&uuml;llen.</p>
           </div>
    
            <div class="pay_option_box pay_option_box1">
                <table>
                    <tr><th rowspan="3">
                        <h1>Gast</h1>
                        <h2>6,25&euro;/Monat</h2>
                    </th>
                    <td>
                        <p>Sie sind interessierter B&uuml;rger mit beschr&auml;nkten Mitteln, der nur einmal neugierig hineinschnuppern m&ouml;chte, ob es die Wertewirtschaft auch wert ist.</p>
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
                        <h1>Kursteilnehmer</h1>
                        <h2>12,50&euro;/ Monat</h2>
                    </th>
                    <td>
                        <p>Sie sind an tiefer gehender Erkenntnis und Inspiration interessiert. Sie vertrauen der Wertewirtschaft bereits, dass sich hier wirklich etwas lernen l&auml;sst. Manchmal w&uuml;rde Sie auch die Teilnahme an intensiven Seminaren reizen.</p>
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
                            <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Kursteilnehmer">
                        </form>   
                    </td>
                    </tr>
                </table>
        </div>
        
        <div class="pay_option_box pay_option_box3">
            <table>
                <tr><th th rowspan="3">
                    <h1>Wertewirt</h1>
                    <h2>25&euro;/ Monat</h2>
                </th>
                <td class="pay_option_box_td_top">           
                    <p>Sie sind nicht zuf&auml;llig hier, sondern empfinden so wie wir. Wenn es die Wertewirtschaft nicht g&auml;be, w&uuml;rden Sie sie vermissen. Sie wollen wie wir die Realit&auml;t erkennen, Werte schaffen und Sinn finden. Sie leben Eigenverantwortung und leisten als B&uuml;rger einen Beitrag, um dieses Zentrum verantwortlichen Unternehmertums, unabh&auml;ngiger Forschung und zivilgesellschaftlichen Engagements abseits der subventionierten Anstalten zu erm&ouml;glichen. Wenn es Sie nicht g&auml;be, g&auml;be es auch keine Wertewirtschaft.
                    </p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast und Kursteilnehmer</li>
                        <li>Teilnahme an Seminaren und Salon, sowie Bezug von B&uuml;chern und Medien  je nach Belieben in entsprechend gr&ouml;&szlig;erem Ausma&szlig;.</li>
                        <li>Nutzung der digitalen Bibliothek.</li>
                        <li>Exklusive Informationen.</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="300">
                        <input type="hidden" name="level" value="Wertewirt">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Wertewirt">
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
                        <li>Vorteile von Gast, Kursteilnehmer und Wertewirt</li>
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

        <div class="pay_option_box pay_option_box5">
            <table>
                <tr><th rowspan="3">
                    <h1>Beirat</h1>
                    <h2>100&euro;/Monat</h2>
                </th>
                <td>
                    <p>Sie wollen und k&ouml;nnen einen wirklich ernsthaften Beitrag leisten, weil Sie ein Interesse an der strategischen Entwicklung der Wertewirtschaft haben. Wir nehmen Sie als Beirat auf und Sie gestalten mit uns die Zukunft. Nat&uuml;rlich gehen wir mit Ihrer Zeit pfleglich um: Einmal im Jahr reflektieren wir mit unseren Beir&auml;ten die Erkenntnisse des vergangenen Jahres und blicken in das kommende.</p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast, Kursteilnehmer, Wertewirt und Partner</li>
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
        </div>

        <div class="pay_option_box pay_option_box6">
            <table>
                <tr><th rowspan="3">
                    <h1>Ehrenpr&auml;sident</h1>
                    <h2>200&euro;/Monat</h2>
                </th>
                <td class="pay_option_box_td_m">
                    <p>Vielleicht w&auml;re das ja eine Aufgabe f&uuml;r Sie? Als Ehrenpr&auml;sident leisten Sie einen Beitrag, der das nachhaltige Bestehen der Wertewirtschaft sichert. Ehrenpr&auml;sidenten sind unsere VIPs: Keine falsche Elite mit Anspr&uuml;chen, sondern eine wahre mit &uuml;berdurchschnittlicher Leistungs- und Verantwortungsbereitschaft.</p>
                </td>
                </tr><tr>
                <td>
                    <ul>
                        <li>Vorteile von Gast, Kursteilnehmer, Wertewirt, Partner und Beirat</li>
                        <li>Einmal im Jahr zu Ihrem Wunschtermin private Campusf&uuml;hrung durch den Rektor mit tief gehender Vorstellung und Reflexion unserer Arbeit und Erkenntnisse, sowie einem exklusiven Mittagessen.</li>
                    </ul>
                </td>
                </tr><tr>
                <td class="pay_option_form" colspan="2">
                    <form method="post" action="zahlung.php">
                        <input type="hidden" name="betrag" value="2400">
                        <input type="hidden" name="level" value="Ehrenpräsident">
                        <input type="submit" class="pay_option_box_inputbutton" name="pay" value="Werden Sie jetzt Ehrenpr&auml;sident">
                    </form>   
                </td>
                </tr>
            </table>
        </div>
        </div>

<?php include('_footer_blog.php'); ?>