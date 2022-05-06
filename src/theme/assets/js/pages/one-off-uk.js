jQuery(document).ready(function($) {

$('#formOne').validate({
    // rules
    rules: {
        field1: {
            required: true
        }
    }
});

$('#formTwo').validate({
    // rules
    rules: {
        field2: {
            required: true
        }
    }
});

$('#formThree').validate({
    // rules,
    rules: {
        field3: {
            required: true
        }
    },
});


$('#toStepTwo').click(function(){
  if ($('#formOne').valid()) {
    $('#formOne').hide();
    $('#formTwo').show();
  }
});



$('#testButton').click(function(){ 

    $.ajax({
        method : 'GET',
        url : '/build/themes/hope-for-justice-2020/duplicate-check.php',
        success: function(output) {
            let obj = $.parseJSON(output)
            let id = obj[0].ConstituentId;
            console.log(output);

            if(id) {
              getPreferences(id);
            }

        }
    });

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
    if (email) {
      $('#emailPreference').prop('checked', true);
    }
}

});