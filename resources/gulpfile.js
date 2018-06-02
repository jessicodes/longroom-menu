var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require("gulp-notify");
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');

var autoprefixerOptions = {
  browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};

gulp.task('styles', function () {
  gulp.src('./scss/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'})).on('error', notify.onError(function (error) {
    return "Problem file : " + error.message;
  }))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./css'))
    .pipe(notify({
      onLast: true,
      message: 'CSS Compiled'
    }));
});

//Watch task
gulp.task('default', function () {
  var watcher = gulp.watch('./scss/**/*.scss', ['styles'])
  watcher.on('change', function (event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
  });
});