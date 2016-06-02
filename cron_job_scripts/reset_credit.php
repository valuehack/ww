<?php
/**
 * Cronjob that checks the Ablauf of every membership and sets the user credits to 0 if the user did not renew ist membership 3 month after Ablauf
 * @author Ulrich Möller
 */
 
require_once('../config/config.php');
require_once('../classes/General.php');

$general = new General();

$get_user_info = $general->db_connection->prepare('SELECT * FROM mitgliederExt');
$get_user_info->execute();
//$user_info = $get_user_info->fetchAll();

echo 'Ich schlafe noch!';

for ($i = 0; $i < count($user_info); $i++) {
	if (strtotime($user_info[$i]['Ablauf']) < time() - 7776000) {
		if ($user_info[$i]['credits_left'] > 0) {

			/*echo $user_info[$i]['user_email'];
			echo '<br>';
			echo $user_info[$i]['Ablauf'];
			echo '<br>';
			echo $user_info[$i]['credits_left'];
			echo '<br>';*/
			
			$reset_credit = $general->db_connection->prepare('UPDATE mitgliederExt SET credits_left = :reset WHERE user_id = :user_id');
			$reset_credit->bindValue(':reset', 0, PDO::PARAM_INT);
			$reset_credit->bindValue(':user_id', $user_info[$i]['user_id'], PDO::PARAM_INT);
			//$reset_credit->execute();
		}
	}
}
?>