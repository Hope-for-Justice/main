const mix = require( 'laravel-mix' );
const wpPot = require( 'wp-pot' );

mix.options( {
	// Don't perform any css url rewriting by default
	processCssUrls: false,
} );

mix.webpackConfig( {
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
} );

mix.copyDirectory( 'assets/src/img', 'assets/dist/img' );

mix
	.setPublicPath( 'assets/dist' )
	.sourceMaps( false )
	.sass( 'assets/src/css/ffm-datepicker.scss', 'css/give-ffm-datepicker.css' )
	.sass( 'assets/src/css/ffm-backend.scss', 'css/give-ffm-admin.css' )
	.sass( 'assets/src/css/ffm-frontend.scss', 'css/give-ffm-frontend.css' );

mix.babel(
	[
		'assets/src/js/plugins/jquery-maskedinput.js',
		'assets/src/js/plugins/transition.js',
		'assets/src/js/plugins/jquery-blockUI.js',
		'assets/src/js/plugins/collapse.js',
		'assets/src/js/plugins/give-ffm-upload.js',
		'assets/src/js/plugins/jquery-ui-timepicker-addon.js',
		'assets/src/js/plugins/give-ffm-date-field.js',
		'assets/src/js/admin/give-ffm-transaction.js',
		'assets/src/js/admin/conditional-visibility-settings.js',
		'assets/src/js/admin/give-formbuilder.js',
	],
	'assets/dist/js/give-ffm-admin.js'
);

mix.babel(
	[
		'assets/src/js/plugins/jquery-maskedinput.js',
		'assets/src/js/plugins/jquery-ui-timepicker-addon.js',
		'assets/src/js/plugins/jquery-ui-sliderAccess.js',
		'assets/src/js/plugins/give-ffm-date-field.js',
		'assets/src/js/frontend/give-ffm.js',
		'assets/src/js/plugins/give-ffm-upload.js',
	],
	'assets/dist/js/give-ffm-frontend.js'
);

if ( mix.inProduction() ) {
	wpPot( {
		package: 'Give-Form-Field-Manager',
		domain: 'give-form-field-manager',
		destFile: 'languages/give-ffm.pot',
		relativeTo: './',
		src: ['**/*.php', '!vendor/**/*.php', '!node_modules/**/*.php' ],
		bugReport: 'https://github.com/impress-org/give-funds/issues/new',
		team: 'GiveWP <info@givewp.com>',
	} );
}
