<?php
	require_once('../config/config.php');
	include ('../views/_db.php');
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Cancel Event</title>
		
		<style>
		</style>
	</head>
	<body>
		<div style="padding:0 20%;">
			<h1>Veranstaltungen absagen</h1>		
<?php
	if($_POST['delete'] == 1){
		$event_id = $_POST['event_id'];
		$event_price = $_POST['price'];
		
		$email_subject = $_POST['mailsubject'];
		$email_body = $_POST['mailbody'];
		
		echo "Event ID:".$event_id;
		echo "Event Price:".$event_price;
		echo "email_subject:".$email_subject;
		echo "email_body:".$email_body;
						
		function sendCancelInformation($user_email, $email_subject, $email_body)
    	{
        //consturct email body
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
                        ';

        $body = $body.$email_body;


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');


        //create curl resource
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $user_email,
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => $email_subject,
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);

        if($response === '{"message":"success"}')
        {
            $that->messages[] = MESSAGE_STORNO_CONFIRMATION_MAIL_SUCCESSFULLY_SENT;

        }else 
        {
            $that->errors[] = MESSAGE_STORNO_CONFIRMATION_MAIL_FAILED; 
        }


        // //TODO - add here current
        // if(empty($response))
        // {
        //     die("Error: No response.");
        //     $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
        // }
        // elseif ('{"message":"success"}')
        // {
        //     $json = json_decode($response);
        //     // print_r($json->access_token);
        //     print_r(SENDGRID_API_KEY);
        //     // echo "<br>";
        //     $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
        //     file_put_contents('log.txt', $response);
        //     //$this->messages[] = $json;
        // }

        curl_close($ch);
    }
		
		$registered_users = $pdocon->db_connection->prepare("SELECT * FROM registration WHERE event_id=$event_id");
		$registered_users->execute();
		$registered_users_result = $registered_users->fetchAll();		
				
		print	$registered_users_result;
											
		for ($i = 0; $i < count($registered_users_result); $i++){
			$user_id = $registered_users_result[$i]['user_id'];
			$quantity = $registered_users_result[$i]['quantity'];
			
			$credits_add = $event_price*$quantity;
						
			$update_user_credit = $pdocon->db_connection->prepare("UPDATE mitgliederExt SET credits_left = credits_left + $credits_add WHERE user_id=$user_id");
			$update_user_credit->execute();
						
			$get_user_emails = $pdocon->db_connection->prepare("SELECT user_email FROM mitgliederExt WHERE user_id=$user_id");
		    $get_user_emails->execute();
		    $get_user_emails_result = $get_user_emails->fetchAll();
			
			$user_email = $get_user_emails_result[0]['user_email'];
			
			echo "User_Id:".$user_id;
			echo "Quantity:".$quantity;
			echo "Credits Add:".$credits_add;
			echo "User Email:".$user_email;
			
			sendCancelInformation($user_email, $email_subject, $email_body);
		}
		
		$update_produkte = $pdocon->db_connection->prepare("UPDATE produkte SET status = 0 WHERE n=$event_id");
		$update_produkte->execute();
					
	}
	
	if(isset($_GET['q'])){
		$event_id = $_GET['n'];
		$title = $_GET['title'];
		$price = $_GET['price'];
?>		
		<h2><?=$title?> absagen</h2>
		<form action="<?echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
			<input type="hidden" name="delete" value="1">
			<input type="hidden" name="event_id" value="<?=$event_id?>">
			<input type="hidden" name="price" value="<?=$price?>">
			<input style="width:100%;" type="text" name="mailsubject" value="Absage Veranstaltung: <?=$title?>" required><br>
			<textarea style="width:100%;" name="mailbody" placeholder=" E-Mail Text" rows='20' required></textarea><br>
			<input type="submit" value="Veranstaltung absagen" onClick="return checkMe()">
		</form>
<?php	
	}
	else {
		
	$sql = $pdocon->db_connection->prepare("SELECT * from produkte WHERE type='kurs' OR type='salon' OR type='seminar' AND status=1 AND start > NOW() order by n asc");
	$sql->execute();
    $result = $sql->fetchAll();
	
		echo "<ul>";
	
	for ($i = 0; $i < count($result); $i++){
		$n = $result[$i]['n'];
		$id = $result[$i]['id'];
		$title = $result[$i]['title'];
		$price = $result[$i]['price'];
?>
			<li><a href="event_cancel.php?q=<?=$id?>&n=<?=$n?>&title=<?=$title?>&price=<?=$price?>"<h2><?=$title?></h2></a>
			</li>
<?php						
	}
}
?>
		</ul>
		<a href="index.php">Zur&uuml;ck zum Admin Panel</a>
		</div>
	</body>
</html>

<script type="text/javascript">
function checkMe() {
    if (confirm("Bist du sicher?")) {
        return true;
    } else {
        return false;
    }
}
</script>