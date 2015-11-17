<?php

//code insert for ticket generation

    if ($start != NULL && $end != NULL)
		{
		$tag=date("w",strtotime($start));
		$tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
		$date = $tage[$tag]." ";
		$date = $date.strftime("%d.%m.%Y %H:%M", strtotime($start));
			if (strftime("%d.%m.%Y", strtotime($start))!=strftime("%d.%m.%Y", strtotime($end)))
					{
					$date = $date." Uhr &ndash; ";
					$tag=date("w",strtotime($end));
					$date = $date.$tage[$tag];
					$date = $date.strftime(" %d.%m.%Y %H:%M Uhr", strtotime($end));
					}
			else $date = $date.strftime(" &ndash; %H:%M Uhr", strtotime($end));
		}
	elseif ($start!= NULL)
		{
		$tag=date("w",strtotime($start));
		$date = $tage[$tag]." ";
		$date = $date. strftime("%d.%m.%Y %H:%M Uhr", strtotime($start));
		}
	else 
		$date = "Der Termin wird in K&uuml;rze bekannt gegeben.";

  $ticket_name = "ticket_".$user_id."_".$type."_".$key.".pdf";

  $html = '
  <html lang="de">
      <head>
          <title>Rechnung $invoice_number</title>        
          <link rel="stylesheet" type="text/css" href="../style/invoice_style.css">
          
          <meta name="Content-Disposition" content="attachment; filename='.$ticket_name.'">
          <meta http-equiv="Content-Type" content="application/pdf; charset=UTF-8" />

      </head>
      <body>
          <div class="invoice-info">
              <div class="invoice-logo">
                  <img src="../style/gfx/invoice_logo.svg">
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
                      $name $surename<br>
                      $street<br>
                      $plz $city<br>
                  </p>
              </div>
              
              <div class="invoice-date">
                  <p>Wien, $now</p>
              </div>
              
              <div class="invoice-title">
                  <h1>RECHNUNG $invoice_number</h1>
              </div>
              
              <div class="invoice-detail">
                  <table class="invoice-detail__table">
                      <tr>
                          <th class="invoice-detail__col1">
                             Menge
                          </th>
                          <th class="invoice-detail__col2">
                              Beschreibung
                          </th>
                          <th class="invoice-detail__col3">
                              Einzelpreis
                          </th>
                          <th class="invoice-detail__col4">
                              Gesamtpreis
                          </th>
                      </tr>
                      <tr>
                         <td class="invoice-detail__col1">
                             1
                         </td>
                         <td class="invoice-detail__col2">
                             F&ouml;rdermitgliedschaft II vom 01.01.2016 - 31.12.2016
                         </td>
                         <td class="invoice-detail__col3">
                             &euro; 300,-
                         </td>
                         <td class="invoice-detail__col3">
                             &euro; 300,-
                         </td> 
                      </tr>
                      <tr>
                          <td class="invoice-detail__col1 invoice-detail__last-row">&nbsp;</td>
                          <td class="invoice-detail__col2 invoice-detail__last-row">&nbsp;</td>
                          <td class="invoice-detail__col3 invoice-detail__last-row">Gesamtbetrag</td>
                          <td class="invoice-detail__col4 invoice-detail__last-row">&euro; 300,-</td>
                      </tr>
                  </table>
              </div>
              
              <div class="invoice-payment">
                  <p>Bitte überweisen Sie den Gesamtbetrag mit Angabe der Rechnungsnummer und Mitgliedernummer (Nr. $user_id) innerhalb von 14 Tagen auf unser folgendes Konto:<br>
                      <br>
                Institut für Wertewirtschaft<br>
                IBAN: AT332011128824799900<br>
                BIC: GIBAATWW<br>
                  </p>
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
  $dompdf->stream("invoice.pdf");

  // The next call will store the entire PDF as a string in $pdf
  //$pdf = $dompdf->output();

  // You can now write $pdf to disk, store it in a database or stream it
  // to the client.

  //file_put_contents("../rechnungen/invoice.pdf", $pdf);

?>