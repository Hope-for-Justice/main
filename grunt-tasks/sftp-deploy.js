/*
*
* Update with up new host info
*
*/
module.exports = function (deployBase, themeName) {
	return {
	  	'production': {
			auth: {
			host: 'hfj2.sftp.wpengine.com',
			port: 2222,
			authKey: 'production'
		},
		cache: 'sftpcache.json',
		src: deployBase,
		dest: 'wp-content',
		exclusions: [deployBase + '/uploads', deployBase + '/plugins', deployBase + '/languages', deployBase + '/upgrade', '.ftppass', '.git', '.gitignore', 'node_modules', '.sass-cache', 'npm-debug.log', 'debug.log', '.DS_Store', '.sftpcache.json'],
		serverSep: '/',
		concurrency: 4,
		progress: true
		},

		'staging': {
			auth: {
			host: 'hfj2.sftp.wpengine.com',
			port: 2222,
			authKey: 'staging'
		},
		cache: 'sftpcache-staging.json',
		src: deployBase,
		dest: 'wp-content',
		exclusions: [deployBase + '/uploads', deployBase + '/languages', deployBase + '/upgrade', '.ftppass', '.git', '.gitignore', 'node_modules', '.sass-cache', 'npm-debug.log', 'debug.log', '.DS_Store', '.sftpcache.json'],
		serverSep: '/',
		concurrency: 4,
		progress: true
		}
	}
}
