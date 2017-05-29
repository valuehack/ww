<?php
/**
 * handles the user login/logout/session
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Login
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;

    /*Same as above, only for older way to connect*/
    private $old_db_connect = null;
    /**
     * @var int $user_id The user's id
     */
    private $user_id = null;
    /**
     * @var string $user_name The user's name
     */
    private $user_name = "";
    /**
     * @var string $user_email The user's mail
     */
    private $user_email = "";
    /**
     * @var boolean $user_is_logged_in The user's login status
     */
    private $user_is_logged_in = false;
    /**
     * @var string $user_gravatar_image_url The user's gravatar profile pic url (or a default one)
     */
    public $user_gravatar_image_url = "";
    /**
     * @var string $user_gravatar_image_tag The user's gravatar profile pic url with <img ... /> around
     */
    public $user_gravatar_image_tag = "";
    /**
     * @var boolean $password_reset_link_is_valid Marker for view handling
     */
    private $password_reset_link_is_valid  = false;
    /**
     * @var boolean $password_reset_was_successful Marker for view handling
     */
    private $password_reset_was_successful = false;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */

    public function __construct()
    {
        // create/read session

        if(session_id() == '') session_start();

        // session_start();


        // TODO: organize this stuff better and make the constructor very small
        // TODO: unite Login and Registration classes ?

        // check the possible login actions:
        // 1. logout (happen when user clicks logout button)
        // 2. login via session data (happens each time user opens a page on your php project AFTER he has successfully logged in via the login form)
        // 3. login via cookie
        // 4. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
        //    logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.

        $this->oldDatabaseConnection();
        $this->databaseConnection();

        // if user tried to log out
        if (isset($_GET["logout"])) {
            $this->doLogout();

        // if user has an active session on the server
        } elseif (!empty($_SESSION['user_email']) && ($_SESSION['user_logged_in'] == 1)) {
            $this->loginWithSessionData();

            // checking for form submit from editing screen
            // user try to change his username
            if (isset($_POST["user_edit_profile_submit"])) {

                $this->editProfile($_POST['profile']);

            // user try to change his email
            } elseif (isset($_POST["user_edit_submit_email"])) {
                // function below uses use $_SESSION['user_id'] et $_SESSION['user_email']
                $this->editUserEmail($_POST['user_email']);
            // user try to change his password
            } elseif (isset($_POST["user_edit_submit_password"])) {
                // function below uses $_SESSION['user_name'] and $_SESSION['user_id']
                $this->editUserPassword($_POST['user_password_old'], $_POST['user_password_new'], $_POST['user_password_repeat']);
            }elseif (isset($_POST["upgrade_user_account"])) {

                // function below uses $_SESSION['user_name'] and $_SESSION['user_id']
                #$this->errors[] = "this is working now";
                $this->upgradeUserAccount($_POST['betrag'], $_POST['zahlung'], $_POST['level'], $_POST['profile'], $_POST['source']);
            }elseif (isset($_POST["select_events"])) {
                #check the differences in arrays  
                $this->doEventStuff($_POST['events']);

            }elseif (isset($_POST["select_projects"])) {
                #check the differences in arrays  
                $this->projectify($_POST['projects']);

            }elseif (isset($_POST["user_edit_submit_name"])) { 
                $this->editUserName($_POST['user_first_name'], $_POST['user_surname']);
               
            }elseif (isset($_POST["user_edit_submit_address"])) {
 
                // $this->doEventStuff($_POST['events']);
                $this->editUserAddress($_POST['user_country'], $_POST['user_city'],$_POST['user_street'], $_POST['user_plz']);               
            }elseif (isset($_POST["user_edit_form_level"])) {
 
                $this->editUserLevel($_POST['user_level']);
            }elseif (isset($_POST['register_open_salon'])) {
            	
				$this->registerOpenSalon($_POST['profile'], $_POST['profile']['event_id'], $_POST['profile']['quantity']);
            }elseif (isset($_POST['oneClickReg'])) {
            	$product = $_POST['product'];
            	$this->oneClickReg($product);
            } elseif (isset($_POST["themenwahl_submit"])) {
            	#Abstimmung Themenwahl
            	$this->voteThemenwahl($_POST['themenwahl']);
            } elseif (isset($_POST["suggestion_submit"])) {
            	#Vorschlag Themenwahl
            	$this->suggestionThemenwahl($_POST['suggestion']);
            } elseif (isset($_POST["comment_submit"])) {
            	#Kommentar Themenwahl
            	$this->commentThemenwahl($_POST['comment']);
            } elseif (isset($_POST["edit_comment_submit"])) {
            	#Bearbeiten Kommentar Themenwahl
            	$this->EditComment($_POST['edited_comment']);
            } elseif (isset($_POST["delete_comment_submit"])) {
            	#Löschen Kommentar Themenwahl
            	$this->DeleteComment($_POST['deleted_comment']);
            }
			
        }
        // login with cookie
        elseif (isset($_POST['user_rememberme'])) {
            $this->newRememberMeCookie();

            #used to refresh page for logging in with a cookie
            header("Location:http://www.scholarium.at/");
        }

        // if user just submitted a login form
        // registerform comes from this single ajax form
/*        elseif (isset($_POST["fancy_ajax_form_submit"]) and ($_POST["fancy_ajax_form_submit"] === "Anmelden" )) {
 
            // if (isset($_POST['user_email']) and !(trim($_POST['user_password']) === "")) {
            $this->loginWithPostData($_POST['user_email'], $_POST['user_password'], 1);
            // }
            
        } */
        //login with email and password
        elseif (isset($_POST["anmelden_submit"])) {
 			
            // if (isset($_POST['user_email']) and !(trim($_POST['user_password']) === "")) {
            $this->loginWithPostData($_POST['user_email'], $_POST['user_password'], 1);
			
            // }
        } 
        #elseif (true) {  
        elseif (isset($_COOKIE['rememberme'])) {  
            $this->loginWithCookieData();
            #$this->errors[] = "there is a cookie";

        }

        // checking if user requested a password reset mail
        if (isset($_POST["request_password_reset"]) && isset($_POST['user_email'])) {
            $this->setPasswordResetDatabaseTokenAndSendMail($_POST['user_email']);

        } elseif (isset($_GET["user_email"]) && isset($_GET["verification_code"])) {
            $this->checkIfEmailVerificationCodeIsValid($_GET["user_email"], $_GET["verification_code"]);

        } elseif (isset($_POST["submit_new_password"])) {
            $this->editNewPassword($_POST['user_email'], $_POST['user_password_reset_hash'], $_POST['user_password_new'], $_POST['user_password_repeat']);
        }

        // get gravatar profile picture if user is logged in
        if ($this->isUserLoggedIn() == true) {
            $this->getGravatarImageUrl($this->user_email);
        }
    }

    /**
     * Checks if database connection is opened. If not, then this method tries to open it.
     * @return bool Success status of the database connecting process
     */
    private function databaseConnection()
    {
        // if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                #$this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);

                #using utf8 charset instead of latin1
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                
                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
                $query_time_zone->execute();
                
                return true;
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
                #echo "error! <br>".$e->getMessage();;
            }
        }
        // default return
        return false;
    }

/*
old school database connect
*/
    private function oldDatabaseConnection()
    {
        // if connection already exists
        if ($this->old_db_connect != null) {
            return true;
        } else {
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->old_db_connect = @mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
				mysql_set_charset('utf8', $this->old_db_connect);
                mysql_select_db(DB_NAME);

                return true;
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
                #echo "error! <br>".$e->getMessage();;
            }
        }
        // default return
        return false;
    }


    /**
     * Search into database for the user data of user_name specified as parameter
     * @return user data as an object if existing user
     * @return false if user_name is not found in the database
     * TODO: @devplanete This returns two different types. Maybe this is valid, but it feels bad. We should rework this.
     * TODO: @devplanete After some resarch I'm VERY sure that this is not good coding style! Please fix this.
     */
    public function getUserData($user_email)
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // database query, getting all the info of the selected user
            $query_user = $this->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_email = :user_email');
            $query_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_user->execute();
            // get result row (as an object)
            return $query_user->fetchObject();
        } else {
            return false;
        }
    }

    public function giveCredits()
    {

    $user_email = $_SESSION['user_email'];

    $give_credits_query = "UPDATE mitgliederExt SET credits_left = credits_left + 1, gave_credits = 1 WHERE user_email LIKE '$user_email'";
    mysql_query($give_credits_query);

    $this->sendGivenCreditsMail();

    $this->messages[] = 'Unterst&uuml;tzung erfolgreich ausgew&auml;hlt.';


    // $query_edit_user_profile = "UPDATE mitgliederExt SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
    // $edit_user_profile_result = mysql_query($query_edit_user_profile) or die("Failed Query of " . $query_edit_user_profile.mysql_error());

    }


