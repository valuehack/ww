<?php
namespace Sofort\SofortLib; 

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
ini_set("display_errors" , "0");

date_default_timezone_set('Europe/Vienna');

#if session does not exist, start a session
if(session_id() == '') session_start();
error_log('this is a session id in payment '.session_id());

require_once('../config/config.php');

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];
$donation = $_SESSION['donation'];


if ($profile['payment_option'] === 'sofort')
{
	# replace umlaute in the names because they are not allowed within the reason for transfer statement
	$profile['user_first_name'] = replaceUmlaute($profile['user_first_name']);
	$profile['user_surname'] = replaceUmlaute($profile['user_surname']);

    #forward to sofort payment page
	doSofortPayment($profile, $product);

}
elseif ($profile['payment_option'] === 'paypal')
{

    #forward to paypal payment page
	doPaypalPayment($profile, $product);

}

function doSofortPayment($profile, $product)
{	
    require '../vendor/autoload.php';

    $Sofortueberweisung = new Sofortueberweisung(SOFORT_KEY_TEST);

    $Sofortueberweisung->setAmount($product['total']);
    $Sofortueberweisung->setCurrencyCode('EUR');
	
	if(isset($_SESSION['user_id'])) $Sofortueberweisung->setReason('Spende '.$_SESSION['user_id']);
	elseif ($product['type'] === 'upgrade') $Sofortueberweisung->setReason('Spende '.$profile['user_first_name'].' '.$profile['user_surname']);
	elseif ($product['type'] === 'projekt') $Sofortueberweisung->setReason('Projektspende '.$product['id']);
	elseif ($product['type'] === 'seminar') $Sofortueberweisung->setReason('Seminarbuchung '.$product['id']);
	
    $sofort_success_url = SOFORT_URL_BASE."sofort_listener.php?g=".$profile['wrt_txn_id'];
    error_log('sofort success url in payment '.$sofort_success_url);

    $Sofortueberweisung->setSuccessUrl($sofort_success_url, true);
    // $Sofortueberweisung->setAbortUrl(SOFORT_URL_BASE., true);

    $Sofortueberweisung->sendRequest();

    if($Sofortueberweisung->isError()) {
        #SOFORT-API didn't accept the data
        echo $Sofortueberweisung->getError();

    } else {
        #buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
        $paymentUrl = $Sofortueberweisung->getPaymentUrl();
        header('Location: '.$paymentUrl);
        exit();
    }

}

function doPaypalPayment($profile, $product)
{

    $query = array();

    #to be moved to config
    $query['notify_url'] = 'http://www.scholarium.at/zahlung/paypal_listener.php';
    
    $query['business'] = 'bartholos-facilitator@web.de';
    $query['hosted_button_id'] = 'VEP823EAZG9BA';

    #return url
    $query['return'] = 'http://www.scholarium.at/zahlung/zahlung_erfolgreich.php';

    #generic
    $query['cmd'] = '_xclick';
    $query['charset'] = 'utf-8';
    $query['currency_code'] = 'EUR';     
    
    // #address override. by default takes user's paypal data
    // $query['address_override'] = '1';     
       
    // #profile
    $query['first_name'] = $profile['user_first_name'];
    $query['last_name'] = $profile['user_surname'];
    $query['email'] = $profile['user_email'];
    $query['custom'] =  $profile['wrt_txn_id'];

    $query['address1'] = $profile['user_street'];
    $query['zip'] = $profile['user_plz'];
    $query['city'] = $profile['user_city'];
    $query['country'] = $profile['user_country'];

    #product
    if(isset($_SESSION['user_id'])) {
    	$query['item_name'] = 'Spende '.$_SESSION['user_id'];
		$query['item_number'] = 'Spende '.$_SESSION['user_id'];
	}
	elseif ($product['type'] === 'upgrade') {
		$query['item_name'] = 'Spende '.$profile['user_first_name'].' '.$profile['user_surname'];
		$query['item_number'] = 'Spende '.$profile['user_first_name'].' '.$profile['user_surname'];
	}
	elseif ($product['type'] === 'projekt') {
		$query['item_name'] = 'Projektspende '.$product['id'];
		$query['item_number'] = 'Projektspende '.$product['id'];
	}
	elseif ($product['type'] === 'seminar'){
		$query['item_name'] = 'Seminarbuchung '.$product['id'];
		$query['item_number'] = 'Seminarbuchung '.$product['id'];
	}

    $query['amount'] = $product['total'];

    $query_string = http_build_query($query);

    #redirects to paypal to make a payment
    #works the same as pressing a paypal button
    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);

}

function replaceUmlaute($str) {
	# $str has to be a string
		
	# set search and replace arrays
	$umlaute = array('Ä','ä','Ö','ö','Ü','ü','ß');
	$replace = array('Ae','ae','Oe','oe','Ue','ue','ss');
		
	# replace umlaute
	$str_wo_uml = str_replace($umlaute, $replace, $str);
		
	# strip all that is not alphanumerical (just to be sure)
	$str_wo_uml = preg_replace('/[^a-z0-9_-]/isU', '', $str_wo_uml);
	
	return $str_wo_uml;

	} 
?>
