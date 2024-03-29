//const path = require('path');
//const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
//const { CleanWebpackPlugin } = require('clean-webpack-plugin');
//const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
//const config = require('./config');

import path, { dirname } from "path";
import { fileURLToPath } from 'url';
import RemoveEmptyScriptsPlugin from 'webpack-remove-empty-scripts';
import { CleanWebpackPlugin } from 'clean-webpack-plugin';
import { WebpackManifestPlugin } from 'webpack-manifest-plugin';
import config from './config.js';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const webpackConfig = {
    entry: {
        main: path.join(__dirname, config.jsEntryPoint),
        style: path.join(__dirname, config.scssEntryPoint),
    },
    output: {
        path: path.resolve(__dirname, config.resultFolder),
        filename: 'js/[name].[contenthash].js',
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
        //new BundleAnalyzerPlugin(),
        new WebpackManifestPlugin({
            generate: (seed, files, entries) => {
                for (const [key, value] of Object.entries(entries)) { // remove .map files from manifest file
                    value.forEach(element => {
                        if (element.includes(".map"))  {
                            let index = entries[key].indexOf(element);
                            if (index > -1) entries[key].splice(index, 1);
                        }
                    })
                }
                return entries;
            },
        }),
        new CleanWebpackPlugin(),
        new RemoveEmptyScriptsPlugin(),
    ],
};
//module.exports = webpackConfig;
export default webpackConfig;
