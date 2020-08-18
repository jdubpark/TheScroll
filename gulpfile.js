'use strict';
// https://github.com/sindresorhus/del/issues/45

const
  fs = require('fs'),
  path = require('path'),
  gulp = require('gulp'),
  browserSync = require('browser-sync').create(),
  debug = require('gulp-debug'),
  newer = require('gulp-newer'),
  sass = require('gulp-sass'),
  tap = require('gulp-tap'),
  rename = require('gulp-rename'),
  concat = require('gulp-concat'),
  sourcemaps = require('gulp-sourcemaps'),
  config = {};

sass.compiler = require('node-sass');

config.sass = {
  root: './theme/main/assets/style/',
  dist: './theme/main/assets/style/dist/',
  watch: [
    // ignore sass in root and compile only non-dist folders
    '!./theme/main/assets/style/*.sass',
    './theme/main/assets/style/**/*.sass',
    '!./theme/main/assets/style/dist/',
    // ignore files/folders with prefix _
    '!./theme/main/assets/style/_*/**/*',
    '!./theme/main/assets/style/**/_*',
  ],
};

function getFolders(dir, exclPre = ['.'], exclName = []){
  // ignore folders with prefix $excl
  return fs.readdirSync(dir, {withFileTypes: true})
    .filter(dirent => dirent.isDirectory()
      && exclPre.indexOf(dirent.name[0]) == -1
      && exclName.indexOf(dirent.name) == -1)
    .map(dirent => dirent.name);
}

// https://github.com/gulpjs/gulp/blob/v3.9.1/docs/recipes/running-task-steps-per-folder.md

function sassWatch(){
  return gulp.watch(config.sass.watch, sassBundle);
}

function sassBundle(){
  // exclude folders . _ dist
  const folders = getFolders(config.sass.root, ['.', '_'], ['dist']);
  const tasks = folders.map(folder => {
    const
      curPath = path.join(config.sass.root, folder),
      distFileName = path.basename(curPath)+'.sass';
    return new Promise((resolve, reject) => {
      try {
        gulp.src([
          path.join(curPath, '/**/*.sass'),
          // ignore files with prefix _
          '!'+path.join(curPath, '/**/_*'),
          // ignore name file (e.g. header.sass in header/)
          '!'+path.join(curPath, distFileName),
        ])
          .pipe(debug())
          // https://www.npmjs.com/package/gulp-newer#using-newer-with-many1-sourcedest-mappings
          .pipe(newer(`${config.sass.dist}/${distFileName}`))
          .pipe(concat(distFileName))
          .pipe(gulp.dest(curPath))
          // compile into the dist folder with source map
          .pipe(sourcemaps.init())
          .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
          .pipe(rename({suffix: '.min'}))
          .pipe(sourcemaps.write('./map'))
          .pipe(gulp.dest(config.sass.dist))
          .on('end', resolve);
      } catch (err){
        console.log(err);
        reject(err);
      }
    });
  });

  return Promise.all(tasks).then();

  // process all remaining files in config.sass.root root into main.js and main.min.js files
  // const root = gulp.src(path.join(config.sass.root, '/*.js'))
  //   .pipe(concat('main.js'))
  //   .pipe(gulp.dest(config.sass.root))
  //   .pipe(uglify())
  //   .pipe(rename('main.min.js'))
  //   .pipe(gulp.dest(config.sass.root));
  //
  // return merge(tasks, root);

  /*
  return gulp.src(config.sass.watch)
    .pipe(debug())
    .pipe(sourcemaps.init())
    // concat into the same folder
    .pipe(concat('_all.sass'))
    // allows using folder name of currently processed file
    // .pipe(tap((file, t) => file.path))
    .pipe(gulp.dest(config.sass.root))
    // compile into the dist folder with source map
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(rename(file => {
      // current parent directory name (e.g. headers.min.css)
      file.basename = path.dirname(file.dirname);
      file.suffix = '.min';
    }))
    .pipe(sourcemaps.write(config.sass.dist))
    .pipe(gulp.dest(config.sass.dist));
  */
}

function bsWatch(){
  browserSync.init({
    proxy: 'http://localhost/',
    files: [
      'public/**/*.*', 'theme/main/*.*',
      'theme/main/**/*.*', '!**/src/*.*', '!**/src/**/*.*',
    ],
    port: 3000,
    open: false,
  });
}

// if (process.env.NODE_ENV === 'production'){
//   exports.build = series(transpile, minify);
// } else {
//   exports.build = series(transpile, livereload);
// }
exports.style = sassBundle;
exports.watch = gulp.parallel(bsWatch, sassWatch);
