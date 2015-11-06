// done by dainius

$(document).ready(function(){

  $('#login').on('shown.bs.modal', function() {
      $("#user_email_login").focus();      
  });

  $('#signup').on('shown.bs.modal', function() {
      $("#user_email_signup").focus();      
  });

});