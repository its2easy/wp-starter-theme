const path = require('path');
const miniCss = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");

const config = {
    entry: {
        main: path.join(__dirname, "./src/js/index.js"),
        style: path.join(__dirname, "./src/assets/scss/app.scss"),
    },
    output: {
        path: path.resolve(__dirname, './assets'),
        filename: 'js/[name].js',
    },
    externals: {
        jquery: 'jQuery'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                }
            },
        ]
    },
    plugins: [
        new FixStyleOnlyEntriesPlugin(),// Remove redundant js files from css entries
        new miniCss({
            filename: './css/[name].css',
        }),
    ],
};
module.exports = config;