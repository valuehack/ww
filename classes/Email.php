<?php

	#Collection of automatic emails used within the page
	
class Email {
	
	public function __construct() {
		
	}
	
	/*
	 * 		emails to user
	 */
	
	public function sendVerificationMinimal ($user_id, $user_email, $user_activation_hash, $user_password) {
	
		/*
	 	* Sending verification code and tempory password to users only providing email
	 	*/
		
		$subject = 'Herzlich Willkommen';
		
		#verification link
        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

        #read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
                <!--#/image#-->
                </td>
                </tr>
                </tbody>
                </table>
                <!--#loopsplit#-->
                <table class="editable text" border="0" width="100%">
                <tbody>
                <tr>
                <td valign="top">
                <div style="text-align: justify;">
                <h2></h2>
                <!--#html #-->
                <span style="font-family: times new roman,times;">
                <span style="font-size: 12pt;">
                <span style="color: #000000;">
                <!--#/html#-->
                <br>            
                Lieber Gast,
                <br>
                vielen Dank f&uuml;r Ihr Interesse!
                <br>';

        $body = $body.'
                Bitte klicken Sie auf den Link unterhalb, um Ihre Eintragung abzuschlie&szlig;en. (Falls der Link nicht anklickbar ist, bitte die Adresse des Links in die Adresszeile Ihres Browsers kopieren.)
                <br><a href="'.$link.'">'.$link.'</a>

                <br><strong>Ihr vorl&auml;ufiges Passwort ist: </strong>'.$user_password.'<br>
                Herzliche Gr&uuml;&szlig;e aus Wien!';


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');
		
		if ($this->sendEmail('info@scholarium.at', 'scholarium', $user_email, $subject, $body)) {
			return true;
		}
		else {
			return false;
		}
		
	}
	
