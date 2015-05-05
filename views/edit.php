
<?php 

require_once('classes/Login.php');
include('_header.php'); 
// include ('testView.php');

?>

<div id="center">  
<div id="content">
<!-- <div id="tabs-wrapper-lower"></div> -->
<a class="content" href="../index.php">Index &raquo;</a>
<div id="tabs-wrapper-lower"></div>

<!-- clean separation of HTML and PHP -->
<h2>Profile</h2>


<!-- Your profile: <br> -->

 
<?php 
// echo $_SESSION['user_email'];

// $some = $login->getUserData($_SESSION['user_email']); 

$result_row = $login->getUserData(trim($_SESSION['user_email']));

// echo $result_row->Vorname."<br>";
// echo $result_row->Nachname."<br>";
// echo $result_row->Land."<br>";
// echo $result_row->Ort."<br>";
// echo $result_row->Strasse."<br>";
// echo $result_row->PLZ."<br>";


if ($result_row->gave_credits == 0) echo "Please fill in this form to get a free credit.";

if ( isset($result_row->Vorname) and trim($result_row->Vorname) and 
     isset($result_row->Nachname) and trim($result_row->Nachname) and
     isset($result_row->Land) and trim($result_row->Land) and
     isset($result_row->Ort) and trim($result_row->Ort) and
     isset($result_row->Strasse) and trim($result_row->Strasse) and
     ($result_row->gave_credits == 0)
     )
    {


    $login->messages[] = "You have just received a credit. Spend wisely!";

    $login->giveCredits();


    #page refresh after form was submitted
    #evaluate AJAX for such action in the future 
    echo '<meta http-equiv="refresh" content="0; url=http://test.wertewirtschaft.net/edit.php" />';


    }

?>
<hr/>
<br>



<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="user_edit_profile_form">

        <label for="user_email">Email</label>
<br> 
        <input id="user_email" type="email" value="<?php echo $_SESSION['user_email']; ?>"  name="profile[user_email]" required />
<br> 
        <label for="user_first_name">Name</label>
<br> 
        <input id="user_first_name" type="text" value="<?php echo $result_row->Vorname; ?>" name="profile[user_first_name]" required />
<br>
        <label for="user_surname">Surname</label>
<br> 
        <input id="user_surname" type="text" value="<?php echo $result_row->Nachname; ?>" name="profile[user_surname]" required />
<br>
        <label for="user_street">Street</label>
<br> 
        <input id="user_street" type="text" value="<?php echo $result_row->Strasse; ?>" name="profile[user_street]" required />
<br> 
        <label for="user_city">City</label>
<br> 
        <input id="user_city" type="text" value="<?php echo $result_row->Ort; ?>" name="profile[user_city]" required />
<br>
        <label for="user_country">Country</label>
<br> 
        <input id="user_country" type="text" value="<?php echo $result_row->Land; ?>" name="profile[user_country]" required />
<br>
        <label for="user_plz">Post code</label>
<br> 
        <input id="user_plz" type="text" value="<?php echo $result_row->PLZ; ?>" name="profile[user_plz]" required />
<br> 
   <br>  
<input type="submit" name="user_edit_profile_submit" value="SAVE CHANGES"/>
</form><hr/>


  


<br><br>



<!-- user_email
user_first_name
user_surname
user_street
user_city
user_country
user_plz -->

<!-- <form method="post" action="edit.php" name="user_edit_form_email">
    <label for="user_email"><?php echo WORDING_NEW_EMAIL; ?></label>
    <input id="user_email" type="email" name="user_email" required /> (<?php echo WORDING_CURRENTLY; ?>: <?php echo $_SESSION['user_email']; ?>)
    <input type="submit" name="user_edit_submit_email" value="<?php echo WORDING_CHANGE_EMAIL; ?>" />
</form><hr/> -->


<!-- Form to change name/surname  -->

<!-- <form method="post" action="edit.php" name="user_edit_form_name">
    <label for="user_first_name"></label>
    <input id="user_first_name" type="text" value="bla" name="user_first_name" placeholder="Name" required/>
<br>
    <label for="user_surname"></label>
    <input id="user_surname" type="text" name="user_surname" placeholder="Surname" required/>
<br>
    <input type="submit" name="user_edit_submit_name" value="Change Name" />
</form>
<hr/> -->


<!-- Form to change address -->
<!-- <form method="post" action="edit.php" name="user_edit_form_address">
   
    <label for="user_country"></label>
    <input id="user_country" type="text" name="user_country" placeholder="Country" required/>
<br>

    <label for="user_city"></label>
    <input id="user_city" type="text" name="user_city" placeholder="City" required/>
<br>
 
    <label for="user_street"></label>
    <input id="user_street" type="text" name="user_street" placeholder="Street" required/>
<br> 

    <label for="user_plz"></label>
    <input id="user_plz" type="text" name="user_plz" placeholder="PLZ" required/>
<br> 

    <input type="submit" name="user_edit_submit_address" value="Change Address" required/>
</form>
<hr/> -->
This is a password change form:
<hr>
<form method="post" action="edit.php" name="user_edit_form_password">
    <label for="user_password_old"><?php echo WORDING_OLD_PASSWORD; ?></label>
<br>
    <input id="user_password_old" type="password" name="user_password_old" autocomplete="off" />
<br>
    <label for="user_password_new"><?php echo WORDING_NEW_PASSWORD; ?></label>
<br>
    <input id="user_password_new" type="password" name="user_password_new" autocomplete="off" />
<br>
    <label for="user_password_repeat"><?php echo WORDING_NEW_PASSWORD_REPEAT; ?></label>
<br>
    <input id="user_password_repeat" type="password" name="user_password_repeat" autocomplete="off" />
<br>
<br>
    <input type="submit" name="user_edit_submit_password" value="<?php echo WORDING_CHANGE_PASSWORD; ?>" />
</form>
<hr/>
<br><br><br>

This is only used to test views of different memberships:
<hr/>
<form method="post" action="edit.php" name="user_edit_form_level">
    <label for="user_level"></label>
    <input id="user_level" type="text" name="user_level" placeholder="Membership Level" required/>
<br>
    <input type="submit" name="user_edit_form_level" value="Change Level" />
</form>
<hr/>

<!-- backlink -->
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>
