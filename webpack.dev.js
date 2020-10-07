const { merge, mergeWithCustomize, customizeArray, customizeObject } = require('webpack-merge');
const commonConfig = require('./webpack.common.js');
const path = require('path');
const miniCss = require('mini-css-extract-plugin');

let devConfig = {
    mode: 'development',
    devtool: 'cheap-module-source-map', // eval-source-map, cheap-module-source-map
    devServer: {
        publicPath: '/wp-content/themes/wp-starter-theme/assets/', // на этом адресе по host + publicPath будет контент вебпака
        contentBase: path.join(__dirname, './'),// то где лежит основной контент для обновления
        host: 'localhost',
        port: 3000,
        //historyApiFallback: true,
        open: true,
        overlay: true,
        watchContentBase: true,
        disableHostCheck: true,
        proxy: {
            '/': {
                target: 'http://wp-starter-theme.local/',
                //secure: false,
                changeOrigin: true, // не работает без этого
                //autoRewrite: true,
            },
        }
    },
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
        'module.rules': 'append'
    }),
    // customizeObject: customizeObject({
    //     entry: 'prepend'
    // })
})(commonConfig, devConfig);

module.exports = resultConfig;