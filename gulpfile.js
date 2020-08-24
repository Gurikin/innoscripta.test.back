var gulp = require('gulp');
var bs = require('browser-sync');
var concatCss = require('gulp-concat-css');
var less = require('gulp-less');
var minifyCSS = require('gulp-minify-css');

gulp.task('server', function () {
    bs.init({
        server: {
            baseDir: "./public/"
        }
    });
    gulp.watch('./public/less/*.less' , gulp.series('less'));
    gulp.watch('./public/*.js').on('change', bs.reload);
});

gulp.task('less', function () {
    return gulp.src('./public/less/*.less')
        .pipe(less())
        .pipe(concatCss('style.css'))
        // .pipe(minifyCSS('style.css'))
        .pipe(gulp.dest('./public/css/'))
        .pipe(bs.stream())
});

