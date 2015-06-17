<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}
// include the config
require_once('config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('translations/en.php');

// include the PHPMailer library
require_once('libraries/PHPMailer.php');

// load the login class
require_once('classes/Login.php');
require_once('classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="Eltern";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("views/_header_not_in.php");
    
}

?>

<div class="content">
	<div class="blog">
		<header>
			<h1>F&uuml;r Eltern</h1>
		</header>
		<p class='linie'><img src='../style/gfx/linie.png' alt=''></p>
		<div class="blog_text">
			<p>Haben Sie Kinder zwischen 18 und 28 Jahren? Dann ist die Chance relativ gro&szlig;, dass Sie voll der Sorge um deren Zukunft sind. Zun&auml;chst die gute Nachricht: Wenn Ihre Kinder noch nicht den richtigen Weg gefunden haben, von den Bildungsm&ouml;glichkeiten etwas erdr&uuml;ckt scheinen und ihre Interessen und Talente noch nicht in einen plausiblen Berufsweg &uuml;bersetzen k&ouml;nnen, ist mit ihnen alles in Ordnung. Sie sind keine Ausnahmen, die Schwierigkeit, in dieser Welt Fu&szlig; zu fassen ist nicht ihre Schuld, und Ihre schon gar nicht. Wir wollen uns an dieser Stelle aber nicht mit einer l&auml;ngeren Erkl&auml;rung aufhalten, warum es heute f&uuml;r junge Menschen so unglaublich schwierig ist, gute Bildungs- und Berufsentscheidungen zu f&auml;llen, obwohl die Auswahl so gro&szlig; zu sein scheint. Gemeinsam mit besorgten Eltern haben wir eine Alternative entwickelt, die Ihren Kindern die bestm&ouml;gliche Hilfestellung bei einer&nbsp; Orientierung an den mittelfristigen realen M&ouml;glichkeiten bietet.</p>

			<p>Es&nbsp;handelt&nbsp;sich&nbsp;um&nbsp;ein&nbsp;pers&ouml;nlich&nbsp;zugeschnittenes&nbsp;Ausbildungsprogramm,&nbsp;bei&nbsp;dem&nbsp;pers&ouml;nliche&nbsp;Entwicklung,&nbsp;praktisches&nbsp;Hineinschnuppern&nbsp;in&nbsp;zahlreiche&nbsp;Berufsfelder,&nbsp;unternehmerische&nbsp;Grundausbildung,&nbsp;sowie&nbsp;Natur-&nbsp;und&nbsp;Kulturerfahrung&nbsp;im&nbsp;Mittelpunkt&nbsp;stehen.&nbsp;Es&nbsp;findet&nbsp;Vollzeit&nbsp;in&nbsp;Wien&nbsp;statt&nbsp;und&nbsp;dauert&nbsp;bis&nbsp;zu&nbsp;einem&nbsp;Jahr.&nbsp;Es&nbsp;ist&nbsp;daf&uuml;r&nbsp;gedacht,&nbsp;junge&nbsp;Menschen&nbsp;optimal&nbsp;auf&nbsp;weitere&nbsp;Bildungs-&nbsp;und&nbsp;Karrierewege&nbsp;vorzubereiten,&nbsp;ihnen&nbsp;das&nbsp;notwendige&nbsp;Fundament&nbsp;f&uuml;r&nbsp;gute&nbsp;Entscheidungen&nbsp;mitzugeben&nbsp;und&nbsp;ihre&nbsp;wirtschaftliche&nbsp;Selbst&auml;ndigkeit&nbsp;zu&nbsp;f&ouml;rdern.&nbsp;Es&nbsp;handelt&nbsp;sich&nbsp;um&nbsp;ein&nbsp;ideales&nbsp;Erg&auml;nzungsprogramm&nbsp;vor,&nbsp;zwischen&nbsp;oder&nbsp;nach&nbsp;weiteren&nbsp;universit&auml;ren&nbsp;Studien.</p>

			<p>Das&nbsp;Programm&nbsp;tr&auml;gt&nbsp;den&nbsp;Namen&nbsp;CRAFTprobe,&nbsp;was&nbsp;im&nbsp;Englischen&nbsp;grob&nbsp;&uuml;bersetzt&nbsp;&bdquo;Sondieren&nbsp;beruflicher&nbsp;Fertigkeiten&ldquo;&nbsp;bedeutet&nbsp;und&nbsp;im&nbsp;Deutschen&nbsp;auf&nbsp;die&nbsp;Kraftproben&nbsp;Bezug&nbsp;nimmt,&nbsp;die&nbsp;in&nbsp;traditionellen&nbsp;Gesellschaften&nbsp;den&nbsp;&Uuml;bergang&nbsp;von&nbsp;der&nbsp;Jugend&nbsp;ins&nbsp;Erwachsenenalter&nbsp;markieren.&nbsp;Fehlen&nbsp;solche&nbsp;selbst&auml;ndigen&nbsp;Kraftproben,&nbsp;werden&nbsp;sie&nbsp;durch&nbsp;leichtsinnige&nbsp;Mutproben&nbsp;kompensiert&nbsp;oder&nbsp;die&nbsp;Selbst&auml;ndigkeit&nbsp;misslingt&nbsp;zum&nbsp;Preis&nbsp;ewiger&nbsp;Abh&auml;ngigkeiten.</p>

			<p>Das Tr&auml;gerunternehmen des Programms ist gemeinn&uuml;tzig und wurde von einer Gruppe erfolgreicher Unternehmer aus &Ouml;sterreich, Deutschland, Schweiz und Liechtenstein gegr&uuml;ndet, aus dem Antrieb heraus, der n&auml;chsten Generation Wertvolles mitzugeben und ihr Mut zur Eigenverantwortung zu machen. Das ist in unserer Zeit besonders schwierig und ben&ouml;tigt daher besondere Unterst&uuml;tzung. Diese wollen wir Ihrem Sohn/Ihrer Tochter bieten.</p>

			<p>Die Kosten f&uuml;r einen Ausbildungsplatz betragen 1.000&euro; pro Monat. Wir k&ouml;nnen Ihnen allerdings drei verg&uuml;nstigte Pakete anbieten:</p>

			<ul>
				<li>Bei Teilnahme am gesamten Jahresprogramm, dass insgesamt vier Monate freie Zeiten f&uuml;r andere Praktika, Studien, Projekte oder Reisen l&auml;sst (bei begleitendem Coaching), betr&auml;gt die Gesamtgeb&uuml;hr nur 7.000&euro;.</li>
				<li>Bei Teilnahme w&auml;hrend eines Semesters betr&auml;gt die Semestergeb&uuml;hr nur 3.500&euro;.</li>
				<li>Die Mindestteilnahmedauer betr&auml;gt zwei Monate, daf&uuml;r fallen 1.900&euro; an.</li>
			</ul>

			<p>Zus&auml;tzlich sind wom&ouml;glich Wohnkosten in Wien zu &uuml;bernehmen, wobei wir aber bei der Suche nach einer g&uuml;nstigen Unterkunft helfen. Wir empfehlen die Teilnahme w&auml;hrend des gesamten Jahres. Sollte Ihnen dieser Aufwand finanziell nicht m&ouml;glich sein, sind auch k&uuml;rzere Zeiten ein Gewinn f&uuml;r Ihren Sohn/Ihre Tochter. Eine ratenweise Zahlung ist bei Teilnahme am Jahresprogramm m&ouml;glich.</p>

			<p>Das erh&auml;lt Ihr Sohn/Ihre Tochter daf&uuml;r:</p>

			<ul>
				<li>T&auml;gliche Ausbildung in f&uuml;nf Kernbereichen: Nutzung digitaler Werkzeuge, Nutzung analoger Werkzeuge, Kultur (insbesondere Geistes- und Sozialwissenschaft, Perfektionierung von sprachlichem Ausdruck und Argumentationsf&auml;higkeit), Natur (Gesundheit, K&ouml;rperbeherrschung, Lernen aus und von der Natur) und Zukunftsf&auml;higkeit (Trends erkennen und analysieren, unternehmerische Grundfertigkeiten).</li>
				<li>Pers&ouml;nliche Betreuung und Hilfestellungen beim Finden des eigenen Weges. Durchf&uuml;hrung eigener Projekte, um St&auml;rken zu erkennen und optimal zu f&ouml;rdern.</li>
				<li>Zugang zu einer der au&szlig;ergew&ouml;hnlichsten Privatbibliotheken Wiens.</li>
				<li>Teilhabe an einem Netzwerk f&uuml;r sp&auml;teren beruflichen Erfolg.</li>
				<li>Pers&ouml;nlicher Arbeitsplatz mit allen n&ouml;tigen Ger&auml;ten und Werkzeugen.</li>
				<li>Wertvolle Kontakte zu Unternehmern, Fachleuten, K&uuml;nstlern.</li>
				<li>Alle Spesen f&uuml;r Ausfl&uuml;ge (Betriebsbesuche, Naturerfahrung, externe Kurse &hellip;).</li>
				<li>Aufnahme in eine Gemeinschaft au&szlig;ergew&ouml;hnlicher junger Menschen mit besonders hohem Potential.</li>
			</ul>

			<p>Exklusive Bildungsprogramme mit pers&ouml;nlicher Betreuung, hochwertiger Infrastruktur und moderner Ausr&uuml;stung sind teuer. Alternative praktische Ausbildungsprogramme im Ausland kosten teilweise mehr als 7.000&euro; pro Monat. Wir k&ouml;nnen Ihnen nur deshalb so g&uuml;nstige Konditionen bieten, weil bei uns keine Profite, Zinsen oder Steuern lukriert werden m&uuml;ssen und viel Idealismus privater Unterst&uuml;tzer dahinter steht. </p>

			<p>Wir&nbsp;hoffen,&nbsp;Sie&nbsp;k&ouml;nnen&nbsp;sich&nbsp;zu&nbsp;dieser&nbsp;langfristigen&nbsp;Investition&nbsp;und&nbsp;Starthilfe&nbsp;f&uuml;r&nbsp;Ihren&nbsp;Sohn/Ihre&nbsp;Tochter&nbsp;entschlie&szlig;en&nbsp;und&nbsp;stehen&nbsp;Ihnen&nbsp;gerne&nbsp;f&uuml;r&nbsp;weitere&nbsp;Fragen&nbsp;zur&nbsp;Verf&uuml;gung.&nbsp;Bitte&nbsp;schreiben&nbsp;Sie&nbsp;uns&nbsp;unter&nbsp;info@wertewirtschaft.org.&nbsp;Wir&nbsp;w&uuml;rden&nbsp;uns&nbsp;sehr&nbsp;freuen,&nbsp;Ihren&nbsp;Sohn/Ihre&nbsp;Tochter&nbsp;bald&nbsp;auf&nbsp;seinem/ihrem&nbsp;Lebensweg&nbsp;unterst&uuml;tzen&nbsp;zu&nbsp;d&uuml;rfen.</p>

		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>