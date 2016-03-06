$(document).ready(function() {
$.get("signUp.php?check=login", function ( data ) {
  if(data=='true') {
    window.location = 'invoices.php';
  }
});

/* Validate and process the sign up form */          
$.validate({
  form : '#form-signUp',
  onSuccess : function () { // If validation is valid we process the form 
    
    var email = $("#email").val();
    var password = $("#password").val();
    var fullName = $("#fullName").val();
    var company = $("#company").val();
    var userAddress = $("#userAddress").val();
    var dataString = 'email=' + email + '&password=' + password + '&fullName=' + fullName + '&company=' + company + '&userAddress=' + userAddress;
        
    /* Make ajax call to our PHP file to save the review & rating */
    $.ajax({
        
      type : "POST",
      url : "signUp.php", // our php login 
      data : dataString,
      cache : false,
      beforeSend: function() {
        $('.loading').html('<img src="resources/templates/assets/img/ajax-loader.gif" />');
      },
      success : function (data) {				
        if(data=='true') {
        $(".success-msg").fadeIn(1500);
          setTimeout(function() {
  window.location.href = "login.php";
}, 3500);  
        } else {
          $(".loading").hide();

          $(".error-msg").fadeIn(1500);
          $(".error-msg").html(data);
          
          $("#username").focus(function () {
            $(".error-msg").hide();
          });
        }
      }
          
    });
        
    return false;

  }
});
});