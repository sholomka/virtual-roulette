const { resolve } = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    context: resolve(__dirname, './frontend'),
    entry: {
        Main: "Main"
    },

    output: {
        filename: '[name].js',
        path: resolve(__dirname, './public')
    },

    resolve: {
        extensions: ['.js', '.scss'],
        modules: [
            resolve(__dirname, './frontend/js')
        ]
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['es2015']
                        },
                    },
                ],
            },
            {
                test: /\.scss$/,
                loader: ExtractTextPlugin.extract({
                    fallbackLoader: "style-loader",
                    loader: "css-loader!resolve-url-loader!sass-loader?sourceMap"
                })
            },
            {
                test: /\.(png|jpg|jpeg|gif|svg|ttf|eot|woff|woff2)$/,
                loader: 'file-loader?name=img/[name].[ext]?[hash]'
            }]
    },

    plugins: [
        new ExtractTextPlugin({
            filename: "[name].css",
            disable: false,
            allChunks: true
        })
    ],

    devServer: {
        contentBase: __dirname + '/html/backend',
        hot: true
    }
};