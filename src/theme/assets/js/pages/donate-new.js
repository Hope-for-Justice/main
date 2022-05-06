jQuery(document).ready(function($) {

let amount = $(".giving-widget__options-option--active").data('amount');
let freq = "monthly";
let reason = $(".giving-widget__options-option--active").data('reason');
let currency = $(".currency").text();
//alert(parseFloat(amount).toFixed(2));
$('#reason').text(reason);
$('.giving-widget__text-amount').text(amount);
$('.giving-widget__button-amount').text(amount)

$('.giving-widget__freq-option').click(function() {
	$('.giving-widget__freq-option--active').removeClass('giving-widget__freq-option--active');
	$(this).addClass('giving-widget__freq-option--active');
	freq = $(this).data('freq')
	if (freq == "monthly") {
		$('.giving-widget__button-freq').show();
		$('.giving-widget__button-freq').text(freq);
		$('.giving-widget__text-freq').show();
	} else {
		$('.giving-widget__button-freq').hide();
		$('.giving-widget__text-freq').hide();
	}
});	

$('.giving-widget__options-option').click(function() {
	$('.giving-widget__options-option').removeClass('giving-widget__options-option--active');
	$(this).addClass('giving-widget__options-option--active');
	amount = $(this).data('amount');
	reason = $(this).data('reason');
	$('#reason').text(reason);
	//alert(parseFloat(amount).toFixed(2));
	if (! $(this).hasClass('giving-widget__options-option--custom')) {
		let input = ".giving-widget__options-option--custom"
		$(input).children('.currency').hide();
		$(input).children('.text').show();
		$(input).children('input').hide();
		$('.giving-widget__button-amount').text(amount);
		$('.giving-widget__text-amount').text(amount);
		$('.giving-widget__text-freq').show();
		$('.giving-widget__text-amount').show();
		$('.giving-widget__text-currency').show();
	} else {
		$('.giving-widget__button-amount').text("");
		$('.giving-widget__text-amount').text("")
		$('.giving-widget__text-amount').hide();
		$('.giving-widget__text-currency').hide();
	}
});	

$('.giving-widget__options-option--custom').click(function() {
	$(this).children('.currency').show();
	$(this).children('.text').hide();
	$(this).children('input').show().focus();
	$('.giving-widget__text-freq').hide();
	let val = $(this).children('input').val();
	$('.giving-widget__button-amount').text(val);
	$('.giving-widget__text-amount').text(val)
});	


$('#customAmount').on('input', function(){
	let val = $(this).val();
	$('.giving-widget__button-amount').text(val);
	$('.giving-widget__text-amount').text(val)
	amount = val;
});
	
});