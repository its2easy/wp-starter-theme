const root = '../';

module.exports = {
    root: root,

    scssEntryPoint: `${root}src/scss/app.scss`,
    jsEntryPoint: `${root}src/js/index.js`,

    resultFolder: `${root}assets`,

    watchPhp: `**/*.php`,
    watchJs: `assets/js/**/*.js`,
    watchCss: `assets/css/**/*.css`,
    watchCssSrc: `src/scss/**/*.scss`,

    proxy: 'wp-starter-theme.local',
    port: 3000,
}