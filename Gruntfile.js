module.exports = function(grunt) {

  var themeName = "theme";

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Compiles the LESS files into app.min.css
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

    // Concatenates js files into one.
    // Not used for now...
    concat: {
      options: {
        separator: ';',
      },
      app: {
        src: ['!theme/assets/js/app.js', '!theme/assets/js/**/*.min.js', 'theme/assets/js/**/*.js'],
        dest: 'theme/assets/js/app.js'
      }
    },

    uglify: {
      my_target: {
        files: {
          'theme/assets/js/app.min.js': ['theme/assets/js/bootstrap*/*.js', 'theme/assets/js/modernizr*/*.js', 'theme/assets/js/theme/**/*']
        }
      }
    },

    // Just testing stuff out...
    ftp_push: {
      my_target: {
        options: {
          username: "",
          password: "",
          host: "ftp.bldsvr.com",
          dest: "/josh/"
        }
      }
    },

    /// FUCK... JSHINT...
    jshint: {
      options: {
        reporter: require('jshint-stylish'),
        globals: {
          jQuery: true
        },
      },
      all: ['Gruntfile.js', 'theme/assets/js/theme/**/*']
    },

    // Cleans all the files so they can be recreated. This is to make sure
    // that the file is clearly being created and compiled.
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
  grunt.loadNpmTasks('grunt-ftp-push');

  grunt.registerTask('default', ['clean', 'less', 'jshint', 'uglify']);

};