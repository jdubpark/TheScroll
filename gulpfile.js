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

// sass.compiler = require('node-sass');
sass.compiler = require('dart-sass'); // dart supports @use

config.sass = {
  root: 'theme/main/assets/style/',
  dist: 'theme/main/assets/style/dist/',
  watch: [
    // ignore sass in root and compile only non-dist folders
    'theme/main/assets/style/**/*.sass',
    '!theme/main/assets/style/*.sass',
    // don't watch some sub/folders
    '!theme/main/assets/style/dist/**/*',
    '!theme/main/assets/style/bulma/**/*',
    // some exceptions after the above
    'theme/main/assets/style/bulma/*.sass',
    // ignore files/folders with prefix _
    '!theme/main/assets/style/_*/**/*',
    '!theme/main/assets/style/**/_*',
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
  // return gulp.watch(config.sass.watch, sassBundle);

  const folders = getFolders(config.sass.root, ['.', '_'], ['dist']);
  const foldersAbs = folders.map(folder => path.join(config.sass.root, folder));
  return gulp.watch(config.sass.watch, () => {
    return gulp.src('theme/main/assets/style/dascroll.sass')
      .pipe(debug())
      .pipe(sourcemaps.init())
      .pipe(sass({
        outputStyle: 'compressed',
        includePaths: foldersAbs, // for relative @import
      }).on('error', sass.logError))
      .pipe(rename({suffix: '.min'}))
      .pipe(sourcemaps.write('./map'))
      .pipe(gulp.dest(config.sass.dist));
  });
}

function sassBundle(){
  // return gulp.src(config.sass.watch)
  //   .pipe(debug())
  //   .pipe(newer(`${config.sass.root}/dascroll.sass`))
  //   .pipe(concat('dascroll.sass'))
  //   .pipe(gulp.dest(config.sass.root))
  //   .pipe(sourcemaps.init())
  //   .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  //   .pipe(rename({suffix: '.min'}))
  //   .pipe(sourcemaps.write('./map'))
  //   .pipe(gulp.dest(config.sass.dist));

  const folders = getFolders(config.sass.root, ['.', '_'], ['dist']);
  const foldersAbs = folders.map(folder => path.join(config.sass.root, folder));

  // const tasks = folders.map(folder => {
  //   const curPath = path.join(config.sass.root, folder);
  //     // distFileName = '_'+path.basename(curPath)+'.sass';
  //   return new Promise((resolve, reject) => {
  //     try {
  //       gulp.src([
  //         path.join(curPath, '/**/*.sass'),
  //         // ignore files with prefix _
  //         '!'+path.join(curPath, '/**/_*'),
  //         // ignore name file (e.g. header.sass in header/)
  //         '!'+path.join(curPath, '_all.sass'),
  //       ])
  //         // .pipe(debug())
  //         // https://www.npmjs.com/package/gulp-newer#using-newer-with-many1-sourcedest-mappings
  //         .pipe(concat('_all.sass'))
  //         .pipe(gulp.dest(curPath))
  //         .on('end', resolve);
  //     } catch (err){
  //       console.log(err);
  //       reject(err);
  //     }
  //   });
  // });
  // return Promise.all(tasks);

  // watch alls only watch top-folder _all.sass (not ones in subfolder)
  // so @import (@use not supported yet) what's needed on top _all.sass of each folder
  const watchAlls = folders.map(folder => path.join(config.sass.root, folder, '_all.sass')).filter(Boolean);
  return gulp.src(watchAlls)
    .pipe(debug())
    .pipe(sourcemaps.init())
    .pipe(newer(`${config.sass.dist}/dascroll.sass`))
    .pipe(concat('dascroll.sass'))
    // compile into the dist folder with source map
    .pipe(sass({
      outputStyle: 'compressed',
      includePaths: foldersAbs, // for relative @import
    }).on('error', sass.logError))
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('./map'))
    .pipe(gulp.dest(config.sass.dist));

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
      './theme/main/*.php',
      './theme/main/**/*.php',
      // '!./theme/main/assets/style/**/*',
      // '!./theme/main/assets/js/**/*',
      './theme/main/assets/svg/*',
      './theme/main/assets/images/*',
      './theme/main/assets/style/dist/*',
      './theme/main/assets/js/dist/*',
      '!./**/src/*',
      '!./**/src/**/*',
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
