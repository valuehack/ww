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

       
        #if session does not exist, start a session
        if(session_id() == '') session_start();

        // if we have such a POST request, call the registerNewUser() method
        #this is not in use - main function that deals with it is now subscribe new user
        if (isset($_POST["register"])) 
        {
            $this->registerNewUser($_POST['user_email'], $_POST['user_password_new'], $_POST['user_password_repeat'], $_POST["captcha"]);

        // if we have such a GET request, call the verifyNewUser() method
        } elseif (isset($_GET["id"]) && isset($_GET["verification_code"]) && !isset($_GET["test"])) 
        {
            $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
			
		} elseif (isset($_GET["id"]) && isset($_GET["verification_code"]) && $_GET["test"] == 1) 
		{
			$user_id = $_GET["id"];
			$user_activation_hash = $_GET["verification_code"];
			$test = $_GET["test"];
			$this->verifyNewUser1($user_id, $user_activation_hash);
			
        #eintragen_submit is a button submit from subscription forms
        } elseif (isset($_POST["eintragen_submit"])) {

            $_SESSION['first_reg'] = $_POST['first_reg'];
			$user_anrede = '';
			$user_surname = '';
			$betrag = 1;
            $this->subscribeNewUser($_POST['user_email'], $betrag, $user_anrede, $user_surname);
        }

        #registration of not logged in users that provide data
        #coming from fur buerger
        elseif (isset($_POST["register_from_outside_submit"])) 
        {
        
            $profile = $_POST["profile"];
            $_SESSION["profile"] = $profile;

            $user_email = $profile[user_email];
            $user_anrede = $profile[user_anrede];
			$user_surname = $profile[user_surname];
						
            #if $user_email is unique -> then continue with registration
            #TODO - if already exist - direct to login 
            $this->subscribeNewUser($user_email, $_POST["betrag"], $user_anrede, $user_surname);

            if ($this->registration_successful)
            {
                $this->addPersonalDataForUserReg($profile, $_POST["betrag"]);
                $this->sendNewPayingUserEmailToInstitute($user_email);

            }

            //send out email while still in grey to make sure user is being tracked and emailed in case of troubles
            
        }
        #registration for seminars from outside
        elseif (isset($_POST["register_seminar_from_outside_submit"])) 
        {

            //grab post here and send it over to other functions              
            $profile = $_POST["seminar_profile"];
            $_SESSION["seminar_profile"] = $profile;

            $user_email = $profile[user_email];
			$user_anrede = $profile[user_anrede];
			$user_surname = $profile[user_surname];
            $betrag = 150;
						
            #if $user_email is unique -> then continue with registration
            #if already exist - direct to login 
            $this->subscribeNewUser($user_email, $betrag, $user_anrede, $user_surname);
            
            if ($this->registration_successful)
            {
                $this->addPersonalData($profile);

                #comment this out when testing
                $this->sendNewPayingUserEmailToInstitute($user_email);

                //only redirect after registration was successfully finished
                #header("Location: ../spende/zahlung.php");     
                header("Location: ../spende/zahlung_info.php");

            }
        }        
        #registration for projekte from outside
        elseif (isset($_POST["register_projekte_from_outside_submit"])) 
        {

            //grab post here and send it over to other functions              
            $profile = $_POST["projekte_profile"];
            $_SESSION["projekte_profile"] = $profile;

            $user_email = $profile[user_email];
            $user_anrede = $profile[user_anrede];
            $user_surname = $profile[user_surname];
                                    
            #if $user_email is unique -> then continue with registration
            #if already exist - direct to login 
            $this->subscribeNewUser($user_email, $_POST["betrag"], $user_anrede, $user_surname);
            
            if ($this->registration_successful)
            {
                $this->addPersonalDataForProjekteReg($profile);

                #comment this out when testing
                $this->sendNewPayingUserEmailToInstitute($user_email);

                //only redirect after registration was successfully finished
                #zahlung_info.php displays extra info for selected payment method
                header("Location: ../spende/zahlung_info.php");
            }
        }
        #registration for open salon from outside
        elseif (isset($_POST["register_open_salon_from_outside"])) 
        {

            //grab post here and send it over to other functions              
            $profile = $_POST["profile"];
            $_SESSION["profile"] = $profile;

			$quantity = $profile['quantity'];
			$event_id = $profile['event_id'];
			
			$profile['first_reg'] = $event_id.'_'.$quantity;

            $user_email = $profile[user_email];
			$user_anrede = $profile[user_anrede];
			$user_surname = $profile[user_surname];
			$user_name = $profile[user_first_name];
            						
            #if $user_email is unique -> then continue with registration
            #this is extra step to ajax duplicate check
            $this->subscribeNewUser($user_email, $_POST["betrag"], $user_anrede, $user_surname);
            #TODO transition to pass an array with all values - call it registerNewUser

            # $registration_successful is set to true if registration was succesfull
            if ($this->registration_successful)
            {
                //$this->addPersonalDataGeneric($profile);
				$this->addPersonalDataForUserReg($profile, $_POST["betrag"]);
                #comment this out when testing
                $this->openSalonScholariumEmail($user_email, $user_name, $user_surname);
                				
                //only redirect after registration was successfully finished
                #displays sucess message
                header("Location: ../salon/anmeldung_erfolgreich.php?q=new");
            }
        }

		#Not in use yet. General function for all registrations only with email
		elseif(isset($_POST['submit_email'])) {
			
			#grab user email and first_reg
			$user_email = $_POST['user_email'];
			$first_reg = $_POST['first_reg'];
			
			#set user_level to 1 "Interessent" for all 
			$user_level = 1;
			
			$this->subscribeNewUser1($user_email, $user_level, $first_reg);
			
			# $registration_successful is set to true if registration was succesfull
            if ($this->registration_successful)
            {
				
				//grab info from subcribeNewUser and send verification email to user
				$grey_user_id = $reg_info['grey_user_id'];
				$user_activation_hash = $reg_info['user_activation_hash'];
				$user_password = $reg_info['user_password'];
				
				if ($email->sendVerificationMinimal($grey_user_id, $user_email, $user_activation_hash, $user_password)) {
					
					#comment this out when testing
               		$email->sendScholariumMinimal($user_email);
                				
                	//only redirect after registration was successfully finished
                	#displays sucess message
                	#TODO make generic sucess page or show msg in the specific page
                	header("Location: ../salon/anmeldung_erfolgreich.php");
					// OR
					$this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;

                } else {
                    // delete this users account immediately, as we could not send a verification email
                    $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
                    $query_delete_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                    $query_delete_user->execute();

                    $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
				}
								
            }
		}
		
		#Not in use yet. General function for all registrations with information
		elseif(isset($_POST['submit_full_info'])) {
			
			$email = new Email();
			
			#grab personal information
			$profile = $_POST['profile'];
			$_SESSION['profile'] = $profile;
			
			$user_email = $profile[user_email];
			$user_anrede = $profile[user_anrede];
			$user_surname = $profile[user_surname];
			$user_name = $profile[user_first_name];
			$first_reg = $profile[first_reg];
			$user_level = $profile[level];
			
			#grab product information
			$product = $_POST['product'];
			$_SESSION['product'] = $product;
			
			$quantity = $product[quantity];
			$zahlung = $_POST['zahlung'];
			
			list($event_type, $event_id) = explode('_', $first_reg);
			
			#I decided to work directly with the user level because coding it in $betrag is confusing, $betrag is theerefore not needed anymore because if we need it (e.g. for email) we can calculate it from the level or by $quantity*$price. I think this makes the code more clear and understanable.
						
			#define specific values for different product types			
			switch($event_type) {
				#set user_level to 3 "Kursteilnehmer" for all seminars
				case 'seminar':
					$user_level = 3;
					break;
				#set user_level to 1 "Interessent" for open salons
				case 'opensalon':
					$user_level = 1;
					break;
				case 'upgrade':
					$user_level = $user_level;
					break;
				case 'projekt':
					$user_level = $user_level;
					
					#get $quantity for projekte from user_level because it is not passed from the form anymore
					switch($user_level) {
						case 3:
							$quantity = 150;
							break;
						case 4:
							$quantity = 300;
							break;
						case 5:
							$quantity = 600;
							break;
						case 6:
							$quantity = 1200;
							break;
						case 7:
							$quantity = 2400;
							break;
						default:
							$quantity = 150;
					}
					
					break;
				default:
					$user_level = 1;
					break;
			}
			
			
			#add quantity to first_reg because it can't be added in the form
			$first_reg = $first_reg.'_'.$quantity;
			$profile[first_reg] = $first_reg;

			$reg_info = $this->subscribeNewUser1($user_email, $user_level, $first_reg);
			
			# $registration_successful is set to true if registration was succesfull
            if ($this->registration_successful)
            {
				
				//grab info from subcribeNewUser and send verification email to user
				$grey_user_id = $reg_info['grey_user_id'];
				$user_activation_hash = $reg_info['user_activation_hash'];
				$user_password = $reg_info['user_password'];
				
				if ($email->sendVerificationFull($grey_user_id, $user_email, $user_activation_hash, $user_password, $user_anrede, $user_surname)) {
				//if ($this->sendSubscriptionMail($grey_user_id, $user_email, $user_activation_hash, $user_password, $user_anrede, $user_level, $user_surname)) {
					
					//add adtional user data
					$this->addPersonalDataGeneric($profile);
					$this->addPaymentData($zahlung, $user_email);

					#comment this out when testing TODO think about if we need this because more information is send to scholarium after verification
               		$email->sendScholariumFull($user_email, $user_name, $user_surname, $event_type, $event_id, $quantity, $user_level);
                				
                	//only redirect after registration was successfully finished
                	#displays sucess message
                	#TODO make generic sucess page or show msg in the specific page
                	header("Location: ../salon/anmeldung_erfolgreich.php");
					// OR
					$this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;

                } else {
                    // delete this users account immediately, as we could not send a verification email
                    $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
                    $query_delete_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                    $query_delete_user->execute();

                    $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
				}
								
            }
		}

    }#end of constructor

   public function createNewUser($profile, $product)
    {
        #simple function to add a new entry in mitgliederEXT
        #copy from subscribe new user to include emails etc.

        #here we assume that user is new and the email was not used. 

        $user_password = $this->randomPasswordGenerator();

        $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

        //encrypt password for storage in the database, so no one would see it in plain text
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

        $this->databaseConnection();

        $qry_new_user = $this->db_connection->prepare(
        'INSERT INTO mitgliederExt (
            user_email, 
            Mitgliedschaft,
            credits_left,
            Ablauf, 
            first_reg, 
            user_active,
            user_password_hash,
            user_registration_ip, 
            user_registration_datetime) 
        VALUES(
            :user_email, 
            :Mitgliedschaft, 
            :credits_left,
            :Ablauf,
            :first_reg, 
            :user_active,
            :user_password_hash,
            :user_registration_ip, 
            now())');

        $qry_new_user->bindValue(':user_email', $profile['user_email'], PDO::PARAM_STR);
        $qry_new_user->bindValue(':first_reg', $profile['first_reg'], PDO::PARAM_STR);
        $qry_new_user->bindValue(':Mitgliedschaft', $product['level'], PDO::PARAM_STR);
        $qry_new_user->bindValue(':credits_left', $product['credits'], PDO::PARAM_STR);
        $qry_new_user->bindValue(':Ablauf', $product['membership_end'], PDO::PARAM_STR);
        $qry_new_user->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
        $qry_new_user->bindValue(':user_active', 1, PDO::PARAM_INT);
        $qry_new_user->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
        $qry_new_user->execute();

        $user_id = $this->db_connection->lastInsertId();
        $_SESSION['profile']['user_id'] = $user_id;
        $_SESSION['user_id'] = $user_id;

        #EMAIL SEND BLOCK
        ####################################################################
        #email template must exist in templates/email folder
        $email_template = 'new_paying_user_email.email.twig';

        $post_data = array(
            'to' => $profile['user_email'],
            'bcc' => 'dzainius@gmail.com',
            'subject' => 'You are a new user',
            'from' => 'info@scholarium.at',
            'fromname' => 'Scholarium'
            );

        $body_data = array(
            'profile' => $profile,
            'product' => $product,
            'user_password' => $user_password
            );
        
        if ( !$this->sendThisEmail($email_template, $post_data, $body_data) ) 
        {
          error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        }
        ####################################################################

        $login = new Login();        
        $login->newRememberMeCookie();
    }


    public function addPersonalDataGeneric($profile)
    {  

        #from now on use this function only to update the generic user profile info to grey user db
        #use extra helper function for extra actions
        #consider one big sql query vs many small...

        ### DO NOT ADD EXTRA FIELDS FOR DB UPDATE IN HERE. USE SEPARATE FUNCTIONS, so it would not break other instances depending on this function.  

        /*Anrede = :anrede,
        Vorname = :name,
        Nachname = :surname,
        Telefon = :telefon,
        Strasse = :street,
        PLZ = :plz,
        Ort = :city,
        Land = :country,
        first_reg = :first_reg*/

        $this->databaseConnection();

        $update_profile_query = $this->db_connection->prepare(
        "UPDATE mitgliederExt   
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

        $update_profile_query->bindValue(':anrede', $profile['user_anrede'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':name', $profile['user_first_name'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':surname', $profile['user_surname'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':telefon', $profile['user_telefon'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':street', $profile['user_street'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':plz', $profile['user_plz'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':city', $profile['user_city'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':country', $profile['user_country'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':first_reg', $profile['first_reg'], PDO::PARAM_STR);
        $update_profile_query->bindValue(':user_email', $profile['user_email'], PDO::PARAM_STR);

        $update_profile_query->execute();

    }

    public function giveCredits($credits, $user_email)
    {
        #adds more credits to given user email

        $this->databaseConnection();

        $give_credits_qry = $this->db_connection->prepare(
        "UPDATE mitgliederExt   
            SET credits_left = credits_left+:credits
          WHERE user_email = :user_email"
        );

        $give_credits_qry->bindValue(':credits', $credits, PDO::PARAM_INT);
        $give_credits_qry->bindValue(':user_email', $user_email, PDO::PARAM_STR);

        $give_credits_qry->execute();

        if($give_credits_qry->errorCode() != 0) return $give_credits_qry->errorInfo();


    }

    public function prolongMembership($user_email)
    {
        #prolongs membership one year from now

        $this->databaseConnection();

        $prolong_qry = $this->db_connection->prepare(
        "UPDATE mitgliederExt   
            SET Ablauf = DATE_ADD(CURDATE(), INTERVAL 1 YEAR)
          WHERE user_email = :user_email"
        );

        $prolong_qry->bindValue(':user_email', $user_email, PDO::PARAM_STR);

        $prolong_qry->execute();


        if($prolong_qry->errorCode() != 0) return $prolong_qry->errorInfo();

    }

    public function markAsPaid($user_email, $wrt_txn_id)
    {
        #marks transaction paid - success

        $paid_qry = $this->db_connection->prepare(
        "UPDATE transactions   
            SET paid_datetime = NOW()
          WHERE user_email = :user_email
            AND wrt_txn_id = :wrt_txn_id"
        );

        $paid_qry->bindValue(':user_email', $user_email, PDO::PARAM_STR);
        $paid_qry->bindValue(':wrt_txn_id', $wrt_txn_id, PDO::PARAM_STR);

        $paid_qry->execute();

    }
     
    private function registerSeminar($profile, $product)
    {

        #must have user_id at this point
        #check if user_id exists as it is needed for the function
        #give a person credits and membership

        #updates registration db
        $reg_query = $this->db_connection->prepare(
            'INSERT INTO registration (
                event_id, 
                user_id, 
                quantity, 
                reg_datetime ) 
            VALUES (
                :event_id, 
                :user_id, 
                :quantity, 
                NOW())');
        
        $reg_query->bindValue(':event_id', $product['event_id'], PDO::PARAM_INT);
        $reg_query->bindValue(':user_id', $_SESSION['profile']['user_id'], PDO::PARAM_STR);
        $reg_query->bindValue(':quantity', $product['quantity'], PDO::PARAM_INT);
        $reg_query->execute();

        #updates produkte, increases spots sold by the quantity bought
        $qry_spots_sold = $this->db_connection->prepare(
            "UPDATE produkte 
             SET spots_sold = spots_sold+:spot 
             WHERE n LIKE :event_id");

        $qry_spots_sold->bindValue(':spot', $product['quantity'], PDO::PARAM_INT);
        $qry_spots_sold->bindValue(':event_id', $product['event_id'], PDO::PARAM_INT);
        $qry_spots_sold->execute();

        #gives user extra credits
        #seminar registration get 25 = 150 - 125
        $this->giveCredits(25, $profile['user_email']);

    }

    public function registerProjekt($profile, $product)
    {

        #$product['payment_total'] becomes quantity and spots sold respectively, because it is projekt

        $reg_projekt_qry = $this->db_connection->prepare(
            'INSERT INTO registration (
                event_id, 
                user_id, 
                quantity, 
                reg_datetime ) 
            VALUES (
                :event_id, 
                :user_id, 
                :quantity, 
                NOW())');
        $reg_projekt_qry->bindValue(':event_id', $product['event_id'], PDO::PARAM_INT);
        $reg_projekt_qry->bindValue(':user_id', $_SESSION['profile']['user_id'], PDO::PARAM_INT);
        $reg_projekt_qry->bindValue(':quantity', $product['payment_total'], PDO::PARAM_INT);
        $reg_projekt_qry->execute();


        #in projekte spots sold are incremented by total payment amount 
        $spots_qry = $this->db_connection->prepare(
            "UPDATE produkte 
            SET spots_sold = spots_sold+:donation 
            WHERE n LIKE :event_id");
        $spots_qry->bindValue(':donation', $product['payment_total'], PDO::PARAM_INT);
        $spots_qry->bindValue(':event_id', $product['event_id'], PDO::PARAM_INT);
        $spots_qry->execute();

    }

    public function userUpgrade($profile, $product)
    {

            $query_move_to_main = $this->db_connection->prepare('INSERT INTO 
                mitgliederExt 
                (user_email, Mitgliedschaft, Vorname, Nachname, Anrede, Land, Ort, Strasse, PLZ, Telefon, first_reg, credits_left, Ablauf, user_password_hash, user_registration_ip, user_active, user_registration_datetime) 
                VALUES
                (:user_email, :Mitgliedschaft, :name, :surname, :anrede, :country, :city, :street, :plz, :telefon, :first_reg, :credits_left, DATE_ADD(CURDATE(), INTERVAL 1 YEAR), :user_password_hash, :user_registration_ip, :user_active, NOW())');

    }



public function processPayment($profile, $product)
{

    ini_set("log_errors" , "1");
    error_log('processPayment');

    error_log("User email in registration ".$profile['user_email']);

    if ((isset($profile['user_logged_in'])) and ($profile['user_logged_in'] === 1))
    {
        #user was logged in when payment was made
        error_log($profile['user_email'].' is a returning customer.');

        $this->addPersonalDataGeneric($profile);

        #make sure that credits exists! 
        $this->giveCredits($product['credits'] , $profile['user_email']);
        
        $this->prolongMembership($profile['user_email']);

        // if ( !($this->sendUpgradeEmailToUser($profile['user_email'])) ) 
        // {
        //     error_log( "Mail not sent " .$profile['user_email']);
        // }

        #EMAIL SEND BLOCK
        ####################################################################
        #email template must exist in templates/email folder
        $email_template = 'successful_upgrade.email.twig';

        $post_data = array(
            'to' => $profile['user_email'],
            'bcc' => 'dzainius@gmail.com',
            'subject' => 'The upgrade is successful!',
            'from' => 'info@scholarium.at',
            'fromname' => 'Scholarium'
            );

        $body_data = array(
            'profile' => $profile,
            'product' => $product
            );
        
        if ( !$this->sendThisEmail($email_template, $post_data, $body_data) ) 
        {
          error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        }
        ####################################################################



        #TODO: mark as paid only when all above are successful
        $this->markAsPaid($profile['user_email'],$profile['wrt_txn_id']);
        

    }elseif ( empty($profile['user_logged_in']) )
    {
        #create a new user

        error_log($profile['user_email'].' is NEW.');

        $this->createNewUser($profile, $product);
        $this->addPersonalDataGeneric($profile);


        // if ( !($this->sendUpgradeEmailToUser($profile['user_email'])) ) 
        // {
        //     error_log( "Mail not sent " .$profile['user_email']);
        // }

        #EMAIL SEND BLOCK
        ####################################################################
        #email template must exist in templates/email folder
        $email_template = 'successful_upgrade.email.twig';

        $post_data = array(
            'to' => $profile['user_email'],
            'bcc' => 'dzainius@gmail.com',
            'subject' => 'Vielen Dank fuer Ihre Unterstuetzung',
            'from' => 'info@scholarium.at',
            'fromname' => 'Scholarium'
            );

        $body_data = array(
            'profile' => $profile,
            'product' => $product
            );
        
        if ( !$this->sendThisEmail($email_template, $post_data, $body_data) ) 
        {
          error_log('Problem sending an email '.$email_template.' to '.$profile['user_email']);
        }
        ####################################################################

        #TODO: mark as paid only when all above are successful
        $this->markAsPaid($profile['user_email'],$profile['wrt_txn_id']);

    }else
    {
        #some random shit just happened! 
        #log it and ivestigate
        #send email too 
        #create random gmail email for these errors 
        #biene.sackerl@gmail.com
        error_log('BAD NUTS: check processPayment() in registration class');
    }

    #clear session vars as no longer needed
    $_SESSION['profile'] = '';
    $_SESSION['product'] = '';

    #redirect to success page
    header('Location: einvollererfolg.php');

}



    public function addPaymentData($zahlung, $email)
    {  

    $update_payment_query = $this->db_connection->prepare(
    "UPDATE grey_user   
        SET Zahlungsart = :zahlung
      WHERE user_email = :user_email"
    );

    $update_payment_query->bindValue(':zahlung', $zahlung, PDO::PARAM_STR);
    $update_payment_query->bindValue(':user_email', $email, PDO::PARAM_STR);

    $update_payment_query->execute();

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
                #$this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
                $query_time_zone->execute();

                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
               // $this->errors[] = "this is it";
                return false;
            }
        }
    }   

    //main function to deal with registration of new users
    //initiated when only email is provided
    private function subscribeNewUser($user_email, $betrag, $user_anrede, $user_surname)
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
        } elseif ($this->databaseConnection()) {
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

				$level = 0;
				
            	switch ($betrag) {
            	case 75:
                	$level = 2;
                	break;
            	case 150:
               		$level = 3;
                	break;
           		case 300:
                	$level = 4;
                	break;
            	case 600:
                	$level = 5;
                	break;
            	case 1200:
                	$level = 6;
                	break;
            	case 2400:
                	$level = 7;
                	break;
            	default: 
                	$level = 1;
                break;
            }

                // write new users data into database                
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO grey_user (user_email, Mitgliedschaft, first_reg, user_password_hash, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_email, :Mitgliedschaft, :first_reg, :user_password_hash, :user_activation_hash, :user_registration_ip, now())');

                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':first_reg', $_SESSION['first_reg'], PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':Mitgliedschaft', $level, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                $_SESSION['Mitgliedschaft'] = $level;
				
				
                // id of new user
                $grey_user_id = $this->db_connection->lastInsertId();
                $_SESSION['grey_user_id'] = $grey_user_id;

                if ($query_new_user_insert) {
                    // send a verification email
                    if ($this->sendSubscriptionMail($grey_user_id, $user_email, $user_activation_hash, $user_password, $user_anrede, $level, $user_surname)) {
                       // when mail has been send successfully
                       $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
                       $this->registration_successful = true;

                    } else {
                       // delete this users account immediately, as we could not send a verification email
                       $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
                       $query_delete_user->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                       $query_delete_user->execute();

                       $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                   }
                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }
            }
        }
    }

    #-------------------------------------
    //generates a random string of 6 characters used for temporary passwords
    private function randomPasswordGenerator() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $str='';

        $size = strlen( $chars );
        for( $i = 0; $i < 6; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }

    #-------------------------------------
    #this is temp to keep projekt registration working
    #difference is that it does not add credits to the user 
    public function addPersonalDataForProjekteReg($profile)
    {  

        $user_email = $profile[user_email];
        $name = $profile[user_first_name];
        $surname = $profile[user_surname];
        $street = $profile[user_street];
        $city = $profile[user_city];
        $country = $profile[user_country];
        $plz = $profile[user_plz];

        $event_id = $profile[event_id];

        if (isset($profile[event_id])) $first_reg = $profile[event_id];
        if (isset($profile[first_reg])) $first_reg = $profile[first_reg];

        $anrede = $profile[user_anrede];
        $telefon = $profile[user_telefon];

        $betrag = $profile[betrag];
		$quantity = $profile[betrag];

        $Mitgliedschaft = 1;
        if (isset($betrag))
        {
            switch ($betrag) {
            case 75:
                $Mitgliedschaft = 2;
                break;
            case 150:
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

        }
        
        $query_edit_user_profile = "UPDATE grey_user SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_profile) or die($this->errors[] = "Failed Query of " . $query_edit_user_profile.mysql_error());

        $query_edit_user_address = "UPDATE grey_user SET Land = '$country', Ort = '$city', Strasse = '$street', PLZ = '$plz', Mitgliedschaft = '$Mitgliedschaft', first_reg = '$first_reg', Gesamt = '$betrag', Anrede = '$anrede', Telefon = '$telefon' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_address) or die($this->errors[] = "Failed Query of " . $query_edit_user_address.mysql_error());
     
    }

    #-------------------------------------

    #-------------------------------------
    #this mostly deals with seminar registrations
    public function addPersonalDataForUserReg($profile, $betrag)
    {  

        $user_email = $profile[user_email];
        $name = $profile[user_first_name];
        $surname = $profile[user_surname];
        $street = $profile[user_street];
        $city = $profile[user_city];
        $country = $profile[user_country];
        $plz = $profile[user_plz];

        $event_id = $profile[event_id];
        #$credits = $profile[credits];

        if (isset($profile[event_id])) $first_reg = $profile[event_id];
        if (isset($profile[first_reg])) $first_reg = $profile[first_reg];

        $anrede = $profile[user_anrede];
        $telefon = $profile[user_telefon];

		$quantity = $profile[quantity];
        //$betrag = $profile[betrag];

        $Mitgliedschaft = 1;
        if (isset($betrag))
        {
            switch ($betrag) {
            case 75:
                $Mitgliedschaft = 2;
                break;
            case 150:
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

        }
        
        $query_edit_user_profile = "UPDATE grey_user SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_profile) or die($this->errors[] = "Failed Query of " . $query_edit_user_profile.mysql_error());

        $query_edit_user_address = "UPDATE grey_user SET Land = '$country', Ort = '$city', Strasse = '$street', PLZ = '$plz', Mitgliedschaft = '$Mitgliedschaft', first_reg = '$first_reg', credits_left = credits_left+'$betrag', Anrede = '$anrede', Telefon = '$telefon' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_address) or die($this->errors[] = "Failed Query of " . $query_edit_user_address.mysql_error());
     
    }

    #-------------------------------------
    #this is used for fuer buerger form
    #update grey_user database with the info collected from the form
    public function addPersonalData($profile)
    {  

        $user_email = $profile[user_email];
        $name = $profile[user_first_name];
        $surname = $profile[user_surname];
        $street = $profile[user_street];
        $city = $profile[user_city];
        $country = $profile[user_country];
        $plz = $profile[user_plz];

        $event_id = $profile[event_id];
        $credits = $profile[credits];
        $quantity = $profile[quantity];

        if (isset($profile[event_id])) $first_reg = $profile[event_id];
        if (isset($profile[first_reg])) $first_reg = $profile[first_reg];

        $anrede = $profile[user_anrede];
        $telefon = $profile[user_telefon];
             
        $query_edit_user_profile = "UPDATE grey_user SET Vorname = '$name', Nachname = '$surname' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_profile) or die($this->errors[] = "Failed Query of " . $query_edit_user_profile.mysql_error());

        $query_edit_user_address = "UPDATE grey_user SET Land = '$country', Ort = '$city', Strasse = '$street', PLZ = '$plz', first_reg = '$first_reg', credits_left = '$credits', Anrede = '$anrede', Telefon = '$telefon' WHERE user_email LIKE '$user_email'";
        $edit_user_profile_result = mysql_query($query_edit_user_address) or die($this->errors[] = "Failed Query of " . $query_edit_user_address.mysql_error());
     
    }


    #-------------------------------------
    #sendgrid
    #send an email to a newly subscribed member, containing password and activation link
    public function sendSubscriptionMail($user_id, $user_email, $user_activation_hash, $user_password, $user_anrede, $level, $user_surname)
    {

        #anrede
        
        if ($user_anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        }
		elseif ($user_anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
		}
		else {
			$anrede = 'Lieber';
		}
        
		if ($user_surname == ''){
			$user_surname = 'Gast';
		}
        /*#membership level
        
        switch ($level) {
        case 2:
        	if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'G&auml;stin';
        	}
			else {
            	$mitgliedschaft = 'Gast';
			}
            break;
        case 3:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Teilnehmerin';
        	}
			else {
            	$mitgliedschaft = 'Teilnehmer';
			}
            break;
        case 4:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Scholarin';
        	}
			else {
            	$mitgliedschaft = 'Scholar';
			}
            break;
        case 5:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Partnerin';
        	}
			else {
            	$mitgliedschaft = 'Partner';
			}
            break;
        case 6:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Beir&auml;tin';
        	}
			else {
            	$mitgliedschaft = 'Beirat';
			}
            break;
		case 7:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Patronin';
        	}
			else {
            	$mitgliedschaft = 'Patron';
			} 
            break;
		default:
			if ($user_anrede == 'Frau'){
        		$mitgliedschaft = 'Interessentin';
        	}
			else {
            	$mitgliedschaft = 'Interessent';
			}
            break;
        }*/
        
        #verification link
        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);

        #read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                '.$anrede.' '.$user_surname.',
                <br>
                vielen Dank f&uuml;r Ihr Interesse!
                <br>';

        $body = $body.'
                Bitte klicken Sie auf den Link unterhalb, um Ihre Eintragung abzuschlie&szlig;en. (Falls der Link nicht anklickbar ist, bitte die Adresse des Links in die Adresszeile Ihres Browsers kopieren.)
                <br><a href="'.$link.'">'.$link.'</a>

                <br><strong>Ihr vorl&auml;ufiges Passwort ist: </strong>'.$user_password.'<br>
                Herzliche Gr&uuml;&szlig;e aus Wien!';


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
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => 'Herzlich willkommen',
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

    public function sendUpgradeEmailToUser($user_email)
    {

        //construct body
        $body = "Thanks. We have received your payment. Enjoy one more year and extra credits. ".$user_email;

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $user_email,
            'bcc' => TEST_EMAIL,
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => 'You have been upgraded!',
            'html' => $body,
            'from' => 'no-reply@scholarium.at'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            die("Error: No response.");
            return false;
        }
        else
        {
            // $json = json_decode($response);
            return true;
        }

        curl_close($ch);

    }


    #-------------------------------------
    //send an email to a newly subscribed member, containing password and activation link
    public function sendNewPayingUserEmailToInstitute($user_email)
    {
        //construct body
        $body = "Check database, there is a new paying member ".$user_email;

        //create curl resource
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => 'info@scholarium.at',
            'bcc' => TEST_EMAIL,
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => 'New Paying User',
            'html' => $body,
            'from' => 'no-reply@scholarium.at'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);


        if(empty($response))
        {
            die("Error: No response.");
            return false;
        }
        else
        {
            $json = json_decode($response);
            return true;
        }

        curl_close($ch);

    }
      
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


            #sets php timezone to Europe/Vienna
            #does the same for mysql in PDO way
            #this could be better in the header...
            date_default_timezone_set('Europe/Vienna');
            $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
            $query_time_zone->execute();


            //copy data to the main database
            $query_move_to_main = $this->db_connection->prepare('INSERT INTO 
                mitgliederExt 
                (user_email, Mitgliedschaft, Vorname, Nachname, Anrede, Land, Ort, Strasse, PLZ, Telefon, first_reg, credits_left, Ablauf, user_password_hash, user_registration_ip, user_active, user_registration_datetime) 
                VALUES
                (:user_email, :Mitgliedschaft, :name, :surname, :anrede, :country, :city, :street, :plz, :telefon, :first_reg, :credits_left, DATE_ADD(CURDATE(), INTERVAL 1 YEAR), :user_password_hash, :user_registration_ip, :user_active, NOW())');

            $query_move_to_main->bindValue(':user_email', $the_row->user_email, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':Mitgliedschaft', $the_row->Mitgliedschaft, PDO::PARAM_STR);

            $query_move_to_main->bindValue(':name', $the_row->Vorname, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':surname', $the_row->Nachname, PDO::PARAM_STR);
			$query_move_to_main->bindValue(':anrede', $the_row->Anrede, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':country', $the_row->Land, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':city', $the_row->Ort, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':street', $the_row->Strasse, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':plz', $the_row->PLZ, PDO::PARAM_STR);
			$query_move_to_main->bindValue(':telefon', $the_row->Telefon, PDO::PARAM_STR);

            $query_move_to_main->bindValue(':first_reg', $the_row->first_reg, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':credits_left', $the_row->credits_left, PDO::PARAM_STR);
        
            $query_move_to_main->bindValue(':user_password_hash', $the_row->user_password_hash, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_active', '1', PDO::PARAM_STR);
            $query_move_to_main->execute();

            #capture the final user_id which will be in mitgliederExt
            $user_id = $this->db_connection->lastInsertId();
            $_SESSION['user_id'] = $user_id;

            //if first_reg is numeric then it is assumed it is a seminar
            //change it to be similar as projekte
            if (is_numeric($the_row->first_reg)) 
            {

            // date_default_timezone_set('Europe/Vienna'); // set timezone in php
            // mysql_query("SET `time_zone` = '".date('P')."'"); // set timezone in MySQL
            // mysql_query("SET time_zone = 'Europe/Vienna'");

            $reg_query = $this->db_connection->prepare('INSERT INTO registration (event_id, user_id, quantity, reg_datetime ) VALUES (:event_id, :user_id, :quantity, NOW())');
            $reg_query->bindValue(':event_id', $the_row->first_reg, PDO::PARAM_INT);
            $reg_query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $reg_query->bindValue(':quantity', '1', PDO::PARAM_INT);
            $reg_query->execute();

            #for now event id is first reg
        	$spots_sold_query = $this->db_connection->prepare('UPDATE produkte SET spots_sold = spots_sold+:spot WHERE n = :event_id');
        	$spots_sold_query->bindValue(':spot', 1, PDO::PARAM_INT);
        	$spots_sold_query->bindValue(':event_id', $the_row->first_reg, PDO::PARAM_INT);
        	$spots_sold_query->execute();

            }
			else {
            	#first_reg carry type of event and event id  
            	#this bit catches first_reg from projekte and registers to reg db
            	list($event_type, $event_id) = explode('_', $the_row->first_reg);

				#o_salon
            	#use switch when moving on...
            	if ($event_type === 'projekt') {
                
                	$reg_projekt_query = $this->db_connection->prepare('INSERT INTO registration (event_id, user_id, quantity, reg_datetime ) VALUES (:event_id, :user_id, :quantity, NOW())');
               		$reg_projekt_query->bindValue(':event_id', $event_id, PDO::PARAM_INT);
               		$reg_projekt_query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                	$reg_projekt_query->bindValue(':quantity', $the_row->Gesamt, PDO::PARAM_INT);
                	$reg_projekt_query->execute();

                	#$the_row->Gesamt is being used temporarily as it only exist in grey user
                	#$the_row->Gesamt is not being copied to mitgliederExt
                	$projekt_spots_sold_query = $this->db_connection->prepare("UPDATE produkte SET spots_sold = spots_sold+:betrag WHERE n LIKE :event_id");
                	$projekt_spots_sold_query->bindValue(':betrag', $the_row->Gesamt, PDO::PARAM_INT);
                	$projekt_spots_sold_query->bindValue(':event_id', $event_id, PDO::PARAM_STR);
                	$projekt_spots_sold_query->execute();
            	}

            	#updates relevant dbs for open salons
            	#workaround for open salons $event_type = $event_id and $event_id = $quantity
            	if (is_numeric($event_type)) {
                
                	$reg_o_salon_query = $this->db_connection->prepare('INSERT INTO registration (event_id, user_id, quantity, reg_datetime) VALUES (:event_id, :user_id, :quantity, NOW() )');
                	$reg_o_salon_query->bindValue(':event_id', $event_type, PDO::PARAM_INT);
                	$reg_o_salon_query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                	$reg_o_salon_query->bindValue(':quantity', $event_id, PDO::PARAM_INT);
                	$reg_o_salon_query->execute();

                	$projekt_spots_sold_query = $this->db_connection->prepare("UPDATE produkte SET spots_sold = spots_sold+:spots_sold WHERE n LIKE :event_id");
                	$projekt_spots_sold_query->bindValue(':spots_sold', $event_id, PDO::PARAM_INT);
                	$projekt_spots_sold_query->bindValue(':event_id', $event_type, PDO::PARAM_STR);
                	$projekt_spots_sold_query->execute();
            	}
            }

            $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
            $query_delete_user->bindValue(':user_email', $the_row->user_email, PDO::PARAM_INT);
            $query_delete_user->execute();

            if ($verify_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
                
                // $_POST['user_rememberme'] = 1;
                $_SESSION['user_id'] = $user_id;
				
				//temporary email for open salon
				$osalon_query = $this->db_connection->prepare('SELECT * FROM produkte WHERE n = :event_id');
				$osalon_query->bindValue(':event_id', $event_type, PDO::PARAM_INT);
				$osalon_query->execute();
				
				$osalon_info = $osalon_query->fetchObject();
				if ($osalon_info->spots > 59 && $osalon_info->type == 'salon'){
					$this->openSalonUserEmail($the_row->user_email, $the_row->Anrede, $the_row->Nachname);
				}
            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
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

		public function openSalonUserEmail ($user_email, $user_anrede, $user_surname){
		#anrede
        
        if ($user_anrede == 'Frau'){
        	$anrede = 'Sehr geehrte Frau';
        }
		if ($user_anrede == 'Herr') {
			$anrede = 'Sehr geehrter Herr';
		}
      
        #read header from file
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header_new.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
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
                '.$anrede.' '.$user_surname.',
                <br>
                vielen Dank f&uuml;r Ihr Interesse an userem Offenen Salon!
                <br><br>
                Wir haben die gew&uuml;nschten Pl&auml;tze f&uuml;r Sie reserviert.<br>
                <br>
                Die Zahlung von 5&euro; pro Teilnehmer erfolgt am Abend des Salons vor Ort im Scholarium.<br>
                <br>
                Wir freuen uns darauf Sie kennenzulernen oder wiederzusehen.<br>
                <br>
                Herzliche Gr&uuml;&szlig;e aus Wien!';

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

	private function subscribeNewUser1($user_email, $user_level, $first_reg)
    {
        // we just remove extra space on email
        $user_email = trim($user_email);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (empty($user_email)) {
           $this->errors[] = MESSAGE_EMAIL_EMPTY;
          } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;       

        // finally if all the above checks are ok
        } elseif ($this->databaseConnection()) {
            // check if email already exists
            $query_check_user_email = $this->db_connection->prepare('SELECT user_email FROM mitgliederExt WHERE user_email=:user_email');
            $query_check_user_email->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_email->execute();
            $result = $query_check_user_email->fetchAll();

			if ($result[0]['user_email'] == $user_email) {
				$this->errors[] =  MESSAGE_EMAIL_ALREADY_EXISTS;

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
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO grey_user (user_email, Mitgliedschaft, first_reg, user_password_hash, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_email, :Mitgliedschaft, :first_reg, :user_password_hash, :user_activation_hash, :user_registration_ip, now())');

                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':first_reg', $first_reg, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':Mitgliedschaft', $user_level, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                $_SESSION['Mitgliedschaft'] = $user_level;
						
				$reg_info['user_activation_hash'] = $user_activation_hash;
				$reg_info['user_password']	= $user_password;			
                // id of new user
                $reg_info['grey_user_id'] = $this->db_connection->lastInsertId();
                $_SESSION['grey_user_id'] = $reg_info['grey_user_id'];

                if ($query_new_user_insert) {
                	//if info is successfully entered proceed
                	$this->registration_successful = true;
                	return $reg_info;

                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }
            }
        }
    }

	public function verifyNewUser1($user_id, $user_activation_hash)
    {
            // if database connection opened
            if ($this->databaseConnection()) {

			$general = new General();
			$email = new Email();

            //verify user - get data that will be inserted in the main database
            $verify_user = $this->db_connection->prepare('SELECT * FROM grey_user WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $verify_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_STR);
            $verify_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $verify_user->execute();

            // get result row (as an object)
            $the_row = $verify_user->fetchObject();

			#first_reg carries event type, event id and quantity 	
			list($product_type, $product_id, $quantity) = explode('_', $the_row->first_reg);
						
			$credits_left = 0;
			
			#set credits for seminare and upgrade, projekte and open salon don't get any
			if ($product_type === 'seminar') {
				$credits_left = 25;
			}
			if ($product_type === 'upgrade') {
				switch($the_row->Mitgliedschaft) {
					case 2: $credits_left = 75; break;
					case 3: $credits_left = 150; break;
					case 4: $credits_left = 300; break;
					case 5: $credits_left = 600; break;
					case 6: $credits_left = 1200; break;
					case 7: $credits_left = 2400; break;
					default: $credits_left = 0; break;
				}
			}

            #sets php timezone to Europe/Vienna
            #does the same for mysql in PDO way
            #this could be better in the header...
            date_default_timezone_set('Europe/Vienna');
            $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
            $query_time_zone->execute();

            //copy data to the main database
            $query_move_to_main = $this->db_connection->prepare('INSERT INTO 
                mitgliederExt 
                (user_email, Mitgliedschaft, Vorname, Nachname, Anrede, Land, Ort, Strasse, PLZ, Telefon, first_reg, credits_left, Ablauf, user_password_hash, user_registration_ip, user_active, user_registration_datetime) 
                VALUES
                (:user_email, :Mitgliedschaft, :name, :surname, :anrede, :country, :city, :street, :plz, :telefon, :first_reg, :credits_left, DATE_ADD(CURDATE(), INTERVAL 1 YEAR), :user_password_hash, :user_registration_ip, :user_active, NOW())');

            $query_move_to_main->bindValue(':user_email', $the_row->user_email, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':Mitgliedschaft', $the_row->Mitgliedschaft, PDO::PARAM_INT);

            $query_move_to_main->bindValue(':name', $the_row->Vorname, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':surname', $the_row->Nachname, PDO::PARAM_STR);
			$query_move_to_main->bindValue(':anrede', $the_row->Anrede, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':country', $the_row->Land, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':city', $the_row->Ort, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':street', $the_row->Strasse, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':plz', $the_row->PLZ, PDO::PARAM_INT);
			$query_move_to_main->bindValue(':telefon', $the_row->Telefon, PDO::PARAM_STR);

            $query_move_to_main->bindValue(':first_reg', $the_row->first_reg, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':credits_left', $credits_left, PDO::PARAM_INT);
        
            $query_move_to_main->bindValue(':user_password_hash', $the_row->user_password_hash, PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $query_move_to_main->bindValue(':user_active', '1', PDO::PARAM_INT);
            $query_move_to_main->execute();

            #capture the final user_id which will be in mitgliederExt
            $user_id = $this->db_connection->lastInsertId();
            $_SESSION['user_id'] = $user_id;
     		
			if ($product_type === 'seminar' || $product_type === 'projekt' || $product_id > 999) {
				
				#update registration and produkte
				$general->registerEvent($user_id, $product_id, $quantity);
								
				if ($product_type === 'seminar') {				
					#ticket generation
					$ticket_name = 'Ticket_'.$user_id.'_'.ucfirst($product_type).'_'.$product_id.'.pdf';
					$files[$ticket_name] = $general->generateTicket($user_id, $the_row->Vorname, $the_row->Nachname, $product_id, $quantity);
				}
			}
			if ($product_type === 'seminar' || $product_type === 'projekt' || $product_type === 'upgrade') {
				
				#invoice generation
				$invoice_name = 'Rechnung_'.$user_id.'.pdf';
				$files[$invoice_name]  = $general->generateInvoice($user_id, $product_id, $product_type, $the_row->Mitgliedschaft, $quantity, $the_row->Zahlungsart);
			}

            $query_delete_user = $this->db_connection->prepare('DELETE FROM grey_user WHERE user_email=:user_email');
            $query_delete_user->bindValue(':user_email', $the_row->user_email, PDO::PARAM_STR);
            $query_delete_user->execute();

            if ($verify_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
                
                $_POST['user_rememberme'] = 1;
				
				$email->sendConfirmation($the_row->user_email, $the_row->Nachname, $the_row->Anrede, $the_row->Mitgliedschaft, $files, $product_type, $the_row->Zahlungsart);

            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }

    private function sendEmail($from, $fromname, $to, $subject, $body) 
    {
        
    /*
     * $from = where should the email be comming from? normally info@scholarium.at, however maybe somedays from somewhere else to, stay flexible
     * $fromname = name of the source of the email. normally scholarium but who knows?
     * $to = who should the email be send to? user email or info@scholarium.at
     * $body = to be constructed in the functions above
     */

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $body,
            'from' => $from,
            'fromname' => $fromname
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
        $response = curl_exec($ch);

        if(empty($response))
        {
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

    #email sending based on the email templates
    #_README in templates/email for more info
    public function sendThisEmail($email_template, $post_data, $body_data) 
    {
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        require_once '../libraries/Twig-1.24.0/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('../templates/email');
        $twig = new Twig_Environment($loader, array('cache' => false));

        #select a template, base on the variable
        $emailTemplate = $twig->loadTemplate($email_template);

        #pass variables to template
        $body = $emailTemplate->render($body_data);

        #add rendered body based on the template
        $post_data['html'] = $body;

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
        $response = curl_exec($ch);

        #make a nice error message + log in the error log... 
        if(empty($response))
        {
            $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
            return false;
        }
        else
        {
            // $json = json_decode($response);
            return true;
        }

        curl_close($ch);
        
    }



}