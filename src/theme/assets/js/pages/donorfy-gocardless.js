/*
    (c) Donorfy Ltd 2016
    Functions to support GoCardless Web Widget

    If you are making a change which would potentially break previously deployed web widgets then 
    1) create a new version of this file 
    2) update the references in webwidget_gocardless_directdebit_template
    3) create a new demo version of the file

*/


// make an id for the zap and the comment to edit the correct rpi
function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

var zapId = makeid(8);


if (typeof jQuery == 'undefined') {
    loadScript('https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.1.min.js', function () {
        jQuery(document).ready(function () {
            load();
        });
    });

} else {
    jQuery(document).ready(function () {
        load();
    });
}

function GetBaseServiceUrl() {
    return "https://api.donorfy.com/api/gocardless2/";
}


function loadScript(url, successFunction) {

    var script = document.createElement('script');
    script.src = url;
    var head = document.getElementsByTagName('head')[0],
        done = false;
    head.appendChild(script);
    // Attach handlers for all browsers
    script.onload = script.onreadystatechange = function () {
        if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
            done = true;

            if (successFunction) { successFunction(); }
            script.onload = script.onreadystatechange = null;
            head.removeChild(script);
        }
    };
}



function load() {

    jQuery('#submitButton').click(function (event) {

        if (ValidateForm()) {
            // Disable the submit button to prevent repeated clicks
            jQuery('#submitButton').attr('disabled', 'disabled');
            jQuery('#PleaseWait').show();
            zapier();
            PostPayment();

        }
        // Prevent the form from submitting with the default action
        jQuery('#submitButton').html('Setup Direct Debit');
        return false;
    });

    jQuery(document).ajaxSend(function () {
        jQuery('#spinner').show();
    });

    jQuery(document).ajaxStop(function () {
        jQuery('#spinner').hide();
    });

    jQuery(document).ajaxError(function () {
        jQuery('#spinner').hide();
    });

    jQuery('input.numberOnly[type=text]').on('keypress', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 44 && e.which != 45 && e.which != 46 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    jQuery('input#Amount').blur(function () {

        if (this.value) {
            var amt = parseFloat(this.value);
            jQuery(this).val(amt.toFixed(2));
        }
    });
}


function ValidateForm() {

    jQuery('#formFour').validate({

        groups: {
            sortcodeGroup: 'SortCode1 SortCode2 SortCode3'
        },
        errorPlacement: function (error, element) {
            if (element.attr('name') == 'SortCode1' || element.attr('name') == 'SortCode2' || element.attr('name') == 'SortCode3')
                error.insertAfter('#SortCode3');
            else
                error.insertAfter(element);
        },
        rules: {
            postSelect: {
                required: true
            },
            smsSelect: {
                required: true
            },
            emailSelect: {
                required: true
            },
            phoneSelect: {
                required: true
            }
        },
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                validator.errorList[0].element.focus();
            }
        }

    }).settings.ignore = ':disabled,:hidden';


    return jQuery('#formFour').valid();
}





function PostPayment() {

    jQuery.ajax({
        dataType: 'json',
        url: GetBaseServiceUrl() + 'directdebitpayment',
        data: GetPaymentPostData(),
        async: false,
        method: 'POST',
        type: 'POST'
    }).done(function (data) {

        if (data.OK) {
            RedirectToGoCardless(data.RedirectUrl);
        } else {
            jQuery('#submitButton').removeAttr('disabled');
            jQuery('#PleaseWait').hide();
            DisplayErrors(data.Errors);
            jQuery('#submitButton').html('Setup Direct Debit');
        }

    }).fail(function (jqXHR, textStatus, errorThrown) {

        jQuery('#submitButton').removeAttr('disabled');
        jQuery('#submitButton').html('Setup Direct Debit');
        jQuery('#PleaseWait').hide();
        DisplayErrors(GetErrorArray(jqXHR))
    });

}


