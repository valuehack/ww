<?php

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
#display all errors while developing
ini_set('display_errors', "0");
error_reporting(E_ALL);

date_default_timezone_set('Europe/Vienna');

ob_start();

# check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once('../libraries/password_compatibility_library.php');
}

# include the config
require_once('../config/config.php');
require_once('../translations/de.php');

# load the login class
// require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');
require_once('../classes/Email.php');

#does not work
// $general = new General();
$login = new Login();
$email = new Email();
$registration = new Registration();

if ( (isset($_SESSION['user_logged_in'])) and ($_SESSION['user_logged_in'] === 1) )
{
    include('../views/_header_in_utf8.php'); 
}
else
{   
    include('../views/_header_not_in_utf8.php');
}



    #product selected, redirect to submit your data form
    if ($_GET["g"] === 'ihredaten')
    {

        if (isset($_POST['product']['what'])) updateProductSessionVars($_POST['product']['what']);
        getForm();

    }
    #redirect to summary page
    elseif ($_GET["g"] === 'summary')
    {

        #check if email is already registered       

        #here comes extra post from seminare and projekt, so set all session vars
        if (isset($_POST['product'])) $_SESSION['product'] = $_POST['product'];
        if (isset($_POST['profile'])) $_SESSION['profile'] = $_POST['profile'];
        if ( (isset($_SESSION['user_logged_in'])) and ($_SESSION['user_logged_in'] === 1) )
        {
            $_SESSION['profile']['user_logged_in'] = $_SESSION['user_logged_in'];
        }

        #its coming from edit page
        if (isset($_POST['edit_form_submit']))
        {
            updateProductSessionVars($_POST['product']['what']);
        }

        $_SESSION['product']['total'] = $_SESSION['product']['price']; 

        #generate and display summary 
        getSummary();

    }
    elseif ($_GET["g"] === 'edit')      
    {

        getEditPage();

    }elseif (isset($_POST['change_info_submit']))        
    {
        #edit
        #user want to edit the details, forward to summary/confirmation page

        header('Location: ../zahlung/?g=edit');

    }
    elseif (isset($_POST['confirmed_submit']))        
    {
        #confirmed - send to sofort/paypal
        #problem with namespaces
        #redirect to other file for a quick workaround

        $_SESSION['product']['credits'] = $_SESSION['product']['total'];
        $_SESSION['profile']['first_reg'] = $_SESSION['product']['what'];

        $user_email = $_SESSION['profile']['user_email'];

        $wrt_txn_id = random_wrt_txn_id();
        $_SESSION['profile']['wrt_txn_id'] = $wrt_txn_id;

        #write paypal data to database
        #this writes every txn data to the db
        #TODO - rename
        if (writeTransactionDataToDB($user_email, $wrt_txn_id))
        {
           header('Location: payment.php');     
        }
        else 
        {
           header('Location: leider.php'); 

        }
        

    }
    elseif (!isset($_GET["g"]))
    {
        header('Location: /zahlung/?g=ihredaten');
    }



// #TESTING ONLY
// #var output block
// echo "<br>POST<br>";
// print_r($_POST);
// echo "<br>";
// echo "<br>GET<br>";
// print_r($_GET);
// echo "<br><br><br>";
// #formats print_r for readability 
// $test = print_r($_SESSION, true);
// $test = str_replace("(", "<br>(", $test);
// $test = str_replace("[", "<br>[", $test);
// $test = str_replace(")", ")<br>", $test);
// echo $test;

    

function getForm()
{

    #init methods for twig
    require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader, array('cache' => false));

    #select a template
    $formTemplate = $twig->loadTemplate('the_form.html.twig');

    #values to ease the testing
    $profile = array(
        'user_email' => random_email(),
        'user_anrede' => 'Herr',
        'user_first_name' => 'testDenis',
        'user_surname' => 'testStankus',
        'user_telefon' => '123',
        'user_street' => 'Goodin Street 5',
        'user_plz' => '1050',
        'user_city' => 'Wien',
        'user_country' => 'Austria',
        'payment_option' => 'sofort'
        );


    #user logged in, following will fetch user data and populate the form
    if ( (isset($_SESSION['user_logged_in'])) and ($_SESSION['user_logged_in'] === 1) )
    {

        $user = getUser($_SESSION['user_id'],$_SESSION['user_email']);
        
        #overwrite testing values if a user object returned. 
        $profile = array(
            'user_email' => $user->user_email,
            'user_anrede' => $user->Anrede,
            'user_first_name' => $user->Vorname,
            'user_surname' => $user->Nachname,
            'user_telefon' => $user->Telefon,
            'user_street' => $user->Strasse,
            'user_plz' => $user->PLZ,
            'user_city' => $user->Ort,
            'user_country' => $user->Land
            );

        // $_SESSION['profile']['user_logged_in'] = $_SESSION['user_logged_in'];
    }

    #pass variables to and display the template
    echo $formTemplate->render(array(
            'type' => "type", 
            'product' => $_SESSION['product'],
            'profile' => $profile
            ));

    #footer

}

function getSummary()
{
 
    #init methods for twig
    require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader, array('cache' => false));

    #select a template
    $formTemplate = $twig->loadTemplate('summary.html.twig');

    $now = date('d.m.Y', time());
    #membership ends one year (31536000 sec) from today 
    $membership_end = date('d.m.Y', time()+31536000);

    $_SESSION['product']['membership_end'] = date('Y-m-d', time()+31536000);

    #pass variables to template
    echo $formTemplate->render(array(
        'type' => "seminars",        
        'profile' => $_SESSION['profile'],
        'test' => "another",
        'now' => $now,
        'product' => $_SESSION['product'],
        'membership_end' => $membership_end

        ));
}


