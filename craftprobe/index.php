<?php
#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "error.log");
ini_set("display_errors" , "0");

include "header.php";

$ok = $_POST['ok'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$name = $_POST['name'];
$street = $_POST['street'];
$postal = $_POST['postal'];
$city = $_POST['city'];
$country = $_POST['country'];
$telephone = $_POST['telephone'];
$pref_date = $_POST['pref_date'];
$found_us = $_POST['found_us'];

if ($ok) {

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$in_query = $db->prepare(
	'INSERT INTO cb_anmeldung (
		email,
		firstname,
		name,
		street,
		postal,
		city,
		country,
		telephone,
		pref_date,
		found_us,
		sub_date
		)
	VALUES (
		:email,
		:firstname,
		:name,
		:street,
		:postal,
		:city,
		:country,
		:telephone,
		:pref_date,
		:found_us,
		NOW()
		)'
);

$in_query->bindValue(':email', $email, PDO::PARAM_STR);
$in_query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
$in_query->bindValue(':name', $name, PDO::PARAM_STR);
$in_query->bindValue(':street', $street, PDO::PARAM_STR);
$in_query->bindValue(':postal', $postal, PDO::PARAM_STR);
$in_query->bindValue(':city', $city, PDO::PARAM_STR);
$in_query->bindValue(':country', $country, PDO::PARAM_STR);
$in_query->bindValue(':telephone', $telephone, PDO::PARAM_STR);
$in_query->bindValue(':pref_date', $pref_date, PDO::PARAM_STR);
$in_query->bindValue(':found_us', $found_us, PDO::PARAM_STR);

$in_query->execute();

/*$sql = "INSERT INTO cb_anmeldung (id, email, firstname, name, street, postal, city, country, telephone, pref_date, found_us, sub_date, note) VALUES ('', '$email', '$firstname', '$name', '$street', '$postal', '$city', '$country', '$telephone', '$pref_date', '$found_us', NOW(), '$note')";

$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());*/

//Email an Interessenten

$body = "Hallo $firstname,\n\n
Vielen Dank fuer Dein Interesse. Wir melden uns in Kuerze bei Dir.\n\n
Wir freuen uns schon, Dich bald an Bord zu haben!\n\n
Die Crew der craftprobe";

mail ($email,"Willkommen bei der craftprobe",$body,"From: info@scholarium.at\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

//Email an Uns

//mail ("info@scholarium.at","craftprobe Anmeldung","$firstname, $name, $email hat sich als Interessent eingetragen","From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
}

?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>craftprobe</title>
        <meta name="description" content="Ein intensives Monatsprogramm">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/general.js"></script>

		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  			ga('create', 'UA-62940948-1', 'auto');
  			ga('send', 'pageview');
		</script>

    </head>
    <body>
    	<section class="main-title">
        	<header class="header">
            	<a href="www.craftprobe.com"><p>craft<span>probe</span></p></a>
            	<div class="nav-trigger">
					<div class="nav-trigger__icon">
						<a href="#" onclick="showNav();return false;"><img src="img/navicon.svg" alt="Menu" title="Menu"></a>
					</div>
				</div>
				<div id="nav">
            		<ul>
               	 		<li><a href="#ueber" onclick="showNav();return false;">Über</a></li>
                		<li><a href="#programm" onclick="showNav();return false;">Programm</a></li>
                		<li><a href="#ort" onclick="showNav();return false;">Ort</a></li>
                	    <li><a href="#fragen" onclick="showNav();return false;">Fragen</a></li>
                		<li><a href="#teilnahme" onclick="showNav();return false;">Teilnahme</a></li>
                		<li>&nbsp;</li>
                		<li><a href="http://craftprobe.com/en/"><i>English</i></a></li>
            		</ul>
           		</div>
       	 	</header>
        	<?   if($ok == 1) {
					echo '<div class="ok">
					<h1>Danke f&uuml;r Dein Interesse.</h1>
					<p>Deine Teilnahmebewerbung wurde abgeschickt.</p>
					</div>';
}
?>
          	<div class="banner" id="oben">
            	<div class="bannerimg" style="background-image: url(img/craftprobe.jpg);"></div>
	        	<div class="arrow-down">
            		<a href="#ueber">
                    	<div class="arrow-down__icon"></div>
                	</a>
            	</div>
        	</div>
        </section>
        <!--<div class="content">-->
            <section id="ueber" class="s1">

				<p>Frauen und M&auml;nner f&uuml;r ein waghalsiges Abenteuer gesucht. Keine Multiple-Choice-Tests, kein veraltetes Schulbuchwissen, aber auch kein hipper Start-Up-Unsinn. Zeitig aufstehen, intensives Arbeiten. Muskelkater wahrscheinlich. Erkenntnisgewinn sicher. Eine schonungslose Konfrontation mit der Realit&auml;t.</p>
				<a><img class="img_floatr" src="img/cp1.jpg" name="Home"></a>
				<p>Jugendliche von heute sind &uuml;berrumpelt von den scheinbar unendlichen M&ouml;glichkeiten, die ihnen geboten werden und haben Sorge, das entscheidende Ereignis zu verpassen. Einige fliehen in virtuelle Welten, andere verfallen einem ungesunden Karrierismus &ndash; kalt l&auml;sst diese Zeit niemanden. Ein Universit&auml;tsstudium ist oft nur ein willkommenes Alibi, um das Erwachsenwerden hinauszuschieben oder sinnlose Zertifikate zu sammeln, w&auml;hrend man sich um wesentliche Entscheidungen herumdr&uuml;ckt.</p>


				<p>Die craftprobe ist eine Realit&auml;tspr&uuml;fung f&uuml;r junge Erwachsene mit Drang zum Selberdenken und Andersmachen. Dabei handelt es sich um ein extrem intensives einmonatiges Programm in Wien (&Ouml;sterreich), das einer beschr&auml;nkten Zahl von Teilnehmern eine einzigartige Lebenserfahrung bietet, die darauf vorbereitet, bessere Entscheidungen unter der Ungewissheit der Zukunft zu treffen. Nach der craftprobe kennst Du Deine St&auml;rken und hast ein klareres Bild von zuk&uuml;nftigen Entwicklungen und Deinem Platz in der Welt. Mit der Hilfe einiger der besten K&ouml;pfe und Werkzeuge und in unternehmerischen Projekten, praktischen Experimenten und tiefgehender Reflexion entwickelst Du die notwendigen Fertigkeiten und Ideen, um reale Werte zu schaffen. Nicht die Pseudowerte, die Pseudomanager und Pseudopolitiker anbieten: entweder irgendeinen gehypten Schrott, den Du nicht brauchst, bezahlt mit Geld, das Du nicht hast, oder die Fiktion, durch die jeder versucht, auf Kosten aller anderen zu leben.</p>
				<a><img class="img_floatl" src="img/cp7.jpg" name="Home"></a>
				<p>craftprobe wird von einem Unternehmen angeboten, nicht von einer Agentur, Beh&ouml;rde oder Schule. Die Eigent&uuml;mer des Tr&auml;gerunternehmens zielen angesichts der verzerrten M&auml;rkte nicht auf schnelle Profite ab, sondern wollen ein unternehmerisches Labor aufbauen, in dem realistische, kleinr&auml;umige L&ouml;sungen f&uuml;r die Probleme von morgen entwickelt werden. Das Programm tr&auml;gt den Namen craftprobe, was im Englischen grob &uuml;bersetzt &bdquo;Sondieren beruflicher Fertigkeiten&ldquo; bedeutet und im Deutschen auf die Kraftproben Bezug nimmt, die in traditionellen Gesellschaften den &Uuml;bergang von der Jugend ins Erwachsenenalter markieren. Fehlen solche selbst&auml;ndigen Kraftproben, werden sie durch leichtsinnige Mutproben kompensiert oder die Selbst&auml;ndigkeit misslingt zum Preis ewiger Abh&auml;ngigkeiten.</p>

				<p>Suchst Du einen Job? Fast jeder tut das heute, aber Einstiegsjobs werden immer knapper. Schlechte Nachrichten: Aufgrund aktueller technischer Entwicklungen, des Konjunkturzyklus und politischen Interventionismus wird es bald kaum noch Jobs f&uuml;r junge Menschen geben, die bislang noch keine Gelegenheit hatten, ihre Kreativit&auml;t und Produktivit&auml;t zu beweisen &ndash; ein Teufelskreislauf, denn wie soll man sich beweisen, wenn man gar keine Gelegenheit dazu erh&auml;lt? Lehrer, Journalisten und Politiker haben junge Menschen schon eine ganze Weile in die Irre gef&uuml;hrt, aber sie wissen es auch nicht besser. Wir verstehen Deine Wut und Angst. Sinnvoller ist es, wenn Du Dich selbst f&uuml;r eine ungewisse Zukunft vorbereitest, in der sich viele wirtschaftliche Annahmen als Illusionen erweisen werden.</p>

				<p>Dazu dient die craftprobe. Nicht, weil wir die Zukunft genau kennen, sondern weil wir offen und bereit sind, die Herausforderung anzunehmen. Die craftprobe ist ein einzigartiges Pers&ouml;nlichkeitsentwicklungsprogramm, um Dich auf diese ungewisse Zukunft vorzubereiten, aber nicht durch Hirnw&auml;sche, Psychogeschw&auml;tz oder motivierende Reden, e-Books, Ratgeber oder Videos, die Dir eine falsche Gewissheit versprechen, sondern durch konkrete und relevante Projekte und Aufgaben, die Produkte, Prozesse, Werkzeuge, M&auml;rkte und Ideen erkunden. Wir lieben das Erkunden des Unbekannten, wir lieben Unternehmertum, wir lieben das Lernen neuer Ideen, Fertigkeiten und Wege, wir lieben unsere Freiheit und Individualit&auml;t. Wir misstrauen Experten, Politikern, Bankiers, Managern, Journalisten, Lehrern, Venturekapitalisten genauso wie wir Gurus, Untergangspropheten, Ideologen, Gutmenschen, Hipstern, Internetpromis und -trollen misstrauen. craftprobe ist eine Kraftprobe &ndash; die Teilnahme an unserer Expedition ist definitiv nichts f&uuml;r Weicheicher. Bequeme Illusionen k&ouml;nnten ersch&uuml;ttert werden. Wir tolerieren keinerlei Bullshit an Bord.</p>

				<div class="centered">
					<iframe width="100%" height="500" src="https://www.youtube.com/embed/GvkK5SRvE2I/?rel=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
				</div>
                <p><a href="#oben">Zur&uuml;ck nach oben</a></p>
            </section>
            <section  id="programm" class="s2">
                <h1>Programm</h1>

                <p><b>Daten:</b></p>

                <ul>
                	<li>Termin: 1.-31. M&auml;rz oder 1.-31. August 2017</li>
                	<li>Ort: <i>scholarium</i> in Wien (Schl&ouml;sselgasse 19/2/18, 1080 Wien)</li>
                	<li>Maximale Teilnehmerzahl: 12 Personen</li>
                	<li>Kosten: 1.900 &euro;</li>
                	<li>Kontakt: <a href="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#108;&#097;&#114;&#105;&#117;&#109;&#046;&#097;&#116;">&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#108;&#097;&#114;&#105;&#117;&#109;&#046;&#097;&#116;</a></li>
                </ul>

                <p>Die Ausbildungsschwerpunkte liegen in den Bereichen Praktische Philosophie, Unternehmertum, digitale und analoge Werkzeuge sowie Naturkunde. Eine Auswahl der bislang angebotenen Module:</p>

				<div class="block">
					<div class="blockr">
						<a><img class="img_floatr" src="img/cp2.jpg" name="Home"></a>
							<div class="textl">
								<ul>
									<li>Unternehmensgr&uuml;ndung und Unternehmensf&uuml;hrung</li>
									<li>Wirtschaftswissenschaft, Sozialwissenschaft und Philosophie</li>
									<li>CNC-Steuerung und 3D-Druck, Prototypenerstellung</li>
									<li>Grundlagen der Medizin und Neurowissenschaft</li>
									<li>Marketing und SEO-Optimierung</li>
									<li>Produktion eines Werbefilms</li>
									<li>Grundlagen der Politik- und Rechtswissenschaft</li>
									<li>Landwirtschaftsprojekt: Anbau von Biogem&uuml;se</li>
								</ul>
							</div>
						</div>
						<div class="blockl">
							<a><img class="img_floatl" src="img/cp3.jpg" name="Home"></a>
							<div class="textr">
								<ul>								
									<li>Einf&uuml;hrung in Aquaponik</li>
									<li>Grundlagen der Permakultur</li>
									<li>Einf&uuml;hrung ins Bauingenieurwesen</li>
									<li>Besuche von Unternehmern, Wissenschaftlern, Künstlern</li>
									<li>Wanderungen, Survival</li>
									<li>Schauspielkurs mit Roland D&uuml;ringer</li>
									<li>Professionelle Fotografie</li>
									<li>Einf&uuml;hrung in Typographie und Corporate Design</li>
								</ul>
							</div>
						</div>
						<div class="blockr">
							<a><img class="img_floatr" src="img/cp6.jpg" name="Home"></a>
							<div class="textl">
								<ul>
									<li>Design-orientiertes Gr&uuml;nden</li>
									<li>Einf&uuml;hrung in Modeschnitt</li>
									<li>Technisches Zeichnen mit AutoCAD</li>
									<li>Satz mit Indesign</li>
									<li>Grafisches Gestalten mit Photoshop</li>
									<li>Programmieren in PHP, SQL, C, Python und Javascript</li>
									<li>Webgestaltung mit HTML, CSS und Templates</li>
									<li>Leichtathletik, Tennis, Fu&szlig;ball, Trampolin</li>
							</div>
						</div>
						<div class="blockl">
							<a><img class="img_floatl" src="img/cp5.jpg" name="Home"></a>
							<div class="textr">
								<ul>
									<li>Grundlagen des M&ouml;belbaus</li>
									<li>Bibliotheksverwaltung</li>
									<li>Grundlagen des Interior Design</li>
									<li>Psychologische Typenerkennung</li>
									<li>Sprachkurse: Chinesisch, Russisch, Italienisch</li>
									<li>Textwerkstatt Deutsch/Englisch, Fach&uuml;bersetzung</li>
									<li>Eventorganisation &amp; Catering</li>
									<li>Entwicklung und Pr&uuml;fung von Unternehmensideen</li>
								</ul>
							</div>
						</div>
						<div class="blockr">
							<a><img class="img_floatr" src="img/cp4.jpg" name="Home"></a>
								<div class="textl">
									<ul>
										<li>Robotik mit Arduino</li>
										<li>Social Media Marketing</li>
										<li>Hausbau/Lehmbau</li>
										<li>Einf&uuml;hrung in Botanik &amp; Pflanzenzucht</li>
										<li>Gesangsschulung</li>
										<li>Musikarrangement und Komposition</li>
									</ul>
								</div>
						</div>
					</div>

                <p><a href="#oben">Zur&uuml;ck nach oben</a></p>
            </section>
            <section  id="ort" class="s3">
                <h1>Ort</h1>

                <p>Das <i>scholarium</i> ist eine unabh&auml;ngige Forschungs- und Bildungseinrichtung, die ausschlie&szlig;lich &uuml;ber das freiwillige Engagement von B&uuml;rgern finanziert wird. <i>scholarium</i> steht f&uuml;r die &bdquo;Gemeinschaft der Lernenden&ldquo;, und als lernendes Unternehmen bietet es eine Erg&auml;nzung zu anerkannten universit&auml;ren Ausbildungen. Das praktische Curriculum wird in Kooperation mit erfolgreichen &ouml;sterreichischen und internationalen Unternehmen entwickelt und evaluiert. Die Eigent&uuml;mer dieser Unternehmen &uuml;ben als Gesellschafter die Aufsicht und Qualit&auml;tskontrolle des <i>scholarium</i> aus. Das Tr&auml;gerunternehmen des Programms ist gemeinn&uuml;tzig und wurde von einer Gruppe erfolgreicher Unternehmer aus &Ouml;sterreich, Deutschland, Schweiz und Liechtenstein gegr&uuml;ndet, aus dem Antrieb heraus, der n&auml;chsten Generation Wertvolles mitzugeben und ihr Mut zur Eigenverantwortung zu machen.</p>

                <p>Das <i>scholarium</i> liegt in einem der &auml;ltesten, kreativsten und gebildetsten Vierteln Wiens, in der N&auml;he einer der &auml;ltesten Universit&auml;ten der Welt (von deren glorreicher Vergangenheit aber kaum mehr als die Fassaden &uuml;berlebt haben), direkt neben einem sch&ouml;nen, versteckten Kloster, in dem die allerletzten Stadtm&ouml;nche Garten und Bibliothek hegen. Die Sch&ouml;nheit des Ortes ist inspirierend: Historische R&auml;umlichkeiten mit hohen Decken, ges&auml;umt von einer der gro&szlig;artigsten Privatbibliotheken Wiens, die gen&uuml;gend Platz und Ruhe f&uuml;r praktische Experimente und theoretische Reflexion bieten.</p>

				<p>Wir w&auml;hlten Wien als Heimathafen aufgrund der hohen Lebensqualit&auml;t, des einmaligen Zugangs zu Kultur und Natur und des reichen Erbes als historisches Zentrum von Wissenschaft und Unternehmertum. Wien ist der Geburtsort der Wiener Schule der &Ouml;konomik, die einzige &ouml;konomische Tradition, die sich auf den Unternehmer konzentriert und das Unternehmertum hochh&auml;lt, w&auml;hrend sie gegen&uuml;ber der finanziell und politisch inflationierten Blasenwirtschaft und der damit verbundenen Inflation von Unsinn h&ouml;chst kritisch ist. Doch Wien ist auch der Geburtsort der Logotherapie, der Sinnsuche und der Kritik des Zynismus, Relativismus und verk&uuml;rzten Materialismus.</p>

				<p>Wenn Du f&uuml;r diese Reise geeignet bist, sind wir &uuml;berzeugt, dass Du die Zeit bei uns an Bord niemals vergessen wirst &ndash; es wird einer der besten und sch&ouml;nsten Lebenserfahrungen bleiben, wie zahlreiche begeisterte Teilnehmer best&auml;tigen. Kein anderes Bildungsprogramm oder Praktikum kommt dieser Erfahrung auch nur nahe.</p>

   <p><a href="#oben">Zur&uuml;ck nach oben</a></p>
            </section>

            <section id="fragen" class="s4">
            	<h1>Fragen</h1>

				<h2>F&uuml;r wen ist die craftprobe gedacht?</h2>

				<p>F&uuml;r alle, die alt genug sind, um unabh&auml;ngig zu werden, und jung genug sind, um abseits der ausgetretenen Pfade zu wandern. Das bedeutet &uuml;blicherweise ein Alter zwischen 17 und 27. Die craftprobe ist ganz sicher nichts f&uuml;r jene, die eine typische Karriere suchen, in der ihnen jemand bis zur Pensionierung vorschreibt, was zu tun ist, oder jene, die glauben, dass ein Universit&auml;tsdiplom einen Anspruch auf einen gut bezahlten, interessanten und einfachen Job bedeutet. Wenn Du den Verdacht hast, dass es da drau&szlig;en mehr gibt, als die Universit&auml;t lehrt, die Medien beschreiben, die Politiker zugeben, und dass die Zukunft radikal anders sein k&ouml;nnte als die Elterngeneration erwartete, und Dich trotzdem nicht einfach in die virtuelle Realit&auml;t vor einer herausfordernden Welt zur&uuml;ckziehen willst, sondern den Mut und die Energie hast, diesen Herausforderungen zu begegnen, dann bist Du genau derjenige/diejenige, den/die wir suchen.</p>

				<h2>Wann soll ich teilnehmen?</h2>
				<p>Die h&auml;ufigsten Optionen sind:</p>
					<ol>

						<li>Direkt nach Matura/Abitur, bevor Du Dich an der Universit&auml;t einschreibst oder eine andere Karriereentscheidung triffst. Je fr&uuml;her, desto besser, denn je l&auml;nger Du wartest, desto mehr wirst Du es bereuen. Dir einen Monat Zeit zu nehmen, bevor Du an die Universit&auml;t gehst, ist die beste Entscheidung, die Du treffen kannst.</li>
						<li>W&auml;hrend Deines Studiums in den Semesterferien &ndash; entweder im August oder im M&auml;rz.</li>
						<li>Nach Deinem Bachelor, wenn Du Dich fragst, ob Du noch einen Master machen sollst oder nicht, oder Wartezeiten zu &uuml;berbr&uuml;cken hast. Viele Studenten qu&auml;len sich in dieser Zeit mit Zweifeln und Frustration. Verschwende Deine Zeit nicht! Die craftprobe ist der perfekte L&uuml;ckenf&uuml;ller, der letztlich wichtiger als Deine Studien und Abschl&uuml;sse sein k&ouml;nnte.</li>
						<li>Nach dem Abschluss der Universit&auml;tsstudien, wenn es um den Einstieg in den Arbeitsmarkt geht. Hast Du Dir schon einmal unternehmerische Alternativen &uuml;berlegt? Aber auch wenn Du vor Karrierebeginn noch pers&ouml;nlich wachsen und einen Startvorteil erlangen willst, indem Du die realen Lektionen nachholst, die Dir bislang an der Universit&auml;t vorenthalten blieben, ist die craftprobe genau das Richtige f&uuml;r Dich.</li>
					</ol>

				<h2>Wieviel kostet es?</h2>
				<p>Ein praktisches Programm dieser Art ist normalerweise unleistbar, alternative Angebote kosten 7.000 &euro; und mehr. Da die craftprobe von einem steuerbefreiten Unternehmen angeboten wird, das gr&ouml;&szlig;ten Wert auf Effizienz und Effektivit&auml;t legt, konnten wir die Kosten auf 1.900 &euro; reduzieren. Dieses Angebot gilt nur f&uuml;r 12 Teilnehmer. Wenn Du den Kostenbeitrag selbst nicht aufbringen kannst, helfen Dir vielleicht Eltern oder Verwandte dabei. Gerne stehen wir diesen f&uuml;r Fragen zur Verf&uuml;gung.</p>

				<h2>Bekomme ich einen Abschluss? Und damit leichter einen Job?</h2>
				<p>Du bekommst kein staatlich akkreditiertes Diplom, sondern eine persönliche Urkunde, die Arbeitgebern den Wert und Inhalt des Programms vermittelt. Die craftprobe ist keine Alternative zu einem akkreditierten Studium, sondern die notwendige Ergänzung, um bessere Bildungs- und Karriereentscheidungen zu treffen. Deine Jobaussichten im Sinne von realen und nachvollziehbaren Fähigkeiten, realen Wert für reale Kunden zu schaffen, sollten sich dramatisch verbessern.</p>

        <a><img class="mittig" src="img/cp8.jpg" name="Home"></a>
            <p><a href="#oben">Zur&uuml;ck nach oben</a></p>

            </section>


       		<section id="teilnahme" class="s5">
                <div class="s5img" style="background: url(img/code2.jpg) center;">
                <div class="form">
                 <h1>Jetzt liegt es an Dir. Komm an Bord!</h1>
                 <p>Worauf wartest Du? Eine virale Fernsehwerbung, die Dir versichert, dass Du als Teilnehmer Teil einer hippen Masse bist? Einen Regierungserlass? Wir versuchen, so gut wir k&ouml;nnen, einen Hype, Massenaufmerksamkeit und staatliche Anerkennung und damit Intervention zu vermeiden. Wenn Du Angst hast, bleib an Land. Keine Sorge, an Bord ist ohnehin nicht genug Platz f&uuml;r jeden. Rettungsboote sind schnell &uuml;berf&uuml;llt. Wenn Du den Mut hast, aber noch zweifelst, ob Du geeignet bist, gib Dir einen Ruck. Nach der craftprobe bist Du es gewiss. Wir melden uns zur&uuml;ck, das tut nicht weh. Doch es k&ouml;nnte Dir M&ouml;glichkeiten er&ouml;ffnen, von denen Du bislang noch nicht einmal zu tr&auml;umen gewagt hast.</p>
                     <input type="button" class="inputbutton" value="Anfrage" data-toggle="modal" data-target="#myModal">
                 </div>
                </div>
            </section>
        <!--</div>-->
        <footer class="footer">
            <p>
                &copy; scholarium&trade; | Schl&ouml;sselgasse 19/2/18 | 1080 Wien <br>
            </p>
            <p class="img_links">
                Background-Image: <a href="https://www.flickr.com/photos/riebart/4466482623/in/photolist-7NFTF6-4qquBv-4qvivG-6WxYTc-57hHm6-mjhDwB-5VKcCj-8SjwXw-79EVn6-nfPx72-6xfvm9-ccQ6rL-75cgcM-59ib1t-7Gyyds-9UNeUM-fKSF1d-asasy3-Mdf4-ptJh3V-apgafX-KnCK4-4U2GPi-bpd8Ht-4usG5p-GH7wh-jmr8PB-as7QVk-ec78kF-b7r6g-6fmKyW-3AvBtV-4nqiZn-5RUuNN-6NKzvV-kmhEbE-7E9fqU-d9A4Eb-7d7ipd-8dpeZZ-buRLHu-5WvBYq-7tnkmy-8dsw7J-asaxj1-asawS3-5XzfyW-aMG5S4-9dUbHm-d9A3SY">"Code" by Michael Himbeault</a>
            </p>
        </footer>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-login">
    <div class="modal-content-login">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Komm an Bord!</h2>
      </div>
      <div class="modal-body">
		<form method="post" action="index.php" name="user_create_profile_form" onsubmit="return validateMyForm();">
				<!--<p><span class="inputlabel2">Application form can be filled out in English, German, French, Spanish, Arabic, Persian, Italian or Hungarian.</span></p>-->
				<div class="input">
					<input type="hidden" name="ok" value="1">

					<input class="inputfield" type="text" name="firstname" placeholder=" Vorname" required><br>
        			<input class="inputfield" type="text" name="name" placeholder=" Nachname" required><br>
        			<input class="inputfield" type="email" name="email" placeholder=" E-Mail" required><br>
        			<input class="inputfield" type="tel" name="telephone" placeholder=" Telefonnummer (z.B. +431234567)"><br>
					<input class="inputfield" type="text" name="street" placeholder=" Stra&szlig;e" required><br>
					<input class="inputfield" type="text" name="postal" placeholder=" PLZ" required><br>
					<input class="inputfield" type="text" name="city" placeholder=" Stadt" required><br>

        			<select class="inputfield_select" id="user_country" name="country" placeholder=" Land" required>
					<option value="&Ouml;sterreich">&Ouml;sterreich</option>
        			<option value="Deutschland">Deutschland</option>
        			<option value="Schweiz">Schweiz</option>
        			<option value="Liechtenstein">Liechtenstein</option>
        			<option value="divider" disabled>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
        			<option value="Afghanistan">Afghanistan</option>
        			<option value="&Auml;gypten">&Auml;gypten</option>
        			<option value="Aland">Aland</option>
        			<option value="Albanien">Albanien</option>
        			<option value="Algerien">Algerien</option>
        			<option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option>
        			<option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option>
        			<option value="Andorra">Andorra</option>
					<option value="Angola">Angola</option>
					<option value="Anguilla">Anguilla</option>
					<option value="Antarktis">Antarktis</option>
					<option value="Antigua und Barbuda">Antigua und Barbuda</option>
                    <option value="&Auml;quatorialguinea">&Auml;quatorialguinea</option>
                    <option value="Argentinien">Argentinien</option>
                    <option value="Armenien">Armenien</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Ascension">Ascension</option>
                    <option value="Aserbaidschan">Aserbaidschan</option>
                    <option value="&Auml;thiopien">&Auml;thiopien</option>
                    <option value="Australien">Australien</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesch">Bangladesch</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belgien">Belgien</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivien">Bolivien</option>
                    <option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvetinsel">Bouvetinsel</option>
                    <option value="Brasilien">Brasilien</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgarien">Bulgarien</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Cookinseln">Cookinseln</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                    <option value="D&auml;nemark">D&auml;nemark</option>
                    <option value="Diego Garcia">Diego Garcia</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominikanische Republik">Dominikanische Republik</option>
                    <option value="Dschibuti">Dschibuti</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estland">Estland</option>
                    <option value="Europ&auml;ische Union">Europ&auml;ische Union</option>
                    <option value="Falklandinseln">Falklandinseln</option>
                    <option value="F&auml;r&ouml;er">F&auml;r&ouml;er</option>
                    <option value="Fidschi">Fidschi</option>
                    <option value="Finnland">Finnland</option>
                    <option value="Frankreich">Frankreich</option>
                    <option value="Franz&ouml;sisch-Guayana">Franz&ouml;sisch-Guayana</option>
                    <option value="Franz&ouml;sisch-Polynesien">Franz&ouml;sisch-Polynesien</option>
                    <option value="Gabun">Gabun</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgien">Georgien</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Griechenland">Griechenland</option>
                    <option value="Gr&ouml;nland">Gr&ouml;nland</option>
                    <option value="Gro&szlig;britannien">Gro&szlig;britannien</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernsey">Guernsey</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hongkong">Hongkong</option>
                    <option value="Indien">Indien</option>
                    <option value="Indonesien">Indonesien</option>
                    <option value="Irak">Irak</option>
                    <option value="Iran">Iran</option>
                    <option value="Irland">Irland</option>
                    <option value="Island">Island</option>
                    <option value="Israel">Israel</option>
                    <option value="Italien">Italien</option>
                    <option value="Jamaika">Jamaika</option>
                    <option value="Japan">Japan</option>
                    <option value="Jemen">Jemen</option>
                    <option value="Jersey">Jersey</option>
                    <option value="Jordanien">Jordanien</option>
                    <option value="Kaimaninseln">Kaimaninseln</option>
                    <option value="Kambodscha">Kambodscha</option>
                    <option value="Kamerun">Kamerun</option>
                    <option value="Kanada">Kanada</option>
                    <option value="Kanarische Inseln">Kanarische Inseln</option>
                    <option value="Kap Verde">Kap Verde</option>
                    <option value="Kasachstan">Kasachstan</option>
                    <option value="Katar">Katar</option>
                    <option value="Kenia">Kenia</option>
                    <option value="Kirgisistan">Kirgisistan</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Kokosinseln">Kokosinseln</option>
                    <option value="Kolumbien">Kolumbien</option>
                    <option value="Komoren">Komoren</option>
                    <option value="Kongo">Kongo</option>
                    <option value="Kroatien">Kroatien</option>
                    <option value="Kuba">Kuba</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Laos">Laos</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Lettland">Lettland</option>
                    <option value="Libanon">Libanon</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyen">Libyen</option>
                    <option value="Litauen">Litauen</option>
                    <option value="Luxemburg">Luxemburg</option>
                    <option value="Macao">Macao</option>
                    <option value="Madagaskar">Madagaskar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Malediven">Malediven</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marokko">Marokko</option>
                    <option value="Marshallinseln">Marshallinseln</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauretanien">Mauretanien</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mazedonien">Mazedonien</option>
                    <option value="Mexiko">Mexiko</option>
                    <option value="Mikronesien">Mikronesien</option>
                    <option value="Moldawien">Moldawien</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolei">Mongolei</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Mosambik">Mosambik</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Neukaledonien">Neukaledonien</option>
                    <option value="Neuseeland">Neuseeland</option>
                    <option value="Neutrale Zone">Neutrale Zone</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niederlande">Niederlande</option>
                    <option value="Niederl&auml;ndische Antillen">Niederl&auml;ndische Antillen</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Nordkorea">Nordkorea</option>
                    <option value="N&ouml;rdliche Marianen">N&ouml;rdliche Marianen</option>
                    <option value="Norfolkinsel">Norfolkinsel</option>
                    <option value="Norwegen">Norwegen</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Pal&auml;stina">Pal&auml;stina</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua-Neuguinea">Papua-Neuguinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippinen">Philippinen</option>
                    <option value="Pitcairninseln">Pitcairninseln</option>
                    <option value="Polen">Polen</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Réunion">Réunion</option>
                    <option value="Ruanda">Ruanda</option>
                    <option value="Rum&auml;nien">Rum&auml;nien</option>
                    <option value="Russische F&ouml;deration">Russische F&ouml;deration</option>
                    <option value="Salomonen">Salomonen</option>
                    <option value="Sambia">Sambia</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="São Tomé und Príncipe">São Tomé und Príncipe</option>
                    <option value="Saudi-Arabien">Saudi-Arabien</option>
                    <option value="Schweden">Schweden</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbien und Montenegro">Serbien und Montenegro</option>
                    <option value="Seychellen">Seychellen</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Simbabwe">Simbabwe</option>
                    <option value="Singapur">Singapur</option>
                    <option value="Slowakei">Slowakei</option>
                    <option value="Slowenien">Slowenien</option>
                    <option value="Somalia">Somalia</option>
                    <option value="Spanien">Spanien</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="St. Helena">St. Helena</option>
                    <option value="St. Kitts und Nevis">St. Kitts und Nevis</option>
                    <option value="St. Lucia">St. Lucia</option>
                    <option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option>
                    <option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option>
                    <option value="S&uuml;dafrika, Republik">S&uuml;dafrika, Republik</option>
                    <option value="Sudan">Sudan</option>
                    <option value="S&uuml;dkorea">S&uuml;dkorea</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option>
                    <option value="Swasiland">Swasiland</option>
                    <option value="Syrien">Syrien</option>
                    <option value="Tadschikistan">Tadschikistan</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tansania">Tansania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-Leste">Timor-Leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad und Tobago">Trinidad und Tobago</option>
                    <option value="Tristan da Cunha">Tristan da Cunha</option>
                    <option value="Tschad">Tschad</option>
                    <option value="Tschechische Republik">Tschechische Republik</option>
                    <option value="Tunesien">Tunesien</option>
                    <option value="T&uuml;rkei">T&uuml;rkei</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="Ungarn">Ungarn</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Usbekistan">Usbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatikanstadt">Vatikanstadt</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option>
                    <option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Wallis und Futuna">Wallis und Futuna</option>
                    <option value="Weihnachtsinsel">Weihnachtsinsel</option>
                    <option value="Wei&szlig;russland">Wei&szlig;russland</option>
                    <option value="Westsahara">Westsahara</option>
                    <option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option>
                    <option value="Zypern">Zypern</option>
					</select><br>
					<!-- <textarea name="note" class="inputarea" placeholder=" Hast Du Fragen oder Anmerkungen?" rows="10" required></textarea><br> -->
					<input class="inputfield bottom_border" type="text" name="found_us" placeholder=" Wie hast Du uns gefunden?"><br>
					<p id="input_zeitraum">Zeitraum:<br>
					<input type="radio" name="pref_date" value="2017-03-01" required> 1. bis 31. M&auml;rz 2017<br>
  					<input type="radio" name="pref_date" value="2017-08-01" required> 1. bis 31. August 2017<br>
					</p>
					<!-- honeypot field to prevent spam-->
					<div style="display:none;">
					<label>Dieses Feld bitte freilassen</label>
					<input type="text" name="honeypot" id="honeypot" />
					</div>
				</div>
    			<input type="submit" class="inputbutton_subscribe" name="registrationform" value="Anmelden">
    			<p>Solltest Du vorab noch etwas fragen oder klären wollen, schreib uns einfach eine Mail an:&nbsp;<a href="mailto:&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;">&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;</a></p>
			</form>
		</div>
    </div>
  </div>
</div>

    </body>
</html>
