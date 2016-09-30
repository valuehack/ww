//Smoothscroll function
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

//Show and Hide Nav on Mobile Screens
function showNav() {
	if (document.documentElement.clientWidth < 550) {
		aObj = document.getElementById('nav');
		if (aObj.style.display == 'none' || aObj.style.display == '') {
			aObj.style.display = 'block';
		}
		else {
			aObj.style.display = 'none';
		}
	}
}

//Dismiss Notice            
function dismissNotice() {
	aObj = document.getElementById('notice');
	if (aObj.style.display == 'none') {
		aObj.style.display = 'block';
	}
	else {
		aObj.style.display = 'none';
	}
}

//Spam Prevention with honeypot method
	function validateMyForm() {
		// The field is empty, submit the form.
		if(!document.getElementById("honeypot").value) { 
			return true;
		} 
		 // the field has a value it's a spam bot
		else {
			return false;
		}
	}