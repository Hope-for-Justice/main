module.exports = function (distTheme, devTheme, jsDir) {
	var uglifyFilesObject = {};

	uglifyFilesObject[distTheme + jsDir + 'footer.js'] = [
		// plugins
		devTheme + jsDir + 'plugins/bootstrap.modal.js',
		devTheme + jsDir + 'plugins/utm-tracking.js',
		devTheme + jsDir + 'scripts.js',
	];

	uglifyFilesObject[distTheme + jsDir + 'handlebars.js'] = [

		devTheme + jsDir + 'plugins/handlebars.min.js',

	];

	uglifyFilesObject[distTheme + jsDir + 'payments.js'] = [

		devTheme + jsDir + 'plugins/jquery.payment.js',

	];
	

	uglifyFilesObject[distTheme + jsDir + 'pages/fundraise-us.js'] = [

		devTheme + jsDir + 'pages/fundraise-us.js',

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/twentyone.js'] = [

		devTheme + jsDir + 'pages/twentyone.js',

	];	

	uglifyFilesObject[distTheme + jsDir + 'pages/christmas.js'] = [

		devTheme + jsDir + 'pages/christmas.js',

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/emsi.js'] = [

		devTheme + jsDir + 'pages/emsi.js',

	];		


	uglifyFilesObject[distTheme + jsDir + 'pages/donate-no.js'] = [

		devTheme + jsDir + 'pages/donate-no.js',
		devTheme + jsDir + 'plugins/parsley.lang-no.js'

	];

	uglifyFilesObject[distTheme + jsDir + 'admin/mce-extensions.js'] = [

		devTheme + jsDir + 'admin/mce-actionbuttons.js',
		devTheme + jsDir + 'admin/mce-sharing.js'


	];	

	uglifyFilesObject[distTheme + jsDir + 'pages/donate-go-cardless.js'] = [

		devTheme + jsDir + 'pages/donate-go-cardless.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];	
	
	uglifyFilesObject[distTheme + jsDir + 'pages/donate-stripe.js'] = [

		devTheme + jsDir + 'pages/donate-stripe.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];	
	
	uglifyFilesObject[distTheme + jsDir + 'pages/donate-stripe-SCA.js'] = [

		devTheme + jsDir + 'pages/donate-stripe-SCA.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/donate-stripe-SCA-USA.js'] = [

		devTheme + jsDir + 'pages/donate-stripe-SCA-USA.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/donate-stripe-SCA-USA-once.js'] = [

		devTheme + jsDir + 'pages/donate-stripe-SCA-USA-once.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];		

	uglifyFilesObject[distTheme + jsDir + 'pages/guardian.js'] = [

		devTheme + jsDir + 'pages/guardian.js',

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/campaign.js'] = [

		devTheme + jsDir + 'pages/campaign.js',

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/givethegift-uk.js'] = [

		devTheme + jsDir + 'pages/givethegift-uk.js',
		devTheme + jsDir + 'plugins/postcodeanywhere.js'

	];

	uglifyFilesObject[distTheme + jsDir + 'pages/donorfy-api.js'] = [

		devTheme + jsDir + 'pages/donorfy-api.js'

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