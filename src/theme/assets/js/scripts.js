//format postcode function
function formatPostcode(string) {
	if (string) {
		string = string.replace(/\s+/g, "");
		string = string.split(/(?=.{3}$)/).join(" ");
		string = string.toUpperCase();
		return string;
	}
	string = "";
	return string;
}

/* Page load scripts */
jQuery(document).ready(function ($) {
	console.log("v6.2.5");
	let cookies = Cookies.get("wordpress_hfjcookies");

	// cookieAccept click
	if (cookies !== "accept") {
		$("#cookieNotice").css("visibility", "visible");
	}

	$("#cookieAccept").click(function () {
		Cookies.set("wordpress_hfjcookies", "accept", { path: "/", expires: 100 });
		$("#cookieNotice").css("display", "none");
	});

	//push banner cookie
	$("#pushBanner").click(function () {
		let name = $(this).data("cookie");
		Cookies.set(name, "set", { path: "/", expires: 30 });
		$("#cookieNotice").css("display", "none");
	});

	$(".search-page__filter-button").click(function () {
		$(this).toggleClass("search-page__filter-button--open");
		$(".search-page__filters").toggleClass("search-page__filters--open");
	});

	$(".search-page__filter + label").click(function () {
		console.log("clicked filter");
		let current = $(this).prev();
		$(".search-page__filter").not(current).prop("checked", false).change();
	});

	$(".search-page__filter").on("change", function () {
		$("#inline-search").submit();
	});

	// $(".search-page__filter--all + label").click(function () {
	//     console.log('clicked on all')
	//     $(".search-page__filter").each(function () {
	//         $(this).prop('checked', false).change();
	//     })
	// })

	$(".ukraineDonate").click(function () {
		$([document.documentElement, document.body]).animate(
			{
				scrollTop: $("#ukraineGiving").offset().top - 100,
			},
			500
		);
	});

	$(".button--spinner").click(function () {
		$(this).html("<span>•</span> <span>•</span> <span>•</span>");
	});

	//url param function
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split("&"),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split("=");

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined
					? true
					: decodeURIComponent(sParameterName[1]);
			}
		}
	};

	//push banner
	let banner = $("#pushBanner");
	let bannerHeight = $("#pushBanner").outerHeight();

	if ($("#pushBanner").length) {
		//alert(bannerHeight);
		$("body").css("padding-top", bannerHeight);
		let headerPadding = parseInt($("header").css("padding-top"));
		$("header").css("padding-top", bannerHeight + headerPadding);
	}

	// //if donate=true show donate form
	// var donate = getUrlParameter('donate');
	// if(donate == "true") {
	//     //modal (spash)
	//     $('#payment-modal-once').modal('show');
	// } else if(donate == "monthly")   {
	//     //modal (spash)
	//     $('#payment-modal-regular').modal('show');
	// }

	//Drop down questions
	$(".dropdown").click(function () {
		$(this).toggleClass("dropdown--open");
	});

	//Drop cards
	$(".drop-card__header").click(function () {
		$(this).parent().toggleClass("drop-card--open");
		$(this)
			.find(".cross-circle")
			.find(".cross-circle__plus")
			.toggleClass("cross-circle__plus--open");
	});

	// Bootstrap modal
	$(".modal").on("shown.bs.modal", function () {
		// any time a modal is shown
		$(this)
			.find(".modal__content")
			.addClass("animate__animated animate__fadeInDown")
			.fadeIn(); //animate in
		var urlReplace = "#" + $(this).attr("id"); // make the hash the id of the modal shown
		history.pushState(null, null, urlReplace); // push state that hash into the url
	});

	// If a pushstate has previously happened and the back button is clicked, hide any modals.
	$(window).on("popstate", function () {
		$(".modal").modal("hide");
	});

	// Burger menu
	let isOpen = false;
	$("#burger-menu").click(function () {
		if (isOpen == false) {
			$(this).find(".burger").toggleClass("open");
			$("#menu").toggleClass("menu--open");
			$("#site-header").toggleClass("header--open");
			$(".menu__inner").css("opacity", "1");
			isOpen = true;
		} else {
			$(this).find(".burger").toggleClass("open");
			$(".menu__inner").css("opacity", "0");
			$("#menu").toggleClass("menu--open");
			$("#site-header").toggleClass("header--open");
			isOpen = false;
		}
	});

	$(".search-field").val("");
	$("#headerSearch").click(function () {
		$(this).addClass("header__search--show-form");
		if ($(window).width() < 768) {
			$("#burger-menu, #donate").hide();
		} else {
			//$(".header__search-icon").hide();
		}
		$(".search-field").focus();
	});

	$(".search-field").focusout(function () {
		$("#headerSearch").removeClass("header__search--show-form");
		if ($(window).width() < 768) {
			$("#burger-menu, #donate").show();
		} else {
			//$(".header__search-icon").show();
		}
	});

	// autoplay bootstrap modal video
	var $videoSrc;
	var $frame = $(".video");
	$(".video-trigger").click(function () {
		$videoSrc = $(this).data("src");
		console.log($videoSrc);
		$frame.attr("src", $videoSrc + "?autoplay=1&playsinline=0");
	});

	$(".modal").on("hidden.bs.modal", function (e) {
		// sets the source to nothing, stopping the video
		$frame.attr("src", "");
	});

	//get help modal on show
	$("#get-help-modal").on("shown.bs.modal", function (e) {
		$(".get-help").addClass("get-help--modal-open");
	});

	//get help modal on hidden
	$("#get-help-modal").on("hidden.bs.modal", function (e) {
		$(".get-help").removeClass("get-help--modal-open");
	});

	//reference modal text
	var $text;
	$(".reference__symbol, .reference").click(function () {
		$text = $(this).data("text");
		$title = $(this).data("title");
		$(".modal__text").html($text);
		$(".modal__title").html($title);
	});

	// responsive resizing videos
	//$(".page").fitVids();
	//$(".single").fitVids();
	$('iframe[src*="youtube"]').parent().fitVids();
	$('iframe[src*="bbc"]').parent().fitVids();

	let open = false;

	$(".picture-description").click(function () {
		if (!open) {
			$(this).toggleClass("picture-description--active");
			$(".picture-description__text").delay(200).slideDown(150);
			open = true;
		} else {
			$(".picture-description__text").hide();
			$(this).toggleClass("picture-description--active");
			open = false;
		}
	});

	//capitalize function
	jQuery.fn.capitalize = function () {
		$(this[0]).keyup(function (event) {
			var box = event.target;
			var txt = $(this).val();
			var stringStart = box.selectionStart;
			var stringEnd = box.selectionEnd;
			$(this).val(
				txt.replace(/^(.)|(\s|\-)(.)/g, function ($word) {
					return $word.toUpperCase();
				})
			);
			box.setSelectionRange(stringStart, stringEnd);
		});
		return this;
	};

	$(".wp-block-columns").each(function () {
		let children = $(this).children().length;
		$(this).addClass("block-" + children + "-columns");
	});
}); /* end of as page load scripts */

