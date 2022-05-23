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


$('#toStepTwo').click(function(){
    setTimeout(
    function() {
      if ($('#formOne').valid()) {
        $('#formOne').hide();
        $('#formTwo').show();
        $(window).scrollTop(0);
      }
      $('#toStepTwo').html('Next');
    },400);
});

$('#backToStepOne').click(function(){
    setTimeout(
    function() {
        $('#formOne').show();
        $('#formTwo').hide();
        $('#backToStepOne').html('Previous');
        $(window).scrollTop(0);
    },400);
});

$('#toStepThree').click(function(){
    setTimeout(
    function() {
    if ($('#formTwo').valid()) {
        $('#CreditCardForm').show();
        $('#formTwo').hide();
        $(window).scrollTop(0);
    }
    $('#toStepThree').html('Next');
    },400);
});

$('#backToStepTwo').click(function(){
    setTimeout(
    function() {
        $('#formTwo').show();
        $('#CreditCardForm').hide();
        $('#backToStepTwo').html('Previous');
    },400);
});




});
