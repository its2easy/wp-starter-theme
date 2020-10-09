'use strict';
const yargs = require('yargs'),
    browserSync = require('browser-sync').create(),
    gulp = require('gulp'),
    gulpif = require('gulp-if'),
    sourcemaps = require('gulp-sourcemaps'),
    gulpSass = require('gulp-sass'),
    postcss    = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    packageImporter = require('node-sass-package-importer'),
    beeper = require('beeper'),
    rename = require("gulp-rename");
const config = require('./config');

// Check for --production flag
const PRODUCTION = !!(yargs.argv.production);

//================ CSS
function sass() {
    return gulp.src(config.scssEntryPoint)
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(gulpSass({
            importer: packageImporter()
        }).on('error', gulpSass.logError))
        .on('error', (err) => {
            beeper(1);
        })
        .on('data', () => { // fix missing browsersync update notifications
            browserSync.notify("Styles updated", 2000);
        })
        .pipe(gulpif(PRODUCTION, postcss(
            [
                autoprefixer(),
                cssnano()
            ]
        )))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(rename("css/style.css"))
        .pipe(gulp.dest(config.resultFolder))
        .pipe(browserSync.stream());
}

// Start a server with BrowserSync
function server(done) {
    browserSync.init(
        {
            proxy: config.proxy,
            port: config.port,
        }, done);
}
// Reload the browser with BrowserSync
function reload(done) {
    browserSync.reload();
    done();
}

//================
function watch() {
    //paths relative to config folder
    gulp.watch([`${config.root}${config.watchPhp}`, '!node_modules/**'], reload);
    gulp.watch([`${config.root}${config.watchJs}`, '!**/*.js.map'], reload);
    gulp.watch(`${config.root}${config.watchCssSrc}`, sass);
}

//Public tasks
const build = gulp.series(sass);
exports.build = build;
exports.default = gulp.series(build, server, watch);