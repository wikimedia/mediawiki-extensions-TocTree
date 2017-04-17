/*!
 * Grunt file
 *
 * @package TocTree
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-stylelint' );

	var conf = grunt.file.readJSON( 'extension.json' );
	grunt.initConfig( {
		banana: conf.MessagesDirs,
		jsonlint: {
			all: [
				'**/*.json',
				'.stylelintrc',
				'!node_modules/**'
			]
		},
		stylelint: {
			all: [
				'**/*.css',
				'!node_modules/**'
			]
		},
		jshint: {
			all: [
				'**/*.js',
				'!node_modules/**'
			]
		}
	} );

	grunt.registerTask( 'test', [ 'jshint', 'jsonlint', 'banana', 'stylelint' ] );
	grunt.registerTask( 'default', 'test' );
};
