module.exports = function (distTheme, devTheme, scssDir) {
  return {
    build: {
      options: {
        outputStyle: 'compressed',
        sourceMap: false
      },        
      files: [
        { src: devTheme + scssDir + 'style.scss',dest: distTheme  + '/style.css'},
        { src: devTheme + scssDir + 'old-ie.scss',dest: distTheme  + '/old-ie.css'},
        { src: devTheme + scssDir + 'news-page.scss',dest: distTheme  + '/assets/css/news-page.css'},

         { src: devTheme + scssDir + 'lib/bootstrap/scss/bootstrap.scss',dest: distTheme  + '/assets/css/bootstrap.css'},
      
      ]
    }
  }
}