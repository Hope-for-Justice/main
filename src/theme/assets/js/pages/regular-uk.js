jQuery(document).ready(function($) {

$('#formOne').validate({
    // rules
    rules: {
        Email: {
          required: true,
          email: true
        }
    }
});

$('#formTwo').validate({
    // rules
});

$('#formThree').validate({
    // rules
});

// $('#formOne').hide();
// $('#formTwo').hide();
// $('#formThree').show();

$("#GiftAidSelect").on('change', function(){
	if ($(this).val() == "true") {
		$("#GiftAid").prop('checked', true);
	}
})

$('#toStepTwo').click(function(){
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

  }
});

$('#backToStepOne').click(function(){
  	$('#formOne').show();
	$('#formTwo').hide();
});

$('#toStepThree').click(function(){
	if ($('#formTwo').valid()) {
  		$('#DirectDebitForm').show();
		$('#formTwo').hide();
	}
});

$('#backToStepTwo').click(function(){
  	$('#formTwo').show();
	$('#DirectDebitForm').hide();
});


function getPreferences(id) {

    $.ajax({
        method : 'POST',
        url : '/build/themes/hope-for-justice-2020/get-preferences.php',
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
      	$('#postPreference').val("true").change();
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
