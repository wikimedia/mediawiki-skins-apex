/*jshint node:true */
module.exports = function ( grunt ) {
	var conf = grunt.file.readJSON( 'skin.json' );

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-jscs' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.initConfig( {
		jshint: {
			options: {
				jshintrc: true
			},
			all: [
				'*.js',
				'resources/*.js'
			]
		},
		jscs: {
			src: '<%= jshint.all %>'
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			all: [
				'resources/**/*.css'
			]
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**'
			]
		},
		banana: conf.MessagesDirs,
		watch: {
			files: [
				'<%= jshint.all %>',
				'<%= csslint.all %>',
				'<%= jsonlint.all %>',
				'.{jshintrc,jshintignore,jscsrc,csslintrc}'
			],
			tasks: 'test'
		}
	} );

	grunt.registerTask( 'test', [ 'jshint', 'jscs', 'csslint', 'jsonlint', 'banana' ] );
	grunt.registerTask( 'default', 'test' );
};
