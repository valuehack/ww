<?php

//insert code for invoice generation

  $now = date('d.m.Y', time());
  $year = date('Y', time());

  $invoice_number = $year.'-'.$number;

  $invoice_name = 'Rechnung_'.$invoice_number.'.pdf';

  $html = '
  <html lang="de">
                    <head>
                        <title>Rechnung 2016-0010</title>        
                        <link rel="stylesheet" type="text/css" href="../style/invoice_style.css">
          
                        <meta name="Content-Disposition" content="attachment; filename='.$invoice_pdf.'">
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
                                Ulrich M&ouml;ller<br>
                                Jenzschstraße 13<br>
                                99867 Gotha<br>
                                Deutschland<br>
                            </p>
                        </div>
              
                        <div class="invoice-date">
                            <p>Wien, 28.01.2016</p>
                        </div>
              
                        <div class="invoice-title">
                            <h1>RECHNUNG 2016-0010</h1>
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
                                </tr>
    
                                <tr>
                                    <td class="invoice-detail__col1">
                                        2
                                    </td>
                                    <td class="invoice-detail__col2">
                                        Seminar Wiener Schule der &Ouml;konik II
                                    </td>
                                    <td class="invoice-detail__col3">
                                        &euro; 150,-
                                    </td>
                                    <td class="invoice-detail__col3">
                                        &euro; 300,-
                                    </td> 
                                </tr>
                                
								<tr>
                                    <td class="invoice-detail__col1">
                                        1
                                    </td>
                                    <td class="invoice-detail__col2">
                                        Einj&auml;hrige Mitgliedschaft &quot;Teilnehmer&quot; - 28.01.2016 -27.01.2017
                                    </td>
                                    <td class="invoice-detail__col3">
                                        &euro; 0,-
                                    </td>
                                    <td class="invoice-detail__col3">
                                        &euro; 0,-
                                    </td> 
                                </tr>
       
                                <tr>
                                    <td class="invoice-detail__col1 invoice-detail__last-row">&nbsp;</td>
                                    <td class="invoice-detail__col2 invoice-detail__last-row">&nbsp;</td>
                                    <td class="invoice-detail__col3 invoice-detail__last-row">Gesamtbetrag</td>
                                    <td class="invoice-detail__col4 invoice-detail__last-row">&euro; 300 ,-</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="invoice-payment">

                                        <p>Bitte überweisen Sie den Gesamtbetrag mit Angabe der Rechnungsnummer innerhalb von 14 Tagen auf unser folgendes Konto:<br>
                                        <br>
                                        scholarium GmbH<br>
                                        IBAN: AT812011182715898501<br>
                                        BIC: GIBAATWWXXX<br>
                                        </p>';              
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
  $dompdf->stream($invoice_name);
?>