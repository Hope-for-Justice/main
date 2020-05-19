/// <vs AfterBuild='default' />

var theme = {
    name:'hope-for-justice-2020',
    description: 'Custom Wordpress theme for Hope for Justice 2020',
    author: 'James Holt',
    version: '1.0.0'
}

var dir = {

    // Set directory variables
    devTheme: 'src/theme',
    devPlugins: 'src/plugins',
    distTheme: 'build/themes/' + theme.name,
    distPlugins: 'build/plugins',

    devACF: 'src/acf-json',
    distACF: 'build/themes/' + theme.name + '/acf-json',



    deployBase: 'build',

    gruntDir: 'grunt-tasks',

    jsDir:  '/assets/js/',
    fontsDir: '/assets/fonts/',
    imgDir: '/assets/img/',
    scssDir: '/assets/scss/',

    wpDir: 'core/', 
    wpTmp: 'src/',
    wpName: 'wordpress',
    wpZip:  'wordpress.zip',
    wpCurl: 'http://wordpress.org/latest.zip'
}

module.exports = function(grunt) {


  /*  Load tasks  */

  require('load-grunt-tasks')(grunt);

  /*  Configure project  */

  grunt.initConfig({


    pkg: grunt.file.readJSON('package.json'),

    // Setup tasks
    clean:              require('./grunt-tasks/clean')(dir.distTheme, dir.distPlugins, dir.jsDir, dir.fontsDir, dir.imgDir, dir.scssDir, dir.wpDir, dir.wpTmp + dir.wpZip, dir.wpTmp + dir.wpName),
    symlink:            require('./grunt-tasks/symlink')(dir.devPlugins, dir.distPlugins, dir.devACF, dir.distACF),        
    copy:               require('./grunt-tasks/copy')(dir.distTheme, dir.devTheme, dir.distPlugins, dir.devPlugins, dir.fontsDir, dir.imgDir, dir.jsDir, theme.name, theme.description, theme.version, dir.wpTmp + dir.wpName, dir.wpDir),
    sass:               require('./grunt-tasks/sass')(dir.distTheme, dir.devTheme, dir.scssDir),
    uglify:             require('./grunt-tasks/uglify')(dir.distTheme, dir.devTheme, dir.jsDir),
    watch:              require('./grunt-tasks/watch')(dir.distTheme, dir.devTheme, dir.distPlugins, dir.devPlugins, dir.jsDir, dir.fontsDir, dir.imgDir, dir.iconsDir, dir.scssDir),
    'sftp-deploy':      require('./grunt-tasks/sftp-deploy')(dir.deployBase, theme.name),
    curl:               require('./grunt-tasks/curl')(dir.wpCurl, dir.wpTmp + dir.wpZip),
    unzip:              require('./grunt-tasks/unzip')(dir.wpTmp + dir.wpZip, dir.wpTmp),

  });


  /*  Register tasks  */
  
  // Default task. 
  grunt.registerTask('default', ['clean:all', 'symlink', 'copy:theme', 'copy:style', 'copy:img', 'copy:tmpl', 'copy:fonts', 'sass:build', 'uglify', 'watch']);

  // Specific watch-related tasks
  grunt.registerTask('theme_changed',     ['copy:theme']);
  grunt.registerTask('fonts_changed',     ['clean:fonts','copy:fonts']);
  grunt.registerTask('img_changed',       ['clean:img','copy:img']);
  grunt.registerTask('scss_changed',      ['clean:css','sass']);
  grunt.registerTask('js_changed',        ['clean:js','copy:tmpl', 'uglify']);

  // install Wordpress latest
  grunt.registerTask('wp-install',          ['clean:wpTmp', 'curl', 'unzip', 'clean:install', 'copy:install', 'clean:wpTmp']);
  

  grunt.registerTask('deploy-production',            ['clean:all', 'symlink', 'copy:theme', 'copy:style', 'copy:img', 'copy:tmpl', 'copy:fonts', 'sass:build', 'uglify','sftp-deploy:production']);
  grunt.registerTask('deploy-staging',            ['clean:all', 'symlink', 'copy:theme', 'copy:style', 'copy:img', 'copy:tmpl', 'copy:fonts', 'sass:build', 'uglify','sftp-deploy:staging']);

};