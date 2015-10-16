var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-minify-css');

gulp.task('less', function () {
  return gulp.src('less/style.less')
    .pipe(less())
    .pipe(minifyCSS())
    .pipe(gulp.dest('css/'));
});

gulp.task('watch', function () {
    gulp.watch('less/*.less', ['less']);
});

gulp.task('default', ['watch']);;
