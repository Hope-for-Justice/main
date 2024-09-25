/*
(c) Donorfy Ltd 2023

Functions to support Credit Card Web Widget
Designed to use Stripe Elements

 */
// ReSharper disable UseOfImplicitGlobalInFunctionScope
// ReSharper disable AssignToImplicitGlobalInFunctionScope
if (typeof jQuery === "undefined") {
	loadScript(
		"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js",
		function () {
			jQuery(document).ready(function () {
				load();
			});
		}
	);
} else {
	jQuery(document).ready(function () {
		load();
	});
}

//Hfj edit (one line)
jQuery("#ErrorContainer").hide();

function GetBaseServiceUrl() {
	return "https://api.donorfy.com/api/stripe/";
}

function load() {
	if (typeof jQuery.validator === "undefined") {
		loadScript(
			"https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"
		);
	}

	var payPayClientId = jQuery("#PayPalClientId").val();
	var uCurrency = DonorfyWidget.Currency.toUpperCase();

	if (payPayClientId !== undefined && payPayClientId !== "") {
		var payPalScript =
			"https://www.paypal.com/sdk/js?client-id=" +
			payPayClientId +
			"&disable-funding=credit,card&currency=" +
			uCurrency;
		loadScript(payPalScript);
	}

	var code = jQuery("#TenantCode").val();
	var id = jQuery("#WidgetId").val();
	if (id === "") {
		id = jQuery("#DonationPageId").val();
	}
	jQuery
		.ajax({
			dataType: "json",
			url: GetBaseServiceUrl() + "P0?id=" + id + "&code=" + code,
			method: "POST",
			type: "POST",
		})
		.done(function (data) {
			if (data.OK) {
				jQuery("#spinner").hide();
				var key = data.RequestData;
				DonorfyWidget.Stripe = Stripe(key);
				DonorfyWidget.Elements = DonorfyWidget.Stripe.elements();
				DonorfyWidget.StripeStatementText = jQuery(
					"#StripeStatementText"
				).val();
				DonorfyWidget.PayPalStatementText = jQuery(
					"#PayPalStatementText"
				).val();

				var currencyCodeOverride = jQuery("#CurrencyCode").val();
				if (currencyCodeOverride !== undefined && currencyCodeOverride !== "") {
					DonorfyWidget.Currency = currencyCodeOverride;
				}

				var countryCodeOverride = jQuery("#CountryCode").val();
				if (countryCodeOverride !== undefined && countryCodeOverride !== "") {
					DonorfyWidget.Country = countryCodeOverride;
				}

				window.cardNumber = DonorfyWidget.Elements.create("cardNumber");
				window.cardNumber.mount("#card-number");

				window.cardExpiry = DonorfyWidget.Elements.create("cardExpiry");
				cardExpiry.mount("#card-expiry");

				window.cardCvc = DonorfyWidget.Elements.create("cardCvc");
				cardCvc.mount("#card-cvc");

				submitButton = document.getElementById("submitButton");
				submitButton.addEventListener("click", function (ev) {
					console.log("submit clicked");
					DisableSubmitButton();
					ResetErrorMessage();
					if (ValidateForm()) {
						try {
							Process();
						} catch (e) {
							EnableSubmitButton();
							console.log("Exception  " + e);
							ev.preventDefault();
							return false;
						}
					} else {
						EnableSubmitButton();
						DisplayErrorMessage("please scroll up to see the details");
					}
					ev.preventDefault();
					return false;
				});

				jQuery("input.numberOnly[type=text]").on("keypress", function (e) {
					if (
						e.which !== 8 &&
						e.which !== 44 &&
						e.which !== 45 &&
						e.which !== 46 &&
						e.which !== 0 &&
						(e.which < 48 || e.which > 57)
					) {
						return false;
					}
					return true;
				});

				jQuery("input#Amount").blur(function () {
					if (this.value) {
						var amt = parseFloat(this.value);
						jQuery(this).val(amt.toFixed(2));
					}
					SetUpApplePay();
					SetUpPayPal();
				});

				//jQuery('input#Amount').keyup(function (event) {
				//    SetUpApplePay();
				//    SetUpPayPal();
				//});

				jQuery("input[name='PaymentType']").on("click", function () {
					if (jQuery(this).val() === "Recurring") {
						jQuery("#PaymentScheduleRow").show();
						document.getElementById("payment-request-button").style.display =
							"none";
						document.getElementById("paypal-button-container").style.display =
							"none";
					} else {
						jQuery("#PaymentScheduleRow").hide();
						document.getElementById("payment-request-button").style.display =
							"";
						document.getElementById("paypal-button-container").style.display =
							"";
					}
				});

				try {
					InitialiseForm();
				} catch (e) {
					console.log("Exception calling InitialiseForm() " + e);
				}
			} else {
				DisplayErrors(data.Errors);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			DisplayErrors(GetErrorArray(jqXHR));
			return "";
		});
	return "";
}

var DonorfyWidget = {
	Country: jQuery("#CountryCode").val(),
	Currency: jQuery("#CurrencyCode").val(),
	Stripe: null,
	Elements: null,
	StripePaymentRequest: null,
	StripePaymentRequestButton: null,
	StripeStatementText: "",
	PayPal: null,
	PayPalStatementText: "",
	PayPalLoaded: false,
};

function SetUpPayPal() {
	if (jQuery("#PalPayEnabled").val() === "No") {
		return;
	}

	var payPayClientId = jQuery("#PayPalClientId").val();
	if (
		payPayClientId === undefined ||
		payPayClientId === "" ||
		payPayClientId === "none"
	) {
		return;
	}

	var donAmt = jQuery("#Amount").val();
	if (donAmt === undefined || donAmt === "" || donAmt === "none") {
		if (jQuery("#payment-request-button").length) {
			document.getElementById("paypal-button-container").style.display = "none";
		}
		return;
	}

	if (donAmt === 0) {
		if (jQuery("#payment-request-button").length) {
			document.getElementById("paypal-button-container").style.display = "none";
		}
		return;
	}

	if (jQuery("#OneOffPayment").prop("checked")) {
		document.getElementById("paypal-button-container").style.display = "";
	} else {
		document.getElementById("paypal-button-container").style.display = "none";
	}

	jQuery("#paypal-button-container").html("");
	var uCurrency = DonorfyWidget.Currency.toUpperCase();
	try {
		DonorfyWidget.PayPal = paypal
			.Buttons({
				createOrder: function (data, actions) {
					if (!ValidateForm()) {
						return false;
					}
					return actions.order.create({
						purchase_units: [
							{
								amount: {
									value: donAmt,
									currency_code: uCurrency,
								},
								soft_descriptorstring: DonorfyWidget.PayPalStatementText,
								description: DonorfyWidget.PayPalStatementText,
							},
						],
					});
				},
				onApprove: function (data, actions) {
					return actions.order.capture().then(function (details) {
						jQuery("#PayPal").val("Yes");
						jQuery("#ExternalPaymentReference").val(details.id);
						PostPayment(details.id);
					});
				},
			})
			.render("#paypal-button-container");
	} catch (e) {
		console.log("SetUpPayPal " + e);
	}
}

function SetUpApplePay() {
	if (jQuery("#ApplePayEnabled").val() === "No") {
		return;
	}

	var donAmt = jQuery("#Amount").val();
	if (donAmt === undefined || donAmt === "" || donAmt === "none") {
		if (jQuery("#payment-request-button").length) {
			document.getElementById("payment-request-button").style.display = "none";
		}
		return;
	}

	donAmt = Math.round(donAmt * 100);
	if (donAmt === 0) {
		if (jQuery("#payment-request-button").length) {
			document.getElementById("payment-request-button").style.display = "none";
		}
		return;
	}

	if (jQuery("#payment-request-button").length) {
		try {
			// Apply pay btn
			if (DonorfyWidget.StripePaymentRequest === null) {
				DonorfyWidget.StripePaymentRequest =
					DonorfyWidget.Stripe.paymentRequest({
						country: DonorfyWidget.Country,
						currency: DonorfyWidget.Currency,
						total: {
							label: DonorfyWidget.StripeStatementText,
							amount: donAmt,
						},
						requestPayerName: true,
						requestPayerEmail: true,
					});
				DonorfyWidget.StripePaymentRequestButton =
					DonorfyWidget.Elements.create("paymentRequestButton", {
						paymentRequest: DonorfyWidget.StripePaymentRequest,
					});
			} else {
				DonorfyWidget.StripePaymentRequest.update({
					total: {
						label: DonorfyWidget.StripeStatementText,
						amount: donAmt,
					},
				});
			}

			// Check the availability of the Payment Request API first.
			DonorfyWidget.StripePaymentRequest.canMakePayment().then(function (
				result
			) {
				if (result) {
					DonorfyWidget.StripePaymentRequestButton.mount(
						"#payment-request-button"
					);
				} else {
					document.getElementById("payment-request-button").style.display =
						"none";
				}
			});

			DonorfyWidget.StripePaymentRequest.on("paymentmethod", function (ev) {
				ValidateStripeApplePayRequest(ev);
			});

			document.getElementById("payment-request-button").style.display = "none";
			if (!jQuery("#RecurringPayment").is(":checked")) {
				document.getElementById("payment-request-button").style.display = "";
			}
		} catch (e) {
			console.log("SetUpApplePay " + e);
		}
	}
}

// Validates and processes Apple Pay via Stripe
function ValidateStripeApplePayRequest(ev) {
	if (ValidateForm()) {
		var code = jQuery("#TenantCode").val();
		var email = jQuery("#Email").val();
		var recurring = jQuery("#RecurringPayment").is(":checked");

		var donAmt = jQuery("#Amount").val();
		if (donAmt === undefined || donAmt === "" || donAmt === "none") {
			if (jQuery("#payment-request-button").length) {
				document.getElementById("payment-request-button").style.display =
					"none";
			}
			return;
		}

		donAmt = Math.round(donAmt * 100);
		if (donAmt === 0) {
			if (jQuery("#payment-request-button").length) {
				document.getElementById("payment-request-button").style.display =
					"none";
			}
			return;
		}

		var id = jQuery("#WidgetId").val();
		if (id === "") {
			id = jQuery("#DonationPageId").val();
		}

		var siteKey = jQuery("#ReCaptchaSiteKey").val();
		var action = jQuery("#ReCaptchaAction").val();

		try {
			grecaptcha.ready(function () {
				grecaptcha.execute(siteKey, { action: action }).then(function (token) {
					DisableSubmitButton();
					let body = {
						id: id,
						code: code,
						amount: donAmt,
						email: email,
						rec: recurring,
						token: token,
					};
					jQuery
						.ajax({
							dataType: "json",
							url: GetBaseServiceUrl() + "P1a",
							method: "POST",
							type: "POST",
							data: body,
						})
						.done(function (data) {
							if (data.OK) {
								jQuery("#submitButton").attr("data-secret", data.RequestData);
								DonorfyWidget.Stripe.confirmCardPayment(
									data.RequestData,
									{ payment_method: ev.paymentMethod.id },
									{ handleActions: false }
								).then(function (confirmResult) {
									if (confirmResult.error) {
										ValidateForm();
										DisplayErrorMessage(result.error.message);
										ev.complete("fail");
										return false;
									} else {
										jQuery("#StripePaymentIntentId").val(
											confirmResult.paymentIntent.id
										);
										PostPayment(confirmResult.paymentIntent.id);
										ev.complete("success");
										// Check if the PaymentIntent requires any actions and if so let Stripe.js
										// handle the flow. If using an API version older than "2019-02-11" instead
										// instead check for: `paymentIntent.status === "requires_source_action"`.
										if (
											confirmResult.paymentIntent.status === "requires_action"
										) {
											// Let Stripe.js handle the rest of the payment flow.
											DonorfyWidget.Stripe.confirmCardPayment(
												data.RequestData
											).then(function (result) {
												if (result.error) {
													// The payment failed -- ask your customer for a new payment method.
													ValidateForm();
													DisplayErrorMessage(result.error.message);
													return false;
												} else {
													// The payment has succeeded.
													jQuery("#StripePaymentIntentId").val(
														result.paymentIntent.id
													);
													jQuery("#PaymentMethod").val("ApplePay");
													PostPayment(result.paymentIntent.id);
													return true;
												}
											});
										} else {
											// The payment has succeeded.
											jQuery("#StripePaymentIntentId").val(
												result.paymentIntent.id
											);
											PostPayment(result.paymentIntent.id);
											return true;
										}
										return true;
									}
								});
							}
						})
						.fail(function (jqXHR, textStatus, errorThrown) {
							console.log("ValidateStripeApplePayRequest jqXHR " + jqXHR);
							DisplayErrorMessage(GetErrorArray(jqXHR));
							return false;
						});
				});
			});
		} catch (e) {
			console.log("Exception in ValidateStripeApplePayRequest " + e);
			DisplayErrorMessage(e);
			return false;
		}
	} else {
		return false;
	}
}

function loadScript(url, successFunction) {
	var script = document.createElement("script");
	script.src = url;
	var head = document.getElementsByTagName("head")[0],
		done = false;
	head.appendChild(script);
	script.onload = script.onreadystatechange = function () {
		if (
			!done &&
			(!this.readyState ||
				this.readyState === "loaded" ||
				this.readyState === "complete")
		) {
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
	var code = jQuery("#TenantCode").val();
	var id = jQuery("#WidgetId").val();
	if (id === "") {
		id = jQuery("#DonationPageId").val();
	}
	jQuery
		.ajax({
			dataType: "json",
			url: GetBaseServiceUrl() + "P0?id=" + id + "&code=" + code,
			method: "POST",
			type: "POST",
		})
		.done(function (data) {
			if (data.OK) {
				return data.RequestData;
			} else {
				DisplayErrors(data.Errors);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			DisplayErrors(GetErrorArray(jqXHR));
			return "";
		});
	return "";
}

//Hfj edit (whole func)
function ValidateForm() {
	jQuery("#CreditCardForm").validate({
		invalidHandler: function (form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				validator.errorList[0].element.focus();
			}
		},
	}).settings.ignore = ":disabled,:hidden";
	return jQuery("#CreditCardForm").valid();
}

function Process() {
	var code = jQuery("#TenantCode").val();
	var email = jQuery("#Email").val();
	var recurring = jQuery("#RecurringPayment").is(":checked");
	var id = jQuery("#WidgetId").val();
	if (id === "") {
		id = jQuery("#DonationPageId").val();
	}
	var amount = jQuery("#Amount").val();
	amount = amount.replace(/\D/g, "");

	var firstName =
		jQuery("#FirstName").length > 0 ? jQuery("#FirstName").val() : "";
	var lastName =
		jQuery("#LastName").length > 0 ? jQuery("#LastName").val() : "";
	var town = jQuery("#Town").length > 0 ? jQuery("#Town").val() : "";
	var address2 =
		jQuery("#Address2").length > 0 ? jQuery("#Address2").val() : "";
	var address1 =
		jQuery("#Address1").length > 0 ? jQuery("#Address1").val() : "";
	var postcode =
		jQuery("#Postcode").length > 0 ? jQuery("#Postcode").val() : "";
	var county = jQuery("#County").length > 0 ? jQuery("#County").val() : "";

	var siteKey = jQuery("#ReCaptchaSiteKey").val();
	var action = jQuery("#ReCaptchaAction").val();

	try {
		grecaptcha.ready(function () {
			grecaptcha.execute(siteKey, { action: action }).then(function (token) {
				let body = {
					id: id,
					code: code,
					amount: amount,
					email: email,
					rec: recurring,
					token: token,
				};
				jQuery
					.ajax({
						dataType: "json",
						url: GetBaseServiceUrl() + "P1a",
						method: "POST",
						type: "POST",
						data: body,
					})
					.done(function (data) {
						if (data.OK) {
							jQuery("#submitButton").attr("data-secret", data.RequestData);
							DonorfyWidget.Stripe.handleCardPayment(
								data.RequestData,
								cardNumber,
								{
									save_payment_method: recurring,
									receipt_email: email,
									payment_method_data: {
										billing_details: {
											name: firstName + " " + lastName,
											email: email,
											address: {
												city: town,
												line1: address1,
												line2: address2,
												postal_code: postcode,
												state: county,
											},
										},
									},
								}
							).then(function (result) {
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
					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						DisplayErrors(GetErrorArray(jqXHR));
					});
			});
		});
	} catch (e) {
		console.log("Exception in Process " + e);
	}
}

function PostPayment(token) {
	jQuery
		.ajax({
			dataType: "json",
			url: GetBaseServiceUrl() + "P2",
			data: GetPaymentPostData(token),
			method: "POST",
			type: "POST",
		})
		.done(function (data) {
			if (data.OK) {
				Completed();
			} else {
				DisplayErrors(data.Errors);
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
			DisplayErrors(GetErrorArray(jqXHR));
		});
}

function EnableSubmitButton() {
	jQuery("#submitButton").removeAttr("disabled");
	if (jQuery("#DonationPageId").val() !== "") {
		jQuery("#submitButton").button("reset");
	}
	jQuery("#PleaseWait").hide();
	jQuery(submitButton).html("Donate");
}

function DisableSubmitButton() {
	if (jQuery("#DonationPageId").val() !== "") {
		jQuery("#submitButton").button("loading");
	}
	jQuery("#submitButton").attr("disabled", "disabled");
	jQuery("#PleaseWait").show();
}

function GetPaymentPostData(stripeToken) {
	return {
		title: jQuery("#Title").val(),
		firstName: jQuery("#FirstName").val(),
		lastName: jQuery("#LastName").val(),
		email: jQuery("#Email").val(),
		phone: jQuery("#Phone").val(),
		address1: jQuery("#Address1").val(),
		address2: jQuery("#Address2").val(),
		town: jQuery("#Town").val(),
		county: jQuery("#County").val(),
		postCode: jQuery("#Postcode").val(),
		country: jQuery("#Country").length > 0 ? jQuery("#Country").val() : "",
		token: stripeToken,
		giftAid: jQuery("#GiftAid").is(":checked"),
		keepInTouch: GetKeepInTouchValue(),
		doNotKeepInTouch: GetDoNotKeepInTouchValue(),
		optInShown: GetOptInShownValue(),
		legitInterestShown: GetLegitInterestShownValue(),
		amount: jQuery("#Amount").val(),
		cardType: jQuery("#CardType").val(),
		tenantCode: jQuery("#TenantCode").val(),
		widgetId: jQuery("#WidgetId").val(),
		recurring: jQuery("#RecurringPayment").is(":checked"),
		paymentSchedule: jQuery("input:radio[name=PaymentSchedule]:checked").val(),
		donationPageId: jQuery("#DonationPageId").val(),
		comment: jQuery("#Comment").val(),
		quantity: jQuery("#Quantity").length > 0 ? jQuery("#Quantity").val() : "1",
		additionalTitle:
			jQuery("#AdditionalTitle").length > 0
				? jQuery("#AdditionalTitle").val()
				: "",
		additionalFirstName:
			jQuery("#AdditionalFirstName").length > 0
				? jQuery("#AdditionalFirstName").val()
				: "",
		additionalLastName:
			jQuery("#AdditionalLastName").length > 0
				? jQuery("#AdditionalLastName").val()
				: "",
		additionalEmail:
			jQuery("#AdditionalEmail").length > 0
				? jQuery("#AdditionalEmail").val()
				: "",
		additionalPhone:
			jQuery("#AdditionalPhone").length > 0
				? jQuery("#AdditionalPhone").val()
				: "",
		additionalAddress1:
			jQuery("#AdditionalAddress1").length > 0
				? jQuery("#AdditionalAddress1").val()
				: "",
		additionalAddress2:
			jQuery("#AdditionalAddress2").length > 0
				? jQuery("#AdditionalAddress2").val()
				: "",
		additionalTown:
			jQuery("#AdditionalTown").length > 0
				? jQuery("#AdditionalTown").val()
				: "",
		additionalCounty:
			jQuery("#AdditionalCounty").length > 0
				? jQuery("#AdditionalCounty").val()
				: "",
		additionalPostcode:
			jQuery("#AdditionalPostcode").length > 0
				? jQuery("#AdditionalPostcode").val()
				: "",
		additionalCountry:
			jQuery("#AdditionalCountry").length > 0
				? jQuery("#AdditionalCountry").val()
				: "",
		activeTags:
			jQuery("#ActiveTags").length > 0 ? jQuery("#ActiveTags").val() : "",
		blockedTags:
			jQuery("#BlockedTags").length > 0 ? jQuery("#BlockedTags").val() : "",
		useAdditionalDetails:
			jQuery("#UseAdditionalDetails").length > 0
				? jQuery("#UseAdditionalDetails").val()
				: "",
		externalPaymentReference:
			jQuery("#ExternalPaymentReference").length > 0
				? jQuery("#ExternalPaymentReference").val()
				: "",
		payPal: jQuery("#PayPal").length > 0 ? jQuery("#PayPal").val() : "",
	};
}

function GetOptInShownValue() {
	var keepInTouchValue = 0;

	jQuery("input.KeepInTouch[type=checkbox]").each(function () {
		keepInTouchValue += parseInt(jQuery(this).val());
	});

	return keepInTouchValue;
}

function GetLegitInterestShownValue() {
	var doNotKeepInTouchValue = 0;

	jQuery("input.DoNotKeepInTouch[type=checkbox]").each(function () {
		doNotKeepInTouchValue += parseInt(jQuery(this).val());
	});

	return doNotKeepInTouchValue;
}

function GetKeepInTouchValue() {
	var keepInTouchValue = 0;

	jQuery("input.KeepInTouch[type=checkbox]:checked").each(function () {
		keepInTouchValue += parseInt(jQuery(this).val());
	});

	return keepInTouchValue;
}

function GetDoNotKeepInTouchValue() {
	var doNotKeepInTouchValue = 0;

	jQuery("input.DoNotKeepInTouch[type=checkbox]:checked").each(function () {
		doNotKeepInTouchValue += parseInt(jQuery(this).val());
	});

	return doNotKeepInTouchValue;
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
		errors.push("An unexpected error occurred.");
	}

	return errors;
}

function DisplayErrors(errors) {
	var errorMessage = "";
	jQuery.each(errors, function (index, value) {
		errorMessage += value + "<br/>";
	});
	DisplayErrorMessage(errorMessage);
}

function ResetErrorMessage() {
	jQuery("#Errors").html("");
	jQuery("#ErrorContainer").hide();
}

function DisplayErrorMessage(errorMessage) {
	jQuery("#PleaseWait").hide();
	jQuery("#ErrorContainer").show();
	jQuery("#Errors").html(errorMessage);
	EnableSubmitButton();
}

//Hfj edit (whole func) make id
function makeid(length) {
	var result = "";
	var characters =
		"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	var charactersLength = characters.length;
	for (var i = 0; i < length; i++) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

//Hfj edit (whole func)
jQuery.urlParam = function (name) {
	var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(
		window.location.href
	);
	if (results == null) {
		return null;
	}
	return decodeURI(results[1]) || 0;
};
let thankyou = jQuery.urlParam("thankyou");
let thankyouURL = decodeURIComponent(thankyou);

//Hfj edit (whole func)
function zapier(url) {
	var data = {
		id: makeid(8),
		amount: jQuery("#Amount").val(),
		email: jQuery("#Email").val(),
		firstname: jQuery("#FirstName").val(),
		lastname: jQuery("#LastName").val(),
		emailUpdates: jQuery("#emailPreference").is(":checked"),
		emailEvent: jQuery("#emailEvent").val(),
		type: jQuery("#type").val(),
	};
	jQuery
		.ajax({
			type: "POST",
			method: "POST",
			url: url,
			data: data,
			success: function (data) {
				console.log(data);
			},
			error: function (xhr, status, error) {
				console.log("error:" + error);
			},
		})
		.then(function () {
			let signup = "false";
			if (jQuery("#emailPreference").is(":checked")) {
				signup = "true";
			}
			let host = window.location.hostname;
			let currency = jQuery("#currency").val();
			let Name = jQuery("#FirstName").val();
			let type = jQuery("#type").val();
			let tracked = jQuery("#tracked").val();
			var urlAmount = jQuery("#Amount").val();
			if (currency == "NOK") {
				urlAmount = jQuery("#NorwayAmount").val();
			}
			var urlId = makeid(8);
			if (thankyou) {
				var redirectToPage = `${thankyouURL}?tid=${urlId}&amount=${urlAmount}&type=${type}&currency=${currency}&Name=${Name}&signup=${signup}&tracked=${tracked}`;
			} else {
				var redirectToPage = `https://${host}/donate-thankyou/?tid=${urlId}&amount=${urlAmount}&type=${type}&currency=${currency}&Name=${Name}&signup=${signup}&tracked=${tracked}`;
			}
			window.location = redirectToPage;
		});
}

//Hfj edit (whole func)
function Completed() {
	let zapierUrl =
		"/wp-content/themes/hope-for-justice-2020/zapier-thankyou.php";
	zapier(zapierUrl);
}
