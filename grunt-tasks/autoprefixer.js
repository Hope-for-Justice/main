module.exports = function (distTheme, devTheme, scssDir) {
    return {
        autoprefixer: {
            options: {
                browsers: ['last 5 versions'],
            },
            src: 'build/**/*.css'
        }
    }
}