const path = require('path');
const miniCss = require('mini-css-extract-plugin');

const config = {
    entry: {
        main: [path.join(__dirname, "./src/js/index.js"), path.join(__dirname, "./src/assets/scss/app.scss")],
    },
    output: {
        path: path.resolve(__dirname, './assets'),
        filename: 'js/[name].js',
        //publicPath: 'http://sredainvest.local/',
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
        new miniCss({
            filename: './css/[name].css',
        }),
    ],
};
module.exports = config;