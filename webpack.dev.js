const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
const commonConfig = require('./webpack.common.js');
const path = require('path');
const miniCss = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

let devConfig = {
    mode: 'development',
    // eval- doesn't work with mini-css-extract-plugin
    devtool: 'cheap-module-source-map', // eval-source-map, cheap-module-source-map,
    plugins: [
        new BrowserSyncPlugin(
            {
                host: 'localhost',
                port: 3000,
                notify: true,
                proxy: 'http://wp-starter-theme.local/',
                files: [
                    '**/*.php',
                    'assets/js/**/*.js',
                    'assets/css/**/*.css',
                    '!**/*.css.map',
                    '!**/*.js.map',
                ],
            },
            {
                reload: false,
                injectCss: true,
            }
        ),
    ],
    module: {
        rules: [
            {
                test:/\.(s*)css$/,
                use: [
                    miniCss.loader,
                    //'style-loader',
                    {
                        loader: 'css-loader',
                        options: { sourceMap: true, url: false }
                    },
                    {
                        loader: 'sass-loader',
                        options: { sourceMap: true }
                    }
                ]
            }
        ]
    }
}

let resultConfig = mergeWithCustomize({
    customizeArray: customizeArray({
        'module.rules': 'append',
        'plugins': 'append',
    }),
})(commonConfig, devConfig);

module.exports = resultConfig;