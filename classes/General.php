<?php

	#Collection of general functions used within the page
	
class General {
	
	public function __construct() {
		
		$this->databaseConnection();
	}
	
	private function databaseConnection()
    {
        // if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                #$this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);

                #using utf8 charset instead of latin1
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);
                
                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
                $query_time_zone->execute();
                
                return true;
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
                #echo "error! <br>".$e->getMessage();;
            }
        }
        // default return
        return false;
    }
	
	public function getDate ($start, $end) {
		
			#using $start and $end to generate a date string of the form "Freitag 01.04.2016 09:00 – 18:00 Uhr"
			
			if ($start != NULL && $end != NULL) {
				
				$tag = date("w",strtotime($start));
				$tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
				$date = $tage[$tag]." ";
				$date = $date.strftime("%d.%m.%Y %H:%M", strtotime($start));
			
				if (strftime("%d.%m.%Y", strtotime($start))!=strftime("%d.%m.%Y", strtotime($end))) {
				
					$date = $date." Uhr &ndash; ";
					$tag  = date("w",strtotime($end));
					$date = $date.$tage[$tag];
					$date = $date.strftime(" %d.%m.%Y %H:%M Uhr", strtotime($end));
				}
				else {
					$date = $date.strftime(" &ndash; %H:%M Uhr", strtotime($end));
				}
			}
			elseif ($start!= NULL) {
				
				$tag = date("w",strtotime($start));
				$date = $tage[$tag]." ";
				$date = $date. strftime("%d.%m.%Y %H:%M Uhr", strtotime($start));
			}
			else {
				$date = "Der Termin wird in K&uuml;rze bekannt gegeben.";
			}
			
			return $date;
	}

	public function getProduct ($id) {
		
		if(is_numeric($id)) {
			$id_num = $id;
		}
		else {
			$id_text = $id;
		}
		
		$product_query = $this->db_connection->prepare('SELECT * FROM produkte WHERE n LIKE :id_num OR id LIKE :id_text');
		$product_query->bindValue(':id_num', $id_num, PDO::PARAM_INT);
		$product_query->bindValue(':id_text', $id_text, PDO::PARAM_INT);
		$product_query->execute();
		
		$product_result = $product_query->fetchObject();
		
		return $product_result;
		
	}
	
	public function getProducts ($type=array('all'), $status=1, $show_passed=false, $show_soldout=true) {
		# WORK in PROGRESS (using more than one type does not work yet)
		# All have parameters have to be set in the right order when calling the function, omitting one parameter will cause an error, if all parameters are omitted the default values are used
		# $type has to be an array of the types that should be selected or 'all' for all
		# $status: 0 = not active, 1 = active, 2 = test
		# $show_passed: true = show passed events, false = don't
		# $show_soldout: true = show soldout events, false = don't

		$select = 'SELECT * FROM produkte WHERE';
		
		# Preparing the list of product types to be selected
		if ($type[0] != 'all') {			
			foreach ($type as $key => $value) {
					$select = $select.' type = :type'.$key.' AND';
			}
		}
		
		# Don't show passed events
		if ($show_passed === false) {
			$select = $select.' start > NOW() AND';
		}
		
		#Don't show events that are sold out
		if ($show_soldout === false) {
			$select = $select.' spots_sold < spots AND';
		}
		
		$select = $select.' status = :status';
		
		$product_query = $this->db_connection->prepare($select);
		
		if ($type[0] != 'all') {
			foreach ($type as $key => $value) {
				$product_query->bindValue(':type'.$key, $value, PDO::PARAM_STR);
			}
		}
		
		$product_query->bindValue(':status', $status, PDO::PARAM_INT);
		$product_query->execute();
		
		return $product_query->fetchAll();
		//return $product_query->debugDumpParams();
	}
	
	public function getUserInfo ($user_id) {
		
		$table = 'mitgliederExt';
		$ident = 'user_id';
		
		#check if the identification used is id/n or email
		//if(is_numeric($id)) {$ident = 'user_id';}
		//if(!is_numeric($id)) {$ident = 'user_email';}
		
		#check if normal or grey user db should be selected
		//if ($grey === TRUE) {$table = 'grey_user';}
		//if ($grey === FALSE) {$table = 'mitgliederExt';}
		
		$user_query = $this->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_id LIKE :user_id LIMIT 1');
		//$user_query->bindValue(':table', $table, PDO::PARAM_STR);
		//$user_query->bindValue(':ident', $ident, PDO::PARAM_STR);
		$user_query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
		$user_query->execute();
		
		return $user_query->fetchObject();
	}

	public function getEventReg ($user_id, $event_id) {
		#$event_id has to nummeric
		
		$reg_event_query = $this->db_connection->prepare('SELECT * FROM registration WHERE event_id = :event_id AND user_id = :user_id');
		$reg_event_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
		$reg_event_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$reg_event_query->execute();
		
		return $reg_event_query->fetchObject();
	}

	public function getStaticInfo($page) {
		
		$static_query = $this->db_connection->prepare('SELECT * FROM static_content WHERE page LIKE :page');
		$static_query->bindValue(':page', $page, PDO::PARAM_STR);
		$static_query->execute();
		
		return $static_query->fetchObject();
	}

	public function registerEvent ($user_id, $event_id, $quantity, $format) {
	    			    				
    	#enter into event registration
		$reg_query = $this->db_connection->prepare('INSERT INTO registration (event_id, user_id, quantity, format, reg_datetime ) VALUES (:event_id, :user_id, :quantity, :format, NOW())');
        $reg_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $reg_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $reg_query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
		$reg_query->bindValue(':format', $format, PDO::PARAM_INT);
        $reg_query->execute();

		if ($format != 'Stream') {
        	#update spots sold in produkte
        	$spots_sold_query = $this->db_connection->prepare('UPDATE produkte SET spots_sold = spots_sold+:spot WHERE n = :event_id');
        	$spots_sold_query->bindValue(':spot', $quantity, PDO::PARAM_INT);
        	$spots_sold_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        	$spots_sold_query->execute();
		}

    }

	public function changeCredit ($user_id, $quantity, $price) {

		$total = $quantity*$price;

		$credit_change_query = $this->db_connection->prepare('UPDATE mitgliederExt SET credits_left = credits_left - :total WHERE user_id = :user_id');
		$credit_change_query->bindValue(':total', $total, PDO::PARAM_INT);
		$credit_change_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$credit_change_query->execute();
	}

	public function generateTicket ($user_id, $user_name, $user_surname, $event_id, $quantity) {
		
			#automated ticket generation for events both for outsiders and insiders
			
			#get event information
			$event_query = $this->db_connection->prepare('SELECT * FROM produkte WHERE n = :event_id');
			$event_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
			$event_query->execute();
			$event_result = $event_query->fetchObject();
			
			$event_title = $event_result->title;
			$event_price = $event_result->price;
			$event_type = $event_result->type;
			$event_start = $event_result->start;
			$event_end = $event_result->end;
			
			#prepare the date-string
			$event_date = $this->getDate($event_start, $event_end);

			$ticket_name = 'Ticket_'.$user_id.'_'.$event_type.'_'.$event_id;
			$ticket_pdf = 'ticket_'.$user_id.'_'.$event_type.'_'.$event_id.'.pdf';
			
			$total = $event_price*$quantity;
			
			#prepare the ticket content with html and css
			$html = '
  					<html lang="de">
      				<head>
          				<title>'.$ticket_name.'</title>        
          				<link rel="stylesheet" type="text/css" href="/home/content/56/6152056/html/production/style/ticket_style.css">
          
          				<meta name="Content-Disposition" content="attachment; filename='.$ticket_pdf.'">
          				<meta http-equiv="Content-Type" content="application/pdf; charset=UTF-8">
      				</head>
      				<body>
          				<div class="ticket_content">
              				<div>
                  				<img src="/home/content/56/6152056/html/production/style/gfx/ticket_logo.png" style="width:300px;margin-bottom:50px;">
              				</div>
              				<div class="ticket_event">
                  				<p><i>'.ucfirst($event_type).'</i></p>
                  				<h1>'.$event_title.'</h1>
                  				<p>
                      				<span class="ticket_date">'.$date.'</span>
                      				<span class="ticket_object">Anzahl</span> <span class="ticket_value">'.$quantity.'</span><br>
                      				<span class="ticket_object">Preis</span> <span class="ticket_value">'.$event_price.' &euro;</span>
                      				<span class="ticket_object">Gesamtpreis</span> <span class="ticket_value">'.$total.' &euro;</span>                       
                  				</p>   
              				</div>
              				<div class="ticket_user">
                  				<p>
                      				<span class="ticket_user_name">'.$user_name.' '.$user_surname.'</span><br>
                      				<span class="ticket_user_no">Kundennummer: '.$user_id.'</span> 
                  				</p>
              				</div>              
              				<div class="ticket_location">  
                  				<h1>Veranstaltungsort</h1>
                  				<p>Schl&ouml;sselgasse 19/2/18<br>A-1080 Wien, &Ouml;sterreich</p>
                  				<div>
  									<img src="../style/gfx/ticket_map.jpg" alt="">
          						</div>
              				</div>
          				</div>        
      				</body>
  					</html>';
			
			#render the ticket using dompdf
			require_once('../dompdf/dompdf_config.inc.php');

			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->set_paper('a4', 'portrait');
			$dompdf->render();

  			#dompdf output is saved as a string
  			$pdf = $dompdf->output();

			$ticket_location = '/home/content/56/6152056/html/production/tickets/'.$ticket_pdf;

			#save ticket on sever and prepare attachment
  			file_put_contents($ticket_location, $pdf);

			return $ticket_location;
	}
	
	public function generateInvoice($user_id, $product_id, $product_type, $user_level, $quantity, $zahlung) {
		
			#automated invoice generation both for outsiders and insiders
			
			#get user information
			$user_query = $this->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_id = :user_id');
			$user_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$user_query->execute();
			$user_result = $user_query->fetchObject();
			
			$user_name = $user_result->Vorname;
			$user_surname = $user_result->Nachname;
			$user_street = $user_result->Strasse;
			$user_plz = $user_result->PLZ;
			$user_city = $user_result->Ort;
			$user_country = $user_result->Land;
			
			#get event information
			$event_query = $this->db_connection->prepare('SELECT * FROM produkte WHERE n = :event_id');
			$event_query->bindValue(':event_id', $product_id, PDO::PARAM_INT);
			$event_query->execute();
			$event_result = $event_query->fetchObject();
			
			$event_title = $event_result->title;
			$event_price = $event_result->price;
			
			$year = date('Y', time());
			$now = date('d.m.Y', time());
			
			#membership ends one year (31536000 sec) from today 
			$membership_end = date('d.m.Y', time()+31536000);
			
			#get number of invoices from the current year
			$get_invoices = $this->db_connection->prepare('SELECT * FROM rechnungen WHERE date LIKE :year');
			$get_invoices->bindValue(':year', $year.'%', PDO::PARAM_INT);
			$get_invoices->execute();
			$num_of_invoices = $get_invoices->rowCount();
			
			#add one (this invoice) to the total
			$num_of_invoices = $num_of_invoices + 1;
			#add zeros on the left hand side to a fixed 4 digit number (e.g. 0001)
			$number = sprintf('%04d', $num_of_invoices);

			$invoice_number = $year.'-'.$number;
			
			$invoice_name = 'Rechnung_'.$invoice_number;
			$invoice_pdf = 'Rechnung_'.$invoice_number.'.pdf';
								
			#
			switch ($user_level) {
				case 2: $product_price = 75; $membership = 'Gast'; break;
				case 3: $product_price = 150; $membership = 'Teilnehmer'; break;
				case 4: $product_price = 300; $membership = 'Scholar'; break;
				case 5: $product_price = 600; $membership = 'Partner'; break;
				case 6: $product_price = 1200; $membership = 'Beirat'; break;
				case 7: $product_price = 2400; $membership = 'Gr&uuml;nder'; break;
				default: $product_price = 75; $membership = 'Gast'; break;
			}
			
			if ($product_type === 'seminar') {
      			$invoice_info[] = array('price' => $event_price, 'quantity' => $quantity, 'description' => 'Seminar: '.ucfirst($event_title));
	  			$invoice_info[] = array('price' => 0, 'quantity' => 1, 'description' => 'Einj&auml;hrige Mitgliedschaft - &quot;Teilnehmer&quot; ('.$now.' - '.$membership_end.')');
			}
			elseif ($product_type === 'projekt') {
	  			$invoice_info[] = array('price' => $product_price, 'quantity' => 1, 'description' => 'Projekt: '.ucfirst($event_title));
	  			$invoice_info[] = array('price' => 0, 'quantity' => 1, 'description' => 'Einj&auml;hrige Mitgliedschaft - &quot;'.$membership.'&quot; ('.$now.' - '.$membership_end.')');
			}
			else {
	  			$invoice_info[] = array('price' => $product_price, 'quantity' => 1, 'description' => 'Einj&auml;hrige Mitgliedschaft - &quot;'.$membership.'&quot; ('.$now.' - '.$membership_end.')');
			}
			
			$html = '
  					<html lang="de">
      				<head>
          				<title>Rechnung '.$invoice_number.'</title>        
          				<link rel="stylesheet" type="text/css" href="/home/content/56/6152056/html/production/style/invoice_style.css">
          
          				<meta name="Content-Disposition" content="attachment; filename='.$invoice_pdf.'">
          				<meta http-equiv="Content-Type" content="application/pdf; charset=UTF-8">
					</head>
      				<body>
          			<div class="invoice-info">
              			<div class="invoice-logo">
                  			<img src="/home/content/56/6152056/html/production/style/gfx/invoice_logo.png">
             			</div>
              			<div class="invoice-scholarium">
                  			Scholarium GmbH<br>
                  			Schl&ouml;sselgasse 19/2/18<br>
                  			1080 Wien<br>
                  			&Ouml;sterreich<br>
                  			<br>
                  			info@scholarium.at<br>
                  			www.scholarium.at
              			</div>
          			</div>
          			<div class="invoice-content">
              			<div class="invoice-address"> 
                  			<p>
                      			'.$user_name.' '.$user_surname.'<br>
                      			'.$user_street.'<br>
                      			'.$user_plz.' '.$user_city.'<br>
                      			'.$user_country.'<br>
                  			</p>
              			</div>
              
              			<div class="invoice-date">
                  			<p>Wien, '.$now.'</p>
              			</div>
              
              			<div class="invoice-title">
                  			<h1>RECHNUNG '.$invoice_number.'</h1>
              			</div>
              
              			<div class="invoice-detail">
                  			<table class="invoice-detail__table">
                      			<tr>
                          			<td class="invoice-detail__col1 invoice-detail__first-row">
                             			Menge
                          			</td>
                          			<td class="invoice-detail__col2 invoice-detail__first-row">
                              			Beschreibung
                          			</td>
                          			<td class="invoice-detail__col3 invoice-detail__first-row">
                              			Einzelpreis
                          			</td>
                          			<td class="invoice-detail__col4 invoice-detail__first-row">
                              			Gesamtpreis
                          			</td>
                      			</tr>';
					  	$i = 0;
					  	while ($i < count($invoice_info)) {					  	
                      	$price_total = $invoice_info[$i]['quantity']*$invoice_info[$i]['price'];
					  
					  	$html = $html.'
                      			<tr>
                         			<td class="invoice-detail__col1">
                             			'.$invoice_info[$i]['quantity'].'
                         			</td>
                         			<td class="invoice-detail__col2">
                             			'.$invoice_info[$i]['description'].'
                         			</td>
                         			<td class="invoice-detail__col3">
                             			&euro; '.$invoice_info[$i]['price'].',-
                         			</td>
                         			<td class="invoice-detail__col3">
                             			&euro; '.$price_total.',-
                         			</td> 
                      			</tr>';
                      $total = $total + $price_total;
                      $i++;
                      }
					  $html = $html.'
                      			<tr>
                          			<td class="invoice-detail__col1 invoice-detail__last-row">&nbsp;</td>
                          			<td class="invoice-detail__col2 invoice-detail__last-row">&nbsp;</td>
                          			<td class="invoice-detail__col3 invoice-detail__last-row">Gesamtbetrag</td>
                          			<td class="invoice-detail__col4 invoice-detail__last-row">&euro; '.$total.',-</td>
                      			</tr>
                  			</table>
              			</div>
              			
              			<div class="invoice-payment">';
              				if ($zahlung == 'bank'){
			 	  			$html = $html.'
                  						<p>Bitte überweisen Sie den Gesamtbetrag mit Angabe der Rechnungsnummer innerhalb von 14 Tagen auf unser folgendes Konto:<br>
                      					<br>
                						scholarium GmbH<br>
                						IBAN: AT27 2011 1827 1589 8503<br>
                						BIC: GIBAATWWXXX<br>
                  						</p>';
                  			}
			  				if ($zahlung == 'kredit'){
				  			$html = $html.'
				  						<p>Sie haben diese Rechnung bereits mit paypal beglichen.</p>';
				  			}   
			  				if ($zahlung == 'bar'){
				  			$html = $html.'
				  						<p>Bitte schicken Sie uns den gew&auml;hlten Betrag von '.$total.' &euro; in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an das scholarium, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.</p>';
				  			}
			  			$html = $html.'
              			</div>
              
              			<div class="invoice-ending">
                  			<p>Mit freundlichen Gr&uuml;&szlig;en</p>
                  			<p><i>Ihr Scholarium</i></p>
              			</div>
                            
          			</div>        
      			</body>
  				</html>';

			#render the invoice using dompdf
			require_once('/home/content/56/6152056/html/production//dompdf/dompdf_config.inc.php');

			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->set_paper('a4', 'portrait');
			$dompdf->render();

			#dompdf output is saved as a string
			$pdf = $dompdf->output();

			#save invoice on sever
			$invoice_location = '/home/content/56/6152056/html/production/rechnungen/'.$invoice_pdf;
			file_put_contents($invoice_location, $pdf);
			
			#put invoice into database
			$invoice_query = $this->db_connection->prepare('INSERT INTO rechnungen (user_id, nummer, date, zahlungsart, pdf) VALUES (:user_id, :nummer, NOW(), :zahlung, :pdf)');
			$invoice_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$invoice_query->bindValue(':nummer', $invoice_number, PDO::PARAM_STR);
			$invoice_query->bindValue(':zahlung', $zahlung, PDO::PARAM_STR);
			$invoice_query->bindValue(':pdf', $invoice_location, PDO::PARAM_STR);
			$invoice_query->execute();

			return $invoice_location;
		}

	public function createChat($n, $type) {
			
		$file = '../phpfreechat-1.7/chats/'.$type.'-'.$n.'.php';
		
		if (file_exists($file)) {
			
		}
		else {
			$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
		
			$chatid = $type.'-'.$n;
		
			$content = '<?php

						require_once "../../phpfreechat-1.7/src/phpfreechat.class.php";

						$params =  array("title"		  		=> "Diskussion",
				 						 "max_msg"		 		=> 400,
				 						 "max_text_len"	  		=> 2000,
				 						 "max_displayed_lines"	=> 1000,
				  						 "display_ping"   		=> true,
                 						 "clock"          		=> true,
                    					 "showsmileys"   		=> false,
                 						 "startwithsound" 		=> false,
                 						 "height"        		=> "200px",
                 						 "language"		 		=> "de_DE-formal",
                 						 "theme"		  		=> "scholarium",
                 						 "serverid"       		=> '.$chatid.',
				 						 "display_pfc_logo"		=> false,
				 						 "showwhosonline" 		=> true,
				 						 "admins"		  		=> array("scholarium" => "Werte333wirte"),
				 						 "channels"		  		=> array("Chat"),
				 						 "displaytabimage" 		=> false,
				 						 "btn_sh_smileys" 		=> false,
				 					 	 "nickmarker"	  		=> false,
				 					 	 "refresh_delay"		=> 6000,
				 					 	 "refresh_delay_steps" 	=> array(7000,20000,8000,60000,10000,120000,12000,240000),
				 					 	 "time_offset"			=> 32400,	 
                 					);

						$chat = new phpFreeChat($params);

						$chat->printJavascript();
						$chat->printStyle();

						$chat->printChat();
						?>';

			fwrite($handle, $content);
		}
		return $file;
	}
}

?>