/*
GET user data using old database connection
*/






    /**
     * Logs in with S_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     */
    private function loginWithSessionData()
    {
    	error_log('User was logged in with session data');
        #$this->user_name = $_SESSION['user_name'];
        $this->user_email = $_SESSION['user_email'];

        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
    }

    /**
     * Logs in via the Cookie
     * @return bool success state of cookie login
     */
    private function loginWithCookieData()
    {
    	error_log('User was logged in with cookie data');
        if (isset($_COOKIE['rememberme'])) {
        	error_log('Cookie is set');
            // extract data from the cookie
            list ($user_id, $token, $hash) = explode(':', $_COOKIE['rememberme']);
            // check cookie hash validity
            if ($hash == hash('sha256', $user_id . ':' . $token . COOKIE_SECRET_KEY) && !empty($token)) {
            	error_log('Cookie is valid');
                // cookie looks good, try to select corresponding user
                if ($this->databaseConnection()) {
                    // get real token from database (and all other data)
                    $sth = $this->db_connection->prepare("SELECT * FROM mitgliederExt WHERE user_id = :user_id
                                                      AND user_rememberme_token = :user_rememberme_token AND user_rememberme_token IS NOT NULL");
                    $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $sth->bindValue(':user_rememberme_token', $token, PDO::PARAM_STR);
                    $sth->execute();
                    // get result row (as an object)
                    $result_row = $sth->fetchObject();

                    if (isset($result_row->user_id)) {
                        // write user data into PHP SESSION [a file on your server]
                        $_SESSION['user_id'] = $result_row->user_id;
                        #$_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['credits_left'] = $result_row->credits_left;
                        $_SESSION['user_logged_in'] = 1;
                        #MOD
                        #$_SESSION['user_level'] = $result_row->user_level;
                        $_SESSION['Mitgliedschaft'] = $result_row->Mitgliedschaft;

                        // declare user id, set the login status to true
                        $this->user_id = $result_row->user_id;
                        #$this->user_name = $result_row->user_name;
                        $this->user_email = $result_row->user_email;
                        $this->user_is_logged_in = true;

                        $user_email = $result_row->user_email;

                        #update last_login_time to now
                        $query_login_time = $this->db_connection->prepare('UPDATE mitgliederExt SET last_login_time = NOW() WHERE user_email = :user_email LIMIT 1');
                        $query_login_time->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                        $query_login_time->execute();

                        // Cookie token usable only once
                        $this->newRememberMeCookie();
                        return true;
                    }
                }
            }
			error_log('Cookie is not valid');
            // A cookie has been used but is not valid... we delete it
            $this->deleteRememberMeCookie();
            $this->errors[] = MESSAGE_COOKIE_INVALID;
        }
        $this->errors[] = "Cookie nicht gesetzt";
        return false;
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $user_name
     * @param $user_password
     * @param $user_rememberme
     */
    private function loginWithPostData($user_email, $user_password, $user_rememberme)
    {
		error_log('User was logged in with post data');
        $user_password = trim($user_password);

        if (empty($user_email)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } else if (empty($user_password)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;

        // if POST data (from login form) contains non-empty user_name and non-empty user_password
        } else {
            // user can login with his username or his email address.
            // if user has not typed a valid email address, we try to identify him with his user_name
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                // database query, getting all the info of the selected user
                $result_row = $this->getUserData(trim($user_email));

            // if user has typed a valid email address, we try to identify him with his user_email
            } else if ($this->databaseConnection()) {
                // database query, getting all the info of the selected user
                $query_user = $this->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_email = :user_email');
                $query_user->bindValue(':user_email', trim($user_email), PDO::PARAM_STR);
                $query_user->execute();
                // get result row (as an object)
                $result_row = $query_user->fetchObject();
            }

            // if this user not exists
            if (! isset($result_row->user_id)) {
                // was MESSAGE_USER_DOES_NOT_EXIST before, but has changed to MESSAGE_LOGIN_FAILED
                // to prevent potential attackers showing if the user exists
                $this->errors[] = MESSAGE_LOGIN_FAILED;
            } else if (($result_row->user_failed_logins >= 3) && ($result_row->user_last_failed_login > (time() - 30))) {
                $this->errors[] = MESSAGE_PASSWORD_WRONG_3_TIMES;
            
            // has the user activated their account with the verification email
            } else if ($result_row->user_active != 1) {
                $this->errors[] = MESSAGE_ACCOUNT_NOT_ACTIVATED;

            // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
            } else if (! password_verify($user_password, $result_row->user_password_hash)) {
                // increment the failed login counter for that user
                $sth = $this->db_connection->prepare('UPDATE mitgliederExt '
                        . 'SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login '
                        . 'WHERE user_email = :user_email OR user_email = :user_email');
                $sth->execute(array(':user_email' => $user_email, ':user_last_failed_login' => time()));

                $this->errors[] = MESSAGE_PASSWORD_WRONG;
            
            
            } else {
                #this is a successful login

                // write user data into PHP SESSION [a file on your server]
                $_SESSION['user_id'] = $result_row->user_id;
                #$_SESSION['user_name'] = $result_row->user_name;
                $_SESSION['user_email'] = $result_row->user_email;
                $_SESSION['credits_left'] = $result_row->credits_left;
                $_SESSION['user_logged_in'] = 1;
                #MOD
                // $_SESSION['user_level'] = $result_row->user_level;
                $_SESSION['Mitgliedschaft'] = $result_row->Mitgliedschaft;

                // declare user id, set the login status to true
                $this->user_id = $result_row->user_id;
                #$this->user_name = $result_row->user_name;
                $this->user_email = $result_row->user_email;
                $this->user_is_logged_in = true;

                #update last_login_time to now and set password reminder to 0
                $query_login_time = $this->db_connection->prepare('UPDATE mitgliederExt '
                        . 'SET last_login_time = NOW(), reminded = 0 '
                        . 'WHERE user_email = :user_email LIMIT 1');
                $query_login_time->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_login_time->execute();

                // reset the failed login counter for that user
                $sth = $this->db_connection->prepare('UPDATE mitgliederExt '
                        . 'SET user_failed_logins = 0, user_last_failed_login = NULL '
                        . 'WHERE user_id = :user_id AND user_failed_logins != 0');
                $sth->execute(array(':user_id' => $result_row->user_id));

                #every successful login with post data creates a cookie

                // if user has check the "remember me" checkbox, then generate token and write cookie
                // if (isset($user_rememberme)) {
                       $this->newRememberMeCookie();
                //     #$this->errors[] = "A new cookie has been created.";
                // } else {
                //     // Reset remember-me token
                //     $this->deleteRememberMeCookie();
                // }

                // OPTIONAL: recalculate the user's password hash
                // DELETE this if-block if you like, it only exists to recalculate users's hashes when you provide a cost factor,
                // by default the script will use a cost factor of 10 and never change it.
                // check if the have defined a cost factor in config/hashing.php
                if (defined('HASH_COST_FACTOR')) {
                    // check if the hash needs to be rehashed
                    if (password_needs_rehash($result_row->user_password_hash, PASSWORD_DEFAULT, array('cost' => HASH_COST_FACTOR))) {

                        // calculate new hash with new cost factor
                        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => HASH_COST_FACTOR));

                        // TODO: this should be put into another method !?
                        $query_update = $this->db_connection->prepare('UPDATE mitgliederExt SET user_password_hash = :user_password_hash WHERE user_id = :user_id');
                        $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                        $query_update->bindValue(':user_id', $result_row->user_id, PDO::PARAM_INT);
                        $query_update->execute();

                        if ($query_update->rowCount() == 0) {
                            // writing new hash was successful. you should now output this to the user ;)
                        } else {
                            // writing new hash was NOT successful. you should now output this to the user ;)
                        }
                    }
                }
            }
        }
    }

    /**
     * Create all data needed for remember me cookie connection on client and server side
     */
    public function newRememberMeCookie()
    {
		error_log('A new cookie is going to be set');

        // if database connection opened
        if ($this->databaseConnection()) {        	
            // generate 64 char random string and store it in current user data
            $random_token_string = hash('sha256', mt_rand());
            $sth = $this->db_connection->prepare("UPDATE mitgliederExt SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id");
            $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $_SESSION['user_id']));

            // generate cookie string that consists of userid, randomstring and combined hash of both
            $cookie_string_first_part = $_SESSION['user_id'] . ':' . $random_token_string;
            $cookie_string_hash = hash('sha256', $cookie_string_first_part . COOKIE_SECRET_KEY);
            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

            // set cookie
            #setcookie('rememberme', $cookie_string, time() + 3600, "/", COOKIE_DOMAIN);
            #cookie expiration is set to 3 years (seconds*minutes*hoursday*daysinayear*years)
            if (setcookie('rememberme', $cookie_string, time() + (60*60*24*365*3), "/") === TRUE) {
            	error_log('Cookie set');
            }
			else {
				error_log('The Error is here');
			};
        }
		else {
		error_log('No cookie set because there is no connection');
		}
    }

    /**
     * Delete all data needed for remember me cookie connection on client and server side
     */
    private function deleteRememberMeCookie()
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // Reset rememberme token
            $sth = $this->db_connection->prepare("UPDATE mitgliederExt SET user_rememberme_token = NULL WHERE user_id = :user_id");
            $sth->execute(array(':user_id' => $_SESSION['user_id']));
        }

        // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obviously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320

        #setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);
        setcookie('rememberme', false, time() - (3600 * 3650), '/');
    }

    /**
     * Perform the logout, resetting the session
     */
    public function doLogout()
    {
        $this->deleteRememberMeCookie();

        $_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        //$this->messages[] = MESSAGE_LOGGED_OUT;
    }

    /**
     * Simply return the current state of the user's login
     * @return bool user's login status
     */
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }

