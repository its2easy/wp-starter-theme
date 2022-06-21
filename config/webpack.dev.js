//const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
//const commonConfig = require('./webpack.common.js');
//const miniCss = require('mini-css-extract-plugin');
//const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
//const config = require('./config');

import { merge, mergeWithCustomize, customizeArray, customizeObject } from 'webpack-merge';
import miniCss from 'mini-css-extract-plugin';
import BrowserSyncPlugin from 'browser-sync-webpack-plugin';
import config from './config.js';
import commonConfig from './webpack.common.js';
//import fibers from 'fibers';

let devConfig = {
    mode: 'development',
    stats: {
        modules: false
    },
    // eval- doesn't work with mini-css-extract-plugin
    devtool: 'cheap-module-source-map', // eval-source-map, cheap-module-source-map,
    plugins: [
        new miniCss({
            filename: 'css/[name].css',
            //filename: 'css/[name].[contenthash].css', // for tunnel, won't load new styles without reload
        }),
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
                watchEvents: ["change", "add"],// "add" to reload when js file names are dynamic
                ghostMode: false, // disable sync between devices
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
                        options: { sourceMap: true, url: false, importLoaders: 1 }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            sassOptions: {

                            },
                        }
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

//module.exports = resultConfig;
export default resultConfig;
