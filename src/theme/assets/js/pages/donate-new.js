jQuery(document).ready(function ($) {
	let amount = $(".giving-widget__options-option--active").data("amount");
	let freq = $(".giving-widget__freq-option--active").data("freq");
	let reason = $(".giving-widget__options-option--active").data("reason");
	let reasonMonthly = $(".giving-widget__options-option--active").data(
		"monthly"
	);
	let currency = $(".giving-widget").data('currency');

	$('.customAmountNorway').on('input', function (e) {
		$(this).val($(this).val().replace(/[^0-9\,]/, ''));
	});

	// Norway monthly click

	$('#norwayMonthly').click(function () {
		let link = $(this).data('link');
		window.location.href = link;
	})

	//modal currency click
	$('.modal-currency__currency').click(function () {
		let data = $(this).data('currency');
		let url = window.location.origin + window.location.pathname;
		window.location.href = url + `?Currency=${data}`;
	})


	//alert(parseFloat(amount).toFixed(2));


	//initial set

	if (freq == "monthly") {
		$("#reason").text(reasonMonthly);
		amount = $(".giving-widget__options-option--active").data(
			"amountmonthly"
		);
		$(".giving-widget__options-option").each(function () {
			let textAmount = $(this).data("amountmonthly");
			$(this).children(".giving-widget__options-amount").text(textAmount);
		});
		$(".giving-widget__top-text").show();
		$(".giving-widget__top-text--once").hide();
		$(".giving-widget__title").show();
		$(".giving-widget__title--once").hide();
		$(".giving-widget__button-freq").text(freq);
	} else {
		$("#reason").text(reason);
		amount = $(".giving-widget__options-option--active").data("amount");
		$(".giving-widget__options-option").each(function () {
			let textAmount = $(this).data("amount");
			$(this).children(".giving-widget__options-amount").text(textAmount);
		});
		$(".giving-widget__top-text").hide();
		$(".giving-widget__top-text--once").show();
		$(".giving-widget__title").hide();
		$(".giving-widget__title--once").show();
		$(".giving-widget__button-freq").hide();
	}

	$(".giving-widget__text-amount").text(amount);
	$(".giving-widget__button-amount").text(amount);


	//fade in widget
	$(".donate-new__giving-widget").css('opacity', '1');


	//frequency select

	$(".giving-widget__freq-option").click(function () {

		$(".giving-widget__freq-option--active").removeClass(
			"giving-widget__freq-option--active"
		);



		$(this).addClass("giving-widget__freq-option--active");
		freq = $(this).data("freq");
		if (freq == "monthly") {
			$(".picture-description").hide();
			$(".donate-new__hero-image--main").show();
			$(".donate-new__hero-image--alt").hide();
			$(".giving-widget__button-freq").show();
			$(".giving-widget__button-freq").text(freq);
			$(".giving-widget__text-freq").show();
		} else {
			$(".donate-new__hero-image--alt").show();
			$(".donate-new__hero-image--main").hide();
			$(".giving-widget__button-freq").hide();
			$(".giving-widget__text-freq").hide();
			$(".picture-description").show();
		}

		if (freq == "monthly") {
			$("#reason").text(reasonMonthly);
			amount = $(".giving-widget__options-option--active").data(
				"amountmonthly"
			);
			$(".giving-widget__options-option").each(function () {
				let textAmount = $(this).data("amountmonthly");
				$(this)
					.children(".giving-widget__options-amount")
					.text(textAmount);
			});
			$(".giving-widget__top-text").show();
			$(".giving-widget__top-text--once").hide();
			$(".giving-widget__title").show();
			$(".giving-widget__title--once").hide();

		} else {
			$("#reason").text(reason);

			$(".giving-widget__top-text").hide();
			$(".giving-widget__top-text--once").show();
			$(".giving-widget__title").hide();
			$(".giving-widget__title--once").show();
			amount = $(".giving-widget__options-option--active").data("amount");
			$(".giving-widget__options-option").each(function () {
				let textAmount = $(this).data("amount");
				$(this)
					.children(".giving-widget__options-amount")
					.text(textAmount);
			});
		}

		if ($('.giving-widget__options-option--custom').hasClass('giving-widget__options-option--active')) {
			amount = $('.giving-widget__options-option--custom').children('input').val();
			$(".giving-widget__text-freq").hide();
		}

		$(".giving-widget__text-amount").text(amount);
		$(".giving-widget__button-amount").text(amount);

	});

	//options select

	$(".giving-widget__options-option").click(function () {
		$(".giving-widget__options-option").removeClass(
			"giving-widget__options-option--active"
		);
		$(this).addClass("giving-widget__options-option--active");
		reason = $(this).data("reason");
		reasonMonthly = $(this).data("monthly");

		if (freq == "monthly") {
			$("#reason").text(reasonMonthly);
			amount = $(this).data("amountmonthly");
			$(".giving-widget__text-freq").show();
		} else {
			$("#reason").text(reason);
			amount = $(this).data("amount");
			$(".giving-widget__text-freq").hide();
		}

		//alert(parseFloat(amount).toFixed(2));
		if (!$(this).hasClass("giving-widget__options-option--custom")) {
			let input = ".giving-widget__options-option--custom";
			$(input).children(".currency").hide();
			$(input).children(".text").show();
			$(input).children("input").hide();
			$(".giving-widget__button-amount").text(amount);
			$(".giving-widget__text-amount").text(amount);
			$(".giving-widget__text-amount").show();
			$(".giving-widget__text-currency").show();
		} else {
			$(".giving-widget__button-amount").text("");
			$(".giving-widget__text-amount").text("");
			$(".giving-widget__text-amount").hide();
			$(".giving-widget__text-currency").hide();
		}
	});

	//custom select

	$(".giving-widget__options-option--custom").click(function () {
		reason = $(this).data("reason");
		reasonMonthly = $(this).data("monthly");
		let val = $(this).children("input").val();
		$(".giving-widget__button-amount").text(val);
		$(".giving-widget__text-amount").text(val);
		$(".giving-widget__text-freq").hide();
		$(this).children(".currency").show();
		$(this).children(".text").hide();
		$(this).children("input").show().focus();

		if (freq == "monthly") {
			$("#reason").text(reasonMonthly);
		} else {
			$("#reason").text(reason);
		}

		amount = val;
	});

	// custom input

	$("#customAmount").on("input", function () {
		let val = $(this).val();
		$(".giving-widget__button-amount").text(val);
		$(".giving-widget__text-amount").text(val);
		amount = val;
	});


	$('.giving-widget__button').click(function () {
		console.log(amount, freq, currency);

		let url = window.location.origin;
		let urlAmount;

		if (currency == 'NOK') {
			amount = amount.toString().replace(",", ".");
			urlAmount = parseFloat(amount).toFixed(2);
		} else {
			urlAmount = parseFloat(amount).toFixed(2);
		}

		if (currency == 'GBP') {
			if (freq == 'monthly') {
				url += '/donate-GBP-regular/'
			} else {
				url += '/donate-GBP-once/'
			}
		} else if (currency == 'USD') {
			if (freq == 'monthly') {
				url += '/donate-USD-regular/'
			} else {
				url += '/donate-USD-once/'
			}
		} else if (currency == 'NOK') {
			url += '/donate-NOK-once/'
			urlAmount = urlAmount.replace(".", ",");
		}

		window.location.href = url + `?Amount=${urlAmount}`;
	});


});















