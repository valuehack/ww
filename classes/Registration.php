<?php

/**
 * Handles the user registration
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $registration_successful  = false;
    /**
     * @var bool success state of verification
     */
    public  $verification_successful  = false;
    /**
     * @var array collection of error messages
     */
    public  $errors                   = array();
    /**
     * @var array collection of success / neutral messages
     */
    public  $messages                 = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        session_start();

        // if we have such a POST request, call the registerNewUser() method
        if (isset($_POST["register"])) {
            $this->registerNewUser($_POST['user_email'], $_POST['user_password_new'], $_POST['user_password_repeat'], $_POST["captcha"]);
        // if we have such a GET request, call the verifyNewUser() method
        } else if (isset($_GET["id"]) && isset($_GET["verification_code"])) {
            $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
        } else if (isset($_POST["subscribe"])) {
            $this->subscribeNewUser($_POST['user_email']);
        }
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection()
    {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser($user_email, $user_password, $user_password_repeat, $captcha)
    {
        // we just remove extra space on username and email
        #$user_name  = trim($user_name);
        $user_email = trim($user_email);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (strtolower($captcha) != strtolower($_SESSION['captcha'])) {
            $this->errors[] = MESSAGE_CAPTCHA_WRONG;
        #} elseif (empty($user_name)) {
        #    $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } elseif (empty($user_password) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        } elseif ($user_password !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        } elseif (strlen($user_password) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        #} elseif (strlen($user_name) > 64 || strlen($user_name) < 2) {
        #    $this->errors[] = MESSAGE_USERNAME_BAD_LENGTH;
        #} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {
        #    $this->errors[] = MESSAGE_USERNAME_INVALID;
        } elseif (empty($user_email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
        } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;

        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if username or email already exists
            $query_check_user_email = $this->db_connection->prepare('SELECT user_email FROM mitgliederExt WHERE user_email=:user_email');
            #$query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_email->execute();
            $result = $query_check_user_email->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    #$this->errors[] = ($result[$i]['user_name'] == $user_name) ? MESSAGE_USERNAME_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                    $this->errors[] = ($result[$i]['user_email'] == $user_email) ? MESSAGE_EMAIL_ALREADY_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                   
                }
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                $user_activation_hash = sha1(uniqid(mt_rand(), true));

                // write new users data into database
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO mitgliederExt (user_password_hash, user_email, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_password_hash, :user_email, :user_activation_hash, :user_registration_ip, now())');
                #$query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                // id of new user
                $user_id = $this->db_connection->lastInsertId();
                $_SESSION['user_id'] = $user_id;

                if ($query_new_user_insert) {
                    // send a verification email
                    if ($this->sendVerificationEmail($user_id, $user_email, $user_activation_hash)) {
                        // when mail has been send successfully
                        $this->messages[] = "Please check your email for further details.";
                        $this->registration_successful = true;
                    } else {
                        // delete this users account immediately, as we could not send a verification email
                        $query_delete_user = $this->db_connection->prepare('DELETE FROM mitgliederExt WHERE user_id=:user_id');
                        $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                        $query_delete_user->execute();

                        $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                    }
                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }
            }
        }
    }

private function subscribeNewUser($user_email)
    {
        // we just remove extra space on email
        $user_email = trim($user_email);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (empty($user_email)) {
           $this->errors[] = MESSAGE_EMAIL_EMPTY;;
          } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;       

        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if username or email already exists
            $query_check_user_email = $this->db_connection->prepare('SELECT user_email FROM mitgliederExt WHERE user_email=:user_email');
            #$query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_email->execute();
            $result = $query_check_user_email->fetchAll();


            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    #$this->errors[] = ($result[$i]['user_name'] == $user_name) ? MESSAGE_USERNAME_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                    $this->errors[] = ($result[$i]['user_email'] == $user_email) ? MESSAGE_EMAIL_ALREADY_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                   
                }
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                #$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                #$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                #$user_activation_hash = sha1(uniqid(mt_rand(), true));

                // write new users data into database
                
                    $query_new_user_insert = $this->db_connection->prepare('INSERT INTO mitgliederExt (user_email, Mitgliedschaft ,user_registration_ip, user_registration_datetime) VALUES(:user_email, :Mitgliedschaft, :user_registration_ip, now())');
                #$query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                #$query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);

                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':Mitgliedschaft', '1', PDO::PARAM_STR);
                #$query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                // id of new user
                $user_id = $this->db_connection->lastInsertId();
                $_SESSION['user_id'] = $user_id;

               // if ($query_new_user_insert) {
               //     // send a verification email
               //     if ($this->sendVerificationEmail($user_id, $user_email, $user_activation_hash)) {
               //         // when mail has been send successfully
               //         $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
               //         $this->registration_successful = true;
               //     } else {
               //         // delete this users account immediately, as we could not send a verification email
               //         $query_delete_user = $this->db_connection->prepare('DELETE FROM mitgliederExt WHERE user_id=:user_id');
               //         $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
               //         $query_delete_user->execute();

               //         $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
               //     }
               // } else {
               //     $this->errors[] = MESSAGE_REGISTRATION_FAILED;
               // }


                #TO-DO: exchange with a custom function to have control over email content
                $this->subscriptionPassword($user_email);



                if ($query_new_user_insert) 
                {
                    // $this->errors[] = "Successfully registered.";
                    // $this->messages[] =
                    $_POST['user_rememberme'] = 1;


                } else 
                {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }


                            }
                        }
                    }

