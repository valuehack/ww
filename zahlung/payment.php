<?php 
namespace Sofort\SofortLib;

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
ini_set("display_errors" , "0");

#if session does not exist, start a session
if(session_id() == '') session_start();
error_log('this is a session id in payment '.session_id());

date_default_timezone_set('Europe/Vienna');

require_once('../config/config.php');

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];


if ($profile['payment_option'] === 'sofort')
{

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
    $Sofortueberweisung->setReason($product['what']);

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
    $query['notify_url'] = 'http://scholarium.at/zahlung/paypal_listener.php';
    
    $query['business'] = 'dainius.tol-facilitator@gmail.com';
    $query['hosted_button_id'] = 'VEP823EAZG9BA';

    #return url
    $query['return'] = 'http://scholarium.at/zahlung/einvollererfolg.php';

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
    $query['item_name'] = $product['name'];
    $query['item_number'] = $product['what'];

    $query['amount'] = $product['total'];

    $query_string = http_build_query($query);

    #redirects to paypal to make a payment
    #works the same as pressing a paypal button
    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);

}