public function getUserEvents()
{

    $this->oldDatabaseConnection();

    $user_id = $_SESSION['user_id'];

    $user_events_query = "SELECT * from registration WHERE `user_id` LIKE '%$user_id%'";

    $user_events_result = mysql_query($user_events_query) or die("Failed Query of " . $user_events_query. mysql_error());


    $userEventArray = array();
    while ($entry = mysql_fetch_array($user_events_result))
    {

        array_push($userEventArray, $entry[event_id]);
        # echo "User event: ".$entry[event_id]."<br>";

    }


    return $userEventArray;



// $stack = array("orange", "banana");
// array_push($stack, "apple", "raspberry");




}

# adjustment of function registerForEvents for the new checkout process by Bernhard Hegyi
//function not used at the moment, the script is inside korb.php
public function checkout ($items)
{
    $user_id = $_SESSION['user_id'];
   
    $user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '$user_id' ";
    $user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

    $userCreditsArray = mysql_fetch_array($user_credits_result);
    $userCredits = $userCreditsArray[credits_left];

    $_SESSION['credits_left'] = $userCredits;

    mysql_query("SET time_zone = 'Europe/Vienna'");

    $itemsPrice = 0;
    foreach ($items as $key => $quantity) 
    {
        $items_price_query = "SELECT * from termine WHERE `id` LIKE '$key'";
        $items_price_result = mysql_query($items_price_query) or die("Failed Query of " . $items_price_query. mysql_error());
        $itemsPriceArray = mysql_fetch_array($items_price_result);
        $itemsPriceSum = $quantity * $itemsPriceArray[event_price];
        $itemsPrice += $itemsPriceSum;
    }

    if (!($userCredits >= $itemsPrice)) {
        //$this->errors[] = "You do not have enough credits to buy the items in your basket.";
        //error message does not work, alternate message above
        //echo "<div style='text-align:center'><hr><i>You do not have enough credits to buy the items in your basket.</i><hr><br></div>";
        echo 'Ihr Guthaben reicht leider nicht aus.';
        }

        else 
        {
        foreach ($items as $key => $quantity) 
                {      
                    $checkout_query = "INSERT INTO registration (event_id, user_id, quantity, reg_datetime) VALUES ('$key', '$user_id', '$quantity', NOW())";
                    mysql_query($checkout_query);

                    $credits_left = $userCredits - $itemsPrice;

                    $left_credits_query = "UPDATE mitgliederExt SET credits_left='$credits_left' WHERE `user_id` LIKE '$user_id'";
                    mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

                    $space_query = "UPDATE termine SET spots_sold = spots_sold + '$quantity' WHERE `id` LIKE '$key'";
                    mysql_query($space_query);
                
                }
        
        echo "<b>You bought the following items:</b><br>";
        echo "<hr><table style='width:100%'><tr><td style='width:5%'><b>ID</b></td>";
        echo "<td style='width:55%'><b>Name</b></td>";
        echo "<td style='width:10%'><b>Quantity</b></td>";
        echo "<td style='width:10%'>&nbsp;</td></tr>";

        foreach ($items as $key => $quantity) {
            $items_extra_query = "SELECT * from termine WHERE `id` LIKE '$key' ORDER BY start DESC";
            $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
            $itemsExtraArray = mysql_fetch_array($items_extra_result);
            
            $sum = $quantity*$itemsExtraArray[event_price];
            $download_link = '<a href="<?php downloadurl(\'http://www.scholarium.at/secdown/sec_files/'.$key.'.pdf\',\''.$key.'\'); ?>" onclick="updateReferer(this.href);">Download</a>';

            echo "<tr><td>".$itemsExtraArray[id]."&nbsp</td>";
            echo "<td><i>".ucfirst($itemsExtraArray[type])."</i> ".$itemsExtraArray[title]." <i>".$itemsExtraArray[format]."</i></td>";
            echo "<td>&nbsp; &nbsp;".$quantity."</td>";
            echo "<td>".$download_link."</td></tr>";
           
            // TO DO: Find better solution to display the relevant information for different product categories  
            if (!(is_null($itemsExtraArray[start]))) {
                echo "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]));
                if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]))."</td></tr>";
            }       
        }
        
        echo "</table><hr>";

        //delete bought items from session variable
        unset($_SESSION['basket']);


                //$this->sendEventRegMail($items);
        }
}


#
public function registerForEvents($events)
{
        # echo "$input[0] + $input[1]";
   # echo "smth";


    #$user_id = $_SESSION['user_id'];

    #$reg_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";

#should check for credits... 
#i need credits available from user database
#the price of all selected events from events database




// credits_left

// $userCredits = select from user database
// $eventsPrice = with a for loop check event ids and add up the price
$user_id = $_SESSION['user_id'];

$user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";
$user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

$userCreditsArray = mysql_fetch_array($user_credits_result);
$userCredits = $userCreditsArray[credits_left];

$_SESSION['credits_left'] = $userCredits;

// echo $userCredits;

    $eventsPrice = 0;
    foreach ($events as $event_id) 
    {
        $events_price_query = "SELECT * from termine WHERE `id` LIKE '%$event_id%'";
        $events_price_result = mysql_query($events_price_query) or die("Failed Query of " . $events_price_query. mysql_error());
        $eventsPriceArray = mysql_fetch_array($events_price_result);
        $eventsPrice += $eventsPriceArray[event_price];
    }

    // echo $eventsPrice;

#iterate array of event ids and do the queries 
#insert in registration database event id + user id 
#take user id from session var


    if (!($userCredits >= $eventsPrice)) $this->errors[] = "You do not have enough credits to register for events.";
    else 
    {
        foreach ($events as $event_id) 
        {      
            $reg_query = "INSERT INTO registration (event_id, user_id) VALUES ('$event_id', '$user_id')";
            mysql_query($reg_query);

            $creditsLeft = $userCredits - $eventsPrice;

            $left_credits_query = "UPDATE mitgliederExt SET credits_left='$creditsLeft' WHERE `user_id` LIKE '$user_id'";
            mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

            $space_query = "UPDATE termine SET spots_sold = spots_sold + 1 WHERE `id` LIKE '$event_id'";
            mysql_query($space_query);
        }

        $this->sendEventRegMail($events);

        //send confirmation email


        #$reg_result = mysql_query($reg_query) or die("Failed Query of " . $query. mysql_error());

        // while ($entry = mysql_fetch_array($reg_result))
        // {
        //     #var_dump( $entry );
        //     echo "User id: ".$entry[user_id]."<br>";
        //     echo "Membership: ".$entry[Mitgliedschaft]."<br>";
        //     echo "Email: ".$entry[user_email];
        // }
    }

}



