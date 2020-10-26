const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
const miniCss = require('mini-css-extract-plugin');
const commonConfig = require('./webpack.common.js');

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
                        options: { sourceMap: false, url: false, importLoaders: 1 }
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            sourceMap: false,
                            postcssOptions: {
                                plugins: [
                                    [ 'autoprefixer' ],
                                    [ 'cssnano', {preset: 'default'} ]
                                ],
                            },
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