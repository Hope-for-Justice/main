module.exports = function (distTheme, devTheme, jsDir) {
	var uglifyFilesObject = {};


	uglifyFilesObject[distTheme + jsDir + 'footer.js'] = [
		// plugins
		devTheme + jsDir + 'plugins/bootstrap.modal.js',
		devTheme + jsDir + 'plugins/utm-tracking.js',
		devTheme + jsDir + 'plugins/newsticker.js',
		devTheme + jsDir + 'plugins/lottie.js',
		devTheme + jsDir + 'plugins/waypoint.js',
		devTheme + jsDir + 'plugins/gsap.js',
		devTheme + jsDir + 'plugins/draggable.js',
		devTheme + jsDir + 'plugins/headroom.js',
		devTheme + jsDir + 'plugins/pca.js',
		devTheme + jsDir + 'plugins/flexslider.js',
		devTheme + jsDir + 'plugins/fitvids.js',
		//devTheme + jsDir + 'plugins/bootstrap-flags.js',
		devTheme + jsDir + 'scripts.js',

	];


	uglifyFilesObject[distTheme + jsDir + 'pages/homepage.js'] = [

		devTheme + jsDir + 'pages/homepage.js',


	];

	uglifyFilesObject[distTheme + jsDir + 'pages/donate.js'] = [

		devTheme + jsDir + 'pages/donate.js',


	];

	uglifyFilesObject[distTheme + jsDir + 'pages/training.js'] = [

		devTheme + jsDir + 'pages/training.js',


	];

	uglifyFilesObject[distTheme + jsDir + 'popper.min.js'] = [

		devTheme + jsDir + 'plugins/popper.min.js',


	];
	uglifyFilesObject[distTheme + jsDir + 'bootstrap.min.js'] = [

		devTheme + jsDir + 'plugins/bootstrap.min.js',


	];

	uglifyFilesObject[distTheme + jsDir + 'news-page.js'] = [

		devTheme + jsDir + 'news-page.js',


	];

	uglifyFilesObject[distTheme + jsDir + 'pages/freedom-run.js'] = [

		devTheme + jsDir + 'pages/freedom-run.js',


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
	}
}