#now we gonna cancel some events
#--------------------------------------
public function cancelEvents($events)
{
        # echo "$input[0] + $input[1]";

    #$user_id = $_SESSION['user_id'];

    #$reg_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";

#iterate array of event ids and do the queries 
#insert in registration database event id + user id 
#take user id from session var
$user_id = $_SESSION['user_id'];

    foreach ($events as $event_id) 
    {
        #echo "smth bla bla"; 
        #echo $_SESSION['user_id'];
        #echo "event: ".$event."<br>";
        
// delete from orders 
// where id_users = 1 and id_product = 2
// limit 1

// WHERE `event_id` LIKE '%$event_id%' AND `user_id` LIKE '%$user_id%' ""

    $cancel_query = "DELETE FROM registration WHERE `event_id` LIKE '%$event_id%' AND `user_id` LIKE '%$user_id%'";
    mysql_query($cancel_query);

    #check event price 
    $event_price_query = "SELECT * from termine WHERE `id` LIKE '$event_id'";
    $event_price_result = mysql_query($event_price_query) or die("Failed Query of " . $event_price_query. mysql_error());
    $eventPriceArray = mysql_fetch_array($event_price_result);
    $creditsBack += $eventPriceArray[event_price];

    #add the price to the users credits_left
    $space_query = "UPDATE termine SET spots_sold = spots_sold - 1 WHERE `id` LIKE '$event_id'";
    mysql_query($space_query);


    }

    $user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";
    $user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());
    $userCreditsArray = mysql_fetch_array($user_credits_result);
    $userCredits = $userCreditsArray[credits_left];

    $creditsBack += $userCredits;

    $_SESSION['credits_left'] = $creditsBack;

    $add_credits_query = "UPDATE mitgliederExt SET credits_left='$creditsBack' WHERE `user_id` LIKE '$user_id'";
    mysql_query($add_credits_query) or die("Failed Query of " . $add_credits_query. mysql_error());

    #$reg_result = mysql_query($reg_query) or die("Failed Query of " . $query. mysql_error());

    // while ($entry = mysql_fetch_array($reg_result))
    // {
    //     #var_dump( $entry );
    //     echo "User id: ".$entry[user_id]."<br>";
    //     echo "Membership: ".$entry[Mitgliedschaft]."<br>";
    //     echo "Email: ".$entry[user_email];
    // }

}

private function doEventStuff($eventsPostArray)
{

    #echo "This is working too.";
    $userArray = $this->getUserEvents();


    #do the comparison of the arrays which will indicate if events should be added or canceled from the db

// echo count($userArray);

// echo count($eventsPostArray);

            // if ($eventsPostArray > $userArray)
            // {
            // #do register

            // $eventToRegister = array_diff($eventsPostArray, $userArray);

            //     $this->registerForEvents($eventToRegister);
            // // echo "testing";
            //     // foreach ($eventToRegister as $temp) 
            //     // {
            //     // }


            // }
            // elseif ($eventsPostArray < $userArray)
            // {
            // #cancel events
            //     $eventToCancel = array_diff($userArray, $eventsPostArray);
            //     $this->cancelEvents($eventToCancel);
            // }

// $testArray = array();
// if (empty($testArray)) echo "array is empty";

// to keep php happy make sure that aray diff does not get an empty array

if (empty($eventsPostArray)) $this->cancelEvents($userArray);

// $eventToRegister = array_diff($eventsPostArray, $userArray);
// if (!empty($eventToRegister)) $this->registerForEvents($eventToRegister);

// $eventToCancel = array_diff($userArray, $eventsPostArray);


// if (empty($eventsPostArray)) $eventToRegister = $userArray;
// else $eventToRegister = array_diff($eventsPostArray, $userArray);

//if $eventsPostArray is empty then php is not happy and throws error
if (!empty($eventsPostArray))
{
    $eventToRegister = array_diff($eventsPostArray, $userArray);

    $eventToCancel = array_diff($userArray, $eventsPostArray);
}


if (!empty($eventToRegister)) 
{
    $this->registerForEvents($eventToRegister);
    // print_r($eventToRegister);
}

// if (empty($eventsPostArray)) $eventToCancel = $userArray;
// else $eventToCancel = array_diff($userArray, $eventsPostArray);



// $eventToCancel = array_diff($userArray, $eventsPostArray);

        if (!empty($eventToCancel)) 
        {
            $this->cancelEvents($eventToCancel);
        }    
        elseif (empty($eventToCancel)) 
        {
            #$this->cancelEvents($userArray);
        }


}

/*
Update for projects
*/
public function projectify($projects)
{

$user_id = $_SESSION['user_id'];

$user_credits_query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";
$user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

$userCreditsArray = mysql_fetch_array($user_credits_result);
$userCredits = $userCreditsArray[credits_left];

$_SESSION['credits_left'] = $userCredits;


    $eventsPrice = 0;
    foreach ($projects as $event_id) 
    {
        $events_price_query = "SELECT * from termine WHERE `id` LIKE '%$event_id%'";
        $events_price_result = mysql_query($events_price_query) or die("Failed Query of " . $events_price_query. mysql_error());
        $eventsPriceArray = mysql_fetch_array($events_price_result);
        $eventsPrice += $eventsPriceArray[event_price];
    }

    if (!($userCredits >= $eventsPrice)) $this->errors[] = "You do not have enough credits to donate to projects.";
    else 
    {
        foreach ($projects as $event_id) 
        {      
            $reg_query = "INSERT INTO registration (event_id, user_id) VALUES ('$event_id', '$user_id')";
            mysql_query($reg_query);

            $creditsLeft = $userCredits - $eventsPrice;

            $left_credits_query = "UPDATE mitgliederExt SET credits_left='$creditsLeft' WHERE `user_id` LIKE '$user_id'";
            mysql_query($left_credits_query) or die("Failed Query of " . $left_credits_query. mysql_error());

            $space_query = "UPDATE termine SET spots_sold = spots_sold + 1 WHERE `id` LIKE '$event_id'";
            mysql_query($space_query);
        }

        // $this->sendEventRegMail($events);

    }

}


/*
function to send email if user registered to some events.
*/
public function sendEventRegMail($events)
    {
        $mail = new PHPMailer;

        $user_email = $_SESSION['user_email'];

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

        $mail->From = "info@scholarium.at";
        $mail->FromName = "scholarium";
        $mail->AddAddress($user_email);
        $mail->Subject = 'Anmeldung';
        
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                    Sie haben sich erfolgreich f&uuml;r unsere Veranstaltung angemeldet. 
                        ';

        // $body = $body.'
        //             <table cellspacing="0" cellpadding="0"> <tr>
        //             <td align="center" width="300" height="40" bgcolor="#f9f9f9" style="border:1px solid #dcdcdc;color: #ffffff; display: block;">
        //             <a href="'.$link.'" style="font-size:10px; font-weight: bold; font-family:verdana; text-decoration: none; line-height:40px; width:100%; display:inline-block">
        //             <span style="color: #000000">
        //             Password reset
        //             </span>
        //             </a></td></tr></table> 
        //             ';

        foreach ($events as $event_id) 
        { 
            $body = $body.' '.$event_id.'<br>';
        }

        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);


        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
            return false;
        } else {
            $this->messages[] = 'Eine Nachricht wurde an Sie versandt.';
            return true;
        }
    }



