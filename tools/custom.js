/*
done by dainius

required stuff for the html based on this script:

user_email field in the html form must have id ajax_email_exists
id="ajax_email_exists"

after the email input box, to display the error message
<div id="ajax_email_exists_error"></div> 

this must be in the submit button to be disabled if email already exists
id="weiter_button"
*/

//function used to validate email
function validateEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

//main script to check for duplicate emails and error display
//+some jquery to focus on modal load
$(document).ready(function()
{
	//once form is loaded, places cursor in the text box
	$("#ajax_email_exists").focus();

	$("#ajax_email_exists").change(function() 
	{
		var ajax_email_exists = $("#ajax_email_exists").val();

		if(validateEmail(ajax_email_exists))
		{
	  	    $.post('/tools/ajax_email_exists.php',{user_email: $('#ajax_email_exists').val()}, function(response){
			    if(response.exists){
			        $("#ajax_email_exists_error").fadeIn("fast").html('Wir kennen Sie schon - bitte zu Ihrer Sicherheit durch Log-In Identit&auml;t best&auml;tigen: rechts oben &quot;Anmelden&quot; anklicken.');
			        $("#ajax_email_exists_error").addClass("error");
			        $("#ajax_email_exists").addClass("error--input");
			        $("#weiter_button").attr("disabled", "disabled");     
				}
				else
				{
			        //user email does not exist - enable the button
			        $("#weiter_button").removeAttr("disabled");
			        $("#ajax_email_exists_error").fadeOut('fast');
			        $("#ajax_email_exists").removeClass("error--input");   
			    }
		 	}, 'JSON');
		}
		else
		{
			//keep button enabled if email is not validated
			$("#weiter_button").removeAttr("disabled");
			$("#ajax_email_exists_error").fadeOut('fast');    
		}

	});

	$("#ajax_email_exists2").change(function()
	{
		var ajax_email_exists = $("#ajax_email_exists").val();
		var ajax_email_exists2 = $("#ajax_email_exists2").val();
		
		if(validateEmail(ajax_email_exists) && validateEmail(ajax_email_exists2))
		{
			$.post('/tools/ajax_email_same.php',{user_email: $('#ajax_email_exists').val(), user_email2: $('#ajax_email_exists2').val()}, function(response){
				if(response.notsame)
				{
					$("#ajax_email_same_error").fadeIn("fast").html('Die E-Mails sind nicht identisch.');
					$("#ajax_email_same_error").addClass("error");
					$("#ajax_email_same_error").addClass("h-nofloat");
			        $("#ajax_email_exists2").addClass("error--input");
			        $("#weiter_button").attr("disabled", "disabled");	      
				}
				else
				{
					//user emails are the same - enable the button, remove error
			 		$("#weiter_button").removeAttr("disabled");
			 		$("#ajax_email_same_error").fadeOut('fast');
			 		$("#ajax_email_exists2").removeClass("error--input");
			 		$("#ajax_email_exists").addClass("message--input");
			 		$("#ajax_email_exists2").addClass("message--input");
				}
			}, 'JSON');
		}
		else
		{
			//keep button enabled if email is not validated
			$("#weiter_button").removeAttr("disabled");
			$("#ajax_email_exists_error").fadeOut('fast'); 
		}
	});

	// autofocus for login form in the header
	$('#login').on('shown.bs.modal', function() {
    	$("#user_email_login").focus();      
	});

	// autofocus for signup form in the header
	$('#signup').on('shown.bs.modal', function() {
    	$("#user_email_signup").focus();      
  	});

});