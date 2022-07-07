module.exports = function (distTheme, devTheme, scssDir) {
  const sass = require('dart-sass');
  return {
    build: {
      options: {
        implementation: sass,
        outputStyle: 'compressed',
        sourceMap: false
      },
      files: [
        // { src: devTheme + scssDir + 'old-ie.scss',dest: distTheme  + '/old-ie.css'},
        { src: devTheme + scssDir + 'style.scss', dest: distTheme + '/style.css' },
        { src: devTheme + scssDir + 'givewp-iframes-styles.scss', dest: distTheme + '/givewp-iframes-styles.css' },
        { src: devTheme + scssDir + 'news-page.scss', dest: distTheme + '/assets/css/news-page.css' },
        { src: devTheme + scssDir + 'gov-pol-fund.scss', dest: distTheme + '/assets/css/gov-pol-fund.css' },
        { src: devTheme + scssDir + 'resources-template.scss', dest: distTheme + '/assets/css/resources-template.css' },
        { src: devTheme + scssDir + 'volunteering-opportunities.scss', dest: distTheme + '/assets/css/volunteering-opportunities.css' },
        { src: devTheme + scssDir + 'events.scss', dest: distTheme + '/assets/css/events.css' },
        { src: devTheme + scssDir + 'case-studies.scss', dest: distTheme + '/assets/css/case-studies.css' },
        { src: devTheme + scssDir + 'lib/bootstrap/scss/bootstrap.scss', dest: distTheme + '/assets/css/bootstrap.css' },
        //page specific
        { src: devTheme + scssDir + 'pages/men-are-victims.scss', dest: distTheme + '/men-are-victims.css' },
        { src: devTheme + scssDir + 'pages/goats-milk.scss', dest: distTheme + '/goats-milk.css' },

      ]
    }
  }
}