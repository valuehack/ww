<?php

	#Collection of general functions used within the page
	
class General {
	
	 /**
     * @var object $db_connection The database connection
     */
    public $db_connection = null;
	
	public function __construct() {
		
		$this->databaseConnection();
	}
	
	public function databaseConnection()
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
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                
                //$this->$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                
                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = '+2:00'");
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
				
					$date = $date." Uhr – ";
					$tag  = date("w",strtotime($end));
					$date = $date.$tage[$tag];
					$date = $date.strftime(" %d.%m.%Y %H:%M Uhr", strtotime($end));
				}
				else {
					$date = $date.strftime(" – %H:%M Uhr", strtotime($end));
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

	public function getTopic () {
		
		$topic_query = $this->db_connection->prepare('SELECT * FROM themen WHERE status = 1 order by amount desc');
		$topic_query->execute();
		
		$topic_result = $topic_query->fetchAll();
		
		return $topic_result;
		
	}
	
	public function getTopicComments () {
		
		$comments_query = $this->db_connection->prepare('SELECT themen_kommentare.*, mitgliederExt.Nachname, mitgliederExt.Vorname
														FROM themen_kommentare INNER JOIN mitgliederExt
														ON themen_kommentare.user_id = mitgliederExt.user_id
														WHERE themen_kommentare.status > 0
														ORDER BY themen_kommentare.comment_datetime ASC');
		$comments_query->execute();
		
		$comments_result = $comments_query->fetchAll();
		
		return $comments_result;
	}
	
	public function getIDLatestComment() {
		
		$latest_comment_query = $this->db_connection->prepare('SELECT id FROM themen_kommentare ORDER BY comment_datetime DESC LIMIT 1');
		$latest_comment_query->execute();
		
		$latest_comment_result = $latest_comment_query->fetch();
		$latest_id = $latest_comment_result[id];
		
		return $latest_id;
	}
	
	public function getIDLatestEditedComment() {
		
		$latest_edit_query = $this->db_connection->prepare('SELECT id FROM themen_kommentare ORDER BY edit_datetime DESC LIMIT 1');
		$latest_edit_query->execute();
		
		$latest_edit_result = $latest_edit_query->fetch();
		$latest_edited_id = $latest_edit_result[id];
		
		return $latest_edited_id;
	}
	
	public function getIDLatestDeletedComment() {
		
		$latest_delete_query = $this->db_connection->prepare('SELECT id FROM themen_kommentare ORDER BY delete_datetime DESC LIMIT 1');
		$latest_delete_query->execute();
		
		$latest_delete_result = $latest_delete_query->fetch();
		$latest_deleted_id = $latest_delete_result[id];
		
		return $latest_deleted_id;
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
		#$event_id has to be nummeric
		
		$reg_event_query = $this->db_connection->prepare('SELECT * FROM registration WHERE event_id = :event_id AND user_id = :user_id');
		$reg_event_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
		$reg_event_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$reg_event_query->execute();
		
		return $reg_event_query->fetchObject();
	}

	public function getLatestTopicReg ($user_id) {
		
		$reg_topic_query = $this->db_connection->prepare('SELECT title FROM themen 
														INNER JOIN themen_registration 
														ON themen_registration.topic_id = themen.n 
														WHERE themen_registration.user_id = :user_id 
														ORDER BY themen_registration.reg_datetime DESC LIMIT 1');
		$reg_topic_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$reg_topic_query->execute();
		
		return $reg_topic_query->fetchObject();
	}

	public function getStaticInfo($page) {
		
		$static_query = $this->db_connection->prepare('SELECT * FROM static_content WHERE page LIKE :page');
		$static_query->bindValue(':page', $page, PDO::PARAM_STR);
		$static_query->execute();
		
		return $static_query->fetchObject();
	}

	public function getMembershipInfo ($level) {
		
		# takes a level number (2,3,4,5,6,7) or price (75 ... 2400) in and returns the corresponding information (level, price, name)
		
		if ($level < 10) 
		{
			switch ($level) {
				case 2: $mb_info['level'] = 2; $mb_info['price'] = 75; $mb_info['name'] = 'Gast'; break;
				case 3: $mb_info['level'] = 3; $mb_info['price'] = 150; $mb_info['name'] = 'Teilnehmer'; break;
				case 4: $mb_info['level'] = 4; $mb_info['price'] = 300; $mb_info['name'] = 'Scholar'; break;
				case 5: $mb_info['level'] = 5; $mb_info['price'] = 600; $mb_info['name'] = 'Partner'; break;
				case 6: $mb_info['level'] = 6; $mb_info['price'] = 1200; $mb_info['name'] = 'Beirat'; break;
				case 7: $mb_info['level'] = 7; $mb_info['price'] = 2400; $mb_info['name'] = 'Patron'; break;
				default: $mb_info['level'] = 2; $mb_info['price'] = 75; $mb_info['name'] = 'Gast'; break;
			}
		}
		else 
		{
			switch ($level) {
				case 75: $mb_info['level'] = 2; $mb_info['price'] = 75; $mb_info['name'] = 'Gast'; break;
				case 150: $mb_info['level'] = 3; $mb_info['price'] = 150; $mb_info['name'] = 'Teilnehmer'; break;
				case 300: $mb_info['level'] = 4; $mb_info['price'] = 300; $mb_info['name'] = 'Scholar'; break;
				case 600: $mb_info['level'] = 5; $mb_info['price'] = 600; $mb_info['name'] = 'Partner'; break;
				case 1200: $mb_info['level'] = 6; $mb_info['price'] = 1200; $mb_info['name'] = 'Beirat'; break;
				case 2400: $mb_info['level'] = 7; $mb_info['price'] = 2400; $mb_info['name'] = 'Patron'; break;
				default: $mb_info['level'] = 2; $mb_info['price'] = 75; $mb_info['name'] = 'Gast'; break;
			}			
		}
		return $mb_info;
	}

	public function registerEvent ($user_id, $event_id, $quantity, $format='') {
	    			    				
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

	public function generateTicket ($profile, $product) {
		
			#automated ticket generation for events both for outsiders and insiders
						
			$now = date('d.m.Y', time());
			
			$ticket_name = 'Ticket_'.$profile['user_id'].'_'.$product['type'].'_'.$product['id'];
			$ticket_pdf = 'ticket_'.$profile['user_id'].'_'.ucfirst($product['type']).'_'.$product['id'].'.pdf';
			
			//$total = $event_price*$quantity;
			
			#prepare the ticket content with html and css
			$html = '
  					<html lang="de">
      				<head>
          				<title>'.$ticket_name.'</title>        
          				<link rel="stylesheet" type="text/css" href="/home/content/56/6152056/html/production/style/invoice_style.css">
          
          				<meta name="Content-Disposition" content="attachment; filename='.$ticket_pdf.'">
          				<meta http-equiv="Content-Type" content="application/pdf; charset=UTF-8">
      				</head>
      				<body>
						<div class="invoice-info">
            				<div class="invoice-logo">
                				<img src="../style/gfx/invoice_logo.png">
            				</div>
            				<div class="invoice-scholarium">
                				scholarium<br>
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
                      				'.$profile['user_first_name'].' '.$profile['user_surname'].'<br>
                      				'.$profile['user_street'].'<br>
                      				'.$profile['user_plz'].' '.$profile['user_city'].'<br>
                      				'.$profile['user_country'].'<br>
                				</p>
            				</div>              
            				<div class="invoice-date">
                				<p>Wien, '.$now.'</p>
            				</div>
            				<div class="invoice-title">
                				<h1>Ticket '.$product['title'].'</h1>
            				</div>
            				<div class="invoice-detail">
                				<table class="invoice-detail__table">
                    				<tr>
                        				<td class="invoice-detail__col2 invoice-detail__first-row">
                            				Beschreibung
                        				</td>
                        				<td class="invoice-detail__col1 invoice-detail__first-row">
                            				&nbsp;
                        				</td>
                        				<td class="invoice-detail__col3 invoice-detail__first-row">
                            				&nbsp;
                        				</td>
                        				<td class="invoice-detail__col4 invoice-detail__first-row">
                            				Menge
                      					</td>
                   					</tr>
									<tr>
                        				<td class="invoice-detail__col2">
                        					<span class="invoice-detail__type">'.ucfirst($product['type']).'</span>
                            				<h1 class="invoice-detail__title">'.$product['title'].'</h1>
                            				<span class="invoice-detail__date">'.$product['date'].'</span>
                        				</td>
                        				<td class="invoice-detail__col1">
                            				&nbsp;
                        				</td>
                        				<td class="invoice-detail__col3">
                            				&nbsp;
                        				</td>
                        				<td class="invoice-detail__col4">
                            				'.$product['quantity'].'
                        				</td> 
                   					</tr>
               						<tr>
                        				<td class="invoice-detail__col2 invoice-detail__last-row">&nbsp;</td>
                        				<td class="invoice-detail__col1 invoice-detail__last-row">&nbsp;</td>
                        				<td class="invoice-detail__col3 invoice-detail__last-row">&nbsp;</td>
                        				<td class="invoice-detail__col4 invoice-detail__last-row">&nbsp;</td>
                					</tr>
            					</table>
        					</div>
        					<div class="invoice-location">
        						<table class="h-full-width">
        							<tr>
                						<td class="invoice-location__info">  
                    						<h1>Veranstaltungsort</h1>
                    						<p>Schl&ouml;sselgasse 19/2/18<br>1080 Wien, &Ouml;sterreich</p>
                						</td>
                						<td class="invoice-location__map">
                       						&nbsp;
                						</td>
                					</tr>
                				</table>
            				</div>
            				<div class="invoice-ending">
                				<p>Mit freundlichen Gr&uuml;&szlig;en</p>
                				<p><i>Ihr scholarium</i></p>
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
	
	public function generateInvoice($profile, $product, $membership) {
		
			#automated invoice generation both for outsiders and insiders
						
			$now = date('d.m.Y', time());
			$year = date('Y', time());
			
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
											
			if ($product['type'] === 'seminar') {
      			$invoice_info[] = array('price' => $product['price'], 'quantity' => $product['quantity'], 'description' => 'Seminar: '.ucfirst($product['title']));
	  			$invoice_info[] = array('price' => 0, 'quantity' => 1, 'description' => 'Spende für ein Jahr - &quot;Teilnehmer&quot; ('.$membership['start'].' - '.$membership['end'].')');
			}
			elseif ($product['type'] === 'projekt') {
	  			$invoice_info[] = array('price' => $product['price'], 'quantity' => 1, 'description' => 'Projekt: '.ucfirst($product['title']));
	  			$invoice_info[] = array('price' => 0, 'quantity' => 1, 'description' => 'Spende für ein Jahr - &quot;'.$membership['name'].'&quot; ('.$membership['start'].' - '.$membership['end'].')');
			}
			else {
	  			$invoice_info[] = array('price' => $product['price'], 'quantity' => 1, 'description' => 'Spende für ein Jahr - &quot;'.$membership['name'].'&quot; ('.$membership['start'].' - '.$membership['end'].')');
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
                  			scholarium<br>
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
                      			'.$profile['user_first_name'].' '.$profile['user_surname'].'<br>
                      			'.$profile['user_street'].'<br>
                      			'.$profile['user_plz'].' '.$profile['user_city'].'<br>
                      			'.$profile['user_country'].'<br>
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
                      	//$price_total = $invoice_info[$i]['quantity']*$invoice_info[$i]['price'];
					  
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
                             			&euro; '.$product['total'].',-
                         			</td> 
                      			</tr>';
                      //$total = $total + $price_total;
                      $i++;
                      }
					  $html = $html.'
                      			<tr>
                          			<td class="invoice-detail__col1 invoice-detail__last-row">&nbsp;</td>
                          			<td class="invoice-detail__col2 invoice-detail__last-row">&nbsp;</td>
                          			<td class="invoice-detail__col3 invoice-detail__last-row">Gesamtbetrag</td>
                          			<td class="invoice-detail__col4 invoice-detail__last-row">&euro; '.$product['total'].',-</td>
                      			</tr>
                  			</table>
              			</div>
              			
              			<div class="invoice-payment">';
              				if ($profile['payment_option'] === 'sofort'){
			 	  			$html = $html.'
                  						<p>Wir haben den Spendenbetrag bereits dankend via SOFORT erhalten.</p>';
                  			}
			  				if ($profile['payment_option'] == 'paypal'){
				  			$html = $html.'
				  						<p>Wir haben den Spendenbetrag bereits dankend via PayPal erhalten.</p>';
				  			}   
			  			$html = $html.'
              			</div>
              
              			<div class="invoice-ending">
                  			<p>Mit freundlichen Gr&uuml;&szlig;en</p>
                  			<p><i>Ihr scholarium</i></p>
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

			#save invoice on server
			$invoice_location = '/home/content/56/6152056/html/production/rechnungen/'.$invoice_pdf;
			file_put_contents($invoice_location, $pdf);
			
			#put invoice into database
			$invoice_query = $this->db_connection->prepare('INSERT INTO rechnungen (user_id, nummer, date, zahlungsart, pdf) VALUES (:user_id, :nummer, NOW(), :zahlung, :pdf)');
			$invoice_query->bindValue(':user_id', $profile['user_id'], PDO::PARAM_INT);
			$invoice_query->bindValue(':nummer', $invoice_number, PDO::PARAM_STR);
			$invoice_query->bindValue(':zahlung', $profile['payment_option'], PDO::PARAM_STR);
			$invoice_query->bindValue(':pdf', $invoice_location, PDO::PARAM_STR);
			$invoice_query->execute();

			return $invoice_location;
		}

	public function createChat($n, $type) {
			
		$file = '../salon/chats/'.$type.'-'.$n.'.php';
		
		if (file_exists($file)) {
			
		}
		else {
			$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
		
			$chatid = $type.'-'.$n;
		
			$content = '<?php

						require_once "../phpfreechat/src/phpfreechat.class.php";

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

	public function replaceUmlaute($str) {
		# $str has to be a string
		
		# set search and replace arrays
		$umlaute = array('Ä','ä','Ö','ö','Ü','ü','ß');
		$replace = array('Ae','ae','Oe','oe','Ue','ue','ss');
		
		# replace umlaute and encode in utf-8
		$str_wo_uml = str_replace($umlaute, $replace, utf8_encode($str));
		
		# strip all that is not alphanumerical (just to be sure)
		$str_wo_uml = preg_replace('/[^a-z0-9_-]/isU', '', $str_wo_uml);
	
		return $str_wo_uml;

	} 
}

?>
