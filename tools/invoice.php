<?php

//insert code for invoice generation

  $now = date('d.m.Y', time());
  $year = date('Y', time());

  $invoice_number = $year.'-'.$number;

  $invoice_name = 'Rechnung_'.$invoice_number.'.pdf';

  $html = '
  <html lang="de">
      <head>
          <title>Rechnung '.$invoice_number.'</title>        
          <link rel="stylesheet" type="text/css" href="../style/invoice_style.css">
          
          <meta name="Content-Disposition" content="attachment; filename='.$invoice_name.'">
          <meta http-equiv="Content-Type" content="application/pdf; charset=UTF-8">

      </head>
      <body>
          <div class="invoice-info">
              <div class="invoice-logo">
                  <img src="../style/gfx/invoice_logo.png">
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
					  while ($i < count($invoice_info)){					  	
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
                IBAN: AT812011182715898501<br>
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

  require_once("../dompdf/dompdf_config.inc.php");

  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper("a4", 'portrait');
  $dompdf->render();
  //$dompdf->stream($invoice_name);

  // The next call will store the entire PDF as a string in $pdf
  $pdf = $dompdf->output();

  // You can now write $pdf to disk, store it in a database or stream it
  // to the client.

  file_put_contents('../rechnungen/'.$invoice_name.'.pdf', $pdf);

?>