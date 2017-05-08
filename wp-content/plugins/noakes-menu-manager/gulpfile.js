/*!
 * Gulp asset automation script.
 * 
 * @since 1.4.0 Added sourcemaps and removed gulp-cache from image processing.
 * @since 1.3.0
 * 
 * @package Nav Menu Manager
 */

const del = require('del');
const cssnano = require('gulp-cssnano');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const jshint = require('gulp-jshint');
const run_sequence  = require('run-sequence');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');

gulp.task('default', ['clean'], function (callback)
{
	run_sequence('styles', 'scripts', 'images', callback);
});

gulp.task('clean', function ()
{
	return del(['./assets/styles', './dist/styles', './dist/scripts', './dist/images']);
});

gulp.task('styles', function ()
{
	return gulp.src('./assets/sass/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass(
		{
			'outputStyle': 'expanded'
		}))
		.pipe(gulp.dest('./assets/styles'))
		.pipe(cssnano(
		{
			'safe': true
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./dist/styles'));
});

gulp.task('scripts', function ()
{
	return gulp.src('./assets/scripts/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'))
		.pipe(sourcemaps.init())
		.pipe(uglify(
		{
			'preserveComments': 'license'
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./dist/scripts'));
});

gulp.task('images', function ()
{
	return gulp.src('./assets/images/*')
		.pipe(imagemin(
		{
			'optimizationLevel': 3,
			'progressive': true,
			'interlaced': true
		}))
		.pipe(gulp.dest('./dist/images'));
});