function GetPaymentPostData() {

    return {
        title: jQuery('#Title').val(),
        firstName: jQuery('#FirstName').val(),
        lastName: jQuery('#LastName').val(),
        email: jQuery('#Email').val(),
        phone: jQuery('#Phone').val(),
        address1: jQuery('#Address1').val(),
        address2: jQuery('#Address2').val(),
        town: jQuery('#Town').val(),
        county: jQuery('#County').val(),
        postCode: jQuery('#Postcode').val(),
        country: jQuery('#Country').length > 0 ? jQuery('#Country').val() : '',
        giftAid: jQuery('#GiftAid').is(':checked'),
        keepInTouch: GetKeepInTouchValue(),
        doNotKeepInTouch: GetDoNotKeepInTouchValue(),
        optInShown: GetOptInShownValue(),
        legitInterestShown: GetLegitInterestShownValue(),
        amount: jQuery('#Amount').val(),
        accountNumber: jQuery('#AccountNumber').val(),
        sortCode: GetSortCode(),
        tenantCode: jQuery('#TenantCode').val(),
        widgetId: jQuery('#WidgetId').val(),
        paymentSchedule: jQuery('input:radio[name=PaymentSchedule]:checked').val(),
        comment: zapId,
        quantity: jQuery('#Quantity').length > 0 ? jQuery('#Quantity').val() : '1',
        additionalTitle: jQuery('#AdditionalTitle').length > 0 ? jQuery('#AdditionalTitle').val() : '',
        additionalFirstName: jQuery('#AdditionalFirstName').length > 0 ? jQuery('#AdditionalFirstName').val() : '',
        additionalLastName: jQuery('#AdditionalLastName').length > 0 ? jQuery('#AdditionalLastName').val() : '',
        additionalEmail: jQuery('#AdditionalEmail').length > 0 ? jQuery('#AdditionalEmail').val() : '',
        additionalPhone: jQuery('#AdditionalPhone').length > 0 ? jQuery('#AdditionalPhone').val() : '',
        additionalAddress1: jQuery('#AdditionalAddress1').length > 0 ? jQuery('#AdditionalAddress1').val() : '',
        additionalAddress2: jQuery('#AdditionalAddress2').length > 0 ? jQuery('#AdditionalAddress2').val() : '',
        additionalTown: jQuery('#AdditionalTown').length > 0 ? jQuery('#AdditionalTown').val() : '',
        additionalCounty: jQuery('#AdditionalCounty').length > 0 ? jQuery('#AdditionalCounty').val() : '',
        additionalPostcode: jQuery('#AdditionalPostcode').length > 0 ? jQuery('#AdditionalPostcode').val() : '',
        additionalCountry: jQuery('#AdditionalCountry').length > 0 ? jQuery('#AdditionalCountry').val() : '',
        activeTags: jQuery('#ActiveTags').length > 0 ? jQuery('#ActiveTags').val() : '',
        blockedTags: jQuery('#BlockedTags').length > 0 ? jQuery('#BlockedTags').val() : ''
    };
}


function GetOptInShownValue() {
    var keepInTouchValue = 0;
    jQuery('input.KeepInTouch[type=checkbox]').each(function () {
        keepInTouchValue += parseInt(jQuery(this).val());
    });
    return keepInTouchValue;
}
function GetLegitInterestShownValue() {
    var doNotKeepInTouchValue = 0;
    jQuery('input.DoNotKeepInTouch[type=checkbox]').each(function () {
        doNotKeepInTouchValue += parseInt(jQuery(this).val());
    });
    return doNotKeepInTouchValue;
}

function GetDoNotKeepInTouchValue() {
    var doNotKeepInTouchValue = 0;
    jQuery('input.DoNotKeepInTouch[type=checkbox]:checked').each(function () {
        doNotKeepInTouchValue += parseInt(jQuery(this).val());
    });
    return doNotKeepInTouchValue;
}

function GetKeepInTouchValue() {

    var keepInTouchValue = 0;

    jQuery('input.KeepInTouch[type=checkbox]:checked').each(function () {
        keepInTouchValue += parseInt(jQuery(this).val());
    });

    return keepInTouchValue;
}

function GetSortCode() {

    return jQuery('#SortCode1').val() + jQuery('#SortCode2').val() + jQuery('#SortCode3').val();

}


function GetErrorArray(jqXHR) {

    var errors = [];

    var response = JSON.parse(jqXHR.responseText);

    if (response.ModelState) {
        for (var key in response.ModelState) {
            errors.push(response.ModelState[key]);
        }
    }
    else if (response.Message) {
        errors.push(response.Message);
    }
    else {
        errors.push('An unexpected error occurred.');
    }

    return errors;
}


function DisplayErrors(errors) {

    jQuery('#ErrorContainer').show();

    var errorMessage = '';

    jQuery.each(errors, function (index, value) {

        errorMessage += value + '<br/>';
    });

    jQuery('#Errors').html(errorMessage);
}

function RedirectToGoCardless(redirectUrl) {
    //redirect to GoCardless payment pages
    if (redirectUrl) {
        let date = new Date();
        let minutes = 15;
        let amount = jQuery('#Amount').val();
        let name = jQuery('#FirstName').val();
        let signup = jQuery('#emailSelect').val();
        date.setTime(date.getTime() + (minutes * 60 * 1000));

        //set cookie for amount
        Cookies.set('wordpress_guardian_amount', amount, { path: '/', expires: date });

        //set cookie for tid
        let tid = makeid(8);
        Cookies.set('wordpress_guardian_tid', tid, { path: '/', expires: date });

        //set cookie for name
        Cookies.set('wordpress_guardian_name', name, { path: '/', expires: date });

        //set cookie for signup
        Cookies.set('wordpress_guardian_signup', signup, { path: '/', expires: date });

        window.location = redirectUrl;
    } else {
        var errors = [];
        errors.push('Unable to redirect to GoCardless');
        DisplayErrors(errors);
    }
}

function zapier() {

    var data = {
        email: jQuery('#Email').val(),
        Amount: jQuery('#Amount').val(),
        collectionDay: jQuery('#paymentDay').val(),
        giftAid: jQuery('#GiftAid').is(':checked'),
        comments: jQuery('#inspiration_question').val() + " " + jQuery('#Comment').val(),
        campaign: jQuery('#Campaign').val(),
        id: zapId,
        firstname: jQuery('#FirstName').val(),
        lastname: jQuery('#LastName').val(),
        emailUpdates: jQuery("#emailPreference").is(':checked')
    };

    jQuery.ajax({
        type: 'POST',
        url: 'https://hooks.zapier.com/hooks/catch/8597852/bk64mw8/',
        data: JSON.stringify(data),
        success: function (data) {
            console.log('sent to zapier');
        },
        error: function (xhr, status, error) {
            console.log('failed to send to zapier');
        }
    });
}





