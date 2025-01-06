module.exports = function (distTheme, devTheme, scssDir) {
	const sass = require("dart-sass");
	return {
		build: {
			options: {
				implementation: sass,
				outputStyle: "compressed",
				sourceMap: false,
			},
			files: [
				// { src: devTheme + scssDir + 'old-ie.scss',dest: distTheme  + '/old-ie.css'},
				{
					src: devTheme + scssDir + "style.scss",
					dest: distTheme + "/style.css",
				},
				{
					src: devTheme + scssDir + "givewp-iframes-styles.scss",
					dest: distTheme + "/givewp-iframes-styles.css",
				},
				{
					src: devTheme + scssDir + "news-page.scss",
					dest: distTheme + "/assets/css/news-page.css",
				},
				{
					src: devTheme + scssDir + "gov-pol-fund.scss",
					dest: distTheme + "/assets/css/gov-pol-fund.css",
				},
				{
					src: devTheme + scssDir + "resources-template.scss",
					dest: distTheme + "/assets/css/resources-template.css",
				},
				{
					src: devTheme + scssDir + "volunteering-opportunities.scss",
					dest: distTheme + "/assets/css/volunteering-opportunities.css",
				},
				{
					src: devTheme + scssDir + "events.scss",
					dest: distTheme + "/assets/css/events.css",
				},
				{
					src: devTheme + scssDir + "case-studies.scss",
					dest: distTheme + "/assets/css/case-studies.css",
				},
				{
					src: devTheme + scssDir + "lib/bootstrap/scss/bootstrap.scss",
					dest: distTheme + "/assets/css/bootstrap.css",
				},
				//page specific
				{
					src: devTheme + scssDir + "pages/men-are-victims.scss",
					dest: distTheme + "/men-are-victims.css",
				},
				{
					src: devTheme + scssDir + "pages/goats-milk.scss",
					dest: distTheme + "/goats-milk.css",
				},
				{
					src: devTheme + scssDir + "pages/church-partnerships.scss",
					dest: distTheme + "/church-partnerships.css",
				},
				{
					src: devTheme + scssDir + "pages/offline-regular-ask.scss",
					dest: distTheme + "/offline-regular-ask.css",
				},

				//better styles for design system
				{
					src: devTheme + scssDir + "block-base-styles.scss",
					dest: distTheme + "/block-base-styles.css",
				},

				//block editor styles
				{
					src: devTheme + scssDir + "editor-block-base-styles.scss",
					dest: distTheme + "/editor-block-base-styles.css",
				},

				{
					src: devTheme + scssDir + "block-styles.scss",
					dest: distTheme + "/block-styles.css",
				},

				{
					expand: true, // Recursive
					flatten: true,
					//cwd: distTheme,
					src: devTheme + "/template-parts/blocks/" + "**/*.scss", // Source files
					dest: distTheme + "/template-parts/blocks/", // Destination
					ext: ".css", // File extension
				},
			],
		},
	};
};
