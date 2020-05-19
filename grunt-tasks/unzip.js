module.exports = function(devInstall, distInstall) {

    return{
      highlight: {
        src: devInstall,
        dest: distInstall
      }
    }
};