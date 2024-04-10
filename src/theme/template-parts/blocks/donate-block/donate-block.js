(function ($) {
	/**
	 * initializeBlock
	 *
	 * Adds custom JavaScript to the block HTML.
	 *
	 * @date    15/4/19
	 * @since   1.0.0
	 *
	 * @param   object $block The block jQuery element.
	 * @param   object attributes The block attributes (only available when editing).
	 * @return  void
	 */
	var initializeBlock = function () {
		let image = $(".donate-block__container").data("image");

		let amount = $(".donate-block__options-option--active").data("amount");
		let freq = $(".donate-block__freq-option--active").data("freq");
		let reason = $(".donate-block__options-option--active").data("reason");
		let reasonMonthly = $(".donate-block__options-option--active").data(
			"monthly"
		);
		let currency = $(".donate-block").data("currency");
		let widgetIdOnce = $(".donate-block").data("widgetidonce");
		let widgetIdMonthly = $(".donate-block").data("widgetidmonthly");
		let thankyou = $(".donate-block").data("thankyou");
		let emailEventMonthly = $(".donate-block").data("emaileventmonthly");
		let emailEventOnce = $(".donate-block").data("emaileventonce");
		let tracked = $(".donate-block").data("tracked");

		$(document).ready(function () {
			if (currency == "NOK") {
				$(".donate-block__options-option").each(function () {
					$(this)
						.children(".currency")
						.insertAfter($(this).children(".donate-block__options-amount"));

					let amountEl = $(this).children(".donate-block__options-amount");
					let amountText = amountEl.text();
					let amountLength = amountText.length;
					//console.log(amountLength);

					if (amountLength > 3) {
						let text = amountText.split("");
						text.splice(-3, 0, " ");
						let newText = text.join("");
						amountEl.text(newText);
					}

					if ($(this).hasClass("donate-block__options-option--custom")) {
						$(this)
							.children(".currency")
							.insertAfter($(this).children("#customAmount"));
					}
				});

				$(".donate-block__text-currency").insertAfter(
					".donate-block__text-amount"
				);
				$(".donate-block__button-currency").insertAfter(
					".donate-block__button-amount"
				);
			}
		});

		$(".customAmountNorway").on("input", function (e) {
			$(this).val(
				$(this)
					.val()
					.replace(/[^0-9\,]/, "")
			);
		});

		// Norway monthly click

		$("#norwayMonthly").click(function () {
			let link = $(this).data("link");
			window.location.href = link;
		});

		//modal currency click
		$(".modal-currency__currency").click(function () {
			let data = $(this).data("currency");
			let url = window.location.origin + window.location.pathname;
			window.location.href = url + `?Currency=${data}`;
		});

		//alert(parseFloat(amount).toFixed(2));

		//initial set

		if (freq == "monthly") {
			$("#reason").text(reasonMonthly);
			amount = $(".donate-block__options-option--active").data("amountmonthly");
			$(".donate-block__options-option").each(function () {
				let textAmount = $(this).data("amountmonthly");
				$(this).children(".donate-block__options-amount").text(textAmount);
			});
			$(".donate-block__top-text").show();
			$(".donate-block__top-text--once").hide();
			$(".donate-block__title").show();
			$(".donate-block__title--once").hide();
			if (currency == "NOK") {
				$(".donate-block__button-freq").text("månedlig");
			} else {
				$(".donate-block__button-freq").text(freq);
			}
		} else {
			$("#reason").text(reason);
			amount = $(".donate-block__options-option--active").data("amount");
			$(".donate-block__options-option").each(function () {
				let textAmount = $(this).data("amount");
				$(this).children(".donate-block__options-amount").text(textAmount);
			});
			$(".donate-block__top-text").hide();
			$(".donate-block__top-text--once").show();
			$(".donate-block__title").hide();
			$(".donate-block__title--once").show();
			$(".donate-block__button-freq").hide();
			$(".donate-block__text-freq").hide();
		}

		$(".donate-block__text-amount").text(amount);
		$(".donate-block__button-amount").text(amount);

		//fade in widget
		$(".donate-new__donate-block").css("opacity", "1");

		//frequency select

		$(".donate-block__freq-option").click(function () {
			$(".donate-block__freq-option--active").removeClass(
				"donate-block__freq-option--active"
			);

			$(this).addClass("donate-block__freq-option--active");
			freq = $(this).data("freq");

			//no longer needed - stripe regular implemented
			// if (currency == 'NOK' && freq == 'monthly') {
			//     const link = $(this).data("link");
			//     window.location.assign(link);
			// }

			if (freq == "monthly") {
				$(".picture-description").hide();
				$(".donate-new__hero-image--main").show();
				$(".donate-new__hero-image--alt").hide();
				$(".donate-block__button-freq").show();
				$(".donate-block__button-freq").text(freq);
				$(".donate-block__text-freq").show();
			} else {
				$(".donate-new__hero-image--alt").show();
				$(".donate-new__hero-image--main").hide();
				$(".donate-block__button-freq").hide();
				$(".donate-block__text-freq").hide();
				$(".picture-description").show();
			}

			if (freq == "monthly") {
				$("#reason").text(reasonMonthly);
				amount = $(".donate-block__options-option--active").data(
					"amountmonthly"
				);
				$(".donate-block__options-option").each(function () {
					let textAmount = $(this).data("amountmonthly");
					$(this).children(".donate-block__options-amount").text(textAmount);
				});
				$(".donate-block__top-text").show();
				$(".donate-block__top-text--once").hide();
				$(".donate-block__title").show();
				$(".donate-block__title--once").hide();
			} else {
				$("#reason").text(reason);

				$(".donate-block__top-text").hide();
				$(".donate-block__top-text--once").show();
				$(".donate-block__title").hide();
				$(".donate-block__title--once").show();
				$(".donate-block__text-freq").hide();
				amount = $(".donate-block__options-option--active").data("amount");
				$(".donate-block__options-option").each(function () {
					let textAmount = $(this).data("amount");
					$(this).children(".donate-block__options-amount").text(textAmount);
				});
			}

			if (
				$(".donate-block__options-option--custom").hasClass(
					"donate-block__options-option--active"
				)
			) {
				amount = $(".donate-block__options-option--custom")
					.children("input")
					.val();
				$(".donate-block__text-freq").hide();
			}

			$(".donate-block__text-amount").text(amount);
			$(".donate-block__button-amount").text(amount);
		});

		//options select

		$(".donate-block__options-option").click(function () {
			$(".donate-block__options-option").removeClass(
				"donate-block__options-option--active"
			);
			$(this).addClass("donate-block__options-option--active");
			reason = $(this).data("reason");
			reasonMonthly = $(this).data("monthly");

			if (freq == "monthly") {
				$("#reason").text(reasonMonthly);
				amount = $(this).data("amountmonthly");
				$(".donate-block__text-freq").show();
			} else {
				$("#reason").text(reason);
				amount = $(this).data("amount");
				$(".donate-block__text-freq").hide();
			}

			//alert(parseFloat(amount).toFixed(2));
			if (!$(this).hasClass("donate-block__options-option--custom")) {
				let input = ".donate-block__options-option--custom";
				$(input).children(".currency").hide();
				$(input).children(".text").show();
				$(input).children("input").hide();
				$(".donate-block__button-amount").text(amount);
				$(".donate-block__text-amount").text(amount);

				if (currency == "NOK") {
					let amountText = amount.toString();
					let amountLength = amountText.length;
					console.log(amountText, amountLength);

					if (amountLength > 3) {
						let text = amountText.split("");
						text.splice(-3, 0, " ");
						let newText = text.join("");
						$(".donate-block__button-amount").text(newText);
						$(".donate-block__text-amount").text(newText);
					}
				}

				$(".donate-block__text-amount").show();
				$(".donate-block__text-currency").show();
			} else {
				$(".donate-block__button-amount").text("");
				$(".donate-block__text-amount").text("");
				$(".donate-block__text-amount").hide();
				$(".donate-block__text-currency").hide();
			}
		});

		//custom select

		$(".donate-block__options-option--custom").click(function () {
			reason = $(this).data("reason");
			reasonMonthly = $(this).data("monthly");
			let val = $(this).children("input").val();
			$(".donate-block__button-amount").text(val);
			$(".donate-block__text-amount").text(val);
			$(".donate-block__text-freq").hide();
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
			$(".donate-block__button-amount").text(val);
			$(".donate-block__text-amount").text(val);
			amount = val;

			string = val.toString();

			if (string.length > 3) {
				let amountText = string;
				let amountLength = amountText.length;
				console.log(amountText, amountLength);

				if (amountLength > 3 && amountLength < 7) {
					let text = amountText.split("");
					text.splice(-3, 0, " ");
					let newText = text.join("");
					$(".donate-block__button-amount").text(newText);
					$(".donate-block__text-amount").text(newText);
				} else if (amountLength >= 7) {
					let text = amountText.split("");
					text.splice(-3, 0, " ");
					text.splice(-7, 0, " ");
					let newText = text.join("");
					$(".donate-block__button-amount").text(newText);
					$(".donate-block__text-amount").text(newText);
				}
			}
		});

		$(".donate-block__button").click(function () {
			console.log(amount, freq, currency);

			let url = window.location.origin;
			let urlAmount;

			if (currency == "NOK") {
				amount = amount.toString().replace(",", ".");
				urlAmount = parseFloat(amount).toFixed(2);
			} else {
				urlAmount = parseFloat(amount).toFixed(2);
			}

			if (currency == "GBP") {
				if (freq == "monthly") {
					url += "/donate-GBP-regular/";
				} else {
					url += "/donate-GBP-once/";
				}
			} else if (currency == "USD") {
				if (freq == "monthly") {
					url += "/donate-USD-regular/";
				} else {
					url += "/donate-USD-once/";
				}
			} else if (currency == "NOK") {
				if (freq == "monthly") {
					url += "/donate-NOK-regular/";
				} else {
					url += "/donate-NOK-once/";
				}
				urlAmount = urlAmount.replace(".", ",");
			} else if (currency == "AUD") {
				if (freq == "monthly") {
					url += "/donate-AUD-regular/";
				} else {
					url += "/donate-AUD-once/";
				}
			}

			if (widgetIdMonthly && freq == "monthly") {
				url += `?Amount=${urlAmount}&wid=${widgetIdMonthly}`;
			} else if (widgetIdOnce && freq != "monthly") {
				url += `?Amount=${urlAmount}&wid=${widgetIdOnce}`;
			} else {
				url += `?Amount=${urlAmount}`;
			}

			if (emailEventMonthly && freq == "monthly") {
				url += `&emailEvent=${emailEventMonthly}`;
			} else if (emailEventOnce && freq != "monthly") {
				url += `&emailEvent=${emailEventOnce}`;
			}

			if (thankyou) {
				url += `&thankyou=${thankyou}`;
			}

			if (tracked && freq != "monthly") {
				url += `&tracked=${tracked}`;
			}

			if (image) {
				url += `&image=${encodeURIComponent(image)}`;
			}

			window.location.href = url;
		});
	};

	// Initialize each block on page load (front end).
	$(document).ready(function () {
		$(".donate-block").each(function () {
			initializeBlock($(this));
		});
	});

	// Initialize dynamic block preview (editor).
	if (window.acf) {
		window.acf.addAction(
			"render_block_preview/type=donate-block",
			initializeBlock
		);
	}
})(jQuery);