//gravity forms on render
jQuery(document).on(
	"gform_post_render",
	function (event, form_id, current_page) {
		// //modify field name to 'search' on gravity forms if class exists
		// jQuery(".address-search input").attr("name","search");

		//show address fields on click
		jQuery(".address-link").on("click", function () {
			jQuery(".address-fields").show();
		});

		//remove html in search input on click
		jQuery(".address-search input").on("click", function () {
			jQuery(this).val("");
		});

		// //postcode anywhere with regex matching
		// var e = {
		//     key: "DN97-JG93-ZJ46-EW48" //PCA API key
		// },
		// d = [{
		//     element: "search", // use the field named 'search' to search
		//     field: "",
		//     mode: pca.fieldMode.SEARCH
		// }, {
		//     element: "^input_[0-9]{1,}_[0-9]{1,}_1$",
		//     field: "Line1",
		//     mode: pca.fieldMode.POPULATE
		// }, {
		//     element: "^input_[0-9]{1,}_[0-9]{1,}_2$",
		//     field: "Line2",
		//     mode: pca.fieldMode.POPULATE
		// }, {
		//     element: "^input_[0-9]{1,}_[0-9]{1,}_3$",
		//     field: "City",
		//     mode: pca.fieldMode.POPULATE
		// }, {
		//     element: "^input_[0-9]{1,}_[0-9]{1,}_4$",
		//     field: "Province",
		//     mode: pca.fieldMode.POPULATE
		// }, {
		//     element: "^input_[0-9]{1,}_[0-9]{1,}_5$",
		//     field: "PostalCode",
		//     mode: pca.fieldMode.POPULATE
		// }],
		// o = new pca.Address(d, e);
		// o.listen("populate", function() {
		//     jQuery(".address-search input").val(jQuery(".address_line_1 input").val() + "...");
		// }), o.load()
	}
);

