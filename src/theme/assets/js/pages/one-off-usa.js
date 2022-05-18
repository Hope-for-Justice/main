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


$('#toStepTwo').click(function(){
  if ($('#formOne').valid()) {
    $('#formOne').hide();
    $('#formTwo').show();
  }
});

$('#backToStepOne').click(function(){
    $('#formOne').show();
    $('#formTwo').hide();
});

$('#toStepThree').click(function(){
    if ($('#formTwo').valid()) {
        $('#CreditCardForm').show();
        $('#formTwo').hide();
    }
});

$('#backToStepTwo').click(function(){
    $('#formTwo').show();
    $('#CreditCardForm').hide();
});




});
