<?php 
namespace Sofort\SofortLib;

#display all errors while developing
ini_set('display_errors',1);
error_reporting(E_ALL);

#init methods
session_start();
date_default_timezone_set('Europe/Vienna');

#radius_config(radius_handle, file)
require_once('../config/config.php');

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];

#set random txn id 



if ($_SESSION['profile']['payment_option'] === 'sofort')
{

    #forward to sofort payment page
	doSofortPayment();

}
elseif ($_SESSION['profile']['payment_option'] === 'paypal')
{


    #forward to paypal payment page
	doPaypalPayment($profile, $product);

}


function doSofortPayment()
{

    require '../vendor/autoload.php';

    $Sofortueberweisung = new Sofortueberweisung(SOFORT_KEY_TEST);

    // $Sofortueberweisung->setAmount(10.21);
    $Sofortueberweisung->setAmount($_SESSION['product']['total']);
    $Sofortueberweisung->setCurrencyCode('EUR');
    // $Sofortueberweisung->setReason($profile[user_email],$profile[memb_type]);
    $Sofortueberweisung->setReason('reason');

    // define("SOFORT_SUCCESS_URL", 'http://localhost:4567/sofort/success.php');

    // $Sofortueberweisung->setSuccessUrl(SOFORT_SUCCESS_URL, true);
    // $Sofortueberweisung->setAbortUrl(SOFORT_ABORT_URL, true);

    $Sofortueberweisung->setSuccessUrl("http://localhost:4567/zahlung/success.php", true);
    $Sofortueberweisung->setAbortUrl(SOFORT_ABORT_URL, true);




    // $Sofortueberweisung->setSenderSepaAccount('SFRTDE20XXX', 'DE06000000000023456789', 'Max Mustermann');
    // $Sofortueberweisung->setSenderCountryCode('DE');
    // $Sofortueberweisung->setNotificationUrl('http://www.google.de', 'loss,pending');
    // $Sofortueberweisung->setNotificationUrl('http://www.yahoo.com', 'loss');
    // $Sofortueberweisung->setNotificationUrl('http://www.bing.com', 'pending');
    // $Sofortueberweisung->setNotificationUrl('http://www.sofort.com', 'received');
    // $Sofortueberweisung->setNotificationUrl('http://www.youtube.com', 'refunded');
    // $Sofortueberweisung->setNotificationUrl('http://www.youtube.com', 'untraceable');
    // $Sofortueberweisung->setNotificationUrl('http://www.twitter.com');
    //$Sofortueberweisung->setCustomerprotection(true);

    $Sofortueberweisung->sendRequest();

    if($Sofortueberweisung->isError()) {
        //SOFORT-API didn't accept the data
        echo $Sofortueberweisung->getError();

    } else {
        //buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
        $paymentUrl = $Sofortueberweisung->getPaymentUrl();
        header('Location: '.$paymentUrl);
        exit();
    }

    // header('Location: ../test.php?q=finished');


}#end of doSofortPayment

function doPaypalPayment($profile, $product)
{

    #Prepare Paypal vars
    $query = array();

    // $query[''] = '';

    #to be moved to config
    #secret
    $query['notify_url'] = 'http://scholarium.at/testl1k2j302u31lk2139ds/working_listener_test.php';
    $query['business'] = 'dainius.tol-facilitator@gmail.com';
    $query['hosted_button_id'] = 'VEP823EAZG9BA';

    #generic
    $query['cmd'] = '_xclick';   
    $query['charset'] = 'utf-8';
    $query['currency_code'] = 'EUR';     
    
    #address override. by default takes user's paypal data
    $query['address_override'] = '1';     
   
    #profile
    $query['first_name'] = $profile['user_first_name'];
    $query['last_name'] = $profile['user_surname'];
    $query['email'] = $profile['user_email'];
    $query['custom'] =  $profile['wrt_txn_id'];

    $query['address1'] = $profile['user_street'];
    $query['zip'] = $profile['user_plz'];
    $query['city'] = $profile['user_city'];

    $query['wrt_txn_id'] = "someRandomthing";


    // $query['address1'] = $profile;
    // $query['city'] = $profile;
    // $query['state'] = $profile;
    // $query['zip'] = $profile;

    #product
    #use item number as transaction id
    $query['item_name'] = $product['name'];
    #first reg?
    #generate a random thing, which would be written to the trans db
    $query['item_number'] = $product['what'];

    $query['amount'] = $product['total'];

    $query_string = http_build_query($query);

    #redirects to paypal to make a payment
    #works the same as pressing a paypal button
    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);

    // $query['return'] = 'http://scholarium.at/test/paypal_test.php/';
    // $query['cancel_return'] = 'http://scholarium.at/test/paypal_test.php/';
        // <input type="hidden" name="return" value="http://business.example.com/order/123/" /> 
    // TODO adds info to transaction db
    // adds info to grey_registration db, items bougth, events... 
    // 

    // <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
    // <input type="hidden" name="cmd" value="_s-xclick">
    // <input type="hidden" name="hosted_button_id" value="VEP823EAZG9BA">
    // <input type="image" src="https://www.sandbox.paypal.com/en_US/AT/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    // <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    // </form>

    // if ($method == 'PayPal') {

    //     // Prepare GET data
    //     $query = array();
    //     $query['notify_url'] = 'http://jackeyes.com/ipn';
    //     $query['cmd'] = '_cart';
    //     $query['upload'] = '1';
    //     $query['business'] = 'social@jackeyes.com';
    //     $query['address_override'] = '1';
    //     $query['first_name'] = $first_name;
    //     $query['last_name'] = $last_name;
    //     $query['email'] = $email;
    //     $query['address1'] = $ship_to_address;
    //     $query['city'] = $ship_to_city;
    //     $query['state'] = $ship_to_state;
    //     $query['zip'] = $ship_to_zip;
    //     $query['item_name_'.$i] = $item['description'];
    //     $query['quantity_'.$i] = $item['quantity'];
    //     $query['amount_'.$i] = $item['info']['price'];

    //     // Prepare query string
    //     $query_string = http_build_query($query);

    //     header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);

    // $query['business'] = 'social@jackeyes.com';
    // $query['address_override'] = '1';
    // $query['first_name'] = $first_name;
    // $query['last_name'] = $last_name;
    // $query['email'] = $email;
    // $query['address1'] = $ship_to_address;
    // $query['city'] = $ship_to_city;
    // $query['state'] = $ship_to_state;
    // $query['zip'] = $ship_to_zip;
    // $query['item_name_'.$i] = $item['description'];
    // $query['quantity_'.$i] = $item['quantity'];
    // $query['amount_'.$i] = $item['info']['price'];
    // $query['upload'] = '1';

}

