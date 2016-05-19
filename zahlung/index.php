<?php

#error log settings
ini_set("log_errors" , "1");
#php_listener_errors is a filename where errors are logged
ini_set("error_log" , "./log/zahlung_index_errors");
ini_set("display_errors" , "0");

ob_start();

#display all errors while developing
ini_set('display_errors',1);
error_reporting(E_ALL);

//session_start();  

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
require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');
require_once('../classes/Email.php');

// $general = new General();
$login = new Login();
$email = new Email();
$registration = new Registration();


#logic
if ($login->isUserLoggedIn() == true) 
{
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
	include("../views/zahlung_in.php");

} 
else 
{

    #product selected, redirect to submit your data form
    if ($_GET["g"] === 'ihredaten')
    {

        updateProductSessionVars($_POST['product']['what']);
        getForm();

    }
    #redirect to summary page
    elseif ($_GET["g"] === 'summary')
    {

        #check if email is already registered       

        #here comes extra post from seminare and projekt, so set all session vars
        if (isset($_POST['product'])) $_SESSION['product'] = $_POST['product'];
        if (isset($_POST['profile'])) $_SESSION['profile'] = $_POST['profile'];


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
        if ($_SESSION['profile']['payment_option'] === 'paypal') writePaypalDataToDB($user_email, $wrt_txn_id);

        header('Location: payment.php');
    }



#TESTING ONLY
#var output block
echo "<br>POST<br>";
print_r($_POST);
echo "<br>";
echo "<br>GET<br>";
print_r($_GET);
echo "<br><br><br>";
#formats print_r for readability 
$test = print_r($_SESSION, true);
$test = str_replace("(", "<br>(", $test);
$test = str_replace("[", "<br>[", $test);
$test = str_replace(")", ")<br>", $test);
echo $test;

    
}#end of else


function getForm()
{

    #init methods for twig
    require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader, array('cache' => false));

    #values to ease the testing
    $profile = array(
        'user_email' => 'saltydillpickles@gmail.com',
        'user_anrede' => 'Herr',
        'user_first_name' => 'Denis',
        'user_surname' => 'Stankus',
        'user_telefon' => '123',
        'user_street' => 'Goodin Street 5',
        'user_plz' => '1050',
        'user_city' => 'Wien',
        'user_country' => 'Austria',
        'payment_option' => 'sofort'
        );

    #select a template
    $formTemplate = $twig->loadTemplate('the_form.html.twig');

    #header
    $title="Unterst&uuml;tzen";
    include('../views/_header_not_in.php'); 

    #pass variables to and display the template
    echo $formTemplate->render(array(
            'type' => "type", 
            'product' => $_SESSION['product'],
            'profile' => $profile
            ));

    #footer
    include('../views/_footer.php'); 
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

    #header
    $title="Unterst&uuml;tzen";
    include('../views/_header_not_in.php'); 

    $now = date('d.m.Y', time());
    #membership ends one year (31536000 sec) from today 
    $membership_end = date('d.m.Y', time()+31536000);

    $_SESSION['product']['membership_end'] = date('Y-m-d', time()+31536000);

    #pass variables to template
    echo $formTemplate->render(array(
        'type' => "seminars",
        
        'profile' => $_SESSION['profile'],

        // 'profile' => "safsadf",
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

        #header
        $title="Unterst&uuml;tzen";
        include('../views/_header_not_in.php'); 

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
            $_SESSION['product']['price'] = "75";
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

function writePaypalDataToDB($user_email, $wrt_txn_id)
{
    #paypal data needs to be written to db as paypal only sends post to another script, not connected to a user session

    $serialized_session = serialize($_SESSION);    

    try 
    {
        $db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } 
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

    $paypal_to_db_query = $db_connection->prepare(
    "INSERT INTO paypal_data_storage 
    (
        user_email,
        wrt_txn_id,
        data,           
        store_datetime
    )
    VALUES
    (     
        :user_email,
        :wrt_txn_id,
        :data,         
        now()
    )
    ");

    $paypal_to_db_query->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    $paypal_to_db_query->bindValue(':wrt_txn_id', $wrt_txn_id, PDO::PARAM_STR);
    $paypal_to_db_query->bindValue(':data', $serialized_session, PDO::PARAM_STR);
    $paypal_to_db_query->execute();

}

function random_wrt_txn_id() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $size = strlen( $chars );
    for( $i = 0; $i < 12; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}