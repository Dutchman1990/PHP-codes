
jQuery.validator.addMethod("email", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])|(yahoo|gmail|hotmail|outlook)+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
}, 'Please enter a valid email.');

jQuery.validator.addMethod("lastname", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^[a-z ,.'-]+$/i.test( value );
}, 'Please enter a valid last name.');

jQuery.validator.addMethod("firstname", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^[a-z ,.'-]+$/i.test( value );
}, 'Please enter a valid first name.');


jQuery.validator.addMethod("password", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/.test( value );
}, 'Please enter a valid Password.(Min 8 Char)');

jQuery.validator.addMethod("phone", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /\d{3}[\-]\d{3}[\-]\d{4}/.test( value );
}, 'Please enter a valid 10 digit Phone No.');


        $(function(){
            $("#phone").intlTelInput({
      utilsScript: "utils.js"
    });

            $('#myform').validate({
                rules:{
                    firstname:{
                        required:true,
                        firstname:true
                    },
                    lastname:{
                        required:true,
                        lastname:true,

                    },
                    email:{
                        required:true,
                        email:true
                    },
                    password:{
                        required:true,
                        password:true,
                        minlength:8
                    },
                    repeatpassword:{
                        required:true,
                        equalTo:'#password'
                        //repeatpassword:true
                    },
                    phone:{
                        required:true,
                        phone:true,
                        //minlength:10,
                        //maxlength:12,
                        //remove_lt_whitespace: true

                    }
                },
                messages:{
                    password: {
                    required: "Please provide a Password",
                    minlength: "Your password must be at least 8 characters long"
                },
                    repeatpassword:{
                        required:"Retype Password",
                        equalTo:"Password Does Not Match"
                    },
                    phone:{
                        required:"This Field is required."
                    }
                },
                errorPlacement: function(){
            return false;  // suppresses error message text
        },
        error: function(label) {
     $(this).addClass("error");
   }
        });
    });

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 && charCode!=40 && charCode!=41 && charCode!=43 && charCode!=32
            && charCode!=45 && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }


$(function(){
    $("#email").keyup(function(){
        var name=$("#email").val();{
            $("#checkmail").text(name);
        }
        });                        
    });
