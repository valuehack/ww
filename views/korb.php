<?php 
include_once("../down_secure/functions.php");
dbconnect();

require_once('../classes/Login.php');
$title="Korb";
include('_header_in.php'); 

?>

<script type="text/javascript">

function checkMe() {
    if (confirm("Are you sure?")) {
        return true;
    } else {
        return false;
    }
}

</script>
 
<div class="content">
	<div class="basket_header">
		<h1>Warenkorb</h1>
	</div>
	<div class="basket">
<?php 
//print_r($_SESSION);

//Check if basket was cleared
if(isset($_POST['delete'])) {
    unset($_SESSION['basket']);
}

//Check if a item was removed
if(isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    unset($_SESSION['basket'][$remove_id]);
}

//Check if checkout was made. If yes, show bought items.
if(isset($_POST['checkout'])) {
    
    $items = $_SESSION['basket'];
    //$login->checkout($items);   

    $user_id = $_SESSION['user_id'];
   
    $user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '$user_id' ";
    $user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

    $userCreditsArray = mysql_fetch_array($user_credits_result);
    
	$user_name = $userCreditsArray['Vorname'];
	$user_surname = $userCreditsArray['Nachname'];
	
    //check, if enough credits
    $userCredits = $userCreditsArray[credits_left];

    $_SESSION['credits_left'] = $userCredits;

    mysql_query("SET time_zone = 'Europe/Vienna'");

    $itemsPrice = 0;
    foreach ($items as $code => $quantity) 
    {				
        $length = strlen($code) - 1;

        $key = substr($code,0,$length);
        $format = substr($code,-1,1);

        $items_price_query = "SELECT * from produkte WHERE `n` LIKE '$key'";
        $items_price_result = mysql_query($items_price_query) or die("Failed Query of " . $items_price_query. mysql_error());
        $itemsPriceArray = mysql_fetch_array($items_price_result);
        
        if ($format == 4 && $itemsPriceArray[price_book]) {
            $itemsPriceSum = $quantity * $itemsPriceArray[price_book];
        }
        else {
            $itemsPriceSum = $quantity * $itemsPriceArray[price];
        }

        $itemsPrice += $itemsPriceSum;

        if ($format == 4) {
            $versand += 1;
        }
    }
    if ($versand >= 1) $itemsPrice += 5;

    if (!($userCredits >= $itemsPrice)) {
        $error = 1;
    }

    //check, if membership still valid
    $zahlung = date_create($userCreditsArray[Zahlung]);
    $heute = date_create(date("Y-m-d"));

    $differenz = date_diff($zahlung,$heute);
    //echo $differenz->format("%a");
    if ($differenz->format("%a") > 365) {
        $error = 2;
    }


    if ($error == 1) {
        //$this->errors[] = "You do not have enough credits to buy the items in your basket.";
        //error message does not work, alternate message above
        echo '<div class="basket_error"><p>Ihre Bestellung &uuml;bersteigt Ihr derzeit noch freies Guthaben. Wir freuen uns sehr &uuml;ber Ihr Interesse. Um die Bestellung abzuschlie&szlig;en, f&uuml;llen Sie bitte Ihr Guthaben auf. Bitte w&auml;hlen Sie dazu eine der m&ouml;glichen Unterst&uuml;tzungsstufen &ndash; Sie k&ouml;nnen Ihr Guthaben im jeweiligen Ausma&szlig; erneut auff&uuml;llen. Sie k&ouml;nnen auch wieder denselben Betrag w&auml;hlen, so bleibt Ihr Guthaben wieder ein volles Jahr von nun an aktiv. Das bedeutet, Sie ziehen Ihre Guthabenauff&uuml;llung, die sonst nach Ablauf eines Jahres und erneuter Unterst&uuml;tzung erfolgen w&uuml;rde, einfach vor, um dieses Guthaben schon jetzt zu nutzen. Oder Sie nutzen die Gelegenheit, uns auf einer h&ouml;heren Stufe zu unterst&uuml;tzen und so innerhalb eines Jahres &uuml;ber noch mehr Guthaben verf&uuml;gen zu k&ouml;nnen. Es ehrt uns sehr, dass Sie unser Angebot in gr&ouml;&szlig;erem Ma&szlig;e nutzen wollen! Vielen Dank f&uuml;r Ihr Vertrauen. <a href="../abo/">Zur Aboseite</a></p></div>';
    }


    elseif ($error == 2) {
        echo '<div class="basket_error"><p>Text f&uuml;r Warenkorb-Checkout nach Ablauf Mitgliedschaft. <a href="../abo/">Zur Aboseite</a></p></div>';
    }

    else 
    	{
        foreach ($items as $code => $$quantity) 
                {					    
                    $length = strlen($code) - 1;

                    $key = substr($code,0,$length);
                    $format = substr($code,-1,1);
                    switch ($format) {
                        case 1: $format = "PDF"; break;
                        case 2: $format = "ePub"; break;
                        case 3: $format = "Kindle"; break;
                        case 4: $format = "Druck"; break;
                        default: $format = NULL; break;
                    }

                    $checkout_query = "INSERT INTO registration (event_id, user_id, quantity, format, reg_datetime) VALUES ('$key', '$user_id', '$quantity', '$format', NOW())";
                    mysql_query($checkout_query);

                    $credits_left = $userCredits - $itemsPrice;

                    $left_credits_query = "UPDATE mitgliederExt SET credits_left='$credits_left' WHERE `user_id` LIKE '$user_id'";
                    mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

                    $space_query = "UPDATE produkte SET spots_sold = spots_sold + '$quantity' WHERE `n` LIKE '$key'";
                    mysql_query($space_query);
					
					$last_donation_query = "UPDATE produkte SET last_donation = NOW() WHERE `n` LIKE '$key'";
					mysql_query($last_donation_query);
                
					//Ticket Generation
				
					$items_ticket_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
            		$items_ticket_result = mysql_query($items_ticket_query) or die("Failed Query of " . $items_ticket_query. mysql_error());
            		$itemsTicketArray = mysql_fetch_array($items_ticket_result);
					
						$title = $itemsTicketArray[title];
						$start = $itemsTicketArray[start];
						$end = $itemsTicketArray[end];
						$type = $itemsTicketArray[type];
						$price = $itemsTicketArray[price];
														
					if ($type == 'kurs' || $type == 'seminar' || $type == 'lehrgang' || $type == 'salon') {
						
						$quantity = $quantity;
						
						$user_id = $user_id;
						$user_name = $user_name;
						$user_surname = $user_surname;
						
						include ('../tools/ticket.php');
					}
				
                }
        		
        echo "<div class='basket_success'><p>Bestellung erfolgreich. Hier sehen Sie nochmals eine Zusammenfassung Ihrer Bestellung.<br> Diese wurde Ihnen auch als eMail zugesandt.</p></div>";
		echo "<div class='basket_summary'>";
        echo "<table><tr>";
		echo "<td style='width:10%'>&nbsp;</td>";
        echo "<td style='width:50%'><b>Name</b></td>";
        echo "<td style='width:10%'><b>Menge</b></td>";
        echo "<td style='width:15%'><b>Preis</b></td>";
        echo "<td style='width:15%'>&nbsp;</td></tr>";

        foreach ($items as $code => $quantity) {
			
            $length = strlen($code) - 1;

            $key = substr($code,0,$length);
            $format = substr($code,-1,1);

            $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
            $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
            $itemsExtraArray = mysql_fetch_array($items_extra_result);

            if ($format == 4 && $itemsExtraArray[price_book]) {
                $sum = $quantity*$itemsExtraArray[price_book];
            }
            else {
                $sum = $quantity*$itemsExtraArray[price];
            }
            //$download_link = downloadurl('http://test.wertewirtschaft.net/secdown/sec_files/'.$key.'.pdf\','.$key);

            echo "<td>".ucfirst($itemsExtraArray[type])."</td>";
            echo "<td>".$itemsExtraArray[title]."<br><i>";
            switch ($format) {
                case 1: echo "pdf"; break;
                case 2: echo "ePub"; break;
                case 3: echo "kindle"; break;
                case 4: echo "druck"; break;
                default: NULL; break;
            }
            echo "</i><br>";
            // TO DO: Find better solution to display the relevant information for different product categories  
            if (!(is_null($itemsExtraArray[start]))) {
                echo date("d.m.Y",strtotime($itemsExtraArray[start]))."</td>";
            }       
            echo "<td>&nbsp; &nbsp;";
            if ($itemsExtraArray[type] == 'projekt') {
                            echo '1';
                        }
                        else {
                            echo $quantity;
                        }
            echo "</td>";
            echo "<td><i>".$sum." Credits</i></td>";

            $id = $itemsExtraArray[id];
            $type = $itemsExtraArray[type];

            switch ($format) {
                case 0: if ($type == 'audio') $extension = '.mp3';
                        if ($type == 'paket') $extension = '.zip';
                        break;
                case 1: $extension = '.pdf'; break;
                case 2: $extension = '.epub'; break;
                case 3: $extension = '.mobi'; break;
                default: NULL; break;
            }

            $total += $sum;

            if ($format == 4) {
                $versand += 1;
            }


                //$file_path = 'http://test.wertewirtschaft.net/secdown/sec_files/1057.pdf'.$key;
                $file_path = 'http://test.wertewirtschaft.net/down_secure/content_secure/'.$id.$extension;
                //$download_link = downloadurl($file_path , $key);
                //echo $file_path;
                //echo '<td><a href="'.$download$file_path = 'http://test.wertewirtschaft.net/secdown/sec_files/'.$key.'/.pdf';_link.'" onclick="updateReferer(this.href);">03/14 Universit&auml;t (Test secureDownload)</a>';
           

                if (($type == 'scholie' || $type == 'analyse' || $type == 'buch' || $type == 'paket' || $type == 'audio') && $format != 4) {

                ?>
                <td><a href="<?php downloadurl($file_path,$id);?>" onclick="updateReferer(this.href);">Download</a></td>
                </tr>

                <?php
                 }
                elseif ($type == 'salon' || $type == 'lehrgang' || $type == 'seminar' || $type == 'kurs') {
                    echo '<td>Reserviert</td></tr>';
                }
                elseif ($format == 4) {
                    echo '<td>wird zugesandt</td></tr>';
                }

                else {
                    echo "";
                }

            //echo '</td></tr>';

            /*
            $file = '/secdown/sec_files/'.$key.'.jpg';
            if (file_exists($file)) {
                echo '<td><a href="'.$file.'" download>Download</a></td></tr>';
            } 
            else {
                //generated ticket should come here
                echo '<td><a href="">Download</a></td></tr>';

            }
            */
            ?>
           
           <?php    
        }
        
        if ($versand >= 1) {
            echo "<tr><td></td><td>Versandkostenpauschale</td><td></td><td>5 Credits</td><td></td></tr>";
            $total += 5;
        }
		echo "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
        echo "<tr><td></td><td></td><td><b>Summe</b></td><td><b>".$total." Credits</b></td></tr>";

        echo "</table>";
		echo "</div>";
?>
			<div class="centered"><p class="linie"><img src="../style/gfx/linie.png" alt=""></p></div>
		</div>
	</div>
<?php include('_footer.php'); 

        //delete bought items from session variable
        unset($_SESSION['basket']);


        //send email

        $mail = new PHPMailer;

        $user_email = $_SESSION['user_email'];

         if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_PASSWORDRESET_FROM;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = 'Produktbestellung';
 
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://www.wertewirtschaft.org/tools/Erinnerung-Header-01.png" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                    <br> Sie haben folgende Produkte gekauft';           
      

        $body = $body. "<hr><table style='width:100%'><tr><td style='width:5%'><b>ID</b></td>
                        <td style='width:55%'><b>Name</b></td>
                        <td style='width:10%'><b>Quantity</b></td>
                        <td style='width:10%'><b>Total</b></td></tr>";

       
        foreach ($items as $code => $quantity) {
		
            $length = strlen($code) - 1;

            $key = substr($code,0,$length);
            $format = substr($code,-1,1);

            $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
            $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
            $itemsExtraArray = mysql_fetch_array($items_extra_result);

            if ($format == 4 && $itemsExtraArray[price_book]) {
                $sum = $quantity*$itemsExtraArray[price_book];
            }
            else {
                $sum = $quantity*$itemsExtraArray[price];
            }

            $body = $body. "<tr><td>".$itemsExtraArray[n]."&nbsp</td>";
            $body = $body. "<td><i>".ucfirst($itemsExtraArray[type])."</i> ".$itemsExtraArray[title]." <i>";
            switch ($format) {
                case 1: $body = $body. "PDF"; break;
                case 2: $body = $body. "ePub"; break;
                case 3: $body = $body. "Kindle"; break;
                case 4: $body = $body. "Druck"; break;
                default: NULL; break;
            }
            $body = $body. "</i></td>";
            $body = $body. "<td>&nbsp; &nbsp;".$quantity."</td>";
            if ($itemsExtraArray[type] == 'projekt') {
                            $body = $body. "<td>&nbsp; &nbsp; 1</td>";
                        }
                        else {
                            $body = $body. "<td>&nbsp; &nbsp;".$quantity."</td>";
                        }
            $body = $body. "<td><i>".$sum." Credits</i></td></tr>";

            $total2 += $sum;

            if ($format == 4) {
                $versand += 1;
            }
 
            if (!(is_null($itemsExtraArray[start]))) {
                $body = $body. "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]))."</td></tr>";
            }       
        }
        
        if ($versand >= 1) {
            $body = $body. "<tr><td></td><td>Versandkostenpauschale</td><td></td><td>5 Credits</td></tr>";
            $total2 += 5;
        }

        $body = $body. "<tr><td></td><td></td><td><b>TOTAL</b></td><td><b>".$total2." Credits</b></td></tr>";

        $body = $body. "</table><hr>";
        

        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);

        if(!$mail->Send()) {
            // here come error message when not sent.
            return false;
        } else {
            // email successfully sent
            return true;
        }

    }
}


