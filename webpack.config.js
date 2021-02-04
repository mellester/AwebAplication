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
    alias: {
      '@': path.resolve('resources/js'),
    },
  },
};
