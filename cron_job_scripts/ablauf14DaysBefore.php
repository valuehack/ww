<!-- 
send email to everyone that matches query
of expiration of account 14 days in advance
TO DO: PDO, PHPMailer
-->

<?php

@$con=mysql_connect ("","","") or die ("cannot connect to MySQL");

#@$con=mysql_connect("localhost","testwerte","password") or die ("cannot connect to MySQL");

#mysql_select_db("testwerte");
mysql_select_db("");

$query = "SELECT * from Mitglieder WHERE Ablauf = DATE_ADD(CURDATE(),INTERVAL 14 DAY)";

$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());

  while ($entry = mysql_fetch_array($result))
  {

	#$to = $entry[Email];
	$to = '@.com';

	$subject = 'Zahlungserinnerung';


#---------------------------------------------------------------------------------------------
#------------------HTML-BODY------------------------------------------------------------------
#---------------------------------------------------------------------------------------------

$body='

<html>
<head>
<meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\'> 
<style type="text/css"></style>

<style id="cr_style">
h1,h2,h3,h4,h5,h6{margin: 0 0 10px 0;}
.background {
background-color: #fafafa;
}
a {color: #0066ff; }
.text {
color: #666666;
font-size: 12px;
font-family: verdana;
}
body {
margin: 0pt;
padding: 0pt;
background-color: #fafafa;
width: 100% ! important;
color: #666666;
font-size: 12px;
font-family: verdana;
}
</style>


<meta name="robots" content="noindex,nofollow">
<title>Erinnerung</title>
</head>

<!--BODY-->

<body leftmargin="0" topmargin="0" offset="0" style="color: rgb(102, 102, 102); font-size: 12px; font-family: arial; margin: 0px; padding: 0px; background-color: rgb(250, 250, 250); width: 100% ! important; cursor: auto;" class="" marginheight="0" marginwidth="0">
<center>
<table class="text" cr_edit="Content" style="background-color: #ffffff; border: 1px solid #cccccc" align="center" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr>
<td cr_edit="Header" style="border: 0px solid #cccccc; background-color: #cccccc;" class="" align="center">
</td>
</tr>
<tr>
<td valign="top" width="600">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tbody><tr>
<td class="text">
<!--#loop #-->
<a rel="isset" class="anc_1" name="anc26181" id="anc26181"></a>
<table class="editable text" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center">
<!--#image #-->
<img style="" class="" title="" alt="" src="http://www.wertewirtschaft.org/tools/Erinnerung-Header-01.png" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
<!--#/image#-->
</td>
</tr>
</tbody>
</table>
<!--#loopsplit#-->
<a rel="isset" class="anc_1" name="anc81061" id="anc81061"></a><table class="editable text" border="0" width="100%">
<tbody>
<tr>
<td valign="top">


<div style="text-align: justify;">
<h2></h2>
<!--#html #-->
<span style="font-family: times new roman,times;">
<span style="font-size: 12pt;">
<span style="color: #000000;">
'; 

if ($entry[Anrede]=="Herr") {$body.="Sehr geehrter Herr ";}

if ($entry[Anrede]=="Frau") {$body.="Sehr geehrte Frau ";}

//else {$body.="Sehr geehrte(r) Frau/ Herr ";}

if ($entry[Titel]) $body.=$entry[Titel]." ";

$body.=$entry[Nachname].',<br>';

$body.='
<br>
dies ist eine automatische Erinnerungsnachricht, dass ein Beitrag  f&uuml;r Ihre Mitgliedschaft/Ihr Abonnement f&auml;llig ist.  Ihre Mitgliedschaft/Ihr Abonnement war bis 

<strong>
'.

date("d.m.Y",strtotime($entry[Ablauf]))

.'
</strong>  
bezahlt. Wir m&ouml;chten Sie um rasche &Uuml;berweisung des  offenen Betrages bitten, denn unser Institut kann nur deshalb ohne  Zwangs- und Lobbygelder &uuml;berleben, wenn uns Menschen wie Sie  regelm&auml;&szlig;ig unterst&uuml;tzen. 

<br> 
<br>

Ein Abonnement der Scholien ist nunmehr mit einer <a href="http://www.wertewirtschaft.org/institut/mitglied.php">Mitgliedschaft</a> im Institut f&uuml;r Wertewirtschaft verbunden und bietet Ihnen  weitere Vorteile. Der Mindestbeitrag betr&auml;gt 90 Euro. <br><br>Neue  Zusatzleistungen: <br><br> - Deutliche Erm&auml;&szlig;igungen bei unseren  Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die  Mitgliedschaft einen finanziellen Vorteil) <br> - Kostenloser Video-Stream zu unseren Salon-Veranstaltungen <br> - Wachsende Zahl exklusiver Inhalte (Video/Audio) <br> - Nutzung der Bibliothek, B&uuml;cherleihe <br><br>Wenn Sie unsere Arbeit f&uuml;r wertvoll halten und honorieren  wollen, w&uuml;rden wir uns geehrt f&uuml;hlen durch eine  Unterst&uuml;tzung, die &uuml;ber diesem minimalen Kostenbeitrag  liegt: <br><br>F&ouml;rdermitgliedschaft - 150 Euro; <br> - Hintergrundinformationen zu unserer Arbeit <br> - Einladung zu exklusiven Veranstaltungen <br> - Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen <br><br>F&ouml;rdermitgliedschaft - 300 Euro; <br> - Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen <br><br>Zahlungsoptionen: <br><br> - Per Bank&uuml;berweisung auf unser EUR-Konto bei der „Erste Bank“ (Wien): Kontonummer: 28824799900, Bankleitzahl: 20111; IBAN: AT332011128824799900, BIC: GIBAATWW.<br> - Per Paypal (erm&ouml;glicht Kreditkartenzahlung) an die Adresse <a href="mailto:info@wertewirtschaft.org" target="_blank">info@wertewirtschaft.org</a>. <br> - Bar oder in Edelmetallen auf dem Postweg an: Institut  f&uuml;r Wertewirtschaft, Schl&ouml;sselgasse 19/2/18, 1080  Wien, &Ouml;sterreich<br><br> Bitte geben Sie bei der Zahlung an: Mitglied 
<strong>
'.

$entry[id]

.'
</strong> <br><br>Falls Sie Fragen haben, stehen wir Ihnen gerne zur  Verf&uuml;gung. Dies ist eine automatisch erstellte Nachricht - wir  hoffen, die Technik funktionierte und Sie haben Verst&auml;ndnis  f&uuml;r diese unpers&ouml;nliche Erinnerung. <br><br>Herzliche  Gr&uuml;&szlig;e und vielen Dank f&uuml;r Ihre  Unterst&uuml;tzung, <br><br>Ihr Institut f&uuml;r Wertewirtschaft<br> <br></span></span></span></div>
<!--#/html#-->
</span>
</span>
</span>

</td>
</tr>
</tbody>
</table>

<!--#loopsplit#
<table class="editable text" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" valign="top">

<!--#line #
<hr class="editable" style="background: transparent;" noshade="" size="1">
<!--#/line#

</td>
</tr>
</tbody>
</table>-->


<!--#loopsplit#-->
<a rel="isset" class="anc_1" name="anc46823" id="anc46823"></a><table class="editable text" border="0" width="100%">
<tbody><tr>
<td valign="top">
<div style="text-align: justify;">
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>


<!--#aboutus #-->
<table style="font-size: 10px;" border="0" cellpadding="10" cellspacing="0" width="100%">
<tbody>
<tr>
<td cr_edit="footer" class="text" style="font-size:10px" align="center" valign="top">
Institut f&uuml;r Wertewirtschaft<br> Schl&ouml;sselgasse 19/2/18<br> 1080 Wien<br> &Ouml;sterreich<br> 		info@wertewirtschaft.org
<br> 
<br> 
<br> 
<br> 
<br> 
<br>
</td>
</tr>
</tbody>
</table>
<!--#/aboutus#-->


<br>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</center>
</body>
</html>

';
#---------------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------------

#$body = html_entity_decode($body);
$body = wordwrap($body,70);

//headers
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Wertewirtschaft<info@wertewirtschaft.org>'. "\r\n";
$headers .= 'Bcc:' . "\r\n"; #use bcc for testing purposes

	if (
	   mail($to, $subject, $body, $headers)
	   ) 
	{

	#if email sent successfuly then update the database
	//$update_query = "UPDATE Mitglieder SET Mahnstufe='1' WHERE id='".$entry[id]."'";
	//mysql_query($update_query) or die("Failed Query of ".$update_query.' '.mysql_error());
	
	}

#Testing the html email body in a browser window
//echo $body;

  }

?>
