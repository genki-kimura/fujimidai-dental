const { src, dest, watch, series, parallel } = require('gulp');
/* sass */
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob-use-forward');
const plumber = require("gulp-plumber");
const notify = require("gulp-notify");
const postcss = require("gulp-postcss");
const cssnext = require("postcss-cssnext")
const cleanCSS = require("gulp-clean-css");
const sourcemaps = require("gulp-sourcemaps");
const browsers = [
    'last 2 versions',
    '> 5%',
    'ie = 11',
    'not ie <= 10',
    'ios >= 8',
    'and_chr >= 5',
    'Android >= 5',
]
/* browser-sync */
const browserSync = require('browser-sync');
/* imagemin */
const imagemin = require('gulp-imagemin');
const imageminPngquant = require('imagemin-pngquant');
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminOption = [
  imageminPngquant({ quality: [0.65, 0.8] }),
  imageminMozjpeg({ quality: 85 }),
  imagemin.gifsicle({
    interlaced: false,
    optimizationLevel: 1,
    colors: 256,
  }),
  imagemin.mozjpeg(),
  imagemin.optipng(),
  imagemin.svgo(),
];

// sass
// 読み込み先（階層が間違えていると動かないので注意）
const srcPath = {
  css: 'scss/**/*.scss',
}

// 吐き出し先（なければ生成される）
const destPath = {
  css: 'css/',
}
const cssSass = () => {
  return src(srcPath.css)
      .pipe(sourcemaps.init())
      .pipe(
          plumber({
              errorHandler: notify.onError('Error:<%= error.message %>')
          }))
      .pipe(sassGlob())
      .pipe(sass.sync({
          includePaths: ['src/sass'],
          outputStyle: 'expanded'
      }))
      .pipe(postcss([cssnext(browsers)]))
      .pipe(sourcemaps.write('./'))
      .pipe(dest(destPath.css))
      .pipe(notify({
          message: 'コンパイル出来たよ！',//文字は好きなものに変更してね！
          onLast: true
      }))
}

// watchFile
const watchFiles = (done) => {
  watch('./*.php', browserReload);
  watch('./scss/**/*.scss', series(cssSass, browserReload));
  watch('./scss/*.scss', series(cssSass, browserReload));
  watch('./js/*.js', browserReload);
  done();
};

// buildServer
const buildServer = (done) => {
  browserSync.init({
    proxy: "http://localhost:8888/", //URLなど
    /*
    server: {
      baseDir: './',
      index: 'index.html',
    },
    */
  });
  done();
};

// browserReload
const browserReload = (done) => {
  browserSync.reload();
  done();
};

// imageMin
const imageMin = (done) => {
  src('./img/**/*').pipe(imagemin(imageminOption)).pipe(dest('./img'));
  done();
};

exports.imagemin = imageMin;
exports.default = series(parallel(cssSass , buildServer, watchFiles));