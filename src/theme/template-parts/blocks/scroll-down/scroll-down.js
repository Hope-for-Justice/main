(function ($) {
	let scrollDepth = 0;
	let initializeScrollDown = function ($block) {
		function updateScrollDepth() {
			scrollDepth = window.scrollY;
			if (scrollDepth >= 100) {
				$(".scroll-down").fadeOut(500);

				window.removeEventListener("scroll", updateScrollDepth);
			}
		}

		window.addEventListener("scroll", updateScrollDepth);
		$($block).click(function () {
			const target = $("#scroll-to");
			if (target.length) {
				$("html, body").animate({ scrollTop: target.offset().top - 100 }, 500); // Animate scroll
			}
			$(".scroll-down").fadeOut(500);
			window.removeEventListener("scroll", updateScrollDepth);
		});
	};

	// Initialize each block on page load (front end).
	$(document).ready(function () {
		$(".scroll-down").each(function () {
			initializeScrollDown($(this));
		});
	});
})(jQuery);
