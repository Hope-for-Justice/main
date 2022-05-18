/*
(c) Donorfy Ltd 2020

Functions to support Credit Card Web Widget
Designed to use Stripe Elements

If you are making a change which would potentially break previously deployed web widgets then
1) create a new version of this file
2) update the references in webwidget_stripe_sca_creditcard_template and  donationpage_stripe_sca_creditcard_template.html
3) create a new demo version of the file


 */
// ReSharper disable UseOfImplicitGlobalInFunctionScope
// ReSharper disable AssignToImplicitGlobalInFunctionScope
if (typeof jQuery === 'undefined') {
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
       return "https://api.donorfy.com/api/stripe/";
}

function load() {

    if (typeof jQuery.validator === 'undefined') {
        loadScript('https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js');
    }

    var code = jQuery('#TenantCode').val();
    var id = jQuery('#WidgetId').val();
    if (id === "") {
        id = jQuery('#DonationPageId').val();
    }
    jQuery.ajax({
        dataType: 'json',
        url: GetBaseServiceUrl() + 'P0?id=' + id + '&code=' + code,
        method: 'POST',
        type: 'POST'
    }).done(function(data) {

        if (data.OK) {
            jQuery('#spinner').hide();
            var key = data.RequestData;
            stripe = Stripe(key);
            elements = stripe.elements();

            window.cardNumber = elements.create('cardNumber');
            window.cardNumber.mount('#card-number');

            window.cardExpiry = elements.create('cardExpiry');
            cardExpiry.mount('#card-expiry');

            window.cardCvc = elements.create('cardCvc');
            cardCvc.mount('#card-cvc');

            submitButton = document.getElementById('submitButton');
            submitButton.addEventListener('click',
                function(ev) {
                    DisableSubmitButton();
                    ResetErrorMessage();
                    if (ValidateForm()) {
                        try {
                            Process();
                        } catch (e) {
                            EnableSubmitButton();
                            console.log('Exception  ' + e);
                            ev.preventDefault();
                            return false;
                        }

                    } else {
                        EnableSubmitButton();
                        DisplayErrorMessage('please scroll up to see the details');
                    }
                    ev.preventDefault();
                    return false;
                });


            jQuery('input.numberOnly[type=text]').on('keypress',
                function(e) {
                    if (e.which !== 8 &&
                        e.which !== 44 &&
                        e.which !== 45 &&
                        e.which !== 46 &&
                        e.which !== 0 &&
                        (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                    return true;
                });

            jQuery('input#Amount').blur(function() {

                if (this.value) {
                    var amt = parseFloat(this.value);
                    jQuery(this).val(amt.toFixed(2));
                }
            });


            jQuery("input[name='PaymentType']").on("click",
                function() {

                    if (jQuery(this).val() === 'Recurring') {
                        jQuery('#PaymentScheduleRow').show();
                    } else {
                        jQuery('#PaymentScheduleRow').hide();
                    }
                });

            try {
                InitialiseForm();
            } catch (e) {
                console.log('Exception calling InitialiseForm() ' + e);
            }
        } else {
            DisplayErrors(data.Errors);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        DisplayErrors(GetErrorArray(jqXHR));
        return "";
    });
    return "";
}

function loadScript(url, successFunction) {

    var script = document.createElement('script');
    script.src = url;
    var head = document.getElementsByTagName('head')[0],
        done = false;
    head.appendChild(script);
    script.onload = script.onreadystatechange = function () {
        if (!done && (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete')) {
            done = true;

            if (successFunction) {
                successFunction();
            }
            script.onload = script.onreadystatechange = null;
            head.removeChild(script);
        }
    };
}

function Initialise() {
    var code = jQuery('#TenantCode').val();
    var id = jQuery('#WidgetId').val();
    if (id === "") {
        id = jQuery('#DonationPageId').val();
    }
    jQuery.ajax({
        dataType: 'json',
        url: GetBaseServiceUrl() + 'P0?id=' + id + '&code=' + code,
        method: 'POST',
        type: 'POST'
    }).done(function(data) {

        if (data.OK) {
            return data.RequestData;
        } else {
            DisplayErrors(data.Errors);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        DisplayErrors(GetErrorArray(jqXHR));
        return "";
    });
    return "";
}

function ValidateForm() {
    jQuery('#CreditCardForm').validate().settings.ignore = ':disabled,:hidden';
    return jQuery('#CreditCardForm').valid();
}


function Process() {

    var code = jQuery('#TenantCode').val();
    var email = jQuery('#Email').val();
    var emailEnc = encodeURIComponent(email);
    var recurring = jQuery('#RecurringPayment').is(':checked');
    var id = jQuery('#WidgetId').val();
    if (id === "") {
        id = jQuery('#DonationPageId').val();
    }
    var amount = jQuery('#Amount').val();
    amount = amount.replace(/\D/g, '');

    var firstName = jQuery('#FirstName').length > 0 ? jQuery('#FirstName').val() : '';
    var lastName = jQuery('#LastName').length > 0 ? jQuery('#LastName').val() : '';
    var town = jQuery('#Town').length > 0 ? jQuery('#Town').val() : '';
    var address2 = jQuery('#Address2').length > 0 ? jQuery('#Address2').val() : '';
    var address1 = jQuery('#Address1').length > 0 ? jQuery('#Address1').val() : '';
    var postcode = jQuery('#Postcode').length > 0 ? jQuery('#Postcode').val() : '';
    var county = jQuery('#County').length > 0 ? jQuery('#County').val() : '';


    var siteKey = jQuery('#ReCaptchaSiteKey').val();
    var action = jQuery('#ReCaptchaAction').val();

    try {
        grecaptcha.ready(function() {
            grecaptcha.execute(siteKey, { action: action }).then(function(token) {
                jQuery.ajax({
                    dataType: 'json',
                    url: GetBaseServiceUrl() +
                        'P1?id=' +
                        id +
                        '&code=' +
                        code +
                        '&amount=' +
                        amount +
                        '&email=' +
                        emailEnc +
                        '&rec=' +
                        recurring +
                        '&token=' +
                        token,
                    method: 'POST',
                    type: 'POST'
                }).done(function(data) {
                    if (data.OK) {
                        jQuery('#submitButton').attr('data-secret', data.RequestData);
                        stripe.handleCardPayment(data.RequestData,
                            cardNumber,
                            {
                                save_payment_method: recurring,
                                receipt_email: email,
                                payment_method_data: {
                                    billing_details: {
                                        name: firstName + ' ' + lastName,
                                        email: email,
                                        address: {
                                            city: town,
                                            line1: address1,
                                            line2: address2,
                                            postal_code: postcode,
                                            state: county
                                        }
                                    }
                                }
                            }).then(function(result) {
                            if (result.error) {
                                DisplayErrorMessage(result.error.message);
                            } else {
                                PostPayment(result.paymentIntent.id);
                            }
                        });
                        var requestData = data.RequestData;
                        return requestData;
                    } else {
                        DisplayErrors(data.Errors);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    DisplayErrors(GetErrorArray(jqXHR));
                });
            });
        });
    } catch (e) {
        console.log('Exception in Process ' + e);
    }
}


function PostPayment(token) {

    jQuery.ajax({
        dataType: 'json',
        url: GetBaseServiceUrl() + 'P2',
        data: GetPaymentPostData(token),
        method: 'POST',
        type: 'POST'
    }).done(function (data) {

        if (data.OK) {
            Completed();
        } else {
            DisplayErrors(data.Errors);
        }

    }).fail(function (jqXHR, textStatus, errorThrown) {
        DisplayErrors(GetErrorArray(jqXHR));
    });

}


function EnableSubmitButton() {
    jQuery('#submitButton').removeAttr('disabled');
    if (jQuery('#DonationPageId').val() !== '') {
        jQuery('#submitButton').button('reset');
    }
    jQuery('#PleaseWait').hide();
}

function DisableSubmitButton() {
    if (jQuery('#DonationPageId').val() !== '') {
        jQuery('#submitButton').button('loading');
    }
    jQuery('#submitButton').attr('disabled', 'disabled');
    jQuery('#PleaseWait').show();
}



function GetPaymentPostData(stripeToken) {

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
        token: stripeToken,
        giftAid: jQuery('#GiftAid').is(':checked'),
        keepInTouch: GetKeepInTouchValue(),
        amount: jQuery('#Amount').val(),
        cardType: jQuery('#CardType').val(),
        tenantCode: jQuery('#TenantCode').val(),
        widgetId: jQuery('#WidgetId').val(),
        recurring: jQuery('#RecurringPayment').is(':checked'),
        paymentSchedule: jQuery('input:radio[name=PaymentSchedule]:checked').val(),
        donationPageId: jQuery('#DonationPageId').val(),
        comment: jQuery('#Comment').val(),
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
        blockedTags: jQuery('#BlockedTags').length > 0 ? jQuery('#BlockedTags').val() : '',
        useAdditionalDetails: jQuery('#UseAdditionalDetails').length > 0 ? jQuery('#UseAdditionalDetails').val() : ''
    };
}

function GetKeepInTouchValue() {

    var keepInTouchValue = 0;

    jQuery('input.KeepInTouch[type=checkbox]:checked').each(function () {
        keepInTouchValue += parseInt(jQuery(this).val());
    });

    return keepInTouchValue;
}

function GetErrorArray(jqXHR) {

    var errors = [];

    var response = JSON.parse(jqXHR.responseText);

    if (response.ModelState) {
        for (var key in response.ModelState) {
            errors.push(response.ModelState[key]);
        }
    } else if (response.Message) {
        errors.push(response.Message);
    } else {
        errors.push('An unexpected error occurred.');
    }

    return errors;
}

function DisplayErrors(errors) {
    var errorMessage = '';
    jQuery.each(errors, function (index, value) {
        errorMessage += value + '<br/>';
    });
    DisplayErrorMessage(errorMessage);
}

function ResetErrorMessage() {
    jQuery('#Errors').html('');
    jQuery('#ErrorContainer').hide();
}

function DisplayErrorMessage(errorMessage) {
    jQuery('#PleaseWait').hide();
    jQuery('#ErrorContainer').show();
    jQuery('#Errors').html(errorMessage);
    EnableSubmitButton();
}

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function Completed() {
    

    let currency = $('#currency').val();
    let type = $('#type').val();
    let zapierUrl = $('#zapierUrl').val();
    zapier(zapierUrl);
    var urlAmount = jQuery('#Amount').val();
    var urlId = makeid(8);
    var redirectToPage = `https://hopeforjustice.org/donation-thank-you/?tid=${urlId}&amount=${urlAmount}&type=${type}&currency=${currency}`; 
    window.location = redirectToPage;
}


function zapier(url) {
    var data = {
        email : jQuery('#Email').val(),
        firstname : jQuery('#FirstName').val(),
        lastname : jQuery('#LastName').val()
    };
    jQuery.ajax({
        type : 'POST',
        url : url,  
        data: JSON.stringify(data),
        success:function (data) {
            console.log('sent to zapier');
        },
        error: function(xhr, status, error) {
            console.log('failed to send to zapier');
        }
    });
}