#upgradeUserAccount
#upgrade only will send an email just like before after things were made 
#and it will be upgraded manualy for the level of membership and credits
#the actual details should be added through edit user details 
public function upgradeUserAccount($betrag, $zahlung, $level, $profile, $source)
{
   /*
   if ($login->isUserLoggedIn() == false) {
        //create new user
   }
    */

//set cookie to see if the credits were already given (problem: if upgrade form gets refreshed, more credits are added)
if (!isset($_COOKIE['gaveCredits'])) {
    setcookie("gaveCredits", true, time()+3600*24*1);  /* expire in 1 Days */

    
    if ($_SESSION['user_email']) $user_email = $_SESSION['user_email'];
    else $user_email = $profile[user_email];
   

   switch ($betrag) {
        case 75:
            $Mitgliedschaft = 2;
            break;
        case 150:
            $Mitgliedschaft = 3;
            break;
		case 990:
            $Mitgliedschaft = 3;
            break;
        case 300:
            $Mitgliedschaft = 4;
            break;
        case 600:
            $Mitgliedschaft = 5;
            break;
        case 1200:
            $Mitgliedschaft = 6;
            break;
        case 2400:
            $Mitgliedschaft = 7;
            break;
        default: 
            $Mitgliedschaft = 1;
            break;
        }
        
        $editProfile = 0;
        if ($_SESSION['Mitgliedschaft'] == 1) $editProfile = 1;

        $upgrade_query = "UPDATE mitgliederExt SET Mitgliedschaft = '$Mitgliedschaft', Mahnstufe = 1, Ablauf = DATE_ADD(CURDATE(), INTERVAL 1 YEAR)  WHERE `user_email` LIKE '$user_email'";
        $upgrade_result = mysql_query($upgrade_query) or die("Failed Query of " . $upgrade_query. mysql_error());
        $_SESSION['Mitgliedschaft'] = $Mitgliedschaft;

        if ($source == 2) {
            $newCredits = 25;
        }

        elseif ($source == 3) {
            $newCredits = 0;
        }

        else {
            $user_credits_query = "SELECT * from mitgliederExt WHERE `user_email` LIKE '$user_email' ";
            $user_credits_result = mysql_query($user_credits_query) or die("Failed Query of " . $user_credits_query. mysql_error());

            $userCreditsArray = mysql_fetch_array($user_credits_result);
            $userCredits = $userCreditsArray[credits_left];
            $newCredits = $userCredits + $betrag;
        }
        
//date from now - 1 year
//DATE_ADD(NOW(), INTERVAL ? MONTH)
//date = DATE_ADD(date, INTERVAL 1 YEAR)

        $upgrade_query = "UPDATE mitgliederExt SET credits_left = '$newCredits', Mahnstufe = 1, Ablauf = DATE_ADD(CURDATE(), INTERVAL 1 YEAR) WHERE `user_email` LIKE '$user_email'";
        $upgrade_result = mysql_query($upgrade_query) or die("Failed Query of " . $upgrade_query. mysql_error());

        $this->sendUpgradeMailToUser($betrag, $zahlung, $level);
        $this->sendUpgradeMailToInstitute($betrag, $zahlung, $level);

        if ($editProfile == 1) {
            $this->editProfile($profile);
        }
        
        $this->messages[] = 'Unterst&uuml;tzung erfolgreich gespeichert. Bitte achten Sie auf korrekte Zahlungsdurchf&uuml;hrung und pr&uuml;fen Sie Ihren Posteingang - '. $user_email;

} 
else {
    $this->messages[] = 'Das Unterst&uuml;tzungs-Formular wurde bereits gesendet.';
}

}

/**/
public function sendUpgradeMailToUser($betrag, $zahlung, $level)
    {
        $level_html = htmlentities($level, ENT_QUOTES, "ISO-8859-1");
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

        $user_email = $_SESSION['user_email'];
        $user_id = $_SESSION['user_id'];

        $mail->From = "info@scholarium.at";
        $mail->FromName = "scholarium";
        $mail->AddAddress($user_email);
        $mail->Subject = 'Unterstuetzung';

        $link    = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body .='
            <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
            Lieber Gast,
            <br><br>
            Vielen Dank f&uuml;r Ihre Unterst&uuml;tzung! Sie sind nun <b>'.$level_html.'</b>.<br> 
            <br>';



        switch ($zahlung) {

        case "bar":   
        $body .="<p>Bitte schicken Sie uns den gew&auml;hlten Betrag von ".$betrag."  &euro; in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an Scholarium, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich im scholarium (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.</p>";
            break;

        case "kredit":
#this does not work in the email/ paypal complains
        $body .="<p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR ".$payment_amount." per Paypal.</p><br>";

/*            <div align="center">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" name="paypal">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="info@wertewirtschaft.org">
            <input type="hidden" name="item_name" value="Spende Nr.'.$user_id.'">
            <input type="hidden" name="amount" value="<?php=$betrag?>">
            <input type="hidden" name="shipping" value="0">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="tax" value="0">
            <input type="hidden" name="bn" value="PP-BuyNowBF">
            <input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but6.gif" border="0" name="submit" alt="" style="border:none">
            <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
            </form>
            </div>
            ';*/

        break;

        case "bank":

        $body .= "
        <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR ".$betrag." an:</p>
        <p>
        <ul>
        <li>scholarium</li>
        <li>Erste Bank, Wien/&Ouml;sterreich</li>
        <li>IBAN: AT27 2011 1827 1589 8503</li>
        <li>BIC: GIBAATWWXXX</li>
        </ul></p>


        <p><b>Bitte verwenden Sie als Zahlungsreferenz/Betreff unbedingt &quot;Spende Nr. ".$user_id."&quot;</b></p>
        ";

            break;

        default: 
            #some text in here if all above fails
            break;
        }

/*        $body = $body.'
                    <table cellspacing="0" cellpadding="0"> <tr>
                    <td align="center" width="300" height="40" bgcolor="#f9f9f9" style="border:1px solid #dcdcdc;color: #ffffff; display: block;">
                    <a href="'.$link.'" style="font-size:10px; font-weight: bold; font-family:verdana; text-decoration: none; line-height:40px; width:100%; display:inline-block">
                    <span style="color: #000000">
                    Password reset
                    </span>
                    </a></td></tr></table> 
                    ';*/


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);

        if(!$mail->Send()) $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;


    }

/**/
public function sendUpgradeMailToInstitute($betrag, $zahlung, $level)
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

        $mail->From = "info@scholarium.at";
        $mail->FromName = "scholarium";
        $mail->AddAddress("dzainius@gmail.com");
        $mail->AddAddress("info@scholarium.at");
        $mail->Subject = 'user upgrade';

        $link    = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        
        $body = 'User '.$_SESSION['user_email'].' möchte auf Stufe '.$level.' unterstützen, Zahlung: '.$zahlung;

        $mail->Body = $body;

        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

        if(!$mail->Send()) $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
    }

    /**/
    public function sendGivenCreditsMail()
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

        $user_email = $_SESSION['user_email'];

        $mail->From = "info@scholarium.at";
        $mail->FromName = "scholarium";
        $mail->AddAddress($user_email);
        $mail->Subject = 'Freies Guthaben';

        $link    = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                    <br>
                    Als Dank f&uuml;r Ihr Interesse haben wir Ihnen ein kostenloses Guthaben im Gegenwert von 5 &euro; gutgeschrieben. Damit k&ouml;nnen Sie auf unser Angebot zugreifen - wenn Sie sich zu einer Unterst&uuml;tzung unserer Arbeit entschlie&szlig;en, wird Ihnen dieses Guthaben zu Ausma&szlig; Ihrer Unterst&uuml;tzung hinzugerechnet.<br>                    
                        ';

/*        $body = $body.'
                    <table cellspacing="0" cellpadding="0"> <tr>
                    <td align="center" width="300" height="40" bgcolor="#f9f9f9" style="border:1px solid #dcdcdc;color: #ffffff; display: block;">
                    <a href="'.$link.'" style="font-size:10px; font-weight: bold; font-family:verdana; text-decoration: none; line-height:40px; width:100%; display:inline-block">
                    <span style="color: #000000">
                    Password reset
                    </span>
                    </a></td></tr></table> 
                    ';*/


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);

        if(!$mail->Send()) $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;


    }  



