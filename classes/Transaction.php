<?php

/**
* Handles payments
* started by Dainius
*/
class Transaction 
{
    
    # class vars come here

    public function __construct()
    {

        session_start();

        #set session vars for confirmation page

        #if confirmation is clicked, then process the session vars and redirect to the payment provider

        if (isset($_POST["payment_submit"])) 
        {
            #record post to session
            #redirect to the confirmation page
            // $_SESSION =  $_POST;
            $_SESSION['profile'] = $_POST['profile'];
            $_SESSION['product']['quantity'] = $_POST['product']['quantity'];


            #redirect to confirmation page
            #move url to config
            // header('Location: http://www.scholarium.at/confirm_your_details/');
            header('Location: http://localhost:4567/confirm_your_details/');


        }

        #form var that triggers this class
        else if (isset($_POST["payment_submit"])) 
        {

            # record profile data...
            $profile = $_POST['profile'];
            $_SESSION['payment_profile'] = $profile;
            #write it to the db and wait for the confirmed transaction

            # do swith case for the following:

            if ($_POST["payment_option"] === "sofort") 
            {
                #doSofortPayment($profile);
            }

            if ($_POST["payment_option"] === "paypal") 
            {
                doPaypalPayment($profile);
            }

        }   

    }
    //have a function that is called after confirmation button is clicked
    public function FunctionName($value='')
    {
        # code...
    }

    // in the same function add info to db
    function doPaypalPayment($profile)
    {




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


        // Prepare GET data
        $query = array();
        // move notify url to the config, hide it from the potential bad guys
        $query['notify_url'] = 'http://scholarium.at/testl1k2j302u31lk2139ds/listener.php';
        $query['cmd'] = '_xclick';   
        $query['charset'] = 'utf-8';
        $query['hosted_button_id'] = 'VEP823EAZG9BA';
        // $query[''] = '';
        //keep business email in the config file
        $query['business'] = 'dainius.tol-facilitator@gmail.com';
        $query['item_name'] = 'Test Item';
        $query['item_number'] = 'tst1';
        $query['amount'] = '1.00';
        $query['currency_code'] = 'EUR';
        $query['return'] = 'http://scholarium.at/test/paypal_test.php/';
        $query['cancel_return'] = 'http://scholarium.at/test/paypal_test.php/';
            // <input type="hidden" name="return" value="http://business.example.com/order/123/" /> 


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

        // Prepare query string
        $query_string = http_build_query($query);

        header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);



    }

    function doSofortPayment($profile)
    {

        #require __DIR__ . '../vendor/autoload.php';
        require '../vendor/autoload.php';

        // enter your configuration key – you only can create a new configuration key by creating
        // a new Gateway project in your account at sofort.com
        #$configkey = SOFORT_KEY_TEST;

        #$Sofortueberweisung = new Sofortueberweisung($configkey);
        $Sofortueberweisung = new Sofortueberweisung(SOFORT_KEY_TEST);

        // $Sofortueberweisung->setAmount(10.21);
        $Sofortueberweisung->setAmount($profile[payment]);
        $Sofortueberweisung->setCurrencyCode('EUR');
        $Sofortueberweisung->setReason($profile[user_email],$profile[memb_type]);
        $Sofortueberweisung->setSuccessUrl(SOFORT_SUCCESS_URL, true);
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
    }#end of doSofortPayment
    
}#end of class
