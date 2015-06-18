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


//old - ajax login form handle
/*        } elseif (isset($_POST["fancy_ajax_form_submit"]) and ($_POST["fancy_ajax_form_submit"] === "Eintragen" )) {
        //} elseif (isset($_POST["fancy_ajax_form_submit"]) and (trim($_POST["user_password"]) === "" )) {

            $this->subscribeNewUser($_POST['user_email']);
        }*/

        //register new user
        } elseif (isset($_POST["eintragen_submit"])) {

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
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                $this->errors[] = "this is it";
                return false;
            }
        }
    }   

    //main function to deal with registration of new users
    //initiated when only email is provided
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
                
                //generate a new password
                $user_password = $this->randomPasswordGenerator();

                //encrypt password for storage in the database, so no one would see it in plain text
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

                // generate random hash for email verification (40 char string)
                $user_activation_hash = sha1(uniqid(mt_rand(), true));

                //in case user has lost email with verification, this will allow to attempt registration
                $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
                $query_delete_user->bindValue(':user_email', $user_email, PDO::PARAM_INT);
                $query_delete_user->execute();

                // write new users data into database                
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO grey_user (user_email, Mitgliedschaft, user_password_hash, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_email, :Mitgliedschaft, :user_password_hash, :user_activation_hash, :user_registration_ip, now())');
                #$query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);

                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':Mitgliedschaft', '1', PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                $_SESSION['Mitgliedschaft'] = 1;

                // id of new user
                $grey_user_id = $this->db_connection->lastInsertId();
                $_SESSION['grey_user_id'] = $grey_user_id;

               if ($query_new_user_insert) {
                   // send a verification email
                   if ($this->sendSubscriptionMail($grey_user_id, $user_email, $user_activation_hash, $user_password)) {
                       // when mail has been send successfully
                       $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
                       $this->registration_successful = true;

                   } else {
                       // delete this users account immediately, as we could not send a verification email
                       $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
                       $query_delete_user->bindValue(':user_email', $user_email, PDO::PARAM_INT);
                       $query_delete_user->execute();

                       $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                   }
               } else {
                   $this->errors[] = MESSAGE_REGISTRATION_FAILED;
               }


                #TO-DO: exchange with a custom function to have control over email content
                #$this->subscriptionVerification($user_id,$user_email,$user_activation_hash);



                if ($query_new_user_insert) 
                {
                    #$this->errors[] = "Successfully registered.";
                    // $this->messages[] =
                    


                } else 
                {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }

            }
        }
    }

    //generates a random string of 6 characters used for temporary passwords
    private function randomPasswordGenerator() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  

        $size = strlen( $chars );
        for( $i = 0; $i < 6; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }


    #-------------------------------------
    //send an email to a newly subscribed member, containing password and activation link
    public function sendSubscriptionMail($user_id, $user_email, $user_activation_hash, $user_password)
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

        $mail->From = EMAIL_PASSWORDRESET_FROM;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = "Membership confirmation";

        #verification link
        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);


        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link.' Password: '.$user_password;


        #password reset link
        #$link = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);


        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

    #---------------------------------------------------------------------------------------------
    #------------------HTML-BODY------------------------------------------------------------------
    #---------------------------------------------------------------------------------------------


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
                </span></a></td></tr></table> 
                <strong>And your password is: </strong>'.$user_password.'
                ';


    $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

    $mail->Body = $body;


    $mail->isHTML(true);
    #---------------------------------------------------------------------------------------------
    #------------------END HTML-BODY--------------------------------------------------------------
    #---------------------------------------------------------------------------------------------


            if(!$mail->Send()) {
                $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
                return false;
            } else {
                // $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
                #$this->messages[] = "Please check your inbox.";
                return true;
            }
        }
    #-------------------------------------

    
    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_activation_hash)
    {
        // if database connection opened
        if ($this->databaseConnection()) {

            //verify user - get data that will be inserted in the main database
            $verify_user = $this->db_connection->prepare('SELECT * FROM grey_user WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $verify_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $verify_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $verify_user->execute();

            // get result row (as an object)
            $the_row = $verify_user->fetchObject();

            print_r($the_row);

            //copy data to the main database

            $query_move_to_main = $this->db_connection->prepare('INSERT INTO mitgliederExt (user_email, Mitgliedschaft, user_password_hash, user_registration_ip, user_active, user_registration_datetime) VALUES(:user_email, :Mitgliedschaft, :user_password_hash, :user_registration_ip, :user_active, now())');

            $query_move_to_main->bindValue(':user_email', $the_row->user_email, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':Mitgliedschaft', $the_row->Mitgliedschaft, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_password_hash', $the_row->user_password_hash, PDO::PARAM_STR);
            //$query_move_to_main->bindValue(':user_activation_hash', $the_row->user_activation_hash, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_active', '1', PDO::PARAM_STR);
            $query_move_to_main->execute();


            /*
            $query_update_user = $this->db_connection->prepare('UPDATE mitgliederExt SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();
            */

            $user_id = $this->db_connection->lastInsertId();
            $_SESSION['user_id'] = $user_id;

            $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
            $query_delete_user->bindValue(':user_email', $the_row->user_email, PDO::PARAM_INT);
            $query_delete_user->execute();


            if ($verify_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
                
                $_POST['user_rememberme'] = 1;
                $_SESSION['user_id'] = $user_id;

            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }
}