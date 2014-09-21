module.exports = function(grunt) {

  // Just all the JS files we want added to the app.min.js
  // files with ! before the path will not be included.
  // This must be set if you don't want a certain file added.
  var jsfileList = [
    'theme/assets/js/bootstrap/*.js',
    'theme/assets/js/theme/*.js',
    '!theme/assets/js/theme/wp*.js',
  ];

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    less: {
      development: {
        options: {
          paths: ["theme/assets/less"],
          compress: true,
          strictImports: true
        },
        files: {
          "theme/assets/css/app.min.css": "theme/assets/less/app.less"
        }
      }
    },

    uglify: {
      my_target: {
        files: {
          'theme/assets/js/app.min.js': jsfileList
        }
      }
    },

    jshint: {
      options: {
        reporter: require('jshint-stylish'),
        globals: {
          jQuery: true
        },
      },
      all: ['Gruntfile.js', 'theme/assets/js/theme/**/*']
    },

    clean: ['theme/assets/js/app.min.js', 'theme/assets/css/app.min.css'],

    // Watches all less, js files; runs the tasks.
    watch: {
      scripts: {
        files: ["theme/assets/less/**/*", "theme/assets/js/**/*"],
        tasks: ['clean', 'less', 'uglify', 'jshint'],
        options: {
          spawn: false
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['clean', 'less', 'jshint', 'uglify']);

};