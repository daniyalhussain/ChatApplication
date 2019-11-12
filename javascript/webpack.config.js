'use strict';

const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

let config = {
  entry: {
    main: [
      './src/app.js'
    ]
  },
  output: {
    path: path.resolve(__dirname, 'assets', 'bundle'),
    filename: '[name].bundle.js'
  },
  resolve: {
    extensions: ['.js', '.jsx', '.json', '.ts', '.tsx']
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx|tsx|ts)$/,
        exclude:path.resolve(__dirname, 'node_modules'),
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env',
              '@babel/preset-react',
              '@babel/preset-typescript'
            ],
            plugins : [
              ["@babel/plugin-proposal-decorators", { "legacy": true }],
              '@babel/plugin-syntax-dynamic-import',
              ['@babel/plugin-proposal-class-properties', { "loose": true }]
            ]
          }
        },
      }
    ]
  },
  externals: {
    myApp: 'myApp',
  },
  plugins: [
    new ExtractTextPlugin(path.join('..', 'css', 'app.css')),
    new webpack.DefinePlugin({
      '__DEV__' : JSON.stringify(true),
      '__API_HOST__' : JSON.stringify('http://localhost/chatApplication/'),
    }),
  ],

};

if (process.env.NODE_ENV === 'production') {
  config.plugins.push(
    new webpack.optimize.UglifyJsPlugin({
      sourceMap: false,
      compress: {
        sequences: true,
        conditionals: true,
        booleans: true,
        if_return: true,
        join_vars: true,
        drop_console: true
      },
      output: {
        comments: false
      },
      minimize: true
    })
  );
}

module.exports = config;