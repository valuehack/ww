<!-- 
send email for all members
-->

<?php

//DEPENDENCIES
require_once('../config/config.php');

#-------------------------------------
//FUNCTIONS

//function to separate messy html body 
function htmlEmail($user_profile) {
   
#---------------------------------------------------------------------------------------------
#------------------HTML-BODY------------------------------------------------------------------
#---------------------------------------------------------------------------------------------

$htmlBody = '<html>
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
<!--#image #
<img style="" class="" title="" alt="" src="http://www.wertewirtschaft.org/tools/Erinnerung-Header-01.png" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
#/image#-->
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
<br>

<strong>

</strong>  

<br> 

<!--ACTUAL TEXT-->

this is an example of newsletter solution

<!--ACTUAL TEXT-->

<br><br><br> <br></span></span></span></div>
<!--#/html#-->
</span></span></span></td></tr></tbody></table>

<!--#loopsplit#
<table class="editable text" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" valign="top">

<!--#line #
<hr class="editable" style="background: transparent;" noshade="" size="1">
<!--#/line#

</td></tr></tbody>
</table>-->

<!--#loopsplit#-->
<a rel="isset" class="anc_1" name="anc46823" id="anc46823"></a><table class="editable text" border="0" width="100%">
<tbody><tr>
<td valign="top">
<div style="text-align: justify;">
</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>

<!--#aboutus #-->
<table style="font-size: 10px;" border="0" cellpadding="10" cellspacing="0" width="100%">
<tbody>
<tr>
<td cr_edit="footer" class="text" style="font-size:10px" align="center" valign="top">
Institut f&uuml;r Wertewirtschaft<br> Schl&ouml;sselgasse 19/2/18<br> 1080 Wien<br> &Ouml;sterreich<br> 		info@scholarium.at
<br> <br> <br></td></tr></tbody></table>
<!--#/aboutus#-->
<br></td></tr></tbody></table></td></tr></tbody></table></center></body></html>';


//$htmlBody .= "hi".$user_profile[Anrede];
// echo $htmlBody;
return $htmlBody;	

}
#-------------------------------------

// user email, user password, user first name?
function sendEmail($user_profile)
{

	//create curl resource
	$ch = curl_init();

	//werte key
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: Bearer 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'));

	//set url
	curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$post_data = array(

		
/*		'to' => $user_profile[user_email],
		'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
		'subject' => 'Herzlich willkommen',
		'html' => htmlEmail($user_profile, $user_password),
		'from' => 'info@scholarium.at'*/


// !!!
		'to' => 'dzainius@gmail.com',
		'toname' => 'test',
		'subject' => 'testing',
		'html' => htmlEmail($user_profile, $user_password),
		'from' => 'info@scholarium.at'

		);

	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

	// $output contains the output string
	$response = curl_exec($ch);

	//TODO - add here current
	if(empty($response))die("Error: No response.");
	else
	{
	    $json = json_decode($response);
	    // print_r($json->access_token);
	    print_r($response);
	}

	curl_close($ch);

}
#-------------------------------------

//MAIN PART OF SCRIPT
try {
    // Generate a database connection, using the PDO connector
    // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
    // Also important: We include the charset, as leaving it out seems to be a security issue:
    // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
    // "Adding the charset to the DSN is very important for security reasons,
    // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
    $db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
// If an error is catched, database connection failed
} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
        exit;
}

//!!!
//make sure that tables names are right!
//$sth = $db_connection->prepare("SELECT * FROM mitgliederExt ORDER BY user_id ASC");
$sth = $db_connection->prepare("SELECT * FROM TEMP_TEST_USERS ORDER BY user_id ASC");

$sth->execute();
$result = $sth->fetchAll();

if (count($result) > 0) 
{

	echo count($result)."<br>";
	
	//iterates through every row in a database
	for ($i = 0; $i < count($result); $i++) {


        // echo "query_migration_password ".$query_migration_password->errorCODE();
        // print_r($query_migration_password->errorInfo());
        // echo "<br>";

        //  print_r($result[$i]);
	    sendEmail($result[$i]);

	}
}

?>
