<?php
#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "reminder_error.log");
ini_set("display_errors" , "0");

date_default_timezone_set('Europe/Vienna');

require('../config/config.php');
require('../classes/General.php');
require('../classes/Email.php');

$general = new General();
$email = new Email();

$get_events = $general->db_connection->prepare(
    'SELECT *
	   FROM produkte 
	  WHERE type = :seminar 
	    AND type = :salon 
	    AND status = :status 
	    AND start > NOW()'
	);
$get_events->bindValue(':seminar', 'seminar', PDO::PARAM_STR);
$get_events->bindValue(':salon', 'salon', PDO::PARAM_STR);
$get_events->bindValue(':status', 1, PDO::PARAM_INT);
$get_events->execute();
$events = $get_events->fetchAll();

if ($get_events->rowCount() > 0) {
    $events_exist = 1;
	for ($j = 1; $j < count($events); $j++) {
        $events[$j]['date'] = $general->getDate($events[$j]['start'],$events[$j]['end']);
	}
} else {
    $events_exist = 0;
} 

$get_scholien = $general->db_connection->prepare(
    'SELECT *
	   FROM blog
	  WHERE publ_date >= DATE_SUB(CURDATE(), INTERVAL 45 DAY)
   ORDER BY publ_date DESC'
   );
$get_scholien->execute();
$scholien = $get_scholien->fetchAll();

if ($get_scholien->rowCount() > 0) $scholien_exist = 1;
else $scholien_exist = 0;

$get_user_info = $general->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_email = "moeller.ulrich@gmx.de"');
$get_user_info->execute();
$user_info = $get_user_info->fetchAll();

