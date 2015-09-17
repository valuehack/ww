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

  $html = '
  <html lang="de">
      <head>
          <title>Ticket</title>        
          <link rel="stylesheet" type="text/css" href="../style/ticket_style.css">
      </head>
      <body>
          <div class="ticket_content">
              <div>
                  <img src="../style/gfx/ticket_logo.png" style="width:300px;margin-bottom:50px;">
              </div>
              <div class="ticket_event">
                  <p><i>'.$type.'</i></p>
                  <h1>'.$title2.'</h1>
                  <p>
                      <span class="ticket_date">'.$date.'</span>
                      
                      <span class="ticket_object">Anzahl</span> <span class="ticket_value">'.$quantity.'</span><br>
                      
                      <span class="ticket_object">Preis</span> <span class="ticket_value">'.$price.' &euro;</span>
                        
                  </p>   
              </div>
              <div class="ticket_user">
                  <p>
                      <span class="ticket_user_name">'.$user_name.' '.$user_surname.'</span> <span class="ticket_user_no">Kundennummer: '.$user_id.'</span> 
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

  require_once("../dompdf/dompdf_config.inc.php");

  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper("a4", 'portrait');
  $dompdf->render();
  //$dompdf->stream("ticket_".$user_id."_".$start.".pdf");

  // The next call will store the entire PDF as a string in $pdf
  $pdf = $dompdf->output();

  // You can now write $pdf to disk, store it in a database or stream it
  // to the client.

  file_put_contents("../tickets/ticket_".$user_id."_".$type."_".$key.".pdf", $pdf);

  $ticket_name = "ticket_".$user_id."_".$type."_".$key.".pdf";
  $ticket_location = "../tickets/".$ticket_name;
  $tickets_array[$ticket_name] = $ticket_location;

?>