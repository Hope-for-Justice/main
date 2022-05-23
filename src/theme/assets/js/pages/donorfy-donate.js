jQuery(document).ready(function($) { 

$('#changeAmount').click(function(){
	$('.donorfy-donate__amount').show().children('input').val("").focus();
});

$("#Amount").on("input", function () {
	let val = $(this).val();
	$("#textAmount").text(val);
});

$("#Email").on("input", function () {
	let val = $(this).val();
	$("#emailText").text(val);
});

$("#GiftAidSelect").on('change', function(){
    if ($(this).val() == "true") {
        $("#GiftAid").prop('checked', true);
    } else {
       $("#GiftAid").prop('checked', false); 
    }
});

$("#emailSelect").on('change', function(){
    if ($(this).val() == "true") {
    	$(this).parent().addClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
        $("#emailPreference").prop('checked', true);
    } else if ($(this).val() == "false")  {
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().addClass('donorfy-donate__select--preference-red');
       $("#emailPreference").prop('checked', false); 
    } else {
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
       $("#emailPreference").prop('checked', false); 
    }
});

$("#postSelect").on('change', function(){
    if ($(this).val() == "true") {
    	$(this).parent().addClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
        $("#postPreference").prop('checked', true);
    } else if ($(this).val() == "false"){
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().addClass('donorfy-donate__select--preference-red');
       $("#postPreference").prop('checked', false); 
    } else {
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
       $("#postPreference").prop('checked', false); 
    }
});

$("#smsSelect").on('change', function(){
    if ($(this).val() == "true") {
    	$(this).parent().addClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
        $("#smsPreference").prop('checked', true);
    } else if  ($(this).val() == "false"){
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().addClass('donorfy-donate__select--preference-red');
       $("#smsPreference").prop('checked', false); 
    } else {
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
       $("#postPreference").prop('checked', false); 
    }
});

$("#phoneSelect").on('change', function(){
    if ($(this).val() == "true") {
    	$(this).parent().addClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
        $("#phonePreference").prop('checked', true);
    } else if ($(this).val() == "false"){
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().addClass('donorfy-donate__select--preference-red');
       $("#phonePreference").prop('checked', false); 
    }  else {
    	$(this).parent().removeClass('donorfy-donate__select--preference-green');
    	$(this).parent().removeClass('donorfy-donate__select--preference-red');
       $("#phonePreference").prop('checked', false); 
    }
});

});