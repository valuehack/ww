<!--Author: Bernhard Hegyi -->
<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>

<?php 
include_once("../down_secure/functions.php");
dbconnect();

require_once('../classes/Login.php');
include('_header.php'); 
$title="Korb";
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

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Korb</a>
<div id="tabs-wrapper-lower"></div>

<h2>Korb</h2>

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
    $userCredits = $userCreditsArray[credits_left];

    $_SESSION['credits_left'] = $userCredits;

    mysql_query("SET time_zone = 'Europe/Vienna'");

    $itemsPrice = 0;
    foreach ($items as $code => $quantity) 
    {
        $length = strlen($code) - 1;

        $key = substr($code,-2,$length);
        $format = substr($code,-1,1);

        $items_price_query = "SELECT * from produkte WHERE `n` LIKE '$key'";
        $items_price_result = mysql_query($items_price_query) or die("Failed Query of " . $items_price_query. mysql_error());
        $itemsPriceArray = mysql_fetch_array($items_price_result);
        
        if ($format == 4 && $itemsPriceArray[price2]) {
            $itemsPriceSum = $quantity * $itemsPriceArray[price2];
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
        //$this->errors[] = "You do not have enough credits to buy the items in your basket.";
        //error message does not work, alternate message above
        echo "<div style='text-align:center'><hr><i>You do not have enough credits to buy the items in your basket.</i><hr><br></div>";
        ?>

        <?
        }

        else 
        {
        foreach ($items as $code => $quantity) 
                {    
                    $length = strlen($code) - 1;

                    $key = substr($code,-2,$length);
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
                
                }
        
        echo "Folgende Produkte haben Sie erworben. Bitte laden Sie die Dateien gleich auf Ihren PC herunter. Es wurde ein eMail an Sie verschickt. <br>";
        echo "<hr><table style='width:100%'><tr><td style='width:5%'><b>ID</b></td>";
        echo "<td style='width:55%'><b>Name</b></td>";
        echo "<td style='width:10%'><b>Quantity</b></td>";
        echo "<td style='width:10%'><b>Total</b></td>";
        echo "<td style='width:10%'>&nbsp;</td></tr>";

        foreach ($items as $code => $quantity) {
            $length = strlen($code) - 1;

            $key = substr($code,-2,$length);
            $format = substr($code,-1,1);

            $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
            $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
            $itemsExtraArray = mysql_fetch_array($items_extra_result);

            if ($format == 4 && $itemsExtraArray[price2]) {
                $sum = $quantity*$itemsExtraArray[price2];
            }
            else {
                $sum = $quantity*$itemsExtraArray[price];
            }
            //$download_link = downloadurl('http://test.wertewirtschaft.net/secdown/sec_files/'.$key.'.pdf\','.$key);

            echo "<tr><td>".$itemsExtraArray[n]."&nbsp</td>";
            echo "<td><i>".ucfirst($itemsExtraArray[type])."</i> ".$itemsExtraArray[title]." <i>";
            switch ($format) {
                case 1: echo "PDF"; break;
                case 2: echo "ePub"; break;
                case 3: echo "Kindle"; break;
                case 4: echo "Druck"; break;
                default: NULL; break;
            }
            echo "</i></td>";
            echo "<td>&nbsp; &nbsp;".$quantity."</td>";
            echo "<td><i>".$sum." Credits</i></td>";

            $id = $itemsExtraArray[id];
            $type = $itemsExtraArray[type];

            switch ($format) {
                case 0: if ($type == 'audio') $extension = '.mp3'; break;
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
           

                if (($type == 'scholien' || $type == 'analyse' || $type == 'buch' || $type == 'audio') && $format != 4) {

                ?>
                <td><a href="<?php downloadurl($file_path,$id);?>" onclick="updateReferer(this.href);">Download</a></td>
                </tr>

                <?php
                 }

                else {
                    echo "<td>Reserviert</td></tr>";
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
            // TO DO: Find better solution to display the relevant information for different product categories  
            if (!(is_null($itemsExtraArray[start]))) {
                echo "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]))."</td></tr>";
            }       
        }
        
        if ($versand >= 1) {
            echo "<tr><td></td><td>Versandkostenpauschale</td><td></td><td>5 Credits</td><td></td></tr>";
            $total += 5;
        }

        echo "<tr><td></td><td></td><td><b>TOTAL</b></td><td><b>".$total." Credits</b></td></tr>";

        echo "</table><hr>";


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

            $key = substr($code,-2,$length);
            $format = substr($code,-1,1);

            $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
            $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
            $itemsExtraArray = mysql_fetch_array($items_extra_result);

            if ($format == 4 && $itemsExtraArray[price2]) {
                $sum = $quantity*$itemsExtraArray[price2];
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
            $body = $body. "<td><i>".$sum." Credits</i></td></tr>";

            $total += $sum;

            if ($format == 4) {
                $versand += 1;
            }
 
            if (!(is_null($itemsExtraArray[start]))) {
                $body = $body. "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]))."</td></tr>";
            }       
        }
        
        if ($versand >= 1) {
            $body = $body. "<tr><td></td><td>Versandkostenpauschale</td><td></td><td>5 Credits</td></tr>";
            $total += 5;
        }

        $body = $body. "<tr><td></td><td><b>TOTAL</b></td><td><b>".$total." Credits</b></td></tr>";

        $body = $body. "</table><hr>";
        

        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);

    }
}


//Array with all the selected items, which are displayed in the basket:
if($_SESSION['basket']) { 
    $items = $_SESSION['basket'];

    /*echo "Items: ";
    print_r($items);
    echo "<br><br>";*/

    echo "You have the following items in your basket:";
    echo "<hr><table><tr><td style='width:5%'><b>ID</b></td>";
    echo "<td style='width:45%'><b>Name</b></td>";
    echo "<td style='width:10%'></td>";
    echo "<td style='width:10%'><b>Quantity</b></td>";
    echo "<td style='width:15%'><b>Price</b></td>";
    echo "<td><b>Sum</b></td></tr>";

    $total = 0;

    foreach ($items as $code => $quantity) {
        $length = strlen($code) - 1;

        $key = substr($code,-2,$length);
        $format = substr($code,-1,1);

        $items_extra_query = "SELECT * from produkte WHERE `n` LIKE '$key' ORDER BY start DESC";
        $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
        $itemsExtraArray = mysql_fetch_array($items_extra_result);
        
        if ($format == 4 && $itemsExtraArray[price2]) {
            $sum = $quantity*$itemsExtraArray[price2];
        }
        else {
            $sum = $quantity*$itemsExtraArray[price];
        }

        echo "<tr><td>".$itemsExtraArray[n]."&nbsp</td>";
        echo "<td><i>".ucfirst($itemsExtraArray[type])."</i> ".$itemsExtraArray[title]." <i>";
        switch ($format) {
            case 1: echo "PDF"; break;
            case 2: echo "ePub"; break;
            case 3: echo "Kindle"; break;
            case 4: echo "Druck"; break;
            default: NULL; break;
        }

        echo "</i></td>";
        ?>
        <td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="remove" value="<?php echo $code ?>" />
                <input type="submit" value="Remove" onClick="return checkMe()"></form></td>
        <?php
        echo "<td>&nbsp &nbsp".$quantity."</td><td><i>";
        
        if ($format == 4 && $itemsExtraArray[price2]) {
            echo $itemsExtraArray[price2];
        }
        else {
            echo $itemsExtraArray[price];
        }
        
        echo " Credits</i></td><td>".$sum." Credits</td></tr>";
       
       // TO DO: Find better solution to display the relevant information for different product categories  
       if (!(is_null($itemsExtraArray[start]))) {
            echo "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]));
            if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
        }
        
        $total += $sum;

        if ($format == 4) {
            $versand += 1;
        }

    }
    if ($versand >= 1) {
        echo "<tr><td></td><td>Versandkostenpauschale</td><td></td><td></td><td>5 Credits</td><td>5 Credits</td></tr>";
        $total += 5;
    }

    echo "<tr><td></td><td></td><td></td><td></td><td><b>TOTAL</b></td><td><b>".$total." Credits</b></td></tr>";
    echo "</table><hr>";  

?>

<!-- Clear Basket + Checkout Buttons-->

<table style="width:100%"><tr><td style="width:80%">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="submit" name="delete" value="Clear Basket" onClick="return checkMe()"></form></td>
    
<?php
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
        
        if ($format == 4 && $itemsPriceArray[price2]) {
            $itemsPriceSum = $quantity * $itemsPriceArray[price2];
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
        ?>
        <input type="button" value="Checkout" data-toggle="modal" data-target="#myModal"> 
    <?
    }
    else {
    ?>
        <td align="right">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" name="checkout" value="Checkout"></form></td>
    <?
    }
    ?>

</tr>
</table>

<?php
}

else {
    if(isset($_POST['checkout'])) {
        echo "";
    }
    else {
        echo "You have no items in your basket.<br><br>"; 
    }
    
}
?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ungenügendes Guthaben</h2>
      </div>
      <div class="modal-body">
        <p>Leider fehlen Ihnen ... Credits um die gew&uuml;nschten Produkte zu bestellen. Wir k&ouml;nnen die Bestellung ...</p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Reservieren und Upgraden</button></a>

      </div>
    </div>
  </div>
</div>

<!-- backlink -->
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>