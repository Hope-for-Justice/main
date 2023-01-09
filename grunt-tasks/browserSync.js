module.exports = function (distTheme) {
    return {
        dev: {
            bsFiles: {
                src: [
                    distTheme + '**/*.css',
                    distTheme + '/assets/css/*.css',
                    distTheme + '/assets/js/**/*.js',
                    distTheme + '/template-parts/blocks/*.css',
                    distTheme + '/template-parts/blocks/**/*.php',
                    distTheme + '/template-parts/blocks/**/*.js',
                    distTheme + '*.php'
                ]
            },
            options: {
                proxy: "https://hfj.dev",
                watchTask: true,
            },
        }
    }
}