require("@babel/polyfill");
const path = require('path');

module.exports = {
  //entry: ["@babel/polyfill", './resources/js'],
  module: {
    rules: [
      {
        test: /\.postcss$/,
        use: ['style-loader',
          {
            loader: `postcss-loader`,
            options: {
              options: {},
            }
          },
        ]
      },
      { test: /\.php$/, use: 'null-loader' }, //empty load php files
      {
        test: /\.tsx?$/,
        loader: 'ts-loader',
        options: { appendTsSuffixTo: [/\.vue$/], transpileOnly: false, },
        exclude: /node_modules/,
    }, 
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
            plugins: [
              "@babel/transform-runtime"
            ]
          },
        }
      },
    ]
  },
  resolve: {
    extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx', '.php'],
    alias: {
      '@': path.resolve('resources/js'),
    },
  },
};
