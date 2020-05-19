module.exports = function (distTheme, devTheme, distPlugins, devPlugins, jsDir, fontsDir, imgDir, iconsDir, scssDir) {
	return {
	  dev_php: {
	    files: [ devTheme + '/**/*.php' ],
	    tasks: [ 'theme_changed' ],
	  },
	  dev_fonts: {
	    files: [ devTheme + fontsDir + '**/*' ],
	    tasks: [ 'fonts_changed' ],
	  },
	  dev_img: {
	    files: [ devTheme + imgDir + '**/*' ],
	    tasks: [ 'img_changed' ],
	  },
	  dev_js: {
	    files: [ devTheme + jsDir + '**/*' ],
	    tasks: [ 'js_changed' ],
	  },	  
	  dev_scss: {
	    files: [ devTheme + scssDir + '**/*' ],
	    tasks: [ 'scss_changed' ],
	  },
	  dev_gruntfile: {
	    files: [ 'gruntfile.js', 'grunt-tasks/**/*' ],
	    tasks: [ 'default' ],
	  },
	  livereload: {
	    files: [
	      distTheme + '/**/*.php',
	      distTheme + '**/*.css',
	      distTheme + imgDir + '**/*',
	      distTheme + jsDir + '**/*.js',
	    ],
	    options: {
	      livereload: true,
	    },
	  },
	}
}