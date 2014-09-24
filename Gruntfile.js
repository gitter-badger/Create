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

    // copy files and folders form the components folder to the theme folder
    // staying hip to package management while staying lean and portable
    // documentation https://github.com/gruntjs/grunt-contrib-copy
    copy: {
      main: {
        files: [
          //BOOTSTRAP COMPONTENTS
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/less/*.less'], dest: 'theme/assets/less/bootstrap/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/less/mixins/*.less'], dest: 'theme/assets/less/bootstrap/mixins/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/js/*.js'], dest: 'theme/assets/js/bootstrap/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/fonts/**'], dest: 'theme/assets/fonts/bootstrap/', filter: 'isFile'},

          // FONTAWESOME
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/font-awesome/less/*.less'], dest: 'theme/assets/less/fontawesome/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/font-awesome/fonts/**'], dest: 'theme/assets/fonts/fontawesome/', filter: 'isFile'},

          // MODERNIZR JS
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/modernizr/modernizr`.js'], dest: 'theme/assets/js/modernizr/', filter: 'isFile'},

          // RESPOND JS
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/respond/src/respond.js'], dest: 'theme/assets/js/respond/', filter: 'isFile'},
        ]
      }
    },

    "regex-replace": {
        foofoo: { //specify a target with any name
            src: ['theme/assets/less/bootstrap/variables.less'],
            actions: [
                {
                    name: 'bar',
                    search: '../fonts/',
                    replace: '../bootstrap/fonts/',
                    flags: 'g'
                }
            ]
        }
    },

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

  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-regex-replace');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('migrate', ['copy', 'regex-replace']);
  grunt.registerTask('replaceit', ['regex-replace']);
  grunt.registerTask('default', ['clean', 'less', 'jshint', 'uglify']);

};