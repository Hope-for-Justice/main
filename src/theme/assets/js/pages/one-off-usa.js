jQuery(document).ready(function($) {

$('#Country').on('change', function() {
  if( this.value != 'United States') {
    $('#County').removeClass('required').parent().hide();
  }
});

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
        $('#dotOne').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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
        $('#dotOne').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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
        $('#dotThree').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
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
        $('#dotThree').toggleClass('donorfy-donate__dot--active');
        $('#dotTwo').toggleClass('donorfy-donate__dot--active');
        $('#formTwo').show();
        $('#CreditCardForm').hide();
        $('#backToStepTwo').html('Previous');
    },400);
});




});
