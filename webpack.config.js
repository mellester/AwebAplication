const path = require('path');

module.exports = {
    module: {
        rules: [
          {
            test: /\.postcss$/,
            use: [ 'style-loader',
            {
              loader: `postcss-loader`,
              options: {
                options: {},
              }
            }, 
            ]
          }
        ]
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
