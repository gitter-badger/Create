pkg             = require "./package.json"
gulp            = require "gulp"
del             = require "del"
ftp             = require "gulp-ftp"
less            = require "gulp-less"
bower           = require "gulp-bower"
watch           = require 'gulp-watch'
concat          = require "gulp-concat"
uglify          = require "gulp-uglify"
replace         = require "gulp-replace"
changed         = require "gulp-changed"
sourcemaps      = require "gulp-sourcemaps"
runSequence     = require "run-sequence"

# bootstrapLess = "#{pkg.theme.name}#{pkg.theme.less}bootstrap"
# bootstrapJs   = "#{pkg.theme.name}#{pkg.theme.js}bootstrap"
# bootstrapFont = "#{pkg.theme.name}#{pkg.theme.fonts}bootstrap"
#
# fontawesomeLess = "#{pkg.theme.name}#{pkg.theme.less}fontawesome"
# fontawesomeFont = "#{pkg.theme.name}#{pkg.theme.fonts}fontawesome"
#
# lessDir = "#{pkg.theme.name}#{pkg.theme.less}"
# fontDir = "#{pkg.theme.name}#{pkg.theme.fonts}"
# cssDir = "#{pkg.theme.name}#{pkg.theme.css}"
# jsDir = "#{pkg.theme.name}#{pkg.theme.js}"

gulp.task "bower", ->
  bower()

# Copies all bower component files to assets dir.
gulp.task "copy", ["bower"], ->
  gulp.src "./components/bootstrap/less/**/*.less"
    .pipe gulp.dest('./theme/assets/less/bootstrap/')
  gulp.src "./components/bootstrap/js/**/*.js"
    .pipe gulp.dest('./theme/assets/js/bootstrap/')
  gulp.src "./components/bootstrap/fonts/**"
    .pipe gulp.dest('./theme/assets/fonts/bootstrap/')
  gulp.src "./components/font-awesome/less/*.less"
    .pipe gulp.dest('./theme/assets/less/fontawesome/')
  gulp.src "./components/font-awesome/fonts/**"
    .pipe gulp.dest('./theme/assets/fonts/fontawesome/')
  gulp.src "./components/modernizr/modernizr.js"
    .pipe gulp.dest('./theme/assets/js/modernizr/')
  gulp.src "./components/respond/src/respond.js"
    .pipe gulp.dest('./theme/assets/js/respond/')

gulp.task 'replace', ->
  gulp.src ['./theme/assets/less/bootstrap/variables.less']
    .pipe replace('../fonts/', '../bootstrap/fonts/')
    .pipe gulp.dest('./theme/assets/less/bootstrap/')

  gulp.src ['./theme/assets/less/fontawesome/variables.less']
    .pipe replace('../fonts', '../fontawesome/fonts/')
    .pipe gulp.dest('./theme/assets/less/fontawesome/')

gulp.task "reset", (cb) ->
  del [
    "./theme/assets/less/bootstrap/"
    "./theme/assets/less/fontawesome/"
    "./theme/assets/js/bootstrap/"
    "./theme/assets/js/respond/"
    "./theme/assets/js/modernizr/"
    "./theme/assets/fonts/bootstrap/"
    "./theme/assets/fonts/fontawesome/"
  ], cb
  return


gulp.task 'sync', ->
  gulp.src './theme/**/**'
    .pipe changed('./theme/**/**')
    .pipe ftp(
      host: pkg.ftp.host
      user: pkg.ftp.user
      pass: pkg.ftp.pass
      remotePath: pkg.ftp.path
    )

gulp.task 'deploy', ->
  gulp.src './theme/**/**'
    .pipe ftp(
      host: pkg.ftp.host
      user: pkg.ftp.user
      pass: pkg.ftp.pass
      remotePath: pkg.ftp.path
    )

gulp.task 'less', ->
  gulp.src ['./theme/assets/less/app.less', './theme/assets/less/admin.less']
    .pipe sourcemaps.init()
    .pipe less()
    .pipe gulp.dest('./theme/assets/css')

gulp.task 'watch', ->
  gulp.watch('./theme/assets/less/**/*.less', ['less'])

gulp.task 'comp', ['bower', 'copy']
gulp.task 'default', ['watch']