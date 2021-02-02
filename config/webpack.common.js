const path = require('path');
const miniCss = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const config = require('./config');

const webpackConfig = {
    entry: {
        main: path.join(__dirname, config.jsEntryPoint),
        style: path.join(__dirname, config.scssEntryPoint),
    },
    output: {
        path: path.resolve(__dirname, config.resultFolder),
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
        new CleanWebpackPlugin(),
        new FixStyleOnlyEntriesPlugin(),// Remove redundant js files from css entries
        new miniCss({
            filename: './css/[name].css',
        }),
    ],
};
module.exports = webpackConfig;