jQuery(document).on("gform_confirmation_loaded", function (event, formId) {
	// lottie
	var blackTick;
	var elem = document.getElementById("blackTick");

	if (elem != undefined) {
		var blackTickAnimData = {
			container: elem,
			renderer: "canvas",
			loop: false,
			autoplay: true, //change to false when using trigger
			rendererSettings: {
				progressiveLoad: false,
			},
			path: "/wp-content/themes/hope-for-justice-2020/assets/img/black-tick.json",
			//on wp-engine /wp-content/themes/hope-for-justice-2020/assets/img/black-tick.json
			//on local setup /build/themes/hope-for-justice-2020/assets/img/black-tick.json
		};
		blackTick = bodymovin.loadAnimation(blackTickAnimData);
	}
});

/* Window load scripts */
(function ($) {
	jQuery(window).on("load", function () {
		// Headroom
		var elem = document.querySelector("header");
		var headroom = new Headroom(elem, {
			offset: 150,
			tolerance: 5,
			classes: {
				pinned: "header--slideDown",
				unpinned: "header--slideUp",
			},
		});
		// initialise
		headroom.init();

		//url param function
		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split("&"),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split("=");

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined
						? true
						: decodeURIComponent(sParameterName[1]);
				}
			}
		};

		//if no donate url param show splash
		// var donate = getUrlParameter('donate');
		// if(donate != "true" && donate != "monthly") {
		//     $('#splash-modal').modal('show');
		// }

		//////////////////////////////////////////////////////////////////////////////////////////////////////
		// give wp //////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////

		$("#usaForm, #usaFormMonthly")
			.find("iframe")
			.contents()
			.find(".currency--before")
			.html("$");
		$("#ausForm, #ausFormMonthly")
			.find("iframe")
			.contents()
			.find(".currency--before")
			.html("$");
		$("#norwayForm, #norwayFormMonthly")
			.find("iframe")
			.contents()
			.find(".currency--before")
			.html("Kr.");
		$("iframe").contents().find(".country-selector").hide();

		const inspirationQuestion = $(".give-embed-form-wrapper")
			.find("iframe")
			.contents()
			.find(".inspiration-question")
			.find("select");

		function customLabel(obj) {
			let choice = obj.val();
			let furtherDetails = obj
				.parent()
				.siblings(".further-details")
				.find("label");
			if (choice == "Faith Based") {
				$(furtherDetails).html(
					"Please tell us the name of your place of worship"
				);
			} else if (choice == "Social media") {
				$(furtherDetails).html("Please tell us which platform inspired you");
			} else if (
				choice == "I know a Hope for Justice staff member/ volunteer"
			) {
				$(furtherDetails).html("Please tell us who you know");
			} else if (choice == "Gift of celebration") {
				$(furtherDetails).html("Please let us know what you are celebrating");
			} else if (choice == "Other") {
				$(furtherDetails).html("Tell us more");
			} else if (choice == "Event or talk") {
				$(furtherDetails).html("Please tell us which event or talk");
			} else {
				$(furtherDetails).html("Further details");
			}
		}

		inspirationQuestion.change(function () {
			customLabel($(this));
		});

		inspirationQuestion.each(function () {
			customLabel($(this));
		});

		//const selectOption = $(".give-embed-form-wrapper").find('iframe').contents().find(".preferencesQuestion").find('select');
		//const options = $(".give-embed-form-wrapper").find('iframe').contents().find(".preference");
		//const preferenceText = $(".give-embed-form-wrapper").find('iframe').contents().find(".preferenceText");

		// let selectedValue = selectOption.val();

		// function preferenceQuestions(){
		//     let selectedValue = selectOption.val();
		//     if (selectedValue !== "Yes, keep my settings as they are") {
		//         $(options).each(function(i) {
		//             $(this).show();
		//             $(this).find('select').children('option:nth-child(4)').prop('hidden','true');
		//             $(this).find('select').children('option:nth-child(1)').prop('selected','selected');
		//             $(preferenceText).parent().show();
		//         });
		//     } else {
		//         $(options).each(function(i) {
		//             $(this).hide();
		//             $(this).find('select').children('option:nth-child(4)').prop('hidden','true');
		//             $(this).find('select').children('option:nth-child(4)').prop('selected','selected');
		//             $(preferenceText).parent().hide();
		//         });
		//     }
		// }

		// preferenceQuestions();

		// selectOption.change(function (){
		//     preferenceQuestions();
		// });

		//Homepage
		// if(!$(".modal").length){
		//     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
		// }

		// $('.modal').on('hidden.bs.modal', function () {
		//     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
		// });
	}); /* end of on widow load*/
})(jQuery);
