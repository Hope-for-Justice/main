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
            $('#dotOne').toggleClass('donorfy-donate__dot--active');
            $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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

                    if (obj.length !== 0) {
                        let id = obj[0].ConstituentId;
                        console.log(output);
                        getPreferences(id);
                        $('#preferenceText').html('These are the preferences we hold for ');
                        $('#emailText').show();
                        $('#emailAppend').show();

                    } else {
                        resetPreferences();
                        $('#preferenceText').html('We would love for you to hear about the life-changing difference that your donation will make and more ways you can support this work. Can we contact you via:');
                        $('#emailText').hide();
                        $('#emailAppend').hide();
                    }

                },
                error: function() {
                    $('#preferenceText').html('We would love for you to hear about the life-changing difference that your donation will make and more ways you can support this work. Can we contact you via:');
                    $('#emailText').hide();
                    $('#emailAppend').hide();
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
        $('#dotOne').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
        $('#backToStepOne').html("Previous");
        $(window).scrollTop(0);
    },400);
});

$('#toStepThree').click(function(){
    setTimeout(
    function() {
        if ($('#formTwo').valid()) {
            $('#dotThree').toggleClass('donorfy-donate__dot--active');
            $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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
        $('#dotThree').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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
            $('#dotThree').toggleClass('donorfy-donate__dot--active');
            $('#dotFour').toggleClass('donorfy-donate__dot--active');
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
        $('#dotThree').toggleClass('donorfy-donate__dot--active');
        $('#dotFour').toggleClass('donorfy-donate__dot--active');
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

function resetPreferences() {
    $('#emailSelect').val("").change();
    $('#postSelect').val("").change();
    $('#phoneSelect').val("").change();
    $('#smsSelect').val("").change();
}

});
