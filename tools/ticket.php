<?php
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

		echo $date;
		echo $title;
		echo $type;
		echo $price;
		echo $quantity;
		echo $user_name;
		echo $user_surname;
		echo $user_id;

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
                <h1>'.$title.'</h1>
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
            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095&amp;output=embed"></iframe>
            <br><small>
                <a href="https://maps.google.de/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095">
                </a>
            </iframe>
        </div>
            </div>
        </div>        
    </body>
</html>';

$file = fopen("temp_ticket.html","w+");
		fwrite($file, $html);
        fclose($file);

echo $html;

require_once("../dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html('temp_ticket.html');
$dompdf->set_paper("a4", 'portrait');
$dompdf->render();
$dompdf->stream("ticket_".$user_id."_".$start.".pdf");
?>