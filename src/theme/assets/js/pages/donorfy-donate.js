

jQuery(document).ready(function ($) {

    function addTags() {
        const tags = [];

        if ($("#emailSelect").val() == "true") {
            tags.push("Purpose_Email Updates");
        }

        if ($("#inspiration_question").val()) {
            tags.push($("#inspiration_question").val());
        }

        $("#ActiveTags").val(tags);

    }

    addTags();

    //inspiration questions
    $('#inspiration_question').on('change', function () {
        if ($(this).val() == 'Inspiration_Faith') {
            $('#Comment').attr('placeholder', 'Please tell us the name of your place of worship');
        } else if ($(this).val() == 'Inspiration_SocialMedia') {
            $('#Comment').attr('placeholder', 'Please tell us which platform inspired you');
        } else if ($(this).val() == 'Inspiration_NatalieGrant') {
            $('#Comment').attr('placeholder', 'Further details');
        } else if ($(this).val() == 'Inspiration_StaffContact') {
            $('#Comment').attr('placeholder', 'Please tell us who you know');
        } else if ($(this).val() == 'Inspiration_Celebration') {
            $('#Comment').attr('placeholder', 'Please let us know what you are celebrating');
        } else if ($(this).val() == 'Inspiration_Cause') {
            $('#Comment').attr('placeholder', 'Further details');
        } else if ($(this).val() == 'Inspiration_Event') {
            $('#Comment').attr('placeholder', 'Please tell us where');
        } else {
            $('#Comment').attr('placeholder', 'Please tell us more');
        }
        $('.donorfy-donate__comment').show();

        addTags();

    });

    //capitalize these
    $('#FirstName').capitalize();
    $('#LastName').capitalize();
    $('#Address1').capitalize();
    $('#Address2').capitalize();
    $('#Town').capitalize();

    //remove spaces
    $('#Phone').on('keyup', function (e) {
        $(this).val($(this).val().replace(/\s/g, ''));
    });

    $('#Postcode').on('change', function (e) {
        let formatted;
        if ($(this).hasClass("justCapsPostcode")) {
            formatted = $('#Postcode').val().toUpperCase();
        } else {
            formatted = formatPostcode($('#Postcode').val());
        }
        $('#Postcode').val(formatted);
    });

    $('#FirstName').on('change', function (e) {
        let formatted = $(this).val().trim();
        $(this).val(formatted);
    });

    $('#LastName').on('change', function (e) {
        let formatted = $(this).val().trim();
        $(this).val(formatted);
    });

    $('#Email').on('change', function (e) {
        //set cookie for amount
        let date = new Date();
        let minutes = 30;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        let email = $('#Email').val();
        Cookies.set('wordpress_donor_email', email, { path: '/', expires: date });
    });


    $('#Phone').on('keypress', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 44 && e.which != 45 && e.which != 46 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $.extend(jQuery.validator.messages, {
        required: "Required."
    });

    $('#changeAmount').click(function () {
        $('.donorfy-donate__amount').show().children('input').val("").focus();
    });

    $("#Amount").on("input", function () {
        let val = $(this).val();
        $("#textAmount").text(val);
        $("#donationTotalConfirm").text(val);
    });

    $("#Email").on("input", function () {
        let val = $(this).val();
        $("#emailText").text(val);
    });

    $("#GiftAidSelect").on('change', function () {
        if ($(this).val() == "true") {
            $("#GiftAid").prop('checked', true);
            $("#giftAidConfirm").text("Yes");
        } else {
            $("#GiftAid").prop('checked', false);
            $("#giftAidConfirm").text("No");
        }
    });

    $("#emailSelect").on('change', function () {
        if ($(this).val() == "true") {
            $(this).parent().addClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#emailPreference").prop('checked', true);
            $("#emailNo").hide();
        } else if ($(this).val() == "false") {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().addClass('donorfy-donate__select--preference-red');
            $("#emailPreference").prop('checked', false);
            $("#emailNo").show();
        } else {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#emailPreference").prop('checked', false);
            $("#emailNo").hide();
        }
        addTags();
    });

    $("#postSelect").on('change', function () {
        if ($(this).val() == "true") {
            $(this).parent().addClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#postPreference").prop('checked', true);
        } else if ($(this).val() == "false") {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().addClass('donorfy-donate__select--preference-red');
            $("#postPreference").prop('checked', false);
        } else {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#postPreference").prop('checked', false);
        }
    });

    $("#smsSelect").on('change', function () {
        if ($(this).val() == "true") {
            $(this).parent().addClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#smsPreference").prop('checked', true);
        } else if ($(this).val() == "false") {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().addClass('donorfy-donate__select--preference-red');
            $("#smsPreference").prop('checked', false);
        } else {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#postPreference").prop('checked', false);
        }
    });

    $("#phoneSelect").on('change', function () {
        if ($(this).val() == "true") {
            $(this).parent().addClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#phonePreference").prop('checked', true);
        } else if ($(this).val() == "false") {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().addClass('donorfy-donate__select--preference-red');
            $("#phonePreference").prop('checked', false);
        } else {
            $(this).parent().removeClass('donorfy-donate__select--preference-green');
            $(this).parent().removeClass('donorfy-donate__select--preference-red');
            $("#phonePreference").prop('checked', false);
        }
    });

});