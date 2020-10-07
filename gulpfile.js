'use strict';
const plugins = require('gulp-load-plugins'),
    yargs = require('yargs'),
    browser = require('browser-sync'),
    gulp = require('gulp'),
    del = require('del'),
    notify = require('gulp-notify'),//errors handling (mb platform specific)
    plumber = require('gulp-plumber'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano');//errors handling

// Load all Gulp plugins into one variable
const $ = plugins();

// Check for --production flag
const PRODUCTION = !!(yargs.argv.production);

const PATHS = {
    delete_dist_options: [
        "assets/css",
    ],
    watch_styles: "src/assets/scss/**/*.scss",
    javascript: [
        "src/assets/js/**/*",
    ],
    views: [
        "**/*.php",
    ]
};

// Build the "dist" folder by running all of the below tasks
gulp.task('build',
    gulp.series(clean, gulp.parallel(gulp.series(gulp.parallel(sass)), copyCss))
);

// Build the site, run the server, and watch for file changes
gulp.task('default',
    gulp.series('build', server, watch)
);

// Delete the "assets/css" and "assets/js" folders
function clean(done) {
    del(PATHS.delete_dist_options)
        .then(function () {
            done();
        })
}

//copy css without build
function copyCss() {
    return gulp.src('src/assets/css/**/*')
        .pipe(gulp.dest('assets/css'));
}

// Compile Sass into CSS
// In production, the CSS is compressed
function sass() {
    return gulp.src('src/assets/scss/app.scss')
        .pipe(plumber({
            errorHandler: notify.onError(err => ({
                title: 'SCSS ERROR!',
                message: err.message
            }))
        }))
        .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
        .pipe($.sass({})
            .on('error', $.sass.logError))
        // .pipe($.if(PRODUCTION, $.autoprefixer() ))
        // .pipe($.if(PRODUCTION, $.cssnano({
        //     safe: true
        // })))
        .pipe($.if(PRODUCTION, postcss(
            [
                autoprefixer(),
                cssnano()
            ]
        )))
        .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
        .pipe(gulp.dest('assets/css'))
}

// Combine JavaScript into one file
// function javascript() {
//   // return gulp.src(PATHS.javascript)
//   //   .pipe(plumber({
//   //     errorHandler: notify.onError(err => ({
//   //       title: 'JS ERROR!',
//   //       message: err.message
//   //     }))
//   //   }))
//   //   .pipe($.sourcemaps.init())
//   //   .pipe($.concat('app.js'))
//   //   .pipe($.if(PRODUCTION, $.uglify()
//   //     .on('error', e => { console.log(e); })
//   //   ))
//   //   .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
//   //   .pipe(gulp.dest(PATHS.dist + '/assets/js'));
//
//     //for easier changes, just copy all files from src/js to dist/js
//     // return gulp.src( PATHS.javascript )
//     //     .pipe(newer('assets/js'))//filter existent files
//     //     .pipe(gulp.dest('assets/js'));
// }


// Start a server with BrowserSync to preview the site in
function server(done) {
    browser.init({
        proxy: "wp-starter-theme.local/",
    });
    done();
}

// Reload the browser with BrowserSync
function reload(done) {
    browser.reload();
    done();
}

// Watch for changes to static assets, pages, Sass, and JavaScript
function watch(done) {
    gulp.watch(PATHS.views).on('all', gulp.series(reload));//html
    gulp.watch('src/assets/css/**/*', gulp.series(copyCss, reload));//css without build
    gulp.watch(PATHS.watch_styles).on('all', gulp.series(sass, reload));//scss
    gulp.watch('assets/js/**/*.js').on('all', gulp.series(reload));//js
    done();
}




