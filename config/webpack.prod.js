// const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
// const miniCss = require('mini-css-extract-plugin');
// const commonConfig = require('./webpack.common.js');

import { merge, mergeWithCustomize, customizeArray, customizeObject } from 'webpack-merge';
import miniCss from 'mini-css-extract-plugin';
import commonConfig from './webpack.common.js';

let prodConfig = {
    mode: 'production',
    devtool: false, //'source-map'
    optimization: {
        splitChunks: {
            chunks: 'all',
        },
    },
    plugins: [
        new miniCss({
            filename: 'css/[name].[contenthash].css',
        }),
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
                        // importLoaders for .css @import,
                        // 1 to handle by postcss, 2 to postcss and scss (probably wrong)
                        options: { sourceMap: false, url: false, importLoaders: 1 }
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            sourceMap: false,
                            postcssOptions: {
                                plugins: [
                                    [ 'autoprefixer' ],
                                    [ 'cssnano', {preset: ['default', {
                                            svgo: false
                                        }]} ]
                                ],
                            },
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: false,
                            sassOptions: {
                                outputStyle: 'expanded',
                                //fiber: require("fibers"), // included by default
                            }
                        }
                    }
                ]
            }
        ]
    }
}

let resultConfig = mergeWithCustomize({
    customizeArray: customizeArray({
        'module.rules': 'append'
    }),
    // customizeObject: customizeObject({
    //     entry: 'prepend'
    // })
})(commonConfig, prodConfig);

//module.exports = resultConfig;
export default resultConfig;
