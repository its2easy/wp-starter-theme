'use strict';
import yargs from 'yargs';
import  { default as browserSync }  from  'browser-sync' ;
import gulp  from 'gulp';
import gulpif  from  'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import gulpSass from 'gulp-sass';
import dartSass from 'sass';
import postcss from  'gulp-postcss';
import autoprefixer  from 'autoprefixer';
import cssnano  from 'cssnano';
import packageImporter  from 'node-sass-package-importer';
import beeper from 'beeper'; // v3 doesn't work without type: module
import rename from "gulp-rename";
import del from "del";

import config from './config.js';
const sassPlugin = gulpSass( dartSass );
const argv = yargs(process.argv.slice(2)).argv;
const PRODUCTION = !!(argv.production);

// Delete the "dist" folder
// This happens every time a build starts
function clean(done) {
    del(`${config.resultFolder}/**/*`, {
        force: true, // dist is outside of cwd (config folder)
        //dryRun: true,
    })
        .then(function(){
            done();
        })
}

//================ CSS
function sass() {
    return gulp.src(config.scssEntryPoint)
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sassPlugin.sync({
            importer: packageImporter()
        }).on('error', sassPlugin.logError))
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
    // js from src is not compiled, so only assets/js/app.js watched
    gulp.watch([`${config.root}${config.watchStaticJs}`, '!**/*.js.map'], reload);
    gulp.watch(`${config.root}${config.watchCssSrc}`, sass);
}

//Public tasks
const build = gulp.series(clean, sass);


// exports.build = build;
// exports.default = gulp.series(build, server, watch);
export default  gulp.series(build, server, watch);
export { build };
