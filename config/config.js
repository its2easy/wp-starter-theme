const root = '../'; // root of the project

const config = {
    root: root,

    scssEntryPoint: `${root}src/scss/app.scss`,
    jsEntryPoint: `${root}src/js/index.js`,

    resultFolder: `${root}dist`,

    watchPhp: `**/*.php`,
    watchJs: `dist/js/**/*.js`,
    watchStaticJs: `assets/js/**/*.js`,
    watchCss: `dist/css/**/*.css`,
    watchCssSrc: `src/scss/**/*.scss`,

    proxy: 'wp-starter-theme.local',
    port: 3000,
}
//module.exports = config;
export default config;

