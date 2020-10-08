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

// Check for --production flag
const PRODUCTION = !!(yargs.argv.production);

const PATHS = {
        scss_main_file: 'src/assets/scss/app.scss',
        watch_styles: "src/assets/scss/**/*.scss",
        result_styles: "assets",
    },
    OPTIONS = {
        port: 3000,
        proxy: 'wp-starter-theme.local'
    };

//================ CSS
function sass() {
    return gulp.src(PATHS.scss_main_file)
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
        .pipe(gulp.dest(PATHS.result_styles))
        .pipe(browserSync.stream());
}

// Start a server with BrowserSync
function server(done) {
    browserSync.init(
        {
            proxy: OPTIONS.proxy,
            port: OPTIONS.port,
        }, done);
}
// Reload the browser with BrowserSync
function reload(done) {
    browserSync.reload();
    done();
}

//================
function watch() {
    gulp.watch(['**/*.php', '!node_modules/**'], reload);
    gulp.watch('src/js/**/*.js', reload);
    gulp.watch(PATHS.watch_styles, sass);
}

//Public tasks
const build = gulp.series(sass);
exports.build = build;
exports.default = gulp.series(build, server, watch);