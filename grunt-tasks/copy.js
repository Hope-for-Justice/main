module.exports = function (distTheme, devTheme, distPlugins, devPlugins, fontsDir, imgDir, jsDir, themeName, themeDescription, themeVersion, devInstall, distInstall) {

  return {
      theme: {
        files: [{
          expand: true,
          cwd: devTheme,
          src: [ '*.php', 'inc/**/*', 'partials/**/*', 'templates/**/*'],
          dest: distTheme,
        }],
      },    
      style: {
        src: devTheme + '/style.css',
        dest: distTheme + '/style.css',
        options: {
          process: function (content, srcpath) {
            content = content.replace("grunt_theme_name_replace",themeName);
            content = content.replace("grunt_theme_description_replace",themeDescription);
            content = content.replace("grunt_theme_version_replace",themeVersion);
            return content;
          }
        }
      },
      fonts: {
        files: [{
          expand: true,
          cwd: devTheme + fontsDir,
          src: [ '**/*' ],
          dest: distTheme + fontsDir,
        }],
      },
      img: {
        files: [{
          expand: true,
          cwd: devTheme + imgDir,
          src: [ '**/*' ],
          dest: distTheme + imgDir,
        }],
      },
      tmpl: {
        files: [{
          expand: true,
          cwd: devTheme + jsDir + 'tmpl',
          src: ['**/*'],
          dest: distTheme + jsDir + 'tmpl',
        }],
      },
      install:{
        files: [{
          expand: true,
          cwd: devInstall,
          src: [ '**/*' ],
          dest: distInstall,
        }],
      }      

  }
}