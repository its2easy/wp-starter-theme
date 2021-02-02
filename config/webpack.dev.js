const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
const commonConfig = require('./webpack.common.js');
const miniCss = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const config = require('./config');

let devConfig = {
    mode: 'development',
    stats: {
        modules: false
    },
    // eval- doesn't work with mini-css-extract-plugin
    devtool: 'cheap-module-source-map', // eval-source-map, cheap-module-source-map,
    plugins: [
        new BrowserSyncPlugin(
            {
                port: config.port,
                notify: true,
                proxy: config.proxy,
                files: [ // relative to cwd, not to config
                    `./${config.watchPhp}`,
                    `./${config.watchJs}`,
                    `./${config.watchCss}`,
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
