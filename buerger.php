<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('../libraries/password_compatibility_library.php');
}
// include the config
require_once('../config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('../translations/en.php');

// include the PHPMailer library
require_once('../libraries/PHPMailer.php');

// load the login class
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="B&uuml;rger";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("../views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("../views/_header_not_in.php");
    
}

?>

<div class="content">
	<div class="blog">
		<header>
			<h1>B&uuml;rger</h1>
		</header>
		<p class='linie'><img src='../style/gfx/linie.png' alt=''></p>
		<div class="blog_text">
			<p>
				Sind Sie ein Wertewirt? Die meisten Menschen sind Wertekonsumenten und allenfalls Blasenwirte. Wertewirte schaffen mehr reale Werte als sie aufbrauchen und stiften dadurch Sinn. Das ist heute gar nicht leicht, oft schier unm&ouml;glich. Die Voraussetzung daf&uuml;r ist, sich der Realit&auml;t zu stellen. Das bedeutet f&uuml;r die meisten zun&auml;chst eine gro&szlig;e Ent&ndash;T&auml;uschung, die sich anfangs nicht sehr gut anf&uuml;hlt. Doch Sie suchen gewiss mehr als bequeme Gef&uuml;hle, sonst w&auml;ren Sie gar nicht hier.
			</p>
			<p>
				Was k&ouml;nnen wir f&uuml;r Sie tun? Sie w&uuml;nschen sich Alternativen, m&ouml;chten selbst nachdenken und sich f&uuml;r bessere Wege engagieren, doch es fehlen Ihnen Zeit, Mittel und Mu&szlig;e. Sie wissen, dass viele Spinner und Ideologen das Feld der Systemkritik beackern und sehen den Bedarf f&uuml;r ein seri&ouml;ses, professionelles und unabh&auml;ngiges Forschungsprogramm, das nicht im Expertenjargon, sondern in allgemein verst&auml;ndlicher Form Probleme und Dynamiken analysiert, Alternativen n&uuml;chtern pr&uuml;ft, andere B&uuml;rger sensibilisiert und Inspiration und Ermutigung f&uuml;r neue Wege werte&ndash; und sinnorientierten Wirtschaftens abseits der verzerrten Blasenwirtschaft unserer Zeit bietet.
			</p>
			<p>
				Wer sind wir? Unsere Unabh&auml;ngigkeit und Professionalit&auml;t wird durch eine rein private Finanzierung gew&auml;hrleistet. Erfolgreiche Unternehmer aus &ouml;sterreich, Deutschland, Schweiz und Liechtenstein waren die ersten, die einen Bedarf nach realer Wertewirtschaft abseits der T&auml;uschungen und Blasen erkannten und auf Einladung und Initiative von Rahim Taghizadegan das gemeinn&uuml;tzige Unternehmen SCHOLARIUM gr&uuml;ndeten, das unter anderem die langj&auml;hrige Arbeit des Instituts f&uuml;r Wertewirtschaft professionalisiert und als Forschungsprogramm auf nachhaltiger Grundlage nun noch mehr Menschen zug&auml;nglich macht. Wenn Sie zu uns geh&ouml;ren, dann laden wir Sie ein, uns auf diesem schwierigen, aber unglaublich lehrreichen Weg zu begleiten, auf dem wir herausfinden wollen, wie sich heute noch die Realit&auml;t erkennen, Werte schaffen und Sinn finden lassen.
			</p>
			<p>
				Warum braucht es ein solches Unternehmen &uuml;berhaupt? Institute und Initiativen mit guten Intentionen gibt es zur Gen&uuml;ge. Die meisten sind allerdings ideologisch motiviert, das hei&szlig;t, sie wissen schon, was gut f&uuml;r uns ist, haben fertige Schlussfolgerungen und entwickeln erst danach Argumente, um andere zu bekehren. In aller Regel sind solche Initiativen subventioniert, das hei&szlig;t, Interessengruppen zahlen f&uuml;r diese (letztlich nicht zielf&uuml;hrende) Missionierungsarbeit, oder es flie&szlig;t gar Steuergeld hinein, das hei&szlig;t wir zahlen alle mit, egal ob wir die Werte teilen und die Arbeit sch&auml;tzen. Das ist nat&uuml;rlich die ideale Voraussetzung f&uuml;r Unprofessionalit&auml;t, Verschwendung, Selbstbeweihr&auml;ucherung, Anpassung und Denkverbote. Sind sie nicht subventioniert, so sind es meist Hobby&ndash;Projekte mit der typischen Vereinsmeierei (je drei Engagierte werden vier Vereine gegr&uuml;ndet, die ihren jeweiligen Anspruch auf Wichtigkeit durch ausgefeilte Strukturen und Versprechen zelebrieren).
			</p>
			<p>
				Wir sch&auml;tzen das vielf&auml;ltige, zivilgesellschaftliche Engagement sehr und wollen es nicht schlechtreden. Auf diesem Engagement bauen wir auf und wollen es professionell begleiten und erg&auml;nzen. SCHOLARIUM spricht die Menschen nicht nur als Konsumenten an, sondern als engagierte, vernunftbegabte B&uuml;rger und ist dadurch einmalig, die Spannung zwischen zwei Versuchungen halten zu  k&ouml;nnen, die unsere Zeit und damit auch die meisten B&uuml;rgerinitiativen kennzeichnen:
			</p>
			<p>
				Auf der einen Seite steht das Gutreden der Verh&auml;ltnisse: Wir w&uuml;rden auf hohem Niveau jammern, lebten in unvergleichlichem Wohlstand, noch nie w&auml;re es uns so gut gegangen. Dieses nachvollziehbare Gutreden, das dem notwendigen Grundoptimismus gerade unternehmerischer und eigenverantwortlicher Menschen entspringt, f&uuml;hrt zu einem Grundvertrauen in die Institutionen: Klar k&ouml;nnten die Politiker besser sein, die Wissenschaftler und K&uuml;nstler renommierter, die Unternehmer erfolgreicher. Wir m&uuml;ssten uns alle nur ein bisschen zusammenrei&szlig;en, um das Bestehende zu bewahren, und dann w&auml;re eigentlich alles gut, zumindest akzeptabel.
			</p>
			<p>
				Auf der anderen Seite steht das Schlechtreden der Verh&auml;ltnisse: Es h&auml;tte ohnehin alles keinen Sinn, die politischen Verh&auml;ltnissen w&auml;ren nicht zu &auml;ndern, das Unternehmertum immer schwieriger bis unm&ouml;glich, die verbliebenen B&uuml;rger, die zur Eigenverantwortung noch f&auml;hig w&auml;ren, sollten eher den Exodus suchen, um dem Wahnsinn zu entkommen.  Dieses nachvollziehbare Schlechtreden, das der notwendigen N&uuml;chternheit gerade unternehmerischer und eigenverantwortlicher Menschen entspringt, f&uuml;hrt zu einem absoluten Vertrauensverlust: Wenn Experten und Medien etwas verlautbaren, w&auml;re wahrscheinlich das Gegenteil richtig – und dieses Richtige wird dann im Internet, in Foren und Weblogs gesucht, die immer neue Theorien parat haben, wer an den Verh&auml;ltnissen Schuld w&auml;re und welche Endl&ouml;sung aller Probleme durch wen und warum verhindert w&uuml;rde.
			</p>
			<p>
				So entstehen zwei Welten, die sich immer mehr von einander entfernen. Das Lager der verantwortungsbereiten B&uuml;rger reibt sich vollkommen auf im Konflikt zwischen Gutrednern und Schlechtrednern (links und rechts, elit&auml;r und anti&ndash;elit&auml;r, strukturkonservativ und revolution&auml;r, Mutb&uuml;rger und Wutb&uuml;rger – all das entz&uuml;ndet sich dann noch an jener Bruchlinie).
			</p>
			<p>
				Wem kann man denn noch vertrauen? Dem eigenen Verstand und der eigenen Erfahrung, im &uuml;berschaubaren Bereich eigener Versuche der Wertsch&ouml;pfung und Sinnfindung. Wir haben keine fertigen Antworten, keine Programmatik, keine L&ouml;sungsformel anzubieten. Nur absolut unabh&auml;ngiges Streben nach Erkenntnis, und zwar nicht rein theoretischer anhand von Weltmodellen, sondern praktischer anhand der tiefgehenden Reflexion realer Herausforderungen und M&ouml;glichkeiten.
			</p>
			<p>
				Wir laden die letzten eigenverantwortlichen B&uuml;rger im deutschsprachigen Raum (und auch jene, die bereits den Exodus angetreten haben) ein, uns bei unserer unbequemen Suche nach Erkenntnis, Wertsch&ouml;pfung und Sinnfindung zu begleiten und daraus Nutzen, Inspiration und Ermutigung zu ziehen.
			</p>
		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>