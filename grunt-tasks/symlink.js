module.exports = function (devPlugins, distPlugins, devACF, distACF) {
	return {
    // Enable overwrite to delete symlinks before recreating them
    options: {
      overwrite: false
    },
    // The "build/target.txt" symlink will be created and linked to
    // "source/target.txt". It should appear like this in a file listing:
    // build/target.txt -> ../source/target.txt
    expanded: {
      files: [
        {
          expand: false,
          src: devPlugins,
          dest: distPlugins
        },
        {
          expand: false,
          src: devACF,
          dest: distACF
        }
      ]
    }
	}
}