#ADDITION
#Creating password for newly subscribed members
public function subscriptionPassword($user_email)
    {
        $user_email = trim($user_email);

        if (empty($user_email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;

        } else {
            // generate timestamp (to see when exactly the user (or an attacker) requested the password reset mail)
            // btw this is an integer ;)
            $temporary_timestamp = time();
            // generate random hash for email password reset verification (40 char string)
            $user_password_reset_hash = sha1(uniqid(mt_rand(), true));
            // database query, getting all the info of the selected user
            

#PROBLEM here. take user email from session id\\ no need for more data
#$result_row = $this->getUserData($user_email);

            // if this user exists
            #if (isset($result_row->user_id)) {


                // database query:
                $query_update = $this->db_connection->prepare('UPDATE mitgliederExt SET user_password_reset_hash = :user_password_reset_hash,
                                                               user_password_reset_timestamp = :user_password_reset_timestamp
                                                               WHERE user_email = :user_email');
                $query_update->bindValue(':user_password_reset_hash', $user_password_reset_hash, PDO::PARAM_STR);
                $query_update->bindValue(':user_password_reset_timestamp', $temporary_timestamp, PDO::PARAM_INT);
                $query_update->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_update->execute();

                // check if exactly one row was successfully changed:
                if ($query_update->rowCount() == 1) {
                    // send a mail to the user, containing a link with that token hash string
                    $this->sendSubscriptionMail($user_email, $user_password_reset_hash);
                    return true;
                } else {
                    $this->errors[] = MESSAGE_DATABASE_ERROR;
                }
#            } else {
#                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
#            }
        }
        // return false (this method only returns true when the database entry has been set successfully)
        return false;
    }
#-------------------------------------
public function sendSubscriptionMail($user_email, $user_password_reset_hash)
    {
        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            #$mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_PASSWORDRESET_FROM;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = "Membership confirmation";

        $link = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

#---------------------------------------------------------------------------------------------
#------------------HTML-BODY------------------------------------------------------------------
#---------------------------------------------------------------------------------------------
$link;



// $mail->Body = include();

$body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

$body = $body.'
            <img style="" class="" title="" alt="" src="http://www.wertewirtschaft.org/tools/Erinnerung-Header-01.png" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
            Dear economist,
            <br>
            Thank you for becoming a member.
            <br>
            Please consider supporting us by becoming a paying member. 
            In addition you will get access to our members area. 

                ';

$body = $body.'
            And finally, please click on the link below to redeem your free credit with which you will be able to register for one of our events. 
            <table cellspacing="0" cellpadding="0"> <tr>
            <td align="center" width="300" height="40" bgcolor="#f9f9f9" style="border:1px solid #dcdcdc;color: #ffffff; display: block;">
            <a href="'.$link.'" style="font-size:16px; font-weight: bold; font-family:verdana; text-decoration: none; line-height:40px; width:100%; display:inline-block">
            <span style="color: #000000">
            Click here for membership!
            </span>
            </a></td></tr></table> 
            ';


$body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

$mail->Body = $body;

// $mail->Body = '
// <html>
// <head>
// <meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\'> 
// <style type="text/css"></style>

// <style id="cr_style">
// h1,h2,h3,h4,h5,h6{margin: 0 0 10px 0;}
// .background {
// background-color: #fafafa;
// }
// a {color: #0066ff; }
// .text {
// color: #666666;
// font-size: 12px;
// font-family: verdana;
// }
// body {
// margin: 0pt;
// padding: 0pt;
// background-color: #fafafa;
// width: 100% ! important;
// color: #666666;
// font-size: 12px;
// font-family: verdana;
// }
// </style>

// <meta name="robots" content="noindex,nofollow">
// <title>Erinnerung</title>
// </head>

// <!--BODY-->
// <body leftmargin="0" topmargin="0" offset="0" style="color: rgb(102, 102, 102); font-size: 12px; font-family: arial; margin: 0px; padding: 0px; background-color: rgb(250, 250, 250); width: 100% ! important; cursor: auto;" class="" marginheight="0" marginwidth="0">
// <center>
// <table class="text" cr_edit="Content" style="background-color: #ffffff; border: 1px solid #cccccc" align="center" cellpadding="0" cellspacing="0" width="600">
// <tbody>
// <tr>
// <td cr_edit="Header" style="border: 0px solid #cccccc; background-color: #cccccc;" class="" align="center">
// </td>
// </tr>
// <tr>
// <td valign="top" width="600">
// <table border="0" cellpadding="10" cellspacing="0" width="100%">
// <tbody><tr>
// <td class="text">
// <!--#loop #-->
// <a rel="isset" class="anc_1" name="anc26181" id="anc26181"></a>
// <table class="editable text" border="0" cellpadding="0" cellspacing="0" width="100%">
// <tbody>
// <tr>
// <td align="center">
// <!--#image #-->
// <img style="" class="" title="" alt="" src="http://www.wertewirtschaft.org/tools/Erinnerung-Header-01.png" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
// <!--#/image#-->
// </td>
// </tr>
// </tbody>
// </table>
// <!--#loopsplit#-->
// <a rel="isset" class="anc_1" name="anc81061" id="anc81061"></a><table class="editable text" border="0" width="100%">
// <tbody>
// <tr>
// <td valign="top">

// <div style="text-align: justify;">
// <h2></h2>
// <!--#html #-->
// <span style="font-family: times new roman,times;">
// <span style="font-size: 12pt;">
// <span style="color: #000000;">


// <br>
// Thank you for your membership...<br>
// Here is the link:

// <table cellspacing="0" cellpadding="0"> <tr>
// <td align="center" width="300" height="40" bgcolor="#f9f9f9" style="border:3px solid #dcdcdc;color: #ffffff; display: block;">
// <a href="'.$link.'" style="font-size:16px; font-weight: bold; font-family:verdana; text-decoration: none; line-height:40px; width:100%; display:inline-block">
// <span style="color: #000000">
// Click here to get your ebook
// </span></a></td></tr></table> 

// <strong>

// <!--#/html#-->
// </span>
// </span>
// </span>
// </td>
// </tr>
// </tbody>
// </table>

// <!--#loopsplit#-->
// <a rel="isset" class="anc_1" name="anc46823" id="anc46823"></a><table class="editable text" border="0" width="100%">
// <tbody><tr>
// <td valign="top">
// <div style="text-align: justify;">
// </div>
// </td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// </tbody>
// </table>


// <!--#aboutus #-->
// <table style="font-size: 10px;" border="0" cellpadding="10" cellspacing="0" width="100%">
// <tbody>
// <tr>
// <td cr_edit="footer" class="text" style="font-size:10px" align="center" valign="top">
// Institut f&uuml;r Wertewirtschaft<br> Schl&ouml;sselgasse 19/2/18<br> 1080 Wien<br> &Ouml;sterreich<br>         info@wertewirtschaft.org
// <br> 
// <br> 
// <br> 
// <br> 
// </td>
// </tr>
// </tbody>
// </table>
// <!--#/aboutus#-->
// <br>
// </td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// </tbody>
// </table>
// </center>
// </body>
// </html>
// ';
$mail->isHTML(true);
#---------------------------------------------------------------------------------------------
#------------------END HTML-BODY--------------------------------------------------------------
#---------------------------------------------------------------------------------------------


        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
            return false;
        } else {
            // $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
            $this->messages[] = "Please check your inbox.";
            return true;
        }
    }
#-------------------------------------

    /*
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    public function sendVerificationEmail($user_id, $user_email, $user_activation_hash)
    {
        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }

        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_activation_hash)
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // try to update user with specified information
            $query_update_user = $this->db_connection->prepare('UPDATE mitgliederExt SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();

            if ($query_update_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }
}
