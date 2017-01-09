/*jslint indent: 2 */
'use strict';

var gulp = require('gulp'),
  autoprefixer = require('gulp-autoprefixer'),
  browserSync = require('browser-sync'),
  filter = require('gulp-filter'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  prettify = require('gulp-html-prettify'),
  data = require('gulp-data'),
  path = require('path'),
  reload = browserSync.reload,
  scsslint = require('gulp-scss-lint'),
  jshint = require('gulp-jshint'),
  src = {
    scss: '../scss/**/*.scss',
    css: '../css',
    javascript: '../js/*.js'
  };

// Task for local, static development.
gulp.task('local-development', ['sass-dev'], function () {
  gulp.watch(src.scss, ['sass-dev']);
  gulp.watch(src.javascript);
});


// Task for compiling sass in development mode with all features enabled.
gulp.task('sass-dev', function () {
  gulp.src('../scss/{,*/}*.{scss,sass}')
    .pipe(sourcemaps.init())
    .pipe(sass({
      errLogToConsole: true
    }))
    .on('error', function (err) {
      console.error('Error!', err.message);
    })
    .pipe(autoprefixer({browsers: ['safari >= 8', 'last 3 versions', '> 2%']}))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(src.css))
    .pipe(filter("**/*.css"))
    .pipe(reload({
      stream: true
    }));
});

// Task for compiling sass in production mode. No sourcemaps.
gulp.task('sass-prod', function () {
  gulp.src('../scss/{,*/}*.{scss,sass}')
    .pipe(sass({
      errLogToConsole: true
    }))
    .on('error', function (err) {
      console.error('Error!', err.message);
    })
    .pipe(autoprefixer({browsers: ['safari >= 8', 'last 3 versions', '> 2%']}))
    .pipe(gulp.dest(src.css))
    .pipe(filter("**/*.css"))
    .pipe(reload({
      stream: true
    }));
});

/**
 * Uncache data.
 */
function requireUncached( $module ) {
  delete require.cache[require.resolve( $module )];
  return require( $module );
}

// SCSS Lint
gulp.task('scss-lint', function () {
  return gulp.src(src.scss)
    .pipe(
      scsslint({
        'config': 'scss-lint.yml',
      })
    );
});

// Javascript Lint
gulp.task('js-lint', function () {
  return gulp.src(src.javascript)
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});


// Gulp Task for development mode.
// SASS compile, template generation, SCSS/JS linter
gulp.task('dev', ['sass-dev'], function () {
  gulp.watch(src.scss, ['sass-dev', 'scss-lint']);
  gulp.watch(src.javascript, ['js-lint']);
});

// Default task.
gulp.task('default', ['local-development']);
