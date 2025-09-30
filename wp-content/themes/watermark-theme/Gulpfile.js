/* eslint-disable */

// Require our dependencies
const { src, dest, watch, series, parallel } = require('gulp');
const autoprefixer = require('autoprefixer');
const babel = require('gulp-babel');
const beeper = require('beeper');
const cssnano = require('cssnano');
const del = require('del');
const gulp = require('gulp');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const purgecss = require('gulp-purgecss');
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const svgSymbols = require('gulp-svg-symbols');
const uglify = require('gulp-uglify');

// Set assets paths.
const paths = {
	css: ['./*.css', '!*.min.css'],
	images: ['assets/images/*', '!assets/images/*.svg'],
	sass: 'assets/sass/**/*.scss',
	concat_scripts: 'assets/scripts/concat/*.js',
	scripts: ['assets/scripts/*.js', '!assets/scripts/*.min.js']
};

/**
 * Handle errors and alert the user.
 */
function handleErrors() {
	const args = Array.prototype.slice.call(arguments);

	notify
		.onError({
			title: 'Task Failed [<%= error.message %>',
			message: 'See console.',
			sound: 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
		})
		.apply(this, args);

	beeper(); // Beep 'sosumi' again.

	// Prevent the 'watch' task from stopping.
	this.emit('end');
}

/**
 * Delete style.css and style.min.css before we minify and optimize
 */
function cleanStyles() {
	return del(['style.css', 'style.min.css']);
}

/**
 * Compile Sass and run stylesheet through PostCSS.
 *
 * https://www.npmjs.com/package/gulp-sass
 * https://www.npmjs.com/package/gulp-postcss
 * https://www.npmjs.com/package/autoprefixer
 */
function scss() {
	return (
		src('assets/sass/*.scss')
			// Deal with errors
			.pipe(
				plumber({
					errorHandler: handleErrors
				})
			)
			// Wrap tasks in a sourcemap
			.pipe(sourcemaps.init())

			// Compile Sass
			.pipe(
				sass({
					errLogToConsole: true,
					outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
				})
			)

			// Parse with PostCSS plugins
			.pipe(postcss([autoprefixer()]))

			// Create sourcemap.
			.pipe(sourcemaps.write())

			// Create style.css.
			.pipe(dest('./'))
	);
}

/**
 * Minify and optimize style.css.
 *
 * https://www.npmjs.com/package/cssnano
 */
function minifyStyles() {
	return src('style.css')
		.pipe(
			plumber({
				errorHandler: handleErrors
			})
		)
		.pipe(
			postcss([
				cssnano({
					safe: true // Use safe optimizations
				})
			])
		)
		.pipe(rename('style.min.css'))
		.pipe(dest('./'));
}

// TODO: update with correct paths for WP files
// TODO: add whitelist for WP default styles
function purgeStyles() {
	return src('style.css')
		.pipe(
			purgecss({
				content: ['*.html']
			})
		)
		.pipe(dest('./'));
}

function svgIcons() {
	return src('assets/svg-icons/*.svg')
		.pipe(
			svgSymbols({
				id: '%f',
				templates: ['default-svg'],
				title: '%f',
				slug: function (name) {
					return name.toLowerCase().trim().replace(/\s/g, '-');
				}
			})
		)
		.pipe(dest('assets/images'));
}

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
function jsMin() {
	return src(paths.scripts)
		.pipe(
			plumber({
				errorHandler: handleErrors
			})
		)
		.pipe(
			rename({
				suffix: '.min'
			})
		)
		.pipe(
			babel({
				presets: [
					[
						'env',
						{
							targets: {
								browsers: ['last 2 versions']
							}
						}
					]
				]
			})
		)
		.pipe(
			uglify({
				mangle: false
			})
		)
		.pipe(dest('assets/scripts'));
}

/**
 * Process tasks and watch for file changes file changes.
 *
 */
function watchFiles() {
	watch(paths.sass, scss);
}

/**
 * Create individual tasks.
 */
exports.css = series(cleanStyles, scss, minifyStyles);
exports.icons = svgIcons;
exports.js = jsMin;
exports.build = series(cleanStyles, scss, purgeStyles, minifyStyles, jsMin);
exports.default = series(
	parallel(exports.css, exports.icons, exports.js),
	watchFiles
);
