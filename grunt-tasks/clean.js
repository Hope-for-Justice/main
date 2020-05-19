module.exports = function (distTheme, distPlugins, jsDir, fontsDir, imgDir, scssDir, installDir, wpZip, wpTmpFolder) {
  return {
      all:       { src: [ distTheme, distPlugins ], },
      css:       { src: [ distTheme + 'style.css' ], },
      fonts:     { src: [ distTheme + fontsDir ], },
      img:       { src: [ distTheme + imgDir ], },
      scss:      { src: [ distTheme + scssDir ], },
      js:      	 { src: [ distTheme + jsDir ], },
      install:   { src: [ installDir ]},
      wpTmp:     { src: [ wpZip, wpTmpFolder ] }
  }
}