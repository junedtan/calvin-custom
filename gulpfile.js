var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var minify = require('gulp-minify');

var proxyServer = 'foundation6.localhost';

var sassPaths = [
  'node_modules/foundation-sites/scss',
  'node_modules/motion-ui/src'
];

var concatScripts = [
  {
    'scripts': [
      'node_modules/what-input/dist/what-input.js',
      'node_modules/motion-ui/dist/motion-ui.js',
      'node_modules/foundation-sites/dist/js/foundation.js',
      'assets/src/js/modernizr-custom.js',
      'assets/src/js/main.js'
    ],
    'output': 'global.js'
  },
  {
    'scripts': [
      'assets/src/js/page-about.js',
      'assets/src/js/page-home.js'
    ],
    'output': 'pages.js'
  }
];

gulp.task('scripts', function () {
  gulp.src('assets/src/js/*.js')
    .pipe(sourcemaps.init())
    .pipe(minify({
      ext:{
          src:'',
          min:'.min.js'
      },
      noSource: true })
    )
    .on('error', function(error) {
      console.log(error.message);
    })
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('assets/js'));
});

gulp.task('scripts-concat', function() {
  concatScripts.forEach((section) => {
    gulp.src(section['scripts'])
    .pipe(sourcemaps.init())
    .pipe(concat(section['output']))
    .pipe(minify({
      ext:{
          src:'',
          min:'.min.js'
      },
      noSource: true })
    )
    .on('error', function(error) {
      console.log(error.message);
    })
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('assets/js'));
  });
});

gulp.task('sass', function () {
  gulp.src('assets/src/scss/app.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: sassPaths,
      outputStyle: 'compressed',
    }).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('assets/css'));
  gulp.src('assets/src/scss/editor.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: sassPaths,
      outputStyle: 'compressed',
    }).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('assets/css'));
});

gulp.task('browser-sync', function() {
  var files = [
    'assets/css/app.css',
    '*/**/*.php',
    '*/*.php',
    '*.php'
  ];
  browserSync.init(files, {
    proxy: proxyServer,
    notify: true
  });
});

gulp.task('default', ['sass', 'scripts'], function() {
  gulp.watch(['assets/src/**/*.scss'], ['sass']);
  gulp.watch(['assets/src/**/*.js'], ['scripts']);
});

gulp.task('watch', ['sass', 'scripts'], function() {
  gulp.watch(['assets/src/**/*.scss'], ['sass']);
  gulp.watch(['assets/src/**/*.js'], ['scripts']);
});

gulp.task('browser', ['sass', 'scripts', 'browser-sync'], function() {
  gulp.watch(['assets/src/**/*.scss'], ['sass']);
  gulp.watch(['assets/src/**/*.js'], ['scripts']);
});

gulp.task('browser-scripts-concat', ['sass', 'scripts-concat', 'browser-sync'], function() {
  gulp.watch(['assets/src/**/*.scss'], ['sass']);
  gulp.watch(['assets/src/**/*.js'], ['scripts-concat']);
});
