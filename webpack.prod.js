const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
const commonConfig = require('./webpack.common.js');
const miniCss = require('mini-css-extract-plugin');
//const webpack = require("webpack");

let prodConfig = {
    mode: 'production',
    devtool: false, //'source-map'
    plugins: [

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
                        loader: "postcss-loader",
                        options: {
                            sourceMap: true,
                            ident: 'postcss',
                            plugins: (loader) => [
                                require('autoprefixer')(),
                                require('cssnano')()
                            ]
                        }
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
        'module.rules': 'append'
    }),
    // customizeObject: customizeObject({
    //     entry: 'prepend'
    // })
})(commonConfig, prodConfig);

module.exports = resultConfig;