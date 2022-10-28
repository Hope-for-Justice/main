module.exports = function (distTheme, devTheme, distPlugins, devPlugins, jsDir, fontsDir, imgDir, iconsDir, scssDir, devBlocks) {
	return {
		dev_php: {
			files: [devTheme + '/**/*.php', devTheme + '/theme.json'],
			tasks: ['theme_changed', 'blocks_changed', 'scss_changed'],
		},
		dev_fonts: {
			files: [devTheme + fontsDir + '**/*'],
			tasks: ['fonts_changed'],
		},
		dev_img: {
			files: [devTheme + imgDir + '**/*'],
			tasks: ['img_changed'],
		},
		dev_js: {
			files: [devTheme + jsDir + '**/*', devBlocks + '/**/*.js'],
			tasks: ['js_changed'],
		},
		dev_scss: {
			files: [devTheme + '/**/*.scss'],
			tasks: ['scss_changed'],
		},
		dev_gruntfile: {
			files: ['gruntfile.js', 'grunt-tasks/**/*'],
			tasks: ['default'],
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