# Check every user and do the specified cron jobs
for ($i = 0; $i < count($user_info); $i++) {

    $profile = $user_info[$i];

    $now = new DateTime();
    $login_date = DateTime::createFromFormat('Y-m-d H:i:s', $profile['last_login_time']);
	$reg_date = DateTime::createFromFormat('Y-m-d H:i:s', $profile['user_registration_datetime']);
	$expiry_date = DateTime::createFromFormat('Y-m-d', $profile['Ablauf']);

	/*echo 'Datum mit DateTime Class: '.$date->format('d-m-Y');
	$date->add(new DateInterval('P180D'));
	echo 'Datum mit DateTime Class + 6 Monate: '.$date->format('d-m-Y');
	$now->sub(new DateInterval('P1M'));
	echo 'Datum mit DateTime Class - 1 Monate: '.$now->format('d-m-Y');/*

	# NOT LOGGED IN REMINDER 6 MONTHS
    /*if ($login_date < $now->sub(new DateInterval('P180D')) && $profile['reminded'] != 6) {
		    
        #EMAIL SEND BLOCK
        ####################################################################
        #user email
        #email template must exist in templates/email folder
        $email_template = 'reminder_six_months.email.twig';

        $post_data = array(
            'to'       => $profile['user_email'],
            'bcc'      => 'um@scholarium.at',
            'subject'  => 'Wir vermissen Sie',
            'from'     => 'info@scholarium.at',
            'fromname' => 'Scholarium'
        );
			
        $body_data = array(
            'profile'        => $profile,
            'events'         => $events,
            'events_exist'   => $events_exist,
	        'scholien_exist' => $scholien_exist
        );
        
        echo 'E-Mail wird an '.$profile['user_email'].' gesendet';
			
        if (!$email->sendThisEmail($email_template, $post_data, $body_data)) {
            error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        } else {
            $set_notice = $general->db_connection->prepare('UPDATE mitgliederExt SET reminded = :notice WHERE user_id = :user_id');
            $set_notice->bindValue(':notice', 6, PDO::PARAM_INT);
            $set_notice->bindValue(':user_id', $profile['user_id'], PDO::PARAM_STR);
            $set_notice->execute();
        }
        ####################################################################
    }
	*/
	
    # NOT LOGGED IN REMINDER (1 Month)
    if ($login_date < $now->sub(new DateInterval('P1M'))  && $profile['reminded'] !=1 && ($scholien_exist === 1 || $events_exist === 1)) {
    	
        #EMAIL SEND BLOCK
        ####################################################################
        #user email
        #email template must exist in templates/email folder
        $email_template = 'reminder_one_month.email.twig';

        $post_data = array(
            'to'       => $profile['user_email'],
            'bcc'      => 'um@scholarium.at',
            'subject'  => 'Neue Inhalte',
            'from'     => 'info@scholarium.at',
            'fromname' => 'Scholarium'
        );
			
        $body_data = array(
            'profile'        => $profile,
            'events'         => $events,
            'events_exist'   => $event_exist,
            'scholien'	     => $scholien,
            'scholien_exist' => $scholien_exist
        );
        
        echo 'E-Mail wird an '.$profile['user_email'].' gesendet';
			
        if (!$email->sendThisEmail($email_template, $post_data, $body_data)) {
            error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        } else {
            $set_notice = $general->db_connection->prepare('UPDATE mitgliederExt SET reminded = :notice WHERE user_id = :user_id');
            $set_notice->bindValue(':notice', 1, PDO::PARAM_INT);
            $set_notice->bindValue(':user_id', $profile['user_id'], PDO::PARAM_STR);
            $set_notice->execute();
        }
        ####################################################################        
    }

	# UPGRADE REMINDER
    if ($now == $reg_date->add(new DateInterval('P2D')) && $profile['Mitgliedschaft'] == 1) {
    	
        #EMAIL SEND BLOCK
        ####################################################################
        #user email
        #email template must exist in templates/email folder
        $email_template = 'reminder_upgrade.email.twig';

        $post_data = array(
            'to'       => $profile['user_email'],
            'bcc'      => 'um@scholarium.at',
            'subject'  => 'Neue Inhalte',
            'from'     => 'info@scholarium.at',
            'fromname' => 'Scholarium'
        );
			
        $body_data = array(
            'profile' => $profile
        );
        
        echo 'E-Mail wird an '.$profile['user_email'].' gesendet';
			
        if (!$email->sendThisEmail($email_template, $post_data, $body_data)) {
            error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        } else {
            $set_notice = $general->db_connection->prepare('UPDATE mitgliederExt SET reminded = :notice WHERE user_id = :user_id');
            $set_notice->bindValue(':notice', 1, PDO::PARAM_INT);
            $set_notice->bindValue(':user_id', $profile['user_id'], PDO::PARAM_STR);
            $set_notice->execute();
        }
        ####################################################################    	
    }
	
	# EXPIRY REMINDER
	if ($now == $expiry_date->sub(new DateInterval('P14D')) || 
	    $now == $expiry_date || 
	    $now == $expiry_date->add(new DateInterval('P14D')) || 
	    $now == $expiry_date->add(new DateInterval('P30D'))) {
        
		if ($now == $expiry_date->sub(new DateInterval('P14D'))) $period = -14;
		elseif ($now == $expiry_date) $period = 0;
		elseif ($now == $expiry_date->add(new DateInterval('P14D'))) $period = 14;
		elseif ($now == $expiry_date->add(new DateInterval('P30D'))) $period = 30;
			
        #EMAIL SEND BLOCK
        ####################################################################
        #user email
        #email template must exist in templates/email folder
        $email_template = 'reminder_expiry.email.twig';

        $post_data = array(
            'to'       => $profile['user_email'],
            'bcc'      => 'um@scholarium.at',
            'subject'  => 'Neue Inhalte',
            'from'     => 'info@scholarium.at',
            'fromname' => 'Scholarium'
        );
			
        $body_data = array(
            'profile' => $profile,
            'expiry'  => $period
        );
        
        echo 'E-Mail wird an '.$profile['user_email'].' gesendet';
			
        if (!$email->sendThisEmail($email_template, $post_data, $body_data)) {
            error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        } else {
            $set_notice = $general->db_connection->prepare('UPDATE mitgliederExt SET reminded = :notice WHERE user_id = :user_id');
            $set_notice->bindValue(':notice', 1, PDO::PARAM_INT);
            $set_notice->bindValue(':user_id', $profile['user_id'], PDO::PARAM_STR);
            $set_notice->execute();
        }
        ####################################################################		
	}
		
}
?>