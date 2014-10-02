module.exports = function(grunt) {

  // Just all the JS files we want added to the app.min.js
  // files with ! before the path will not be included.
  // This must be set if you don't want a certain file added.


  // Dynamic file locations:
  // <%= pkg.theme %>/<%= pkg.fontsloc %>/
  // <%= pkg.theme %>/<%= pkg.lessloc %>/
  // <%= pkg.theme %>/<%= pkg.cssloc %>/
  // <%= pkg.theme %>/<%= pkg.jsloc %>/

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
          {expand: true, flatten: true, src: ['components/bootstrap/less/*.less'], dest: '<%= pkg.theme %>/<%= pkg.lessloc %>/bootstrap/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/less/mixins/*.less'], dest: '<%= pkg.theme %>/<%= pkg.lessloc %>/bootstrap/mixins/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/js/*.js'], dest: '<%= pkg.theme %>/<%= pkg.jsloc %>/bootstrap/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/bootstrap/fonts/**'], dest: '<%= pkg.theme %>/<%= pkg.fontsloc %>/bootstrap/', filter: 'isFile'},

          // FONTAWESOME
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/font-awesome/less/*.less'], dest: '<%= pkg.theme %>/<%= pkg.lessloc %>/fontawesome/', filter: 'isFile'},
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/font-awesome/fonts/**'], dest: '<%= pkg.theme %>/<%= pkg.fontsloc %>/fontawesome/', filter: 'isFile'},

          // MODERNIZR JS
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/modernizr/modernizr.js'], dest: '<%= pkg.theme %>/<%= pkg.jsloc %>/modernizr/', filter: 'isFile'},

          // RESPOND JS
          // flattens results to a single level
          {expand: true, flatten: true, src: ['components/respond/src/respond.js'], dest: '<%= pkg.theme %>/<%= pkg.jsloc %>/respond/', filter: 'isFile'},
        ]
      }
    },

    "regex-replace": {
        bootstrap: { //specify a target with any name
            src: ['<%= pkg.theme %>/<%= pkg.lessloc %>/bootstrap/variables.less'],
            actions: [
                {
                    name: 'bootstrap',
                    search: '../fonts/',
                    replace: '../bootstrap/fonts/',
                    flags: 'g'
                }
            ]
        },
        fontawesome: {
          src: ['<%= pkg.theme %>/<%= pkg.lessloc %>/fontawesome/variables.less'],
          actions: [
            {
              name: 'fontawesome',
              search: '../fonts',
              replace: '../fontawesome/fonts/',
              flags: 'g'
            }
          ]
        }
    },

    less: {
      development: {
        options: {
          paths: ["<%= pkg.theme %>/<%= pkg.lessloc %>"],
          compress: true,
          strictImports: true
        },
        files: {
          "<%= pkg.theme %>/<%= pkg.cssloc %>/app.min.css": "<%= pkg.theme %>/<%= pkg.lessloc %>/app.less"
        }
      }
    },

    uglify: {
      my_target: {
        files: {
          '<%= pkg.theme %>/<%= pkg.jsloc %>/app.min.js': [
            '<%= pkg.theme %>/<%= pkg.jsloc %>/bootstrap/*.js',
            '<%= pkg.theme %>/<%= pkg.jsloc %>/theme/*.js',
            '!<%= pkg.theme %>/<%= pkg.jsloc %>/theme/wp*.js',
          ]
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
      all: ['Gruntfile.js', '<%= pkg.theme %>/<%= pkg.jsloc %>/theme/**/*']
    },

    clean: ['<%= pkg.theme %>/<%= pkg.jsloc %>/app.min.js', '<%= pkg.theme %>/<%= pkg.cssloc %>/app.min.css'],

    // Watches all less, js files; runs the tasks.
    watch: {
      scripts: {
        files: ["<%= pkg.theme %>/<%= pkg.lessloc %>/**/*", "<%= pkg.theme %>/<%= pkg.jsloc %>/**/*"],
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
  grunt.loadNpmTasks('grunt-ftp-push');

  grunt.registerTask('migrate', ['copy', 'regex-replace']);
  grunt.registerTask('replaceit', ['regex-replace']);
  grunt.registerTask('default', ['clean', 'less', 'jshint', 'uglify']);

};