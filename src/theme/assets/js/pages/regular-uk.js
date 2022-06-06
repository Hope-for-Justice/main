jQuery(document).ready(function($) {

$('#formOne').validate({
    // rules
    rules: {
        Email: {
          required: true,
          email: true
        }
    },
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {                    
            validator.errorList[0].element.focus();
        }
    }
});

$('#formTwo').validate({
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {                    
            validator.errorList[0].element.focus();
        }
    }
});

$('#formThree').validate({
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {                    
            validator.errorList[0].element.focus();
        }
    }
});

// $('#formOne').hide();
// $('#formTwo').hide();
// $('#formThree').show();

$("#GiftAidSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#GiftAid").prop('checked', true);
    } else {
       $("#GiftAid").prop('checked', false); 
    }
});

$("#emailSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#emailPreference").prop('checked', true);
    } else {
       $("#emailPreference").prop('checked', false); 
    }
});

$("#postSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#postPreference").prop('checked', true);
    } else {
       $("#postPreference").prop('checked', false); 
    }
});

$("#smsSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#smsPreference").prop('checked', true);
    } else {
       $("#smsPreference").prop('checked', false); 
    }
});

$("#phoneSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#phonePreference").prop('checked', true);
    } else {
       $("#phonePreference").prop('checked', false); 
    }
});

$('#toStepTwo').click(function(){
setTimeout(
    function() {
        if ($('#formOne').valid()) {
          	$('#formOne').hide();
        	$('#formTwo').show();
        	let email = $('#Email').val();
            let paymentDay = $('#paymentDay').val();
            console.log(paymentDay)
        	$.ajax({
                method : 'POST',
                url : '/wp-content/themes/hope-for-justice-2020/duplicate-check.php',
                // /wp-content/ wp-engine
                // /build/ local
                data : {Email: email},
                success: function(output) {
                    let obj = $.parseJSON(output)
                    let id = obj[0].ConstituentId;
                    console.log(output);

                    if(id) {
                      getPreferences(id);
                    }

                }
            });
            $(window).scrollTop(0);
        }
        $('#toStepTwo').html("Next");
    },400);
});

$('#backToStepOne').click(function(){
    setTimeout(
    function() {
        $('#formOne').show();
        $('#formTwo').hide();
        $('#backToStepOne').html("Previous");
        $(window).scrollTop(0);
    },400);
});

$('#toStepThree').click(function(){
    setTimeout(
    function() {
        if ($('#formTwo').valid()) {
            $('#formThree').show();
            $('#formTwo').hide();
            $(window).scrollTop(0);
        }
        $('#toStepThree').html("Next");
    },400);
});

$('#backToStepTwo').click(function(){
    setTimeout(
    function() {
        $('#formTwo').show();
        $('#formThree').hide();
        $('#backToStepTwo').html("Previous");
        $(window).scrollTop(0);
    },400);
});

$('#toStepFour').click(function(){
    setTimeout(
    function() {
        if ($('#formThree').valid()) {
            $('#formFour').show();
            $('#formThree').hide();
            $(window).scrollTop(0);
        }
        $('#toStepFour').html("Next");
    },400);
});

$('#backToStepThree').click(function(){
    setTimeout(
    function() {
        $('#formThree').show();
        $('#formFour').hide();
        $('#backToStepThree').html("Previous");
        $(window).scrollTop(0);
    },400);
});


function getPreferences(id) {

    $.ajax({
        method : 'POST',
        url : '/wp-content/themes/hope-for-justice-2020/get-preferences.php',
        // /wp-content/ wp-engine
        // /build/ local
        data : {ConstituentId: id},
        success: function(output) {
            let obj = $.parseJSON(output);
            console.log(obj);
            
            let emailUpdates;
            let mailUpdates;
            let phoneUpdates;
            let smsUpdates;

            $.each(obj.PreferencesList, function(i, v) {
                if (v.PreferenceName == "Email Updates") {
                    emailUpdates = v.PreferenceAllowed;
                } else if (v.PreferenceName == "Mail") {
                    mailUpdates = v.PreferenceAllowed;
                } else if (v.PreferenceName == "Phone") {
                    phoneUpdates = v.PreferenceAllowed;
                } else if (v.PreferenceName == "SMS") {
                    smsUpdates = v.PreferenceAllowed;
                }

            });

            console.log(emailUpdates, mailUpdates, phoneUpdates, smsUpdates);
            setPreferences(emailUpdates, mailUpdates, phoneUpdates, smsUpdates);

        }
    });
}

function setPreferences(email, mail, phone, sms) {
	console.log("setting preferences...");
    if (email) {
      $('#emailSelect').val("true").change();
    } else if (email == false) {
    	$('#emailSelect').val("false").change();

    }

    if (mail) {
      	$('#postSelect').val("true").change();
    } else if (mail == false) {
    	$('#postSelect').val("false").change();
    }

    if (phone) {
      $('#phoneSelect').val("true").change();
    } else if (phone == false) {
    	$('#phoneSelect').val("false").change();
    }

    if (sms) {
      $('#smsSelect').val("true").change();
    } else if (sms == false) {
    	$('#smsSelect').val("false").change();
    }

}

});