function getEditPage()
{
 
        #init methods for twig
        require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('../templates');
        $twig = new Twig_Environment($loader, array('cache' => false));

        #select a template
        $formTemplate = $twig->loadTemplate('edit.html.twig');

        $now = date('d.m.Y', time());
        #membership ends one year (31536000 sec) from today 
        $membership_end = date('d.m.Y', time()+31536000);

        #pass variables to template
        echo $formTemplate->render(array(
            'type' => "seminar",
            'product' => $_SESSION['product'],
            'profile' => $_SESSION['profile'],
            'now' => $now,
            'membership_end' => $membership_end


            ));
}

function updateProductSessionVars($product_what)
{

    #sets 'what' to session as used by futher methods 
    $_SESSION['product']['what'] = $product_what;

    switch ($product_what)
    {
        case 'upgrade_2':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "2";
            $_SESSION['product']['price'] = "0.01";
            $_SESSION['product']['name'] = "Gast";
        break;    

        case 'upgrade_3':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "3";
            $_SESSION['product']['price'] = "150";
            $_SESSION['product']['name'] = "Teilnehmer";
        break;

        case 'upgrade_4':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "4";
            $_SESSION['product']['price'] = "300";
            $_SESSION['product']['name'] = "Scholar";
        break;

        case 'upgrade_5':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "5";
            $_SESSION['product']['price'] = "600";
            $_SESSION['product']['name'] = "Partner";
        break;

        case 'upgrade_6':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "6";
            $_SESSION['product']['price'] = "1200";
            $_SESSION['product']['name'] = "Beirat";
        break;

        case 'upgrade_7':
            $_SESSION['product']['type'] = "upgrade";
            $_SESSION['product']['level'] = "7";
            $_SESSION['product']['price'] = "2400";
            $_SESSION['product']['name'] = "Patron";
        break;

        default:
            // $_SESSION['product']['type'] = "unknown";
    }

}

function writeTransactionDataToDB($user_email, $wrt_txn_id)
{
    #paypal data needs to be written to db as paypal only sends post to another script, not connected to a user session

    $registration = new Registration();

    $serialized_session = serialize($_SESSION);

    // if (!unserialize($serialized_session))
    // // if (true)
    // {

    //     #EMAIL SEND BLOCK
    //     ####################################################################
    //     #email template must exist in templates/email folder
    //     $email_template = 'problem.email.twig';

    //     $post_data = array(
    //         'to' => 'dzainius@gmail.com',
    //         'subject' => 'huge problem',
    //         'from' => 'info@scholarium.at',
    //         'fromname' => 'problem'
    //         );

    //     $body_data = array(
    //         'user_email' => $user_email
    //         );
        
    //     if ( !$registration->sendThisEmail($email_template, $post_data, $body_data) ) 
    //     {
    //       error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
    //     }
    //     ####################################################################


    //     ##log in error log
    //     // error_log(message)
        
    //     ##stop further process
    //     return false;
    // }

    try 
    {
        $db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } 
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

    #TODO - change it to Europe/Vienna for server
    // $query_time_zone = $db_connection->prepare("SET time_zone = 'Europe/Vienna'");
    $query_time_zone = $db_connection->prepare("SET time_zone = '+2:00'");
    $query_time_zone->execute();


    $paypal_to_db_query = $db_connection->prepare(
    "INSERT INTO transactions
    (
        user_email,
        wrt_txn_id,
        session_data,           
        attempt_datetime
    )
    VALUES
    (     
        :user_email,
        :wrt_txn_id,
        :session_data,         
        now()
    )
    ");

    $paypal_to_db_query->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    $paypal_to_db_query->bindValue(':wrt_txn_id', $wrt_txn_id, PDO::PARAM_STR);
    $paypal_to_db_query->bindValue(':session_data', $serialized_session, PDO::PARAM_STR);
    $paypal_to_db_query->execute();

    if($paypal_to_db_query->errorCode() != 0) echo "wat ".$paypal_to_db_query->errorInfo();
    return true;


}

function getUser($user_id, $user_email)
{

    try 
    {
        $db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } 
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

    $query_time_zone = $db_connection->prepare("SET time_zone = '+2:00'");
    $query_time_zone->execute();

    $user_query = $db_connection->prepare(
    'SELECT * FROM mitgliederExt 
        WHERE 
        user_id LIKE :user_id 
        AND
        user_email LIKE  :user_email
        LIMIT 1');

    $user_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $user_query->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    $user_query->execute();

    return $user_query->fetchObject();
    #usage
    #$result_row->user_id


    #you are logged in, but we could not retrieve your data for the payment form
    #check if the query was executed and returned exactly one result

}

function random_wrt_txn_id() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $size = strlen( $chars );
    for( $i = 0; $i < 12; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}

function random_email() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $email="";
    $username="";
    $domain="";

    $size = strlen( $chars );
    for( $i = 0; $i < 1; $i++ ) {
        $username .= $chars[ rand( 0, $size - 1 ) ];
    }

    $size = strlen( $chars );
    for( $i = 0; $i < 3; $i++ ) {
        $domain .= $chars[ rand( 0, $size - 1 ) ];
    }

    $email=$username."@".$domain.".com";

    return $email;
}