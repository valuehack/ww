<?php

/**
* Handles payments
* started by Dainius
*/

#payment is used:
#in:
#   upgrade
#not_in:
#   sign_up to a level(upgrade with data provision)
#   seminars
#   projekte

class Transaction 
{
    
    # class vars come here

    private $db_connection = null;

    #constructor
    public function __construct()
    {

        #init methods
        session_start();
        date_default_timezone_set('Europe/Vienna');

        #set on payment function
        #set session vars for confirmation page and redirect
        if (isset($_POST["payment_user_info"])) 
        {
        	$_SESSION['profile'] = $_POST['profile'];
            $_SESSION['product'] = $_POST['product'];
        	$_SESSION['payment_page'] = 'user_info';
			$_SESSION['passed_from'] = $_POST['passed_from'];
			
			header('Location: ../zahlung/index.php?q=user_info');
        }
        
		elseif (isset($_POST["payment_submit"])) 
        {
            #record post to session
            $_SESSION['profile'] = $_POST['profile'];
            $_SESSION['product'] = $_POST['product'];
			$_SESSION['passed_from'] = $_POST['passed_from'];
            $_SESSION['payment_page'] = 'show_summary';
            #show_summary form must set confirmed_submit var if user confirms the data

            #redirect to confirmation page
            #TODO add PAYMENT_PAGE url to the server
            #header('Location: '.PAYMENT_PAGE);
			header('Location: ../zahlung/index.php?q=summary');
        }

        #user wants to change the data
        elseif (isset($_POST["change_info_submit"])) {
         
            #            
            $_SESSION['payment_page'] = 'edit_info';

            #user is redirected to PAYMENT_PAGE
            #header('Location: '.PAYMENT_PAGE);
			header('Location: ../zahlung/index.php?q=edit');
        }

        #user has confirmed the data, db write, process the payment
        elseif (isset($_POST["confirmed_submit"])) 
        {

            #TESTING ONLY:
            #sets session vars
            $this->setSessionVars();
    
            #take session vars and write it to the db 
                #write user data to grey user for registration
                $profile = $_SESSION['profile'];
                $product = $_SESSION['product'];

                $this->writeUserDataToGrey($profile);
                #possibly could differenciate in here the curent users from new 

                #write transaction info to the tran db
                $this->writeTransactionData();

                #what to do with registration for events? first reg on verification?


            #direct to relevant payment processor
            if ($_SESSION["payment_option"] === "sofort") 
            {
                doSofortPayment($profile);
            }
            elseif ($_SESSION["payment_option"] === "paypal") 
            {
                doPaypalPayment($profile);
            }

        }   

    }

    #db connection, same as in Registration.php class
    #usage:
    # call the function - if ($this->databaseConnection())
    # $this->db_connection->prepare('sql query comes here')
    private function databaseConnection()
    {
        // connection already opened
        if ($this->db_connection != null) 
        {
            return true;
        } 
        else 
        {
            try 
            {

                #create new PDO object, connection to the db, info in the config file
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
                $query_time_zone->execute();

                return true;
            } 
            catch (PDOException $e) 
            {
                #error
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }   

    #checks if email is already registered
    private function isEmailRegistered($user_email)
    {

        $email_exists_query = $db_connection->prepare('SELECT user_email FROM mitgliederExt WHERE user_email LIKE :user_email LIMIT 1');
        $email_exists_query->bindValue(':user_email', $user_email, PDO::PARAM_STR);
        $email_exists_query->execute();

        if ($email_exists_query->rowCount() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }

    }           
  

    #records submited data to the temp grey user db 
    private function writeUserDataToGrey($profile)
    {
        
        if (isEmailRegistered())
        {
            #email is registered 

        }
        else
        {
            #registers email
            #copy paste - was easier separating them, rather than rewriting queries
            $query_new_user_insert = $this->db_connection->prepare(
                'INSERT INTO grey_user (user_email, user_registration_datetime) 
                 VALUES(:user_email, now())');

            $query_new_user_insert->bindValue(':user_email', $profile[user_email], PDO::PARAM_STR);
            $query_new_user_insert->execute();

            #adds extra info
            $update_profile_query = $this->db_connection->prepare(
            "UPDATE grey_user   
                SET Anrede = :anrede,
                    Vorname = :name,
                    Nachname = :surname,
                    Telefon = :telefon,
                    Strasse = :street,
                    PLZ = :plz,
                    Ort = :city,
                    Land = :country,
                    first_reg = :first_reg
            WHERE user_email = :user_email"
            );

            $update_profile_query->bindValue(':anrede', $profile[user_anrede], PDO::PARAM_STR);
            $update_profile_query->bindValue(':name', $profile[user_first_name], PDO::PARAM_STR);
            $update_profile_query->bindValue(':surname', $profile[user_surname], PDO::PARAM_STR);
            $update_profile_query->bindValue(':telefon', $profile[user_telefon], PDO::PARAM_STR);
            $update_profile_query->bindValue(':street', $profile[user_street], PDO::PARAM_STR);
            $update_profile_query->bindValue(':plz', $profile[user_plz], PDO::PARAM_STR);
            $update_profile_query->bindValue(':city', $profile[user_city], PDO::PARAM_STR);
            $update_profile_query->bindValue(':country', $profile[user_country], PDO::PARAM_STR);
            $update_profile_query->bindValue(':first_reg', $profile[first_reg], PDO::PARAM_STR);
            $update_profile_query->bindValue(':user_email', $profile[user_email], PDO::PARAM_STR);
            $update_profile_query->execute();

        }

    }

    private function writeTransactionData()
    {
        #generate transaction id and pass it to paypal as well
        $trans_id;
        

    }           


    #process paypal payment
    #TODO
    #
    function doPaypalPayment($profile, $product, $trans_id)
    {

        #Prepare Paypal vars
        $query = array();

        // $query[''] = '';

        #to be moved to config
        #secret
        $query['notify_url'] = 'http://scholarium.at/testl1k2j302u31lk2139ds/listener.php';
        $query['business'] = 'dainius.tol-facilitator@gmail.com';
        $query['hosted_button_id'] = 'VEP823EAZG9BA';

        #generic
        $query['cmd'] = '_xclick';   
        $query['charset'] = 'utf-8';
        $query['currency_code'] = 'EUR';     
        
        #profile
        $query['first_name'] = $profile[user_first_name];
        $query['last_name'] = $profile[user_surname];
        $query['email'] = $profile[user_email];

        // $query['address1'] = $profile;
        // $query['city'] = $profile;
        // $query['state'] = $profile;
        // $query['zip'] = $profile;

        #product
        #use item number as transaction id
        $query['item_name'] = 'Test Item';#first reg?
        #generate a random thing, which would be written to the trans db
        $query['item_number'] = $trans_id;

        $query['amount'] = $product[total];

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