/*Here will be edit profile function*/
/*
user_first_name
user_surname
user_street
user_city
user_country
user_plz
*/

    public function editProfile($profile)
    {  

        $name = $profile[user_first_name];
        $surname = $profile[user_surname];
        $street = $profile[user_street];
        $city = $profile[user_city];
        $country = $profile[user_country];
        $plz = $profile[user_plz];

        $anrede = $profile[user_anrede];
        $telefon = $profile[user_telefon];
        $company = $profile[user_company];


        $name = substr(trim($name), 0, 64);
        $surname = substr(trim($surname), 0, 64);
        $country = substr(trim($country), 0, 64);
        $city = substr(trim($city), 0, 64);
        $street = substr(trim($street), 0, 64);
        $plz = substr(trim($plz), 0, 64);

        $anrede = substr(trim($anrede), 0, 64);
        $telefon = substr(trim($telefon), 0, 64);
        $company = substr(trim($company), 0, 64);


        $name = addslashes($name);
        $surname = addslashes($surname);
        $country = addslashes($country);
        $city = addslashes($city);
        $street = addslashes($street);
        $plz = addslashes($plz);

        $anrede = addslashes($anrede);
        $telefon = addslashes($telefon);
        $company = addslashes($company);
        
        /*
        $name = htmlentities($name, ENT_QUOTES, "ISO-8859-1");
        $surname = htmlentities($surname, ENT_QUOTES, "ISO-8859-1");
        $country = htmlentities($country, ENT_QUOTES, "ISO-8859-1");
        $city = htmlentities($city, ENT_QUOTES, "ISO-8859-1");
        $street = htmlentities($street, ENT_QUOTES, "ISO-8859-1");
        $plz = htmlentities($plz, ENT_QUOTES, "ISO-8859-1");
        */

        $user_email = $_SESSION['user_email'];

        $query_edit_user_profile = "UPDATE mitgliederExt SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_profile) or die($this->errors[] = "Failed Query of " . $query_edit_user_profile.mysql_error());


        $query_edit_user_address = "UPDATE mitgliederExt SET Land = '$country', Ort = '$city', Strasse = '$street', PLZ = '$plz', Anrede = '$anrede', Telefon = '$telefon', Firma = '$company' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_address) or die($this->errors[] = "Failed Query of " . $query_edit_user_address.mysql_error());
     
        // print_r($_SESSION);echo "<br>";
        $this->editUserEmail($profile[user_email]);
        // print_r($_SESSION);

        

    }

    /*Function to modify user information*/
    #pass all of the variables that will be update

    public function editUserName($name, $surname)
    {  
        // prevent database flooding
        $name = substr(trim($name), 0, 64);
        $surname = substr(trim($surname), 0, 64);

        $user_email = $_SESSION['user_email'];

        $query_edit_user_profile = "UPDATE mitgliederExt SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_profile) or die("Failed Query of " . $query_edit_user_profile.mysql_error());


        // $query_edit_user_profile = $this->db_connection->prepare('UPDATE mitgliederExt SET Nachname = :name, Vorname = :surname WHERE user_email = :user_email');
        // $query_edit_user_profile->bindValue(':user_email', $_SESSION['user_email'], PDO::PARAM_STR);
        // $query_edit_user_profile->bindValue(':name', $name, PDO::PARAM_STR);
        // $query_edit_user_profile->bindValue(':surname', $surname, PDO::PARAM_STR);
        // $query_edit_user_profile->execute();


/*        if(false){

               } elseif (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;

        } else {
            // check if new username already exists
            $result_row = $this->getUserData($user_email);

            if (isset($result_row->user_id)) {
                $this->errors[] = MESSAGE_EMAIL_EXISTS;
            } else {
                // write user's new data into database
                $query_edit_user_email = $this->db_connection->prepare('UPDATE mitgliederExt SET user_email = :user_name WHERE user_id = :user_id');
                $query_edit_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_edit_user_email->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query_edit_user_email->execute();

                if ($query_edit_user_email->rowCount()) {
                    $_SESSION['user_email'] = $user_email;
                    $this->messages[] = MESSAGE_USERNAME_CHANGED_SUCCESSFULLY . $user_email;
                } else {
                    $this->errors[] = MESSAGE_USERNAME_CHANGE_FAILED;
                }
            }
        }*/

        
    }

    
 public function editUserLevel($level)
    {  
        // prevent database flooding
        $level = substr(trim($level), 0, 64);

        $user_email = $_SESSION['user_email'];

        $query_edit_user_level = "UPDATE mitgliederExt SET Mitgliedschaft = '$level' WHERE user_email LIKE '$user_email'";
        $edit_user_level_result = mysql_query($query_edit_user_level) or die("Failed Query of " . $query_edit_user_level.mysql_error());

        $_SESSION['Mitgliedschaft'] = $level;
        
    }

    
    public function editUserAddress($country, $city, $street, $plz)
    {  
        // prevent database flooding
        $country = substr(trim($country), 0, 64);
        $city = substr(trim($city), 0, 64);
        $street = substr(trim($street), 0, 64);
        $plz = substr(trim($plz), 0, 64);

        $user_email = $_SESSION['user_email'];

        $query_edit_user_address = "UPDATE mitgliederExt SET Land = '$country', Ort = '$city', Strasse = '$street', PLZ = '$plz' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_address) or die("Failed Query of " . $query_edit_user_address.mysql_error());
        
    }

    /**
     * Edit the user's name, provided in the editing form
     */#changed
    // public function editUserEmail($user_email)
    // {
    //     // prevent database flooding
    //     $user_email = substr(trim($user_email), 0, 64);

    //     // if (!empty($user_email) == $_SESSION['user_email']) {
    //     //     $this->errors[] = MESSAGE_EMAIL_SAME_LIKE_OLD_ONE;
    //     if(false){

    //     // username cannot be empty and must be azAZ09 and 2-64 characters
    //     // TODO: maybe this pattern should also be implemented in Registration.php (or other way round)
    //            } elseif (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    //         $this->errors[] = MESSAGE_EMAIL_INVALID;

    //     } else {
    //         // check if new username already exists
    //         $result_row = $this->getUserData($user_email);

    //         if (isset($result_row->user_id)) {
    //             $this->errors[] = MESSAGE_EMAIL_EXISTS;
    //         } else {
    //             // write user's new data into database
    //             $query_edit_user_email = $this->db_connection->prepare('UPDATE mitgliederExt SET user_email = :user_name WHERE user_id = :user_id');
    //             $query_edit_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    //             $query_edit_user_email->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    //             $query_edit_user_email->execute();

    //             if ($query_edit_user_email->rowCount()) {
    //                 $_SESSION['user_email'] = $user_email;
    //                 $this->messages[] = MESSAGE_USERNAME_CHANGED_SUCCESSFULLY . $user_email;
    //             } else {
    //                 $this->errors[] = MESSAGE_USERNAME_CHANGE_FAILED;
    //             }
    //         }
    //     }
    // }

    /**
     * Edit the user's email, provided in the editing form
     */
    public function editUserEmail($user_email)
    {
        // prevent database flooding
        $user_email = substr(trim($user_email), 0, 64);

        // if (!empty($user_email) && $user_email == $_SESSION["user_email"]) {
        //     $this->errors[] = MESSAGE_EMAIL_SAME_LIKE_OLD_ONE;
        // // user mail cannot be empty and must be in email format
        // } elseif (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        //     $this->errors[] = MESSAGE_EMAIL_INVALID;

        if (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;

        } else if ($this->databaseConnection()) {
            // check if new email already exists
            $query_user = $this->db_connection->prepare('SELECT * FROM mitgliederExt WHERE user_email = :user_email');
            $query_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_user->execute();
            // get result row (as an object)
            $result_row = $query_user->fetchObject();

            // if this email exists
            if (isset($result_row->user_id) and ($_SESSION['user_id'] !== ($result_row->user_id)) ) {
                $this->errors[] = "Diese E-Mail-Adresse wird bereits verwendet.";
            } else {
                // write users new data into database
                $query_edit_user_email = $this->db_connection->prepare('UPDATE mitgliederExt SET user_email = :user_email WHERE user_id = :user_id');
                $query_edit_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_edit_user_email->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $query_edit_user_email->execute();

                if ($query_edit_user_email->rowCount()) {
                    $_SESSION['user_email'] = $user_email;
                    $this->messages[] = MESSAGE_EMAIL_CHANGED_SUCCESSFULLY . $user_email;
                } else {
                    // $this->errors[] = MESSAGE_EMAIL_CHANGE_FAILED;
                }
            }
        }
    }

    /**
     * Edit the user's password, provided in the editing form
     */
    public function editUserPassword($user_password_old, $user_password_new, $user_password_repeat)
    {
        if (empty($user_password_new) || empty($user_password_repeat) || empty($user_password_old)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        // is the repeat password identical to password
        } elseif ($user_password_new !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        // password need to have a minimum length of 6 characters
        } elseif (strlen($user_password_new) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;

        // all the above tests are ok
        } else {
            // database query, getting hash of currently logged in user (to check with just provided password)
            $result_row = $this->getUserData($_SESSION['user_email']);

            // if this user exists
            if (isset($result_row->user_password_hash)) {

                // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
                if (password_verify($user_password_old, $result_row->user_password_hash)) {

                    // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                    // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                    // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                    // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                    // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                    // want the parameter: as an array with, currently only used with 'cost' => XX.
                    $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

                    // write users new hash into database
                    $query_update = $this->db_connection->prepare('UPDATE mitgliederExt SET user_password_hash = :user_password_hash WHERE user_id = :user_id');
                    $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                    $query_update->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $query_update->execute();

                    // check if exactly one row was successfully changed:
                    if ($query_update->rowCount()) {
                        $this->messages[] = MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY;
                    } else {
                        $this->errors[] = MESSAGE_PASSWORD_CHANGE_FAILED;
                    }
                } else {
                    $this->errors[] = MESSAGE_OLD_PASSWORD_WRONG;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
    }

    /**
     * Sets a random token into the database (that will verify the user when he/she comes back via the link
     * in the email) and sends the according email.
     */
    public function setPasswordResetDatabaseTokenAndSendMail($user_email)
    {
        #$user_name = trim($user_name);
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
            $result_row = $this->getUserData($user_email);

            // if this user exists
            if (isset($result_row->user_id)) {

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
                    $this->sendPasswordResetMailSendgrid($user_email, $user_password_reset_hash);
                    return true;
                } else {
                    $this->errors[] = MESSAGE_DATABASE_ERROR;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
        // return false (this method only returns true when the database entry has been set successfully)
        return false;
    }

    /**
     * Sends the password-reset-email.
     */
    #delete this function after sendgrid ones proves to be working fine
    public function sendPasswordResetMail($user_email, $user_password_reset_hash)
    {
        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
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

        $mail->From = "info@scholarium.at";
        $mail->FromName = "scholarium";
        $mail->AddAddress($user_email);
        $mail->Subject = 'Password reset email';

        $link    = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                    Um ein neues Passwort zu erstellen, klicken Sie bitte auf folgenden Link: <a href="'.$link.'">'.$link.'</a>
                    ';


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        $mail->Body = $body;

        $mail->isHTML(true);


        // $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' ' . $link;

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
            return false;
        } else {
            $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
            return true;
        }
    }

    /**
     * Sends the password-reset-email using sendgrid.
     */
    public function sendPasswordResetMailSendgrid($user_email, $user_password_reset_hash)
    {
        //consturct email body
        $link    = EMAIL_PASSWORDRESET_URL.'?user_email='.urlencode($user_email).'&verification_code='.urlencode($user_password_reset_hash);
        
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                    Um ein neues Passwort zu erstellen, klicken Sie bitte auf folgenden Link: <a href="'.$link.'">'.$link.'</a>
                    ';


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');


        //create curl resource
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $user_email,
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => 'scholarium.at: Passwort zurücksetzen',
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);

        if($response === '{"message":"success"}')
        {
            $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;

        }else 
        {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED; 
        }


        // //TODO - add here current
        // if(empty($response))
        // {
        //     die("Error: No response.");
        //     $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
        // }
        // elseif ('{"message":"success"}')
        // {
        //     $json = json_decode($response);
        //     // print_r($json->access_token);
        //     print_r(SENDGRID_API_KEY);
        //     // echo "<br>";
        //     $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
        //     file_put_contents('log.txt', $response);
        //     //$this->messages[] = $json;
        // }

        curl_close($ch);
    }

     
    /**
     * Checks if the verification string in the account verification mail is valid and matches to the user.
     */
    public function checkIfEmailVerificationCodeIsValid($user_email, $verification_code)
    {
        $user_email = trim($user_email);

        if (empty($user_email) || empty($verification_code)) {
            $this->errors[] = MESSAGE_LINK_PARAMETER_EMPTY;
        } else {
            // database query, getting all the info of the selected user
            $result_row = $this->getUserData($user_email);

            // if this user exists and have the same hash in database
            if (isset($result_row->user_id) && $result_row->user_password_reset_hash == $verification_code) {

                $timestamp_one_hour_ago = time() - 3600; // 3600 seconds are 1 hour

                if ($result_row->user_password_reset_timestamp > $timestamp_one_hour_ago) {
                    // set the marker to true, making it possible to show the password reset edit form view
                    $this->password_reset_link_is_valid = true;
                } else {
                    $this->errors[] = MESSAGE_RESET_LINK_HAS_EXPIRED;
                }
            } else {
                $this->errors[] = MESSAGE_USER_DOES_NOT_EXIST;
            }
        }
    }

    /**
     * Checks and writes the new password.
     */
    public function editNewPassword($user_email, $user_password_reset_hash, $user_password_new, $user_password_repeat)
    {
        // TODO: timestamp!
        $user_email = trim($user_email);

        if (empty($user_email) || empty($user_password_reset_hash) || empty($user_password_new) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        // is the repeat password identical to password
        } else if ($user_password_new !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        // password need to have a minimum length of 6 characters
        } else if (strlen($user_password_new) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        // if database connection opened
        } else if ($this->databaseConnection()) {
            // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
            // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
            $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

            // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
            // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
            // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
            // want the parameter: as an array with, currently only used with 'cost' => XX.
            $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

            // write users new hash into database
            //getinhere
            $query_update = $this->db_connection->prepare('UPDATE mitgliederExt SET user_password_hash = :user_password_hash,
                                                           user_password_reset_hash = NULL, user_active = 1, user_password_reset_timestamp = NULL

                                                           WHERE user_email = :user_email AND user_password_reset_hash = :user_password_reset_hash');
            $query_update->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
            $query_update->bindValue(':user_password_reset_hash', $user_password_reset_hash, PDO::PARAM_STR);
            $query_update->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_update->execute();

            // check if exactly one row was successfully changed:
            if ($query_update->rowCount() == 1) {
                $this->password_reset_was_successful = true;
                $this->messages[] = MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY;
            } else {
                $this->errors[] = MESSAGE_PASSWORD_CHANGE_FAILED;
            }
        }
    }

    /**
     * Gets the success state of the password-reset-link-validation.
     * TODO: should be more like getPasswordResetLinkValidationStatus
     * @return boolean
     */
    public function passwordResetLinkIsValid()
    {
        return $this->password_reset_link_is_valid;
    }

    /**
     * Gets the success state of the password-reset action.
     * TODO: should be more like getPasswordResetSuccessStatus
     * @return boolean
     */
    public function passwordResetWasSuccessful()
    {
        return $this->password_reset_was_successful;
    }

    /**
     * Gets the username
     * @return string username
     */
    public function getEmail()
    {
        return $this->user_email;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     * Gravatar is the #1 (free) provider for email address based global avatar hosting.
     * The URL (or image) returns always a .jpg file !
     * For deeper info on the different parameter possibilities:
     * @see http://de.gravatar.com/site/implement/images/
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 50px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function getGravatarImageUrl($email, $s = 50, $d = 'mm', $r = 'g', $atts = array() )
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r&f=y";

        // the image url (on gravatarr servers), will return in something like
        // http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=80&d=mm&r=g
        // note: the url does NOT have something like .jpg
        $this->user_gravatar_image_url = $url;

        // build img tag around
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';

        // the image url like above but with an additional <img src .. /> around
        $this->user_gravatar_image_tag = $url;
    }
	
	public function registerEvent ($user_id, $event_id, $quantity) {
	    	
    		#enter into event registration
		    $reg_query = $this->db_connection->prepare('INSERT INTO registration (event_id, user_id, quantity, reg_datetime ) VALUES (:event_id, :user_id, :quantity, NOW())');
            $reg_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
            $reg_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $reg_query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $reg_query->execute();

            #update spots sold in produkte
            $spots_sold_query = $this->db_connection->prepare("UPDATE produkte SET spots_sold = spots_sold+:spot WHERE n LIKE :event_id");
            $spots_sold_query->bindValue(':spot', $quantity, PDO::PARAM_INT);
            $spots_sold_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
            $spots_sold_query->execute();

    }
	
	public function registerOpenSalon ($profile, $event_id, $quantity) {
		$user_id = $_SESSION['user_id'];
		$mitgliedschaft = $_SESSION['Mitgliedschaft'];
		
		#get user information from the form post
		if ($mitgliedschaft == 1) {
			$profile = $_POST['profile'];
			$anrede = $profile[user_anrede];
			$user_name = $profile[user_first_name];
			$user_surname = $profile[user_surname];
		}
				
		#get user information from database
		if($mitgliedschaft > 1) {
			$result_row = $this->getUserData(trim($_SESSION['user_email']));
			$anrede = trim($result_row->Anrede);
        	$user_name = trim($result_row->Vorname);
        	$user_surname = trim($result_row->Nachname);
		}
		
		#update profile of Gast members
		if ($mitgliedschaft == 1) {		
			$this->editProfile($profile);
		}
		
		$this->registerEvent($user_id, $event_id, $quantity);
		
		//email to user
		$this->openSalonUserEmail($_SESSION['user_email'], $anrede, $user_surname);
		$this->openSalonScholariumEmail($_SESSION['user_email'], $user_name, $user_surname);
		
		//display success message
		header ("Location: ../salon/anmeldung_erfolgreich.php");
	}
	
	public function openSalonUserEmail ($user_email, $user_anrede, $user_surname){
		#anrede
        
        if ($user_anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        }
		elseif ($user_anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
		}
		else {
			$anrede = 'Lieber Interessent';
		}
        #read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                <img style="" class="" title="" alt="" src="http://www.scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                <br>';
				if ($anrede == 'Lieber Interessent') {$body = $body.$anrede.',';}
				else {$body = $body.$anrede.' '.$user_surname.',';}
        $body = $body.'
                <br>
                vielen Dank f&uuml;r Ihr Interesse an unserem Offenen Salon!
                <br><br>
                Wir haben Ihre Reservierung entgegengenommen.<br>
                <br>
                Die Zahlung von 5&euro; pro Teilnehmer erfolgt am Abend des Salons vor Ort im scholarium.<br>
                <br>
                Wir freuen uns darauf, Sie kennenzulernen.<br>
                <br>
                Herzliche Gr&uuml;&szlig;e aus dem scholarium!';

        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $user_email,
            'subject' => 'Anmeldung zum Offenen Salon',
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            #die("Error: No response."); 
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }


        curl_close($ch);

/*            if(!$mail->Send()) {
                $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
                return false;
            } else {
                // $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
                #$this->messages[] = "Please check your inbox.";
                return true;
            }*/
    }

	public function openSalonScholariumEmail ($user_email, $user_name, $user_surname){
     
        $body = '
				Neue Anmeldung zum Offenen Salon:<br>
				<br>'
				.$user_name.' '.$user_surname.'<br>'
				.$user_email.'<br>
                ';

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => 'info@scholarium.at',
            'subject' => 'Neue Anmeldung zum Offenen Salon',
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            #die("Error: No response."); 
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }


        curl_close($ch);

/*            if(!$mail->Send()) {
                $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED . $mail->ErrorInfo;
                return false;
            } else {
                // $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
                #$this->messages[] = "Please check your inbox.";
                return true;
            }*/
    }

	public function oneClickReg($product) {
		
		$general = new General();
		$email = new Email();
		
		$event_info = $general->getProduct($product['event_id']);
		
		if ($product['format'] === 'Stream' && $event_info->price_book != '') {
			$price = $event_info->price_book;
		}
		else {
			$price = $event_info->price;
		}
		
		$general->changeCredit($_SESSION['user_id'], $product['quantity'], $price);
		$general->registerEvent($_SESSION['user_id'], $product['event_id'], $product['quantity'], $product['format']);
		
		# Does not work yet but is not urgent either		
		#$email->sendOneClick($_SESSION['user_id'], $product['event_id'], $product['quantity'], $product['format']);
	}
	
	public function voteThemenwahl($themenwahl) {
		
		$thema_n = $themenwahl[thema_n];
		$weight = $themenwahl[weight];
		$user_id = $themenwahl[user_id];
		
		$topic_query = $this->db_connection->prepare('UPDATE themen SET amount = amount + :weight, last_vote = NOW() WHERE n = :thema_n LIMIT 1');
            $topic_query->bindValue(':weight', $weight, PDO::PARAM_INT);
			$topic_query->bindValue(':thema_n', $thema_n, PDO::PARAM_INT);
            $topic_query->execute();
			
		$update_mahnstufe = $this->db_connection->prepare('UPDATE mitgliederExt SET Mahnstufe = Mahnstufe - 1 WHERE user_id = :user_id LIMIT 1');
			$update_mahnstufe->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$update_mahnstufe->execute();
			
		$reg_topic_query = $this->db_connection->prepare('INSERT INTO themen_registration (topic_id, user_id, quantity, reg_datetime)
															VALUES (:thema_n, :user_id, :weight, NOW())');
			$reg_topic_query->bindValue(':thema_n', $thema_n, PDO::PARAM_INT);
			$reg_topic_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$reg_topic_query->bindValue(':weight', $weight, PDO::PARAM_INT);
			$reg_topic_query->execute();
	}
	
	public function suggestionThemenwahl($suggestion) {
		
		$suggestion_title = $suggestion[title];
		$suggestion_description = $suggestion[description];
		$user_id = $suggestion[user_id];
		
		$suggestion_query = $this->db_connection->prepare('INSERT INTO themen (title, description, user_id, status)
															VALUES (:suggestion_title, :suggestion_description, :user_id, :status)');
			$suggestion_query->bindValue(':suggestion_title', $suggestion_title, PDO::PARAM_STR);
			$suggestion_query->bindValue(':suggestion_description', $suggestion_description, PDO::PARAM_STR);
			$suggestion_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$suggestion_query->bindValue(':status', 2, PDO::PARAM_INT);
			$suggestion_query->execute();
			
		$user_query = $this->getUserData($_SESSION['user_email']);
		
		$this->sendSuggestionMailToInstitute($user_id, $user_query->Vorname, $user_query->Nachname, $suggestion_title, $suggestion_description);
	}

	public function sendSuggestionMailToInstitute($user_id, $user_vorname, $user_nachname, $suggestion_title, $suggestion_description) {
			
		$body = '
				Neuer Themenvorschlag:<br>
				<br>'
				.$user_vorname.' '.$user_nachname.' (user_id: '.$user_id.')<br><br>
				Titel: '.$suggestion_title.'<br><br>
				Beschreibung: '.nl2br($suggestion_description).'<br>
                ';

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => 'info@scholarium.at',
            'subject' => 'Neuer Themenvorschlag',
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            #die("Error: No response."); 
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }

        curl_close($ch);
    }

	public function commentThemenwahl($comment) {
			
		$user_id = $_SESSION['user_id'];	
		$comment_comment = $comment[comment];
		$comment_topic_id = $comment[topic_id];
		
		$comment_query = $this->db_connection->prepare('INSERT INTO themen_kommentare (topic_id, user_id, comment, comment_datetime, status)
															VALUES (:topic_id, :user_id, :comment, NOW(), :status)');
			$comment_query->bindValue(':topic_id', $comment_topic_id, PDO::PARAM_INT);
			$comment_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$comment_query->bindValue(':comment', $comment_comment, PDO::PARAM_STR);
			$comment_query->bindValue(':status', 1, PDO::PARAM_INT);
			$comment_query->execute();
	}

	public function EditComment($edited_comment) {

		$edited_comment_query = $this->db_connection->prepare('UPDATE themen_kommentare SET comment = :comment_edit, edit_datetime = NOW(), status = :status WHERE id = :comment_id LIMIT 1');
            $edited_comment_query->bindValue(':comment_edit', $edited_comment[comment], PDO::PARAM_STR);
			$edited_comment_query->bindValue(':status', 2, PDO::PARAM_INT);
			$edited_comment_query->bindValue(':comment_id', $edited_comment[comment_id], PDO::PARAM_INT);
            $edited_comment_query->execute();
	}

	public function DeleteComment($deleted_comment) {

		$deleted_comment_query = $this->db_connection->prepare('UPDATE themen_kommentare SET comment = :comment_delete, delete_datetime = NOW(), status = :status WHERE id = :comment_id LIMIT 1');
			$deleted_comment_query->bindValue(':comment_delete', $deleted_comment[comment], PDO::PARAM_STR);
			$deleted_comment_query->bindValue(':status', 3, PDO::PARAM_INT);
			$deleted_comment_query->bindValue(':comment_id', $deleted_comment[comment_id], PDO::PARAM_INT);
            $deleted_comment_query->execute();
	}
}
