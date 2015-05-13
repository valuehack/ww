/*
 cc:scriptime.blogspot.in
 edited by :midhun.pottmmal
*/

//function used to validate email
function validateEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$(document).ready(function(){
	$(document).click(function(){
		//$("#ajax_response").fadeOut('slow');
	});
	$("#keyword").focus();
	var offset = $("#keyword").offset();
	var width = $("#keyword").width()-2;
	//$("#ajax_response").css("left",offset.left); 
	//$("#ajax_response").css("width",width);

	$("#keyword").keyup(function(event){
		 //alert(event.keyCode);
		 var keyword = $("#keyword").val();
		 
		 //trying to reduce ajax request, only keep the relevant ones
		 //sends ajax only if the input is validated as email
		 if(validateEmail(keyword) )
		 {

		 	/*
				Enter 	13
				Up arrow 	38
				Down arrow 	40
			*/
			
			 if(event.keyCode != 40 && event.keyCode != 38 && event.keyCode != 13)
			 {
				 $("#loading").css("visibility","visible");
				 $.ajax({
				   type: "POST",
				   url: "/name_fetch.php",
				   data: "data="+keyword,
				   success: function(msg){	
					if(msg != 0)
					{
					//success - found a member with such email
					//now what?	
						//cant change name attribute
						//$("#ajax_response").fadeIn("slow").html(msg);
						$("#user_password").show();
						$("#inputbutton").attr("value", "Anmelden");
						
					}
					else
					{
					  	//$("#ajax_response").fadeIn("slow");	
					  	//$("#ajax_response").html('<div style="text-align:left;">No Matches Found</div>');
						$("#user_password").hide();
						$("#inputbutton").attr("value", "Eintragen");
						
					}
					$("#loading").css("visibility","hidden");
				   }
				 });
			 }
			 else
			 {
				switch (event.keyCode)
				{
				 case 40:
				 {
					  found = 0;
					  $("li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $("li[class='selected']");
						sel.next().addClass("selected");
						sel.removeClass("selected");
					  }
					  else
						$("li:first").addClass("selected");
					 }
				 break;
				 case 38:
				 {
					  found = 0;
					  $("li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $("li[class='selected']");
						sel.prev().addClass("selected");
						sel.removeClass("selected");
					  }
					  else
						$("li:last").addClass("selected");
				 }
				 break;
				 case 13:
					$("#ajax_response").fadeOut("slow");
					$("#keyword").val($("li[class='selected'] a").text());
				 break;
				}
			 }
		 }
		 else
			$("#ajax_response").fadeOut("slow");
	});

	$("#ajax_response").mouseover(function(){
		$(this).find("li a:first-child").mouseover(function () {
			  $(this).addClass("selected");
		});
		$(this).find("li a:first-child").mouseout(function () {
			  $(this).removeClass("selected");
		});
		$(this).find("li a:first-child").click(function () {
			  $("#keyword").val($(this).text());
			  $("#ajax_response").fadeOut("slow");
		});
	});
});