//Array with all the selected items, which are displayed in the basket:
if($_SESSION['basket']) { 
    $items = $_SESSION['basket'];

    /*echo "Items: ";
    print_r($items);
    echo "<br><br>";*/
?>
		<div class="basket_head">
			<div class="basket_head_col_a"></div>
			<div class="basket_head_col_b">Menge</div>
			<div class="basket_head_col_c">Preis</div>
		</div>
<?php

    $total = 0;

    foreach ($items as $code => $quantity) {
    	
        $length = strlen($code) - 1;

        $key = substr($code,0,$length);
        $format = substr($code,-1,1);

        $url = "";
        $url2= "";

        $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
        $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
        $itemsExtraArray = mysql_fetch_array($items_extra_result);
        
        $type = $itemsExtraArray[type];
        $id = $itemsExtraArray[id];

        if ($format == 4 && $itemsExtraArray[price_book]) {
            $sum = $quantity*$itemsExtraArray[price_book];
        }
        else {
            $sum = $quantity*$itemsExtraArray[price];
        }
        
		if ($type == 'buch' || $type == 'analyse' || $type == 'scholie') {
			$url = 'http://scholarium.at/schriften/'.$id.'.jpg';
            $url2 = 'schriften';
			}
		elseif ($type == 'lehrgang' || $type == 'seminar' || $type == 'kurs') {
			$url = 'http://scholarium.at/kurse/'.$id.'.jpg';
            $url2 = 'kurse';
			}
		elseif ($type == 'salon') {
			$url = 'http://scholarium.at/salon/'.$id.'.jpg';
            $url2 = 'salon';
			}
        elseif ($type == 'paket' || $type == 'audio' || $type == 'video') {
            $url = 'http://scholarium.at/medien/'.$id.'.jpg';
            $url2 = 'medien';
            }
?>        
		<div class="basket_body">
			<div class="basket_body_col_a">
				<div class="basket_body_col_a_1">
					<img src="<?echo $url;?>" alt="">
				</div>		
				<div class="basket_body_col_a_2">		
<?php			
		echo "<span class='basket_body_type'>".ucfirst($itemsExtraArray[type])."</span>";
		echo "<span class='basket_body_title'>";
		echo "<a href='../".$url2."/index.php?q=".$id."'>".$itemsExtraArray[title]."</a></span>";
		echo "<span class='basket_body_format'>";
        switch ($format) {
            case 1: echo "pdf"; break;
            case 2: echo "ePub"; break;
            case 3: echo "kindle"; break;
            case 4: echo "druck"; break;
            default: NULL; break;
        }
		echo "</span>";

       if (!(is_null($itemsExtraArray[start]))) {
            echo "<span class='basket_body_date'>".date("d.m.Y",strtotime($itemsExtraArray[start]));
            if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
			echo "</span>";
        }
		
        ?>
        		<form class="basket_body_remove" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                	<input type="hidden" name="remove" value="<?php echo $code ?>" />
                    <? if ($itemsExtraArray[type] == 'projekt') {echo '<input type="hidden" name="projekt" value="1" />';} ?>
                	<input class="basket_body_remove_button" type="submit" value="Entfernen" onClick="return checkMe()">
            	</form>
        	</div>
        	</div>	
			<div class="basket_body_col_b">
				<span class='basket_coin'><img src="../style/gfx/coin.png"></span>
                <span>
					<?php
	        			if ($format == 4 && $itemsExtraArray[price_book]) {
            				echo $itemsExtraArray[price_book];
        				}
                        elseif ($itemsExtraArray[type] == 'projekt') {
                            echo $quantity;
                        }
       					else {
           		 			echo $itemsExtraArray[price];
        				}
					?>				
				</span>
			</div>
			<div class="basket_body_col_c">
				<span>
                    <? if ($itemsExtraArray[type] == 'projekt') {
                            echo '1';
                        }
                        else {
                            echo $quantity;
                        } ?>
                </span>
			</div>
		</div>
	<?php
		$total += $sum;
		
		if ($format == 4) {
            $versand += 1;
        }
		
    }
		if ($versand >= 1) { 
	?>
		<div class="basket_shipping">
			<div class="basket_shipping_col_a">Versandkostenpauschale</div>
			<div class="basket_shipping_col_c">&nbsp;</div>
            <div class="basket_shipping_col_b"><span class='basket_coin'><img src="../style/gfx/coin.png"></span><span>5</span></div>
		</div>
	<?php
		$total += 5;
		}
	?>
		<div class="basket_footer">
			<div class="basket_footer_col_a">Summe:</div>
			<div class="basket_footer_col_c">&nbsp;</div>		
			<span class='basket_coin_total'><img src="../style/gfx/coin.png"></span>
            <div class="basket_footer_col_b"><?echo $total;?></div>	
		</div>	
		<div class="basket_pay">
		    <!-- possibility 1 -->
    		<form class="basket_pay_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        		<input class="basket_pay_button_check" type="submit" name="checkout" value="Jetzt bestellen">
        	</form>   		 
			<!-- Clear Basket + Checkout Buttons-->	
			<form class="basket_pay_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    			<input class="basket_pay_button_clear" type="submit" name="delete" value="Warenkorb leeren" onClick="return checkMe()">
    		</form>
    	</div>

<?php
/* possibility 2
//check, if there are enough credits
    $items = $_SESSION['basket']; 
    $user_id = $_SESSION['user_id'];
   
    $user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '$user_id' ";
    $user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

    $userCreditsArray = mysql_fetch_array($user_credits_result);
    $userCredits = $userCreditsArray[credits_left];

    $_SESSION['credits_left'] = $userCredits;

    $itemsPrice = 0;
    foreach ($items as $code => $quantity) 
    {
        $length = strlen($code) - 1;

        $key = substr($code,-2,$length);
        $format = substr($code,-1,1);

        $items_price_query = "SELECT * from produkte WHERE `n` LIKE '$key'";
        $items_price_result = mysql_query($items_price_query) or die("Failed Query of " . $items_price_query. mysql_error());
        $itemsPriceArray = mysql_fetch_array($items_price_result);
        
        if ($format == 4 && $itemsPriceArray[price_book]) {
            $itemsPriceSum = $quantity * $itemsPriceArray[price_book];
        }
        else {
            $itemsPriceSum = $quantity * $itemsPriceArray[price];
        }

        $itemsPrice += $itemsPriceSum;

        if ($format == 4) {
            $versand += 1;
        }
    }
    if ($versand >= 1) $itemsPrice += 5;

    if (!($userCredits >= $itemsPrice)) {
        $differenz = $itemsPrice - $userCredits;
        ?>
        <!-- possibility 2a
        <td align="right">
        <input type="button" value="Checkout" data-toggle="modal" data-target="#myModal"> 
        </td>
        -->

        <!-- possibility 2b -->
        <td align="right">
        <a href="index.php"><input type="button" name="checkout" value="Checkout"></a></td>  
    <?
    }
    else {
    ?>  
        <td align="right">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" name="checkout" value="Checkout"></form></td>
    <?
    }
    
    
*/
    ?>

<?php
}

else {
    if(isset($_POST['checkout'])) {
        echo "";
    }
    else {
        echo "<div class='basket_no_items'><p>Keine Waren im Warenkorb.</p></div>"; 
    }
    
}
?>

<!-- Modal - zurzeit nicht verwendet
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ungenügendes Guthaben</h2>
      </div>
      <div class="modal-body">
        <p>Vielen Dank f&uuml;r Ihre Bestellung/Reservierung! F&uuml;r den Zugriff/die Teilnahme laden Sie bitte noch Ihr Guthaben auf &ndash; nach Zahlungseingang reservieren wir dann sofort die Pl&auml;tze bzw. Medien f&uuml;r Sie. W&auml;hlen Sie dazu bitte wieder die gew&uuml;nschte Stufe. Vielleicht ist das der richtige Augenblick, sich als Wertewirt zu bekennen und unser Angebot voll nutzen zu k&ouml;nnen?</p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Upgraden</button></a>

      </div>
    </div>
  </div>
</div>
-->

<!-- backlink
		<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>-->
		</div>
	</div>
<?php include('_footer.php'); ?>