	public function sendVerificationFull ($user_id, $user_email, $user_activation_hash, $user_password, $user_anrede, $user_surname) {
		
		/*
	 	* Sending verification code and tempory password to users with full info
	 	*/
		
		$subject = 'Herzlich Willkommen';
		
		#verification link
        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

		if ($user_anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        	}
		if ($user_anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
			}

        #read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
                <!--#/image#-->
                </td>
                </tr>
                </tbody>
                </table>
                <!--#loopsplit#-->
                <table class="editable text" border="0" width="100%">
                <tbody>
                <tr>
                <td valign="top">
                <div style="text-align: justify;">
                <h2></h2>
                <!--#html #-->
                <span style="font-family: times new roman,times;">
                <span style="font-size: 12pt;">
                <span style="color: #000000;">
                <!--#/html#-->
                <br>            
                '.$anrede.' '.$user_surname.',
                <br>
                vielen Dank f&uuml;r Ihr Interesse!
                <br>';

        $body = $body.'
                Bitte klicken Sie auf den Link unterhalb, um Ihre Eintragung abzuschlie&szlig;en. (Falls der Link nicht anklickbar ist, bitte die Adresse des Links in die Adresszeile Ihres Browsers kopieren.)
                <br><a href="'.$link.'">'.$link.'</a>

                <br><strong>Ihr vorl&auml;ufiges Passwort ist: </strong>'.$user_password.'<br>
                
				<br>Nach der erfolgreichen Aktivierung erhalten Sie eine Best&auml;tigung mit der Rechnung sowie gegebenenfalls Ihrem Ticket.<br><br>
				
                Herzliche Gr&uuml;&szlig;e aus Wien!';


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');
		
		if ($this->sendEmail('info@scholarium.at', 'scholarium', $user_email, $subject, $body)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function sendConfirmation ($user_email, $user_surname, $user_anrede, $user_level, $files, $product_type, $zahlung) {
		
		/*
		 * Confirmation email after verification is a success, invoices and tickets will be attched here
		 */ 
		
		switch($user_level) {
			case 2: $membership = "Gast"; break;
			case 3: $membership = "Teilnehmer"; break;
			case 4: $membership = "Scholar"; break;
			case 5: $membership = "Partner"; break;
			case 6: $membership = "Beirat"; break;
			case 7: $membership = "Patron"; break;
			default: $membership = "Interessent"; break;
		}
		
		$subject = 'Anmeldung erfolgreich';
		
		if ($user_anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        	}
		if ($user_anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
			}

		#read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');
		
        $body = $body.'
                <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
                <!--#/image#-->
                </td>
                </tr>
                </tbody>
                </table>
                <!--#loopsplit#-->
                <table class="editable text" border="0" width="100%">
                <tbody>
                <tr>
                <td valign="top">
                <div style="text-align: justify;">
                <h2></h2>
                <!--#html #-->
                <span style="font-family: times new roman,times;">
                <span style="font-size: 12pt;">
                <span style="color: #000000;">
                <!--#/html#-->
                <br>            
                '.$anrede.' '.$user_surname.',
                <br><br>
                Wir freuen uns Sie als <i>'.$membership.'</i> begr&uuml;&szlig;en zu d&uuml;rfen!
                <br><br>
                Anbei finden Sie Ihre Rechnung
                ';
				
		if ($product_type === 'seminar') {
				$body = $body.' und Ihr Ticket';
				}

		$body = $body.'.<br>';
		
		if ($zahlung === 'bank') {
			$body = $body.'Bitte überweisen Sie den Gesamtbetrag mit Angabe der Rechnungsnummer innerhalb von 14 Tagen auf unser folgendes Konto:<br>
                     <br>
                	scholarium GmbH<br>
                	IBAN: AT812011182715898501<br>
                	BIC: GIBAATWWXXX<br>';
		}
		
		if ($zahlung === 'kredit') {
			$body = $body.'Sie haben diese Rechnung bereits mit paypal beglichen.<br>';
		}
		
		if ($zahlung === 'bar') {
			$body = $body.'Bitte schicken Sie uns den Gesamtbetrag in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an das scholarium, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.<br>';
		}

		$body = $body.'<br>Viele Gr&uuml;&szlig;e aus Wien<br>Ihr Scholarium';
		
		$body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');
		
		$this->sendEmailWithFiles('info@scholarium.at', 'scholarium', $user_email, $subject, $body, $files);
				
	}
	
	public function sendOneClick ($user_id, $event_id, $quantity, $format) {
		
		$general = new General();
		
		$user_info = $general->getUserInfo($user_id);
		$event_info = $general->getProduct($event_id);
		
		$date = $general->getDate($event_info->start, $event_info_>end);
		
		if ($user_info->Anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        	}
		if ($user_info->Anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
			}

		$subject = 'Buchungsbest&auml;tigung';
		
		#read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');
		
		$body = '<img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
                <!--#/image#-->
                </td>
                </tr>
                </tbody>
                </table>
                <!--#loopsplit#-->
                <table class="editable text" border="0" width="100%">
                <tbody>
                <tr>
                <td valign="top">
                <div style="text-align: justify;">
                <h2></h2>
                <!--#html #-->
                <span style="font-family: times new roman,times;">
                <span style="font-size: 12pt;">
                <span style="color: #000000;">
                <!--#/html#-->
                <br>            
                '.$anrede.' '.$user_surname.',
                <br><br>
                Ihre Anmeldung war erfolgreich.<br><br>
                '.ucfirst($event_info->type).' '.$event_info->title.'<br>
                '.$date.'<br>
                '.$format.'<br>
                <br>Viele Gr&uuml;&szlig;e aus Wien<br>Ihr Scholarium';
		
		$body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');
		
		$this->sendEmail('info@scholarium.at', 'scholarium', $user_info->user_email, $subject, $body);
		
	}
	
	public function sendUpgrade () {
		
	}
	
	public function sendPasswortReset () {
		
	}
	
	/*
	 * 		emails to Scholarium
	 */
	
	public function sendScholariumMinimal ($user_email) {
		
		/*
		 * sending info that there is a new Interessent to sholarium
		 */
		 
		 $subject = 'Neuer Interessent';
		 
		 $body = $user_email.' hat sich als Interessent eingetragen';
		 
		 $this->sendEmail('info@scholarium.at', 'scholarium', 'info@scholarium.at', $subject, $body);
		
	}
	
	public function sendScholariumFull ($user_email, $user_name, $user_surname, $event_type, $event_id, $quantity, $user_level) {
		
		/*
		 * sending info that there is a new paying user to sholarium
		 */
		 
		 $subject = 'Neues zahlendendes Mitglied:';
		 
		 $body = $user_name.' '.$user_surname.'<br>
		 		 E-Mail: '.$user_email.'<br><br>
		 		 Produkt: '.ucfirst($event_type).'<br>
		 		 ID:'.$event_id.'<br>
		 		 Menge: '.$quantity.'<br><br>
		 		 Mitgliedschaft: '.$user_level
				 ;
		 
		 $this->sendEmail('info@scholarium.at', 'scholarium', 'um@scholarium.at', $subject, $body);
	}
	
	public function sendScholariumUpgrade () {
		
	}
	
	public function sendScholariumBookOrder () {
		
		/*
		 * See korb.php
		 */ 
	}
	
	/*
	 * 		general email function
	 */
	
	public function sendEmail($from, $fromname, $to, $subject, $body) {
		
	/*
	 * $from = where should the email be comming from? normally info@scholarium.at, however maybe somedays from somewhere else to, stay flexible
	 * $fromname = name of the source of the email. normally scholarium but who knows?
	 * $to = who should the email be send to? user email or info@scholarium.at
	 * $body = to be constructed in the functions above
	 */

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $body,
            'from' => $from,
            'fromname' => $fromname
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            //die("Error: No response.");
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }

        curl_close($ch);
		
	}

public function sendEmailWithFiles($from, $fromname, $to, $subject, $body, $files) {
		
	/*
	 * $from = where should the email be comming from? normally info@scholarium.at, however maybe somedays from somewhere else to, stay flexible
	 * $fromname = name of the source of the email. normally scholarium but who knows?
	 * $to = who should the email be send to? user email or info@scholarium.at
	 * $body = to be constructed in the functions above
	 * $files = array of files that should be attached
	 */

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));
        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $body,
            'from' => $from,
            'fromname' => $fromname,
            );
		
		if (!(is_null($files))) {
			foreach ($files as $filename => $location) {
				$post_data['files['. $filename .']'] = "@".$location;
			}
		}

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
        	//die("Error: No response.");
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }


        curl_close($ch);
		
	}

	public function sendPaymentSuccessfullEmail($from, $fromname, $to, $subject, $body, $files) 
	{

		#init methods for twig
	    require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
	    Twig_Autoloader::register();
	    $loader = new Twig_Loader_Filesystem('../templates');
	    $twig = new Twig_Environment($loader, array('cache' => false));

	    #values to ease the testing
	    $profile = array(
	        'user_email' => 'saltydillpickles@gmail.com',
	        'user_anrede' => 'Herr',
	        'user_first_name' => 'Denis',
	        'user_surname' => 'Stankus',
	        'user_telefon' => '123',
	        'user_street' => 'Goodin Street 5',
	        'user_plz' => '1050',
	        'user_city' => 'Wien',
	        'user_country' => 'Austria',
	        'payment_option' => 'sofort'
	        );

	    #select a template
	    $emailTemplate = $twig->loadTemplate('email.succesfullpayment.twig');



	    #pass variables to and display the template
	    $body = $emailTemplate->render(array(
	            'type' => "type", 
	            'product' => $_SESSION['product'],
	            'profile' => $profile
	            ));



	}

	
}

?>