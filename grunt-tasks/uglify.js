module.exports = function (distTheme, devTheme, jsDir) {
	var uglifyFilesObject = {};

	uglifyFilesObject[distTheme + jsDir + "footer.js"] = [
		// plugins
		devTheme + jsDir + "plugins/utm-tracking.js",
		devTheme + jsDir + "plugins/bootstrap.modal.js",
		//devTheme + jsDir + 'plugins/lottie.js', //no longer used
		//devTheme + jsDir + 'plugins/waypoint.js',//added when needed
		//devTheme + jsDir + 'plugins/gsap.js', //used when needed
		//devTheme + jsDir + 'plugins/draggable.js', //used when needed
		devTheme + jsDir + "plugins/headroom.js",
		//devTheme + jsDir + 'plugins/pca.js', //no longer needed
		//devTheme + jsDir + 'plugins/flexslider.js', //added when needed
		devTheme + jsDir + "plugins/fitvids.js",
		//devTheme + jsDir + 'plugins/bootstrap-flags.js', //no longer needed

		devTheme + jsDir + "scripts.js",
	];

	// uglifyFilesObject[distTheme + jsDir + 'pages/modern-slavery.js'] = [

	// 	devTheme + jsDir + 'plugins/gsap.js',
	// 	devTheme + jsDir + 'plugins/draggable.js',
	// 	devTheme + jsDir + 'plugins/flexslider.js',
	// 	devTheme + jsDir + 'pages/modern-slavery.js',

	// ];

	uglifyFilesObject[distTheme + jsDir + "pages/what-we-do.js"] = [
		devTheme + jsDir + "plugins/gsap.js",
		devTheme + jsDir + "plugins/draggable.js",
		devTheme + jsDir + "pages/what-we-do.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/governance.js"] = [
		devTheme + jsDir + "plugins/gsap.js",
		devTheme + jsDir + "plugins/draggable.js",
		devTheme + jsDir + "pages/governance.js",
	];

	uglifyFilesObject[distTheme + jsDir + "plugins/newsticker.js"] = [
		devTheme + jsDir + "plugins/newsticker.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/homepage.js"] = [
		devTheme + jsDir + "pages/homepage.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donate.js"] = [
		devTheme + jsDir + "pages/donate.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/men-are-victims.js"] = [
		devTheme + jsDir + "plugins/gsap.js",
		devTheme + jsDir + "plugins/waypoint.js",
		devTheme + jsDir + "plugins/scrolltrigger.js",
		devTheme + jsDir + "pages/men-are-victims.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/freedom-foundation.js"] = [
		devTheme + jsDir + "plugins/gsap.js",
		devTheme + jsDir + "plugins/scrolltrigger.js",
		devTheme + jsDir + "plugins/scrollto.js",
		devTheme + jsDir + "pages/freedom-foundation.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/church-partnerships.js"] = [
		devTheme + jsDir + "pages/church-partnerships.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donate-new.js"] = [
		devTheme + jsDir + "pages/donate-new.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donorfy-donate.js"] = [
		devTheme + jsDir + "pages/donorfy-donate.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donorfy-stripe.js"] = [
		devTheme + jsDir + "plugins/jquery-validate.js",
		devTheme + jsDir + "pages/donorfy-stripe.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/regular-uk.js"] = [
		devTheme + jsDir + "pages/regular-uk.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donorfy-gocardless.js"] = [
		devTheme + jsDir + "plugins/jquery-validate.js",
		devTheme + jsDir + "pages/donorfy-gocardless.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/one-off-uk.js"] = [
		devTheme + jsDir + "pages/one-off-uk.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/one-off-usa.js"] = [
		devTheme + jsDir + "pages/one-off-usa.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/one-off-norway.js"] = [
		devTheme + jsDir + "pages/one-off-norway.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/one-off-australia.js"] = [
		devTheme + jsDir + "pages/one-off-australia.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/donate-thankyou.js"] = [
		devTheme + jsDir + "pages/donate-thankyou.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/training.js"] = [
		devTheme + jsDir + "pages/training.js",
	];

	uglifyFilesObject[distTheme + jsDir + "popper.min.js"] = [
		devTheme + jsDir + "plugins/popper.min.js",
	];
	uglifyFilesObject[distTheme + jsDir + "bootstrap.min.js"] = [
		devTheme + jsDir + "plugins/bootstrap.min.js",
	];

	uglifyFilesObject[distTheme + jsDir + "news-page.js"] = [
		devTheme + jsDir + "news-page.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/freedom-run.js"] = [
		devTheme + jsDir + "pages/freedom-run.js",
	];

	uglifyFilesObject[distTheme + jsDir + "pages/boost-impact.js"] = [
		devTheme + jsDir + "pages/boost-impact.js",
	];

	return {
		// Process JavaScript
		default: {
			files: uglifyFilesObject,
			options: {
				sourceMap: true,
				sourceMapIncludeSources: true,
			},
		},
	};
};
